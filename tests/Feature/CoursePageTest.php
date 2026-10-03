<?php

namespace Tests\Feature;

use App\Enums\CourseAudience;
use App\Enums\TestimonialPlacement;
use App\Enums\TestimonialType;
use App\Filament\Resources\Courses\Pages\EditCourse;
use App\Models\Course;
use App\Models\CoursePageSettings;
use App\Models\LandingTestimonial;
use App\Models\User;
use Database\Seeders\CoursePageSettingsSeeder;
use Database\Seeders\CourseSeeder;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Livewire\Livewire;
use Tests\TestCase;

class CoursePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_kids_catalog_renders_kids_courses(): void
    {
        $this->seed([
            CourseSeeder::class,
            CoursePageSettingsSeeder::class,
        ]);

        $response = $this->get('/enfants');

        $response->assertOk()
            ->assertViewIs('kids.index')
            ->assertSee('Cours des enfants disponibles')
            ->assertSee('Initiation des Baraa\'im et mémorisation du Coran')
            ->assertSee('Mémorisation du Coran et Tajwid pour enfants')
            ->assertSee('Langue arabe et valeurs islamiques')
            ->assertDontSee('Correction de la récitation et règles du Tajwid')
            ->assertDontSee('data-scroll-to-form')
            ->assertSee('build/assets/courses-', false);
    }

    public function test_kids_curriculum_section_renders_from_settings(): void
    {
        $this->seed([
            CourseSeeder::class,
            CoursePageSettingsSeeder::class,
        ]);

        $settings = CoursePageSettings::singleton();
        $settings->update([
            'kids_curriculum_label' => 'Le programme',
            'kids_curriculum_title' => '📚 Que va apprendre mon enfant ?',
            'kids_curriculum_subtitle' => 'Un programme complet pour votre enfant.',
            'kids_curriculum_items' => [
                ['icon' => '📖', 'title' => 'Récitation du Coran', 'description' => 'Une lecture correcte et fluide.'],
            ],
        ]);

        $this->assertTrue(Schema::hasColumn('course_page_settings', 'kids_curriculum_items'));
        $this->assertCount(1, $settings->fresh()->kids_curriculum_items ?? []);

        $this->get('/enfants')
            ->assertOk()
            ->assertSee('📚 Que va apprendre mon enfant ?')
            ->assertSee('Récitation du Coran')
            ->assertSee('Une lecture correcte et fluide.');

        $settings->update([
            'kids_curriculum_title' => null,
            'kids_curriculum_items' => [],
        ]);

        $this->get('/enfants')
            ->assertOk()
            ->assertSee('Que va apprendre mon enfant ?')
            ->assertDontSee('Récitation du Coran');
    }

    public function test_adults_curriculum_section_renders_from_settings(): void
    {
        $this->seed([
            CourseSeeder::class,
            CoursePageSettingsSeeder::class,
        ]);

        $settings = CoursePageSettings::singleton();
        $settings->update([
            'adults_curriculum_label' => 'Le programme',
            'adults_curriculum_title' => '📚 Que vas-tu apprendre ?',
            'adults_curriculum_subtitle' => 'Un programme structuré pour vous.',
            'adults_curriculum_items' => [
                ['icon' => '📖', 'title' => 'Correction de la récitation', 'description' => 'Lettres et makharij appliqués.'],
            ],
        ]);

        $this->assertTrue(Schema::hasColumn('course_page_settings', 'adults_curriculum_items'));
        $this->assertCount(1, $settings->fresh()->adults_curriculum_items ?? []);

        $this->get('/adultes')
            ->assertOk()
            ->assertSee('📚 Que vas-tu apprendre ?')
            ->assertSee('Correction de la récitation')
            ->assertSee('Lettres et makharij appliqués.');

        $settings->update([
            'adults_curriculum_title' => null,
            'adults_curriculum_items' => [],
        ]);

        $this->get('/adultes')
            ->assertOk()
            ->assertSee('Que vas-tu apprendre ?')
            ->assertDontSee('Lettres et makharij appliqués.');
    }

    public function test_adults_catalog_renders_adults_courses(): void
    {
        $this->seed([
            CourseSeeder::class,
            CoursePageSettingsSeeder::class,
        ]);

        $response = $this->get('/adultes');

        $response->assertOk()
            ->assertViewIs('adults.index')
            ->assertSee('Cours des adultes et des grands')
            ->assertSee('Correction de la récitation et règles du Tajwid')
            ->assertSee('Mémorisation du Coran et consolidation')
            ->assertSee('Langue arabe et études islamiques')
            ->assertDontSee('Initiation des Baraa\'im et mémorisation du Coran')
            ->assertDontSee('data-scroll-to-form')
            ->assertSee('build/assets/courses-', false);
    }

    public function test_kids_and_adults_catalog_labels_are_editable_and_fall_back_to_the_page_label(): void
    {
        $this->seed([
            CourseSeeder::class,
            CoursePageSettingsSeeder::class,
        ]);

        $this->assertTrue(Schema::hasColumn('course_page_settings', 'kids_catalog_label'));
        $this->assertTrue(Schema::hasColumn('course_page_settings', 'adults_catalog_label'));

        $settings = CoursePageSettings::singleton();
        $settings->update([
            'kids_catalog_label' => 'Nos programmes enfants',
            'adults_catalog_label' => 'Nos formations adultes',
        ]);

        $this->get('/enfants')
            ->assertOk()
            ->assertSee('Nos programmes enfants');

        $this->get('/adultes')
            ->assertOk()
            ->assertSee('Nos formations adultes');

        $settings->update([
            'kids_catalog_label' => null,
            'adults_catalog_label' => null,
        ]);

        $this->get('/enfants')
            ->assertOk()
            ->assertSee('Cours pour enfants');

        $this->get('/adultes')
            ->assertOk()
            ->assertSee('Cours pour adultes');
    }

    public function test_course_show_renders_full_details(): void
    {
        $this->seed([
            CourseSeeder::class,
            CoursePageSettingsSeeder::class,
        ]);

        $response = $this->get('/cours/initiation-baraaim-quran');

        $response->assertOk()
            ->assertViewIs('courses.show')
            ->assertSee('Initiation des Baraa\'im et mémorisation du Coran')
            ->assertSee('Ce cours est-il fait pour vous ?')
            ->assertSee('Que vas-tu apprendre dans ce programme ?')
            ->assertSee('Comment se déroule le cours ?')
            ->assertSee('Votre parcours et votre progression')
            ->assertSee('Questions fréquentes')
            ->assertSee('Réserver une séance', false)
            ->assertSee('application/ld+json', false);
    }

    public function test_course_show_returns_404_for_unknown_or_inactive_courses(): void
    {
        $this->seed([
            CourseSeeder::class,
            CoursePageSettingsSeeder::class,
        ]);

        $this->get('/cours/non-existent-slug')->assertNotFound();

        $course = Course::query()->first();
        $course->update(['is_active' => false]);

        $this->get('/cours/'.$course->slug)->assertNotFound();
    }

    public function test_courses_scope_filters_by_audience(): void
    {
        $kids = Course::factory()->kids()->create();
        $adults = Course::factory()->adults()->create();

        $this->assertContains(
            $kids->id,
            Course::query()->forAudience(CourseAudience::Kids)->pluck('id')->all()
        );
        $this->assertNotContains(
            $adults->id,
            Course::query()->forAudience(CourseAudience::Kids)->pluck('id')->all()
        );
    }

    public function test_course_min_age_label(): void
    {
        $course = Course::factory()->create([
            'age_band_min' => 5,
        ]);

        $this->assertSame('À partir de 5 ans', $course->minAgeLabel());

        $course = Course::factory()->create([
            'age_band_min' => null,
        ]);

        $this->assertNull($course->minAgeLabel());
    }

    public function test_course_badge_text(): void
    {
        $course = Course::factory()->create([
            'badge_text' => '30 à 45 min/séance',
        ]);

        $this->assertSame('30 à 45 min/séance', $course->badge_text);

        $course = Course::factory()->create([
            'badge_text' => null,
        ]);

        $this->assertNull($course->badge_text);
    }

    public function test_landing_nav_includes_kids_and_adults_links(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/')
            ->assertOk()
            ->assertSee('Cours pour enfants')
            ->assertSee('Cours pour adultes');
    }

    public function test_course_page_settings_singleton(): void
    {
        $this->seed(CoursePageSettingsSeeder::class);

        $settings = CoursePageSettings::singleton();

        $this->assertSame(1, CoursePageSettings::query()->count());
        $this->assertSame('Cours pour enfants', $settings->kids_label);
    }

    public function test_course_testimonials_render_on_the_right_page(): void
    {
        $this->seed([
            CourseSeeder::class,
            CoursePageSettingsSeeder::class,
        ]);

        LandingTestimonial::create([
            'type' => TestimonialType::Google,
            'placements' => [TestimonialPlacement::Landing, TestimonialPlacement::Kids],
            'author_name' => 'Parent Avis Enfants',
            'content' => 'Retour élève enfant.',
            'rating' => 5,
            'is_active' => true,
            'sort_order' => 0,
        ]);
        LandingTestimonial::create([
            'type' => TestimonialType::Google,
            'placements' => [TestimonialPlacement::Landing, TestimonialPlacement::Adults],
            'author_name' => 'Parent Avis Adultes',
            'content' => 'Retour élève adulte.',
            'rating' => 5,
            'is_active' => true,
            'sort_order' => 1,
        ]);
        LandingTestimonial::create([
            'type' => TestimonialType::Whatsapp,
            'placements' => [TestimonialPlacement::Landing, TestimonialPlacement::Kids, TestimonialPlacement::Adults],
            'author_name' => 'Avis Les Deux',
            'content' => 'Disponible partout.',
            'is_active' => true,
            'sort_order' => 2,
        ]);
        LandingTestimonial::create([
            'type' => TestimonialType::Whatsapp,
            'placements' => [TestimonialPlacement::Landing],
            'author_name' => 'Avis Accueil',
            'content' => 'Réservé à la page d\'accueil.',
            'is_active' => true,
            'sort_order' => 3,
        ]);

        $this->get('/enfants')
            ->assertOk()
            ->assertSee('Parent Avis Enfants')
            ->assertSee('Avis Les Deux')
            ->assertDontSee('Parent Avis Adultes')
            ->assertDontSee('Avis Accueil');

        $this->get('/adultes')
            ->assertOk()
            ->assertSee('Parent Avis Adultes')
            ->assertSee('Avis Les Deux')
            ->assertDontSee('Parent Avis Enfants')
            ->assertDontSee('Avis Accueil');
    }

    public function test_testimonial_placed_outside_the_landing_page_stays_off_it(): void
    {
        $this->seed([
            CourseSeeder::class,
            CoursePageSettingsSeeder::class,
        ]);

        LandingTestimonial::create([
            'type' => TestimonialType::Google,
            'placements' => [TestimonialPlacement::Kids],
            'author_name' => 'Avis Kids فقط',
            'content' => 'Retours élève enfant.',
            'rating' => 5,
            'is_active' => true,
            'sort_order' => 0,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertDontSee('Avis Kids فقط');

        $this->get('/enfants')
            ->assertOk()
            ->assertSee('Avis Kids فقط');
    }

    public function test_course_detail_page_paginates_testimonials(): void
    {
        $this->seed([
            CourseSeeder::class,
            CoursePageSettingsSeeder::class,
        ]);

        CoursePageSettings::singleton()->update([
            'kids_testimonials_per_page' => 2,
        ]);

        foreach (range(1, 4) as $index) {
            LandingTestimonial::create([
                'type' => TestimonialType::Google,
                'placements' => [TestimonialPlacement::Landing, TestimonialPlacement::Kids],
                'author_name' => "Avis numéro {$index}",
                'content' => "Contenu {$index}.",
                'rating' => 5,
                'is_active' => true,
                'sort_order' => $index,
            ]);
        }

        $kidsCourse = Course::query()->where('audience', CourseAudience::Kids->value)->firstOrFail();

        $this->get("/cours/{$kidsCourse->slug}")
            ->assertOk()
            ->assertSee('Avis numéro 1')
            ->assertSee('Avis numéro 2')
            ->assertDontSee('Avis numéro 3')
            ->assertDontSee('Avis numéro 4');

        $this->get("/cours/{$kidsCourse->slug}?testimonials=2")
            ->assertOk()
            ->assertSee('Avis numéro 3')
            ->assertSee('Avis numéro 4')
            ->assertDontSee('Avis numéro 1');
    }

    public function test_landing_page_keeps_showing_every_testimonial_without_pagination(): void
    {
        $this->seed([
            CourseSeeder::class,
            CoursePageSettingsSeeder::class,
        ]);

        CoursePageSettings::singleton()->update([
            'kids_testimonials_per_page' => 2,
        ]);

        foreach (range(1, 5) as $index) {
            LandingTestimonial::create([
                'type' => TestimonialType::Google,
                'placements' => [TestimonialPlacement::Landing],
                'author_name' => "Avis Landing {$index}",
                'content' => "Contenu {$index}.",
                'rating' => 5,
                'is_active' => true,
                'sort_order' => $index,
            ]);
        }

        $this->get('/')
            ->assertOk()
            ->assertSee('Avis Landing 1')
            ->assertSee('Avis Landing 2')
            ->assertSee('Avis Landing 3')
            ->assertSee('Avis Landing 4')
            ->assertSee('Avis Landing 5')
            ->assertDontSee('السابق', false);
    }

    public function test_course_admin_resources_render(): void
    {
        $this->seed([
            CourseSeeder::class,
            CoursePageSettingsSeeder::class,
        ]);

        LandingTestimonial::create([
            'type' => TestimonialType::Whatsapp,
            'author_name' => 'Avis Admin',
            'content' => 'Contenu.',
            'is_active' => true,
            'sort_order' => 0,
        ]);

        $user = User::factory()->create();

        $this->actingAs($user)->get('/admin/courses')
            ->assertOk()
            ->assertSee('toggleTableReordering', false);
        $this->actingAs($user)->get('/admin/courses/create')->assertOk();
        $this->actingAs($user)->get('/admin/courses/1/edit')->assertOk();
        $this->actingAs($user)->get('/admin/course-page-settings')->assertOk();
        $this->actingAs($user)->get('/admin/landing-testimonials')->assertOk();
        $this->actingAs($user)->get('/admin/landing-testimonials/1/edit')->assertOk();
    }

    public function test_kids_faq_items_render_per_question_ctas(): void
    {
        $this->seed([
            CourseSeeder::class,
            CoursePageSettingsSeeder::class,
        ]);

        $settings = CoursePageSettings::singleton();
        $settings->update([
            'kids_faq_items' => [
                [
                    'question' => 'Question Enfant A ?',
                    'answer' => '<p>Réponse enfant A.</p>',
                    'cta1_text' => 'CTA Un Enfant',
                    'cta1_url' => 'https://example.com',
                    'cta2_text' => 'CTA Deux Enfant',
                    'cta2_url' => '#',
                ],
            ],
        ]);

        $this->get('/enfants')
            ->assertOk()
            ->assertSee('Question Enfant A ?')
            ->assertSee('CTA Un Enfant')
            ->assertSee('CTA Deux Enfant')
            ->assertSee('faq-cta-row', false);
    }

    public function test_adults_faq_items_render_per_question_ctas(): void
    {
        $this->seed([
            CourseSeeder::class,
            CoursePageSettingsSeeder::class,
        ]);

        $settings = CoursePageSettings::singleton();
        $settings->update([
            'adults_faq_items' => [
                [
                    'question' => 'Question Adulte A ?',
                    'answer' => '<p>Réponse adulte A.</p>',
                    'cta1_text' => 'CTA Un Adulte',
                    'cta1_url' => '#',
                    'cta2_text' => 'CTA Deux Adulte',
                    'cta2_url' => 'https://example.com',
                ],
            ],
        ]);

        $this->get('/adultes')
            ->assertOk()
            ->assertSee('Question Adulte A ?')
            ->assertSee('CTA Un Adulte')
            ->assertSee('CTA Deux Adulte')
            ->assertSee('faq-cta-row', false);
    }

    public function test_kids_course_inherits_kids_catalog_content_when_its_blocks_are_empty(): void
    {
        $this->seed([
            CourseSeeder::class,
            CoursePageSettingsSeeder::class,
        ]);

        $response = $this->get('/cours/initiation-baraaim-quran');

        $response->assertOk()
            ->assertSee('Récitation du Coran')
            ->assertSee('Invocations')
            ->assertSee('Séance interactive')
            ->assertSee('Méthode ludique, positive et bienveillante')
            ->assertSee('Les cours de Coran pour enfants sont-ils individuels ?');
    }

    public function test_adults_course_inherits_adults_catalog_content_when_its_blocks_are_empty(): void
    {
        $this->seed([
            CourseSeeder::class,
            CoursePageSettingsSeeder::class,
        ]);

        $response = $this->get('/cours/correction-recitation-tajwid');

        $response->assertOk()
            ->assertSee('Correction de la récitation')
            ->assertSee('Règles du Tajwid')
            ->assertSee('Réservez votre essai')
            ->assertSee('Enseignants Al-Azhar — Diplômés')
            ->assertSee('Puis-je apprendre le Coran à mon rythme ?')
            ->assertDontSee('Séance interactive');
    }

    public function test_course_hero_label_prefers_the_course_then_the_shared_copy_then_the_default(): void
    {
        $this->seed(CoursePageSettingsSeeder::class);

        $this->assertTrue(Schema::hasColumn('courses', 'hero_label'));

        $course = Course::factory()->kids()->create(['hero_label' => null]);

        $this->get('/cours/'.$course->slug)
            ->assertOk()
            ->assertSee('Programme dédié aux enfants et aux jeunes');

        $course->update(['hero_label' => 'Programme réservé à cette formation']);

        $this->get('/cours/'.$course->slug)
            ->assertOk()
            ->assertSee('Programme réservé à cette formation')
            ->assertDontSee('Programme dédié aux enfants et aux jeunes');

        $course->update(['hero_label' => '   ']);

        $this->get('/cours/'.$course->slug)
            ->assertOk()
            ->assertSee('Programme dédié aux enfants et aux jeunes');

        $course->update(['hero_label' => null]);
        CoursePageSettings::singleton()->update(['details_kids_hero_label' => null]);

        $this->get('/cours/'.$course->slug)
            ->assertOk()
            ->assertSee('Programme dédié aux enfants et aux jeunes');
    }

    public function test_course_stored_content_overrides_catalog_content(): void
    {
        $this->seed(CoursePageSettingsSeeder::class);

        $course = Course::factory()->kids()->create([
            'curriculum_items' => [
                ['icon' => '📖', 'title' => 'Programme propre à la formation', 'description' => '<p>Contenu dédié.</p>'],
            ],
            'journey_steps' => [
                ['htmlClass' => 'gold', 'number' => '01', 'title' => 'Étape propre à la formation', 'description' => '<p>Étape dédiée.</p>'],
            ],
            'suitability_checks' => ['Convient à des profils spécifiques'],
            'faqs' => [
                ['question' => 'Question propre à la formation ?', 'answer' => '<p>Réponse dédiée.</p>'],
            ],
        ]);

        $this->get('/cours/'.$course->slug)
            ->assertOk()
            ->assertSee('Programme propre à la formation')
            ->assertSee('Étape propre à la formation')
            ->assertSee('Convient à des profils spécifiques')
            ->assertSee('Question propre à la formation ?')
            ->assertDontSee('Les cours de Coran pour enfants sont-ils individuels ?')
            ->assertDontSee('Séance interactive');
    }

    public function test_empty_catalog_blocks_hide_inherited_course_sections_gracefully(): void
    {
        $this->seed(CoursePageSettingsSeeder::class);
        CoursePageSettings::singleton()->update([
            'kids_curriculum_items' => null,
            'kids_journey_items' => null,
            'kids_about_items' => null,
            'kids_faq_items' => null,
        ]);

        $course = Course::factory()->kids()->create([
            'curriculum_items' => null,
            'journey_steps' => null,
            'suitability_checks' => null,
            'faqs' => null,
        ]);

        $this->get('/cours/'.$course->slug)
            ->assertOk()
            ->assertSee($course->title)
            ->assertDontSee('Que vas-tu apprendre dans ce programme ?')
            ->assertSee('Comment se déroule le cours ?');
    }

    public function test_related_courses_render_on_course_detail_page(): void
    {
        $this->seed(CoursePageSettingsSeeder::class);

        $parent = Course::factory()->kids()->create();
        $relatedOne = Course::factory()->kids()->create();
        $relatedTwo = Course::factory()->adults()->create();
        $unrelated = Course::factory()->kids()->create();

        $parent->relatedCourses()->attach([$relatedOne->id, $relatedTwo->id]);

        $this->get('/cours/'.$parent->slug)
            ->assertOk()
            ->assertSee('Autres cours similaires')
            ->assertSee($relatedOne->title)
            ->assertSee($relatedTwo->title)
            ->assertDontSee($unrelated->title);
    }

    public function test_inactive_related_courses_are_hidden_from_course_page(): void
    {
        $this->seed(CoursePageSettingsSeeder::class);

        $parent = Course::factory()->kids()->create();
        $inactive = Course::factory()->kids()->create(['is_active' => false]);
        $active = Course::factory()->kids()->create();

        $parent->relatedCourses()->attach([$inactive->id, $active->id]);

        $this->get('/cours/'.$parent->slug)
            ->assertOk()
            ->assertSee('Autres cours similaires')
            ->assertDontSee($inactive->title)
            ->assertSee($active->title);
    }

    public function test_related_courses_admin_form_renders_relationship_select(): void
    {
        $this->seed([
            CourseSeeder::class,
            CoursePageSettingsSeeder::class,
        ]);

        $user = User::factory()->create();
        $course = Course::query()->first();

        $this->actingAs($user)
            ->get('/admin/courses/'.$course->id.'/edit')
            ->assertOk()
            ->assertSee('دورات مرتبطة');
    }

    public function test_course_related_courses_belongs_to_many_returns_linked_courses(): void
    {
        $course = Course::factory()->kids()->create();
        $related = Course::factory()->kids()->create();

        $course->relatedCourses()->attach([$related->id]);

        $this->assertDatabaseHas('course_related_course', [
            'course_id' => $course->id,
            'related_course_id' => $related->id,
        ]);
        $this->assertTrue($course->relatedCourses()->pluck('courses.id')->contains($related->id));
    }

    public function test_the_course_form_no_longer_asks_for_a_long_description(): void
    {
        $this->seed([
            CourseSeeder::class,
            CoursePageSettingsSeeder::class,
        ]);

        $this->actingAs(User::factory()->create());

        Livewire::test(EditCourse::class, ['record' => Course::query()->firstOrFail()->getKey()])
            ->assertOk()
            ->assertFormFieldDoesNotExist('description');
    }

    public function test_a_course_is_stored_without_a_description(): void
    {
        $this->seed(CoursePageSettingsSeeder::class);

        $course = Course::create([
            'audience' => CourseAudience::Kids->value,
            'title' => 'Cours sans description',
            'slug' => 'cours-sans-description',
            'short_description' => 'Un résumé court qui fait le lien vers la page.',
        ]);

        $this->assertNull($course->fresh()->description);
    }

    public function test_editing_a_course_keeps_the_description_it_already_stores(): void
    {
        $this->seed([
            CourseSeeder::class,
            CoursePageSettingsSeeder::class,
        ]);

        $this->actingAs(User::factory()->create());

        $course = Course::query()->firstOrFail();
        $stored = $course->description;

        Livewire::test(EditCourse::class, ['record' => $course->getKey()])
            ->fillForm(['title' => $course->title.' — révisé'])
            ->call('save')
            ->assertHasNoErrors();

        $this->assertSame($stored, $course->fresh()->description);
    }

    public function test_the_meta_description_falls_back_to_the_description_without_its_html(): void
    {
        $this->seed([
            CourseSeeder::class,
            CoursePageSettingsSeeder::class,
        ]);

        $course = Course::query()->firstOrFail();
        $course->update(['meta_description' => null]);

        $this->get('/cours/'.$course->slug)
            ->assertOk()
            ->assertSeeInOrder(
                ['<meta name="description" content="', 'Ce programme initie les plus petits'],
                escape: false,
            );
    }

    public function test_the_course_page_renders_with_no_description_at_all(): void
    {
        $this->seed([
            CourseSeeder::class,
            CoursePageSettingsSeeder::class,
        ]);

        $course = Course::query()->firstOrFail();
        $course->update(['description' => null, 'meta_description' => null]);

        $this->get('/cours/'.$course->slug)
            ->assertOk()
            ->assertViewIs('courses.show')
            ->assertSee('<meta name="description" content="">', false);
    }
}
