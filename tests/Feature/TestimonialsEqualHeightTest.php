<?php

namespace Tests\Feature;

use App\Enums\CourseAudience;
use App\Enums\TestimonialPlacement;
use App\Enums\TestimonialType;
use App\Models\Course;
use App\Models\LandingTestimonial;
use Database\Seeders\CoursePageSettingsSeeder;
use Database\Seeders\CourseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestimonialsEqualHeightTest extends TestCase
{
    use RefreshDatabase;

    public function test_courses_testimonials_grid_declares_equal_height_for_the_row(): void
    {
        $grid = $this->ruleFor('.testimonials-grid', $this->stylesheet());

        $this->assertStringContainsString('display:grid', $this->normalize($grid));
        $this->assertStringContainsString(
            'align-items:stretch',
            $this->normalize($grid),
            'The testimonials grid must stretch its items so every card in a row shares one height.'
        );
    }

    public function test_every_card_rendered_in_the_courses_testimonials_grid_fills_the_row_height(): void
    {
        $cardClasses = $this->cardClassesRenderedOnCoursePage();
        $stylesheet = $this->stylesheet();

        $this->assertNotEmpty($cardClasses, 'The course page must render testimonials to assert against.');

        foreach ($cardClasses as $cardClass) {
            $this->assertStringContainsString(
                'height:100%',
                $this->normalize($this->rulesForCardIn($cardClass, $stylesheet)),
                "The [{$cardClass}] card sits in .testimonials-grid and must fill the stretched row height."
            );
        }
    }

    public function test_the_grid_does_not_pin_a_fixed_height_that_would_break_the_video_frame(): void
    {
        $videoCard = $this->rulesForCardIn('.trust-video-card', $this->stylesheet());

        $this->assertStringNotContainsString(
            'height:100vh',
            $this->normalize($videoCard),
            'A viewport height would break out of the grid row.'
        );
    }

    public function test_the_equal_height_rule_is_scoped_to_the_courses_grid(): void
    {
        $this->assertNotEmpty(
            $this->rulesForCardIn('.screenshot-card', $this->stylesheet(), '.testimonials-row'),
            'Guard against the lookup silently matching the landing .testimonials-row container instead.'
        );
    }

    /**
     * The card types the courses testimonials grid can emit, discovered from the
     * rendered markup rather than hardcoded, so a new card type that forgets the
     * equal-height rule fails the test above instead of shipping misaligned.
     *
     * @return list<string>
     */
    private function cardClassesRenderedOnCoursePage(): array
    {
        $this->seed([
            CourseSeeder::class,
            CoursePageSettingsSeeder::class,
        ]);

        foreach ([TestimonialType::Google, TestimonialType::Whatsapp, TestimonialType::Video] as $type) {
            LandingTestimonial::query()->create([
                'type' => $type,
                'placements' => [TestimonialPlacement::Landing, TestimonialPlacement::Kids],
                'author_name' => "Auteur {$type->value}",
                'content' => 'Contenu du témoignage.',
                'media_path' => $type === TestimonialType::Video ? 'landing/testimonials/portrait.mp4' : null,
                'rating' => 5,
                'is_active' => true,
            ]);
        }

        $course = Course::query()->where('audience', CourseAudience::Kids->value)->firstOrFail();

        $html = $this->get("/cours/{$course->slug}")->assertOk()->getContent();

        $this->assertSame(1, preg_match('/<div class="testimonials-grid">(.*?)<\/div>\s*<\/div>/s', $html, $matches), 'The testimonials grid must render on the course page.');

        preg_match_all('/class="([^"]*\bcard\b[^"]*)"/', $matches[1], $classes);

        return array_values(array_unique(array_map(
            fn (string $classList): string => '.'.trim(explode(' ', $classList)[0]),
            $classes[1],
        )));
    }

    private function stylesheet(): string
    {
        $css = file_get_contents(resource_path('css/courses.css'));

        $this->assertIsString($css, 'The courses stylesheet must be readable.');

        return $css;
    }

    private function ruleFor(string $selector, string $css): string
    {
        $pattern = '/'.preg_quote($selector, '/').'\s*\{([^}]*)\}/';

        preg_match_all($pattern, $css, $matches);

        $this->assertNotEmpty(
            $matches[1],
            "No [{$selector}] rule found in the courses stylesheet."
        );

        return implode("\n", $matches[1]);
    }

    /**
     * Collects the declaration blocks that style a card inside a given container.
     *
     * The card classes are shared with the landing/kids/adults pages, which lay
     * them out in `.testimonials-row`, so the container is part of the lookup:
     * without it a rule meant for a different grid would satisfy the assertion.
     */
    private function rulesForCardIn(string $selector, string $css, string $container = '.testimonials-grid'): string
    {
        $pattern = '/([^{}]+)\{([^}]*)\}/';

        preg_match_all($pattern, $css, $matches, PREG_SET_ORDER);

        $blocks = [];

        foreach ($matches as $match) {
            foreach (explode(',', $match[1]) as $candidate) {
                $candidate = trim($candidate);

                if (! str_contains($candidate, $container)) {
                    continue;
                }

                if ($this->subjectOf($candidate) === $selector) {
                    $blocks[] = $match[2];
                }
            }
        }

        return implode("\n", $blocks);
    }

    /**
     * The class a rule ultimately applies to: the last simple selector of a
     * compound, stripped of any pseudo-class or pseudo-element.
     */
    private function subjectOf(string $candidate): string
    {
        $tokens = preg_split('/\s+/', trim($candidate)) ?: [];
        $last = (string) end($tokens);

        return preg_replace('/::?[a-z-]+(\([^)]*\))?$/i', '', $last) ?? $last;
    }

    private function normalize(string $css): string
    {
        return preg_replace('/\s+/', '', $css) ?? $css;
    }
}
