<?php

namespace App\Http\Controllers;

use App\Models\LandingSettings;
use App\Models\Lesson;
use App\Models\LessonCategory;
use App\Models\LessonPageSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class LessonController extends Controller
{
    public function index(Request $request)
    {
        $settings = LandingSettings::singleton();
        $pageSettings = LessonPageSettings::singleton();

        $categories = LessonCategory::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $activeCategorySlug = $request->input('k');

        $search = $this->normalizeSearch($request->input('q'));

        $lessons = Lesson::query()
            ->active()
            ->with(['courses', 'categories'])
            ->when($activeCategorySlug, function ($q, $slug) use ($categories) {
                $category = $categories->firstWhere('slug', $slug);

                if ($category) {
                    $q->whereHas('categories', fn ($cq) => $cq->where('lesson_categories.id', $category->id));
                }
            })
            ->when($search, fn ($q, $term) => $q->where(function ($sq) use ($term) {
                $like = '%'.$term.'%';
                $sq->where('title', 'like', $like)
                    ->orWhere('excerpt', 'like', $like)
                    ->orWhere('body', 'like', $like);
            }))
            ->orderBy('sort_order')
            ->paginate(9)
            ->withQueryString();

        return view('lessons.index', [
            'settings' => $settings,
            'pageSettings' => $pageSettings,
            'lessons' => $lessons,
            'activeCategorySlug' => $activeCategorySlug,
            'search' => $search,
            'categories' => $categories,
            'isIndexed' => $pageSettings->is_indexed && $search === null && $lessons->currentPage() === 1,
        ]);
    }

    public function show(Lesson $lesson)
    {
        abort_unless($lesson->is_active, 404);

        $settings = LandingSettings::singleton();
        $pageSettings = LessonPageSettings::singleton();

        $lesson->load(['courses', 'categories']);

        [$bodyHtml, $toc] = $this->prepareBody($lesson->body);

        $related = $this->relatedLessonsFor($lesson);

        return view('lessons.show', [
            'settings' => $settings,
            'pageSettings' => $pageSettings,
            'lesson' => $lesson,
            'bodyHtml' => $bodyHtml,
            'toc' => $toc,
            'related' => $related,
        ]);
    }

    /**
     * Lessons shown as recommendations at the end of a lesson: the ones picked
     * in the dashboard, or — when none were picked — other active lessons from
     * the same category, so the grid is never empty.
     *
     * @return Collection<int, Lesson>
     */
    private function relatedLessonsFor(Lesson $lesson): Collection
    {
        $related = $lesson->relatedLessons()
            ->where('lessons.id', '!=', $lesson->id)
            ->active()
            ->with(['categories', 'courses'])
            ->take(3)
            ->get();

        if ($related->isNotEmpty()) {
            return $related;
        }

        $categoryIds = $lesson->categories()->pluck('lesson_categories.id');

        return Lesson::query()
            ->active()
            ->where('id', '!=', $lesson->id)
            ->when($categoryIds->isNotEmpty(), fn ($q) => $q->whereHas('categories', fn ($cq) => $cq->whereIn('lesson_categories.id', $categoryIds)))
            ->with(['categories', 'courses'])
            ->orderBy('sort_order')
            ->take(3)
            ->get();
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
     * Add stable ids to <h2> tags, extract a table of contents, and render audio shortcodes.
     *
     * @return array{0: string, 1: array<int, array{id: string, text: string}>}
     */
    private function prepareBody(?string $body): array
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
            $body ?? ''
        );

        return [self::renderAudioShortcodes($result ?? ''), $toc];
    }

    /**
     * Replace [audio:URL] shortcodes with inline audio players.
     */
    private function renderAudioShortcodes(string $body): string
    {
        return preg_replace_callback(
            '/\[audio:\s*([^\]\s]+)\s*\]/i',
            function (array $m): string {
                $url = htmlspecialchars(trim($m[1]), ENT_QUOTES, 'UTF-8');

                return '<div class="lesson-audio"><strong>استمع إلى المقاطع الصوتية:</strong>'
                    .'<audio controls class="audio-player" preload="metadata">'
                    .'<source src="'.$url.'">'
                    .'Votre navigateur ne prend pas en charge le lecteur audio.</audio></div>';
            },
            $body
        ) ?? $body;
    }
}
