<?php

namespace App\Http\Controllers;

use App\Enums\LessonCategory;
use App\Models\LandingSettings;
use App\Models\Lesson;

class LessonController extends Controller
{
    public function index()
    {
        $settings = LandingSettings::singleton();

        $activeCategory = request()->has('k') && LessonCategory::tryFrom(request()->input('k')) !== null
            ? LessonCategory::from(request()->input('k'))
            : null;

        $lessons = Lesson::query()
            ->active()
            ->when($activeCategory !== null, fn ($q) => $q->where('category', $activeCategory->value))
            ->with('course')
            ->orderBy('sort_order')
            ->get();

        return view('lessons.index', [
            'settings' => $settings,
            'lessons' => $lessons,
            'activeCategory' => $activeCategory,
            'categories' => LessonCategory::cases(),
        ]);
    }

    public function show(Lesson $lesson)
    {
        abort_unless($lesson->is_active, 404);

        $settings = LandingSettings::singleton();

        $lesson->load('course');

        [$bodyHtml, $toc] = $this->prepareBody($lesson->body);

        return view('lessons.show', [
            'settings' => $settings,
            'lesson' => $lesson,
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
