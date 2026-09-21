<?php

namespace Tests\Feature;

use App\Enums\CourseAudience;
use App\Enums\TestimonialAudience;
use App\Enums\TestimonialType;
use App\Models\Course;
use App\Models\CoursePageSettings;
use App\Models\LandingTestimonial;
use App\Models\User;
use Database\Seeders\CoursePageSettingsSeeder;
use Database\Seeders\CourseSeeder;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

    public function test_course_session_range_label(): void
    {
        $course = Course::factory()->create([
            'session_minutes_min' => 30,
            'session_minutes_max' => 45,
        ]);

        $this->assertSame('30 à 45 min/séance', $course->sessionRangeLabel());

        $course = Course::factory()->create([
            'session_minutes_min' => 45,
            'session_minutes_max' => 45,
        ]);

        $this->assertSame('45 min/séance', $course->sessionRangeLabel());
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
            'page_audience' => TestimonialAudience::Kids,
            'author_name' => 'Parent Avis Enfants',
            'content' => 'Retour élève enfant.',
            'rating' => 5,
            'is_active' => true,
            'sort_order' => 0,
        ]);
        LandingTestimonial::create([
            'type' => TestimonialType::Google,
            'page_audience' => TestimonialAudience::Adults,
            'author_name' => 'Parent Avis Adultes',
            'content' => 'Retour élève adulte.',
            'rating' => 5,
            'is_active' => true,
            'sort_order' => 1,
        ]);
        LandingTestimonial::create([
            'type' => TestimonialType::Whatsapp,
            'page_audience' => TestimonialAudience::Both,
            'author_name' => 'Avis Les Deux',
            'content' => 'Disponible partout.',
            'is_active' => true,
            'sort_order' => 2,
        ]);
        LandingTestimonial::create([
            'type' => TestimonialType::Whatsapp,
            'page_audience' => TestimonialAudience::LandingOnly,
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

        $this->actingAs($user)->get('/admin/courses')->assertOk();
        $this->actingAs($user)->get('/admin/courses/create')->assertOk();
        $this->actingAs($user)->get('/admin/courses/1/edit')->assertOk();
        $this->actingAs($user)->get('/admin/course-page-settings')->assertOk();
        $this->actingAs($user)->get('/admin/landing-testimonials')->assertOk();
        $this->actingAs($user)->get('/admin/landing-testimonials/1/edit')->assertOk();
    }
}
