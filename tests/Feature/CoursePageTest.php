<?php

namespace Tests\Feature;

use App\Enums\CourseAudience;
use App\Models\Course;
use App\Models\CoursePageSettings;
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

    public function test_course_age_band_label(): void
    {
        $course = Course::factory()->create([
            'age_band_min' => 5,
            'age_band_max' => 8,
        ]);

        $this->assertSame('5 - 8 ans', $course->ageBandLabel());
    }

    public function test_landing_nav_includes_kids_and_adults_links(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/')
            ->assertOk()
            ->assertSee('Cours enfants')
            ->assertSee('Cours adultes');
    }

    public function test_course_page_settings_singleton(): void
    {
        $this->seed(CoursePageSettingsSeeder::class);

        $settings = CoursePageSettings::singleton();

        $this->assertSame(1, CoursePageSettings::query()->count());
        $this->assertSame('Cours pour enfants', $settings->kids_label);
    }

    public function test_courses_admin_resources_render(): void
    {
        $this->seed([
            CourseSeeder::class,
            CoursePageSettingsSeeder::class,
        ]);

        $user = User::factory()->create();

        $this->actingAs($user)->get('/admin/courses')->assertOk();
        $this->actingAs($user)->get('/admin/courses/1/edit')->assertOk();
        $this->actingAs($user)->get('/admin/course-page-settings')->assertOk();
    }
}
