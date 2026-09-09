<?php

namespace Tests\Feature;

use App\Models\Lesson;
use App\Models\User;
use Database\Seeders\CourseSeeder;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\LessonSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LessonPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_lessons_index_renders_all_lessons_and_categories(): void
    {
        $this->seed([
            CourseSeeder::class,
            LessonSeeder::class,
        ]);

        $response = $this->get('/lecons-gratuites');

        $response->assertOk()
            ->assertViewIs('lessons.index')
            ->assertSee('Découvrez par vous-même notre méthode et la qualité de l\'enseignement', false)
            ->assertSee('Comment prononcer les trois lettres de madd facilement avec votre enfant ?')
            ->assertSee('Règles de la nun sakina et du tanwin — l\'izhar')
            ->assertSee('Les adhkar du matin et du soir pour les enfants simplifiés')
            ->assertSee('Tous')
            ->assertSee('Leçons gratuites')
            ->assertSee('build/assets/lessons-', false);
    }

    public function test_lessons_index_filters_by_category(): void
    {
        $this->seed([
            CourseSeeder::class,
            LessonSeeder::class,
        ]);

        $response = $this->get('/lecons-gratuites?k=tajwid');

        $response->assertOk()
            ->assertSee('Règles de la nun sakina et du tanwin — l\'izhar')
            ->assertDontSee('Comment prononcer les trois lettres de madd facilement avec votre enfant ?')
            ->assertDontSee('Les adhkar du matin et du soir pour les enfants simplifiés');
    }

    public function test_lesson_show_renders_full_details(): void
    {
        $this->seed([
            CourseSeeder::class,
            LessonSeeder::class,
        ]);

        $response = $this->get('/lecons-gratuites/regles-nun-sakina-tanwin-izhar');

        $response->assertOk()
            ->assertViewIs('lessons.show')
            ->assertSee('Règles de la nun sakina et du tanwin — l\'izhar')
            ->assertSee('Lié au cours')
            ->assertSee('Correction de la récitation et règles du Tajwid')
            ->assertSee('Les lettres de l\'izhar', false)
            ->assertSee('Sommaire')
            ->assertSee('audio', false)
            ->assertSee('application/ld+json', false)
            ->assertSee('Découvrir la formation complète')
            ->assertSee('lesson-tip', false);
    }

    public function test_lessons_show_course_cta_link(): void
    {
        $this->seed([
            CourseSeeder::class,
            LessonSeeder::class,
        ]);

        $response = $this->get('/lecons-gratuites/regles-nun-sakina-tanwin-izhar');

        $response->assertOk()
            ->assertSee('/cours/correction-recitation-tajwid', false);
    }

    public function test_lesson_show_returns_404_for_unknown_or_inactive_lessons(): void
    {
        $this->seed([
            CourseSeeder::class,
            LessonSeeder::class,
        ]);

        $this->get('/lecons-gratuites/non-existent-slug')->assertNotFound();

        $lesson = Lesson::query()->first();
        $lesson->update(['is_active' => false]);

        $this->get('/lecons-gratuites/'.$lesson->slug)->assertNotFound();
    }

    public function test_lesson_cover_image_url_returns_absolute_url(): void
    {
        $lesson = Lesson::factory()->create([
            'cover_image' => 'https://example.com/cover.jpg',
        ]);

        $this->assertSame('https://example.com/cover.jpg', $lesson->cover_image_url);

        $lesson = Lesson::factory()->create([
            'cover_image' => 'lessons/covers/cover.jpg',
        ]);

        $this->assertStringStartsWith('http', $lesson->cover_image_url);
        $this->assertStringContainsString('lessons/covers/cover.jpg', $lesson->cover_image_url);
    }

    public function test_lesson_active_scope_filters_inactive_lessons(): void
    {
        $active = Lesson::factory()->create();
        $inactive = Lesson::factory()->inactive()->create();

        $this->assertContains($active->id, Lesson::query()->active()->pluck('id')->all());
        $this->assertNotContains($inactive->id, Lesson::query()->active()->pluck('id')->all());
    }

    public function test_lesson_category_is_plain_text(): void
    {
        $lesson = Lesson::factory()->create([
            'category' => 'tajwid',
        ]);

        $this->assertSame('tajwid', $lesson->category);
    }

    public function test_lesson_inline_audio_shortcode_renders_audio_player(): void
    {
        $lesson = Lesson::factory()->create([
            'body' => '<h2>Introduction</h2><p>Le texte avant.</p>[audio:https://example.com/audio.mp3]<p>Le texte après.</p>',
        ]);

        $response = $this->get('/lecons-gratuites/'.$lesson->slug);

        $response->assertOk()
            ->assertSee('class="lesson-audio"', false)
            ->assertSee('src="https://example.com/audio.mp3"', false)
            ->assertDontSee('[audio:', false);
    }

    public function test_lesson_pdf_download_link_renders(): void
    {
        $lesson = Lesson::factory()->create([
            'pdf_url' => 'lessons/pdfs/fichier.pdf',
        ]);

        $response = $this->get('/lecons-gratuites/'.$lesson->slug);

        $response->assertOk()
            ->assertSee('Fiche PDF de la leçon')
            ->assertSee('Télécharger le PDF')
            ->assertSee('lessons/pdfs/fichier.pdf', false);
    }

    public function test_lesson_with_nullable_fields_renders(): void
    {
        $lesson = Lesson::factory()->create([
            'category' => null,
            'title' => null,
            'excerpt' => null,
            'body' => null,
            'reading_time' => null,
            'sort_order' => null,
        ]);

        $this->get('/lecons-gratuites/'.$lesson->slug)->assertOk();
        $this->get('/lecons-gratuites')->assertOk();
    }

    public function test_landing_nav_includes_lessons_link(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/')
            ->assertOk()
            ->assertSee('Leçons gratuites');
    }

    public function test_lessons_admin_resources_render(): void
    {
        $this->seed([
            CourseSeeder::class,
            LessonSeeder::class,
        ]);

        $user = User::factory()->create();

        $this->actingAs($user)->get('/admin/lessons')->assertOk();
        $this->actingAs($user)->get('/admin/lessons/create')->assertOk();
        $this->actingAs($user)->get('/admin/lessons/1/edit')->assertOk();
    }
}
