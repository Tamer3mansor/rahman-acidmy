<?php

namespace App\Support;

use App\Enums\CourseAudience;
use App\Models\Course;
use App\Models\CoursePageSettings;

class CourseContentResolver
{
    /**
     * Fill a course's empty content blocks from the catalog settings of its
     * audience. Course-stored content always wins; session_features stays
     * course-scoped because the catalog has no equivalent for it.
     */
    public static function resolve(Course $course, CoursePageSettings $settings): void
    {
        $prefix = $course->audience === CourseAudience::Kids ? 'kids' : 'adults';

        if (blank($course->curriculum_items)) {
            $course->curriculum_items = $settings->{$prefix.'_curriculum_items'};
        }

        if (blank($course->journey_steps)) {
            $course->journey_steps = self::journeySteps($settings->{$prefix.'_journey_items'});
        }

        if (blank($course->suitability_checks)) {
            $course->suitability_checks = self::suitabilityChecks($settings->{$prefix.'_about_items'});
        }

        if (blank($course->faqs)) {
            $course->faqs = $settings->{$prefix.'_faq_items'};
        }
    }

    /**
     * Normalize catalog journey items into the course journey_steps shape,
     * deriving the sequence number and the highlight style.
     *
     * @param  array<int, array<string, string>>|null  $items
     * @return array<int, array<string, string>>
     */
    private static function journeySteps(?array $items): array
    {
        return collect($items ?? [])
            ->map(fn (array $item, int $index): array => [
                'number' => str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT),
                'htmlClass' => $index === 0 ? 'gold' : 'dark-green',
                'title' => (string) ($item['title'] ?? ''),
                'description' => (string) ($item['description'] ?? ''),
            ])
            ->values()
            ->all();
    }

    /**
     * Flatten catalog "about" items, which carry an icon, title and
     * description, into the plain-text suitability_checks shape.
     *
     * @param  array<int, array<string, string>>|null  $items
     * @return array<int, string>
     */
    private static function suitabilityChecks(?array $items): array
    {
        return collect($items ?? [])
            ->map(function (array $item): string {
                $title = trim((string) ($item['title'] ?? ''));
                $description = trim((string) ($item['description'] ?? ''));

                return $title === '' ? $description : $title.' — '.$description;
            })
            ->filter()
            ->values()
            ->all();
    }
}
