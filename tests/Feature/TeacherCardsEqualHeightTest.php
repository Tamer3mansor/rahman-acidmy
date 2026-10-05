<?php

namespace Tests\Feature;

use App\Models\LandingTeacher;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * The teachers grid hands every card in a row the same height. The booking
 * button has to land on that shared bottom edge too: badges wrap to a different
 * number of rows per teacher, so a body laid out as a plain block leaves the
 * button floating mid-card on the teachers with fewer badges.
 */
class TeacherCardsEqualHeightTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_grid_stretches_its_cards_in_both_layout_modes(): void
    {
        $this->assertDeclares(
            '.teachers-grid',
            'align-items: stretch',
            'The grid must stretch its items so every card in a row shares one height.'
        );

        $this->assertDeclares(
            '.teachers-carousel.is-ready .teachers-grid',
            'align-items: stretch',
            'The carousel swaps the grid into a flex track and must keep stretching it.'
        );
    }

    public function test_the_card_is_a_column_so_the_body_can_absorb_the_stretched_height(): void
    {
        $this->assertDeclares('.teacher-card', 'display: flex');
        $this->assertDeclares('.teacher-card', 'flex-direction: column');
    }

    public function test_the_photo_holds_its_own_height_inside_the_stretched_card(): void
    {
        $this->assertDeclares(
            '.teacher-photo',
            'flex: 0 0 auto',
            'Without this the 4/3 photo is a flex item that the stretched card would shrink.'
        );
    }

    public function test_the_body_fills_the_card_below_the_photo(): void
    {
        $this->assertDeclares('.teacher-body', 'flex: 1');
        $this->assertDeclares('.teacher-body', 'display: flex');
        $this->assertDeclares('.teacher-body', 'flex-direction: column');
    }

    public function test_the_booking_button_is_pinned_to_the_bottom_of_the_body(): void
    {
        $this->assertDeclares(
            '.teacher-cta',
            'margin-top: auto',
            'The auto margin absorbs the row-height slack so every button sits on one baseline.'
        );
    }

    public function test_the_body_and_button_do_not_pin_a_height_that_would_break_the_stretch(): void
    {
        foreach (['.teacher-body', '.teacher-cta'] as $selector) {
            $this->assertDoesNotMatchRegularExpression(
                '/(?:^|[;{])\s*(?:min-)?height\s*:/i',
                $this->declarationsFor($selector),
                "[{$selector}] must keep its height automatic so the stretched row can size it."
            );
        }
    }

    public function test_the_equal_height_chain_is_scoped_to_the_landing_teachers_stylesheet(): void
    {
        $this->assertNotEmpty(
            $this->declarationsFor('.teacher-body'),
            'Guard against the lookup silently matching a differently scoped rule.'
        );
    }

    public function test_the_rules_describe_markup_the_landing_page_actually_renders(): void
    {
        $this->seed(DatabaseSeeder::class);

        $html = $this->get('/')->assertOk()->getContent();

        preg_match_all('/class="(teacher-card|teacher-photo|teacher-body|teacher-cta)"/', $html, $classes);

        foreach (['teacher-card', 'teacher-photo', 'teacher-body', 'teacher-cta'] as $class) {
            $this->assertContains(
                $class,
                $classes[1],
                "The landing teachers section must render [{$class}] for the equal-height rules to apply to."
            );
        }
    }

    public function test_a_teacher_without_badges_still_renders_a_booking_button(): void
    {
        $this->seed(DatabaseSeeder::class);

        LandingTeacher::create([
            'name' => 'Cheikh Sans Badges',
            'specialty' => 'Langue arabe',
            'emoji' => '👨‍🏫',
            'badges' => [],
            'is_featured' => false,
            'is_active' => true,
            'sort_order' => 99,
        ]);

        $html = $this->get('/')->assertOk()->getContent();

        preg_match('/<div class="teacher-card">.*?Cheikh Sans Badges.*?<\/div>\s*<\/div>/s', $html, $matches);

        $this->assertNotEmpty($matches, 'The badge-less teacher card must render.');
        $this->assertStringContainsString('teacher-cta', $matches[0]);
    }

    private function assertDeclares(string $selector, string $declaration, string $because = ''): void
    {
        $this->assertStringContainsString(
            $this->normalize($declaration),
            $this->normalize($this->declarationsFor($selector)),
            $because !== '' ? $because : "[{$selector}] must declare [{$declaration}]."
        );
    }

    private function stylesheet(): string
    {
        $css = file_get_contents(resource_path('css/landing.css'));

        $this->assertIsString($css, 'The landing stylesheet must be readable.');

        // Comments sit directly above most of these rules, and a comment glued to
        // the front of a selector would defeat the exact match below.
        return preg_replace('#/\*.*?\*/#s', '', $css) ?? $css;
    }

    /**
     * The declaration blocks of every rule whose selector is exactly the given
     * one. Exact matching is deliberate: the landing stylesheet also carries
     * `.lp` and carousel-scoped variants of these same classes, and those must
     * not be allowed to satisfy a base-rule assertion.
     */
    private function declarationsFor(string $selector): string
    {
        preg_match_all('/([^{}]+)\{([^{}]*)\}/', $this->stylesheet(), $matches, PREG_SET_ORDER);

        $declarations = [];

        foreach ($matches as $match) {
            foreach (explode(',', $match[1]) as $candidate) {
                if (trim($candidate) === $selector) {
                    $declarations[] = $match[2];
                }
            }
        }

        $this->assertNotEmpty(
            $declarations,
            "No rule for [{$selector}] in the landing stylesheet."
        );

        return implode("\n", $declarations);
    }

    private function normalize(string $css): string
    {
        return preg_replace('/\s+/', '', $css) ?? $css;
    }
}
