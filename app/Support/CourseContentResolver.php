<?php

namespace App\Support;

use App\Enums\CourseAudience;
use App\Models\Course;
use App\Models\CoursePageSettings;

class CourseContentResolver
{
    /**
     * Fill a course's empty content from the dashboard, walking down the three
     * tiers in order until something is found:
     *
     *   1. the course record itself (per-course override)
     *   2. the "المحتوى المشترك" tab for the course audience
     *   3. the audience main-page tab
     *
     * A block that is empty on all three tiers stays empty, and the view hides
     * its section. Course-stored content always wins, so an admin can pin a
     * block to a single course without touching the shared copy.
     *
     * The "why choose Madrassat Ar-Rahman" block is the one exception: it only
     * exists on the details page, so it walks two tiers (shared, then main).
     * `hero_label` is the other: it lives on the detail hero, so it walks the
     * course then the shared details tab, and the view keeps the last-resort
     * wording for its audience.
     */
    public static function resolve(Course $course, CoursePageSettings $settings): void
    {
        $prefix = $course->audience === CourseAudience::Kids ? 'kids' : 'adults';

        $course->hero_label = self::firstFilled(
            $course->hero_label,
            [
                fn (): mixed => $settings->{'details_'.$prefix.'_hero_label'},
            ],
        );

        $course->curriculum_items = self::firstFilled(
            $course->curriculum_items,
            [
                fn (): mixed => $settings->{$prefix.'_shared_curriculum_items'},
                fn (): mixed => $settings->{$prefix.'_curriculum_items'},
            ],
        );

        $course->session_features = self::firstFilled(
            $course->session_features,
            [
                fn (): mixed => $settings->{$prefix.'_shared_session_items'},
                fn (): mixed => $settings->{$prefix.'_session_items'},
            ],
        );

        $course->journey_steps = self::firstFilled(
            $course->journey_steps,
            [
                fn (): mixed => $settings->{$prefix.'_shared_journey_items'},
                fn (): mixed => $settings->{$prefix.'_journey_items'},
            ],
        );
        $course->journey_steps = self::journeySteps($course->journey_steps);

        $course->suitability_checks = self::firstFilled(
            $course->suitability_checks,
            [
                fn (): mixed => $settings->{$prefix.'_shared_about_items'},
                fn (): mixed => $settings->{$prefix.'_about_items'},
            ],
        );
        $course->suitability_checks = self::suitabilityChecks($course->suitability_checks);

        $course->faqs = self::firstFilled(
            $course->faqs,
            [
                fn (): mixed => $settings->{$prefix.'_shared_faq_items'},
                fn (): mixed => $settings->{$prefix.'_faq_items'},
            ],
        );

        $course->why_items = self::firstFilled(
            null,
            [
                fn (): mixed => $settings->{$prefix.'_shared_why_items'},
                fn (): mixed => $settings->{$prefix.'_why_items'},
            ],
        );
    }

    /**
     * Return the first tier that holds content, or null when every tier is empty.
     *
     * @param  array<int, callable(): mixed>  $tiers
     */
    private static function firstFilled(mixed $courseValue, array $tiers): mixed
    {
        if (! blank($courseValue)) {
            return $courseValue;
        }

        foreach ($tiers as $tier) {
            $value = $tier();

            if (! blank($value)) {
                return $value;
            }
        }

        return null;
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
     * Classify a curriculum item icon before it reaches the 52px badge.
     * The Filament field is a free text input, so editors sometimes type a
     * word instead of an emoji, which renders as unreadable text inside the
     * badge. Letters and digits therefore mean "label", not "icon".
     *
     * @return array{kind: 'emoji'|'fa'|'text'|'fallback', value: string}
     */
    public static function curriculumIcon(mixed $icon): array
    {
        $value = trim((string) $icon);

        if ($value === '') {
            return ['kind' => 'fallback', 'value' => 'fa-solid fa-book-open'];
        }

        if (str_starts_with($value, 'fa-')) {
            return ['kind' => 'fa', 'value' => $value];
        }

        if (preg_match('/[\p{L}\p{N}]/u', $value) === 1) {
            return ['kind' => 'text', 'value' => $value];
        }

        return ['kind' => 'emoji', 'value' => $value];
    }

    /**
     * Flatten a "suitability" list into the plain-text suitability_checks
     * shape. The course level stores plain strings, while the catalog level
     * stores icon/title/description blocks, so both shapes are accepted.
     *
     * @param  array<int, array<string, mixed>|string>|null  $items
     * @return array<int, string>
     */
    private static function suitabilityChecks(?array $items): array
    {
        return collect($items ?? [])
            ->map(function (array|string $item): string {
                if (is_string($item)) {
                    return trim($item);
                }

                $title = trim((string) ($item['title'] ?? ''));
                $description = trim((string) ($item['description'] ?? ''));

                if ($title === '') {
                    return $description;
                }

                if ($description === '') {
                    return $title;
                }

                return $title.' — '.$description;
            })
            ->filter()
            ->values()
            ->all();
    }
}
