<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\LandingSettings;

class BlogController extends Controller
{
    public function index()
    {
        $settings = LandingSettings::singleton();

        $categories = BlogCategory::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $activeCategorySlug = request()->input('k');

        $featured = $activeCategorySlug === null
            ? BlogPost::published()->where('is_featured', true)->latest('published_at')->first()
            : null;

        $posts = BlogPost::published()
            ->when($featured !== null, fn ($q) => $q->where('id', '!=', $featured->id))
            ->when($activeCategorySlug, function ($q, $slug) use ($categories) {
                $category = $categories->firstWhere('slug', $slug);
                if ($category) {
                    $q->where('category_id', $category->id);
                }
            })
            ->latest('published_at')
            ->paginate(9);

        return view('blog.index', [
            'settings' => $settings,
            'categories' => $categories,
            'activeCategorySlug' => $activeCategorySlug,
            'featured' => $featured,
            'posts' => $posts,
        ]);
    }

    public function show(BlogPost $post)
    {
        abort_unless($post->is_active && $post->published_at?->lte(now()), 404);

        $settings = LandingSettings::singleton();

        $post->load('category');

        $related = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->orderByRaw('category_id = ? DESC', [$post->category_id])
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
