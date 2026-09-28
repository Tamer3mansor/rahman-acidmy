<?php

namespace Tests\Feature;

use App\Enums\CourseAudience;
use App\Enums\TestimonialAudience;
use App\Enums\TestimonialType;
use App\Models\Course;
use App\Models\CoursePageSettings;
use App\Models\LandingTestimonial;
use Database\Seeders\CoursePageSettingsSeeder;
use Database\Seeders\CourseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * The content chain for every course detail section is:
 *
 *   course record → "المحتوى المشترك" tab → audience main-page tab → hidden
 *
 * These tests pin each rung, in both directions, so a change to the resolver
 * or to the fallback order fails loudly instead of silently blanking a page.
 */
class CourseContentFallbackTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([
            CourseSeeder::class,
            CoursePageSettingsSeeder::class,
        ]);
    }

    public function test_main_page_content_is_used_when_the_course_is_empty(): void
    {
        CoursePageSettings::singleton()->update([
            'kids_curriculum_items' => [
                ['icon' => '📖', 'title' => 'Récitation du Coran', 'description' => 'Depuis la page principale.'],
            ],
        ]);

        $course = $this->makeEmptyKidsCourse();

        $this->get("/cours/{$course->slug}")
            ->assertOk()
            ->assertSee('Récitation du Coran')
            ->assertSee('Depuis la page principale.');
    }

    public function test_shared_content_overrides_the_main_page(): void
    {
        CoursePageSettings::singleton()->update([
            'kids_curriculum_items' => [
                ['icon' => '📖', 'title' => 'Depuis la page principale', 'description' => 'Ne doit pas apparaître.'],
            ],
            'kids_shared_curriculum_items' => [
                ['icon' => '🌙', 'title' => 'Depuis le contenu partagé', 'description' => 'Doit gagner.'],
            ],
        ]);

        $course = $this->makeEmptyKidsCourse();

        $this->get("/cours/{$course->slug}")
            ->assertOk()
            ->assertSee('Depuis le contenu partagé')
            ->assertDontSee('Depuis la page principale');
    }

    public function test_course_stored_content_overrides_the_shared_content(): void
    {
        CoursePageSettings::singleton()->update([
            'kids_curriculum_items' => [
                ['icon' => '📖', 'title' => 'Depuis la page principale', 'description' => 'Ne doit pas apparaître.'],
            ],
            'kids_shared_curriculum_items' => [
                ['icon' => '🌙', 'title' => 'Depuis le contenu partagé', 'description' => 'Ne doit pas apparaître.'],
            ],
        ]);

        $course = Course::factory()->create([
            'audience' => CourseAudience::Kids,
            'curriculum_items' => [
                ['icon' => '⭐', 'title' => 'Depuis la course', 'description' => 'Doit gagner.'],
            ],
        ]);

        $this->get("/cours/{$course->slug}")
            ->assertOk()
            ->assertSee('Depuis la course')
            ->assertDontSee('Depuis le contenu partagé')
            ->assertDontSee('Depuis la page principale');
    }

    public function test_an_empty_shared_tier_falls_back_to_the_main_page(): void
    {
        CoursePageSettings::singleton()->update([
            'kids_curriculum_items' => [
                ['icon' => '📖', 'title' => 'Depuis la page principale', 'description' => 'Repli attendu.'],
            ],
            'kids_shared_curriculum_items' => null,
        ]);

        $course = $this->makeEmptyKidsCourse();

        $this->get("/cours/{$course->slug}")
            ->assertOk()
            ->assertSee('Depuis la page principale');
    }

    public function test_the_section_is_hidden_when_every_tier_is_empty(): void
    {
        CoursePageSettings::singleton()->update([
            'kids_curriculum_title' => 'Titre du programme',
            'kids_curriculum_items' => null,
            'kids_shared_curriculum_items' => null,
        ]);

        $course = $this->makeEmptyKidsCourse();

        $this->get("/cours/{$course->slug}")
            ->assertOk()
            ->assertDontSee('Titre du programme');
    }

    public function test_the_chain_is_scoped_per_audience(): void
    {
        CoursePageSettings::singleton()->update([
            'kids_curriculum_items' => [
                ['icon' => '📖', 'title' => 'Contenu enfants', 'description' => 'Enfants uniquement.'],
            ],
            'adults_curriculum_items' => [
                ['icon' => '🕌', 'title' => 'Contenu adultes', 'description' => 'Adultes uniquement.'],
            ],
        ]);

        $kids = $this->makeEmptyKidsCourse();
        $adults = $this->makeEmptyCourse(CourseAudience::Adults);

        $this->get("/cours/{$kids->slug}")
            ->assertOk()
            ->assertSee('Contenu enfants')
            ->assertDontSee('Contenu adultes');

        $this->get("/cours/{$adults->slug}")
            ->assertOk()
            ->assertSee('Contenu adultes')
            ->assertDontSee('Contenu enfants');
    }

    public function test_the_pages_404_when_the_settings_are_deactivated(): void
    {
        $course = $this->makeEmptyKidsCourse();

        foreach (['/enfants', '/adultes', "/cours/{$course->slug}"] as $url) {
            $this->get($url)->assertOk();
        }

        CoursePageSettings::singleton()->update(['is_active' => false]);

        foreach (['/enfants', '/adultes', "/cours/{$course->slug}"] as $url) {
            $this->get($url)->assertNotFound();
        }
    }

    public function test_a_deactivated_course_404s_even_while_the_pages_are_active(): void
    {
        $course = $this->makeEmptyKidsCourse(['is_active' => false]);

        $this->get("/cours/{$course->slug}")->assertNotFound();
    }

    /**
     * A course whose content blocks are all empty, so the fallback chain is
     * what decides the rendered page. The factory fills some of these, which
     * would short-circuit the chain at the first tier.
     *
     * @param  array<string, mixed>  $overrides
     */
    private function makeEmptyKidsCourse(array $overrides = []): Course
    {
        return $this->makeEmptyCourse(CourseAudience::Kids, $overrides);
    }

    /**
     * @param  array<string, mixed>  $overrides
     */
    private function makeEmptyCourse(CourseAudience $audience, array $overrides = []): Course
    {
        return Course::factory()->create([
            'audience' => $audience,
            'curriculum_items' => null,
            'session_features' => null,
            'journey_steps' => null,
            'suitability_checks' => null,
            'faqs' => null,
            ...$overrides,
        ]);
    }

    public function test_suitability_section_follows_the_chain(): void
    {
        $this->assertSharedWinsFor(
            courseField: 'suitability_checks',
            mainField: 'kids_about_items',
            sharedField: 'kids_shared_about_items',
            mainItems: [['icon' => '👶', 'title' => 'من الرئيسية', 'description' => 'وصف من الرئيسية.']],
            sharedItems: [['icon' => '👦', 'title' => 'من المشترك', 'description' => 'وصف من المشترك.']],
            mainNeedle: 'من الرئيسية',
            sharedNeedle: 'من المشترك',
        );
    }

    public function test_journey_section_follows_the_chain(): void
    {
        $this->assertSharedWinsFor(
            courseField: 'journey_steps',
            mainField: 'kids_journey_items',
            sharedField: 'kids_shared_journey_items',
            mainItems: [['title' => 'خطوة من الرئيسية', 'description' => 'من الرئيسية.']],
            sharedItems: [['title' => 'خطوة من المشترك', 'description' => 'من المشترك.']],
            mainNeedle: 'خطوة من الرئيسية',
            sharedNeedle: 'خطوة من المشترك',
        );
    }

    public function test_session_section_follows_the_chain(): void
    {
        $this->assertSharedWinsFor(
            courseField: 'session_features',
            mainField: 'kids_session_items',
            sharedField: 'kids_shared_session_items',
            mainItems: [['title' => 'ميزة من الرئيسية', 'description' => 'من الرئيسية.']],
            sharedItems: [['title' => 'ميزة من المشترك', 'description' => 'من المشترك.']],
            mainNeedle: 'ميزة من الرئيسية',
            sharedNeedle: 'ميزة من المشترك',
        );
    }

    public function test_faq_section_follows_the_chain(): void
    {
        $this->assertSharedWinsFor(
            courseField: 'faqs',
            mainField: 'kids_faq_items',
            sharedField: 'kids_shared_faq_items',
            mainItems: [['question' => 'سؤال من الرئيسية', 'answer' => '<p>إجابة من الرئيسية</p>']],
            sharedItems: [['question' => 'سؤال من المشترك', 'answer' => '<p>إجابة من المشترك</p>']],
            mainNeedle: 'سؤال من الرئيسية',
            sharedNeedle: 'سؤال من المشترك',
        );
    }

    public function test_why_choose_section_prefers_the_shared_cards(): void
    {
        CoursePageSettings::singleton()->update([
            'kids_why_items' => [['icon' => 'A', 'title' => 'كارت من الأساسي', 'description' => 'وصف أساسي.']],
            'kids_shared_why_items' => [['icon' => 'B', 'title' => 'كارت من المشترك', 'description' => 'وصف مشترك.']],
        ]);

        $course = $this->makeEmptyKidsCourse();

        $this->get("/cours/{$course->slug}")
            ->assertOk()
            ->assertSee('كارت من المشترك')
            ->assertDontSee('كارت من الأساسي');
    }

    public function test_why_choose_section_falls_back_to_the_main_cards(): void
    {
        CoursePageSettings::singleton()->update([
            'kids_why_items' => [['icon' => 'A', 'title' => 'كارت من الأساسي', 'description' => 'وصف أساسي.']],
            'kids_shared_why_items' => null,
        ]);

        $course = $this->makeEmptyKidsCourse();

        $this->get("/cours/{$course->slug}")
            ->assertOk()
            ->assertSee('كارت من الأساسي');
    }

    public function test_why_choose_section_is_hidden_when_both_tiers_are_empty(): void
    {
        CoursePageSettings::singleton()->update([
            'kids_why_items' => null,
            'kids_shared_why_items' => null,
        ]);

        $course = $this->makeEmptyKidsCourse();

        $this->get("/cours/{$course->slug}")
            ->assertOk()
            ->assertDontSee('Pourquoi choisir Madrassat Ar-Rahman ?');
    }

    public function test_the_why_choose_cards_are_seeded_for_both_audiences(): void
    {
        $course = $this->makeEmptyKidsCourse();

        $this->get("/cours/{$course->slug}")
            ->assertOk()
            ->assertSee('Pourquoi choisir Madrassat Ar-Rahman ?')
            ->assertSee("Enseignants diplômés de l'Al-Azhar");

        $adultsCourse = Course::factory()->create([
            'audience' => CourseAudience::Adults,
            'curriculum_items' => null,
            'session_features' => null,
            'journey_steps' => null,
            'suitability_checks' => null,
            'faqs' => null,
        ]);

        $this->get("/cours/{$adultsCourse->slug}")
            ->assertOk()
            ->assertSee('Pourquoi choisir Madrassat Ar-Rahman ?')
            ->assertSee("Plan d'étude personnalisé");
    }

    public function test_details_sections_render_in_the_expected_order(): void
    {
        LandingTestimonial::create([
            'type' => TestimonialType::Google,
            'page_audience' => TestimonialAudience::Kids,
            'author_name' => 'Parent',
            'content' => 'Retour élève enfant.',
            'rating' => 5,
            'is_active' => true,
            'sort_order' => 0,
        ]);

        $course = $this->makeEmptyKidsCourse([
            'curriculum_items' => [['icon' => '📖', 'title' => 'Sujeta', 'description' => 'Desc.']],
            'session_features' => [['title' => 'Sesión', 'description' => 'Desc.']],
            'journey_steps' => [['title' => 'Paso', 'description' => 'Desc.']],
        ]);

        $settings = CoursePageSettings::singleton();
        $settings->update(['kids_why_items' => [['icon' => 'A', 'title' => 'Carta', 'description' => 'Desc.']]]);

        $this->get("/cours/{$course->slug}")
            ->assertOk()
            ->assertSeeInOrder([
                'Ce cours est-il fait pour vous ?',
                'Le programme',
                'Comment se déroule le cours ?',
                'Votre parcours et votre progression',
                'Pourquoi choisir Madrassat Ar-Rahman ?',
                'Ce que disent les parents',
                'Questions fréquentes',
            ]);
    }

    /**
     * The "المحتوى المشترك" override must beat the main page for any section.
     *
     * @param  array<int, array<string, string>>  $mainItems
     * @param  array<int, array<string, string>>  $sharedItems
     */
    private function assertSharedWinsFor(
        string $courseField,
        string $mainField,
        string $sharedField,
        array $mainItems,
        array $sharedItems,
        string $mainNeedle,
        string $sharedNeedle,
    ): void {
        CoursePageSettings::singleton()->update([
            $mainField => $mainItems,
            $sharedField => $sharedItems,
        ]);

        $course = $this->makeEmptyKidsCourse([$courseField => null]);

        $this->get("/cours/{$course->slug}")
            ->assertOk()
            ->assertSee($sharedNeedle)
            ->assertDontSee($mainNeedle);
    }
}
