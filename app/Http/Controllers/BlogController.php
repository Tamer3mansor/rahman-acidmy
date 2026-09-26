<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\LandingSettings;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $settings = LandingSettings::singleton();

        $categories = BlogCategory::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $activeCategorySlug = $request->input('k');
        $search = $this->normalizeSearch($request->input('q'));

        $featured = $activeCategorySlug === null && $search === null
            ? BlogPost::published()->where('is_featured', true)->latest('published_at')->first()
            : null;

        $posts = BlogPost::published()
            ->with('categories')
            ->when($featured !== null, fn ($q) => $q->where('id', '!=', $featured->id))
            ->when($activeCategorySlug, function ($q, $slug) use ($categories) {
                $category = $categories->firstWhere('slug', $slug);
                if ($category) {
                    $q->whereHas('categories', fn ($cq) => $cq->where('blog_categories.id', $category->id));
                }
            })
            ->when($search, fn ($q, $term) => $q->where(function ($sq) use ($term) {
                $like = '%'.$term.'%';
                $sq->where('title', 'like', $like)
                    ->orWhere('excerpt', 'like', $like)
                    ->orWhere('body', 'like', $like);
            }))
            ->orderBy('sort_order')
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        return view('blog.index', [
            'settings' => $settings,
            'categories' => $categories,
            'activeCategorySlug' => $activeCategorySlug,
            'search' => $search,
            'featured' => $featured,
            'posts' => $posts,
            'isIndexed' => $search === null && $posts->currentPage() === 1,
        ]);
    }

    public function show(BlogPost $post)
    {
        abort_unless($post->is_active && $post->published_at?->lte(now()), 404);

        $settings = LandingSettings::singleton();

        $post->load('categories');

        $related = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->whereHas('categories', fn ($q) => $q->whereIn('blog_categories.id', $post->categories->pluck('id')))
            ->latest('published_at')
            ->limit(3)
            ->get();

        [$bodyHtml, $toc] = $this->prepareBody($post->body);

        return view('blog.show', [
            'settings' => $settings,
            'post' => $post,
            'related' => $related,
            'bodyHtml' => $bodyHtml,
            'toc' => $toc,
        ]);
    }

    /**
     * Collapse whitespace and cap the length of a user supplied search term.
     */
    private function normalizeSearch(?string $term): ?string
    {
        $term = trim((string) preg_replace('/\s+/u', ' ', (string) $term));

        if ($term === '') {
            return null;
        }

        return mb_substr($term, 0, 100);
    }

    /**
     * Add stable ids to <h2> tags and extract a table of contents.
     *
     * @return array{0: string, 1: array<int, array{id: string, text: string}>}
     */
    private function prepareBody(string $body): array
    {
        $toc = [];
        $usedIds = [];

        $result = preg_replace_callback(
            '/<h2\b([^>]*)>(.*?)<\/h2>/is',
            function ($m) use (&$toc, &$usedIds) {
                $text = trim(strip_tags($m[2]));
                if ($text === '') {
                    return $m[0];
                }

                $base = preg_replace('/[^\p{L}\p{N}]+/u', '-', $text);
                $base = trim($base, '-') ?: 'section';
                $id = $base;
                $counter = 2;
                while (isset($usedIds[$id])) {
                    $id = $base.'-'.$counter++;
                }
                $usedIds[$id] = true;

                $toc[] = ['id' => $id, 'text' => $text];

                return '<h2'.$m[1].' id="'.$id.'">'.$m[2].'</h2>';
            },
            $body
        );

        return [$result ?? $body, $toc];
    }
}
