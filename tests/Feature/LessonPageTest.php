<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\LandingSettings;
use App\Models\Lesson;
use App\Models\LessonCategory;
use App\Models\LessonPageSettings;
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
            ->assertSee('Découvrez par vous-même notre méthode et la qualité de l\'enseignement')
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

    public function test_lessons_index_paginates_and_keeps_filters_in_page_links(): void
    {
        $category = LessonCategory::factory()->create(['slug' => 'tajwid', 'name' => 'تجويد وتلاوة']);

        Lesson::factory()->count(11)->create()->each(
            fn (Lesson $lesson) => $lesson->categories()->attach($category->id)
        );

        $response = $this->get('/lecons-gratuites?k=tajwid');

        $response->assertOk()
            ->assertSee('k=tajwid&amp;page=2', false)
            ->assertSee('aria-label="Page suivante"', false)
            ->assertSee('<strong>11</strong> leçons trouvées', false);

        $response = $this->get('/lecons-gratuites?k=tajwid&page=2');

        $response->assertOk()
            ->assertSee('rel="prev"', false)
            ->assertSee('page-link is-disabled', false);

        $this->get('/lecons-gratuites?k=tajwid&page=99')->assertOk();
    }

    public function test_lessons_index_searches_lessons_and_keeps_search_in_page_links(): void
    {
        Lesson::factory()->create([
            'title' => 'Comprendre la règle de la nun sakina',
            'excerpt' => 'Une leçon sur la prononciation.',
        ]);

        Lesson::factory()->create([
            'title' => 'Les lettres de l\'alphabet arabe',
            'excerpt' => 'Une autre leçon sans rapport.',
        ]);

        $response = $this->get('/lecons-gratuites?q=sakina');

        $response->assertOk()
            ->assertSee('Comprendre la règle de la nun sakina')
            ->assertSee('<strong>1</strong> leçon trouvée', false)
            ->assertSee('value="sakina"', false)
            ->assertDontSee('Les lettres de l\'alphabet arabe');

        $this->get('/lecons-gratuites?q=zzzznothing')
            ->assertOk()
            ->assertSee('Aucune leçon ne correspond à votre recherche');
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
            ->assertSee('Formations liées')
            ->assertSee('Réserver l\'essai gratuit')
            ->assertSee('lesson-tip', false);
    }

    public function test_lesson_show_in_article_cta_comes_from_the_page_settings(): void
    {
        $this->seed([
            CourseSeeder::class,
            LessonSeeder::class,
        ]);

        LessonPageSettings::singleton()->update([
            'cta_badge' => 'Badge personnalise',
            'cta_title' => 'Titre CTA personnalise',
            'cta_text' => 'Texte CTA personnalise',
            'cta_button_label' => 'Bouton personnalise',
            'cta_button_url' => 'https://example.com/cta',
        ]);

        $this->get('/lecons-gratuites/regles-nun-sakina-tanwin-izhar')
            ->assertOk()
            ->assertSee('Badge personnalise')
            ->assertSee('Titre CTA personnalise')
            ->assertSee('Texte CTA personnalise')
            ->assertSee('Bouton personnalise')
            ->assertSee('https://example.com/cta', false);
    }

    public function test_lesson_show_embeds_the_trial_form_so_ctas_scroll_within_the_page(): void
    {
        $lesson = Lesson::factory()->create(['slug' => 'trial-lesson']);

        $response = $this->get('/lecons-gratuites/trial-lesson');

        $response->assertOk()
            ->assertSee('id="trial-form"', false)
            ->assertSee('id="trialForm"', false)
            ->assertSee('href="#trial-form"', false);

        $this->assertSame(1, substr_count($response->getContent(), 'id="trial-form"'), 'The in-page trial form must be rendered exactly once.');
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

    public function test_lesson_can_be_linked_to_multiple_courses(): void
    {
        $lesson = Lesson::factory()->create(['slug' => 'multi-course-lesson']);

        $courses = Course::factory()->count(2)->create();
        $lesson->courses()->attach($courses->pluck('id'));

        $this->assertCount(2, $lesson->fresh()->courses);
    }

    public function test_lesson_show_lists_each_related_course_as_a_sidebar_card(): void
    {
        $lesson = Lesson::factory()->create(['slug' => 'multi-course-lesson']);

        $first = Course::factory()->create(['title' => 'Formation Première']);
        $second = Course::factory()->create(['title' => 'Formation Seconde']);

        $lesson->courses()->attach([$first->id, $second->id]);

        $response = $this->get('/lecons-gratuites/multi-course-lesson');

        $response->assertOk()
            ->assertSee('Formations liées')
            ->assertSee('lesson-course-card', false)
            ->assertSee('Formation Première')
            ->assertSee('Formation Seconde')
            ->assertSee('/cours/'.$first->slug, false)
            ->assertSee('/cours/'.$second->slug, false);

        $this->assertSame(2, substr_count($response->getContent(), 'lesson-course-card'));
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

    public function test_lesson_show_uses_admin_picked_related_lessons(): void
    {
        $parent = Lesson::factory()->create(['slug' => 'parent-lesson']);

        $picked = Lesson::factory()->create([
            'title' => 'Leçon choisie depuis le tableau de bord',
        ]);

        $sameCategoryNotPicked = Lesson::factory()->create(['title' => 'Leçon même catégorie non choisie']);

        $parent->relatedLessons()->attach($picked->id);

        $this->get('/lecons-gratuites/parent-lesson')
            ->assertOk()
            ->assertSee('Leçons recommandées')
            ->assertSee('Leçon choisie depuis le tableau de bord')
            ->assertDontSee('Leçon même catégorie non choisie');
    }

    public function test_lesson_show_falls_back_to_same_category_lessons_when_none_picked(): void
    {
        $category = LessonCategory::factory()->create();

        $parent = Lesson::factory()->create(['slug' => 'parent-lesson']);
        $parent->categories()->attach($category->id);

        $sameCategory = Lesson::factory()->create(['title' => 'Leçon de la même catégorie']);
        $sameCategory->categories()->attach($category->id);

        $this->get('/lecons-gratuites/parent-lesson')
            ->assertOk()
            ->assertSee('Leçon de la même catégorie');
    }

    public function test_lesson_show_hides_inactive_related_lessons(): void
    {
        $parent = Lesson::factory()->create(['slug' => 'parent-lesson']);

        $active = Lesson::factory()->create();
        $inactive = Lesson::factory()->inactive()->create();

        $parent->relatedLessons()->attach([$inactive->id, $active->id]);

        $this->get('/lecons-gratuites/parent-lesson')
            ->assertOk()
            ->assertSee($active->title)
            ->assertDontSee($inactive->title);
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

    public function test_lesson_can_have_multiple_managed_categories(): void
    {
        $lesson = Lesson::factory()->create();

        $categories = LessonCategory::factory()->count(2)->create();
        $lesson->categories()->attach($categories->pluck('id'));

        $this->assertCount(2, $lesson->fresh()->categories);
    }

    public function test_lessons_index_lists_categories_from_the_database(): void
    {
        $category = LessonCategory::factory()->create([
            'name' => 'تصنيف مضاف من اللوحة',
            'slug' => 'custom-category',
            'sort_order' => 5,
        ]);

        $lesson = Lesson::factory()->create();
        $lesson->categories()->attach($category->id);

        $this->get('/lecons-gratuites')
            ->assertOk()
            ->assertSee('تصنيف مضاف من اللوحة');

        $this->get('/lecons-gratuites?k=custom-category')
            ->assertOk()
            ->assertSee($lesson->title);
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

    public function test_lesson_main_audio_renders_uploaded_file_url(): void
    {
        $lesson = Lesson::factory()->create([
            'audio_url' => 'lessons/audio/lecon.mp3',
        ]);

        $response = $this->get('/lecons-gratuites/'.$lesson->slug);

        $response->assertOk()
            ->assertSee('Fichier audio de la leçon')
            ->assertSee('lessons/audio/lecon.mp3', false);
    }

    public function test_lesson_main_audio_renders_external_url(): void
    {
        $lesson = Lesson::factory()->create([
            'audio_url' => 'https://example.com/audio.mp3',
        ]);

        $response = $this->get('/lecons-gratuites/'.$lesson->slug);

        $response->assertOk()
            ->assertSee('https://example.com/audio.mp3', false);
    }

    public function test_lesson_rich_editor_image_attachment_renders_in_body(): void
    {
        $lesson = Lesson::factory()->create([
            'body' => '<h2>L\'exemple</h2><p>Voici une image :</p><img src="storage/lessons/attachments/illustration.jpg" alt="Illustration">',
        ]);

        $response = $this->get('/lecons-gratuites/'.$lesson->slug);

        $response->assertOk()
            ->assertSee('<img src="storage/lessons/attachments/illustration.jpg" alt="Illustration">', false);
    }

    public function test_lesson_with_nullable_fields_renders(): void
    {
        $lesson = Lesson::factory()->create([
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

    public function test_lessons_index_copy_and_seo_come_from_the_page_settings(): void
    {
        $this->seed([
            CourseSeeder::class,
            LessonSeeder::class,
        ]);

        LessonPageSettings::singleton()->update([
            'label' => 'Mini-leçons',
            'title' => 'Testez notre pédagogie',
            'description' => 'Une description choisie depuis le tableau de bord.',
            'meta_title' => 'Leçons | Ar-Rahman Academy',
            'meta_description' => 'Description de meta choisie depuis le tableau de bord.',
        ]);

        $this->get('/lecons-gratuites')
            ->assertOk()
            ->assertSee('Mini-leçons')
            ->assertSee('Testez notre pédagogie')
            ->assertSee('Une description choisie depuis le tableau de bord.')
            ->assertSee('<title>Leçons | Ar-Rahman Academy</title>', false)
            ->assertSee('Description de meta choisie depuis le tableau de bord.', false)
            ->assertDontSee('Exemples et explications gratuits');
    }

    public function test_lessons_index_falls_back_to_the_bundled_wording_without_settings(): void
    {
        $this->seed([
            CourseSeeder::class,
            LessonSeeder::class,
        ]);

        $settings = LessonPageSettings::singleton();
        $settings->update([
            'label' => null,
            'title' => null,
            'description' => null,
            'meta_title' => null,
            'meta_description' => null,
        ]);

        $this->get('/lecons-gratuites')
            ->assertOk()
            ->assertDontSee('section-label')
            ->assertDontSee('<p class="section-sub">')
            ->assertSee('Découvrez par vous-même notre méthode et la qualité de l\'enseignement');
    }

    public function test_lessons_og_image_uses_the_page_setting(): void
    {
        $this->seed([
            CourseSeeder::class,
            LessonSeeder::class,
        ]);

        LessonPageSettings::singleton()->update(['og_image' => 'images/og/lessons.jpg']);

        $this->get('/lecons-gratuites')
            ->assertOk()
            ->assertSee('<meta property="og:image" content="'.asset('storage/images/og/lessons.jpg').'">', false);
    }

    public function test_lessons_index_is_noindex_when_the_page_settings_say_so(): void
    {
        $this->seed([
            CourseSeeder::class,
            LessonSeeder::class,
        ]);

        LessonPageSettings::singleton()->update(['is_indexed' => false]);

        $this->get('/lecons-gratuites')
            ->assertOk()
            ->assertSee('<meta name="robots" content="noindex,nofollow"', false);
    }

    public function test_lessons_admin_resources_render(): void
    {
        $this->seed([
            CourseSeeder::class,
            LessonSeeder::class,
        ]);

        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/admin/lessons')
            ->assertOk()
            ->assertSee('toggleTableReordering', false);
        $this->actingAs($user)->get('/admin/lessons/create')->assertOk();
        $this->actingAs($user)->get('/admin/lessons/1/edit')->assertOk();
        $this->actingAs($user)->get('/admin/lesson-categories')->assertOk();
        $this->actingAs($user)->get('/admin/lesson-page-settings')->assertOk();
    }

    public function test_lesson_show_uses_the_per_lesson_seo_fields(): void
    {
        $lesson = Lesson::factory()->create([
            'slug' => 'seo-lesson',
            'meta_title' => 'Titre SEO de la leçon',
            'meta_description' => 'Description SEO choisie depuis le tableau de bord.',
            'og_image' => 'images/og/seo-lesson.jpg',
            'schema_type' => 'BlogPosting',
        ]);

        $this->get('/lecons-gratuites/seo-lesson')
            ->assertOk()
            ->assertSee('<title>Titre SEO de la leçon</title>', false)
            ->assertSee('Description SEO choisie depuis le tableau de bord.', false)
            ->assertSee('<meta property="og:image" content="'.asset('storage/images/og/seo-lesson.jpg').'">', false)
            ->assertSee('"@type": "BlogPosting"', false);
    }

    public function test_lesson_show_falls_back_to_title_and_excerpt_when_seo_is_empty(): void
    {
        $lesson = Lesson::factory()->create([
            'slug' => 'plain-lesson',
            'title' => 'Une leçon sans SEO',
            'excerpt' => 'Resume utilise comme description par defaut.',
            'meta_title' => null,
            'meta_description' => null,
            'og_image' => null,
        ]);

        $brand = LandingSettings::singleton()->footer_brand_name;

        $this->get('/lecons-gratuites/plain-lesson')
            ->assertOk()
            ->assertSee('<title>Une leçon sans SEO - '.$brand.'</title>', false)
            ->assertSee('Resume utilise comme description par defaut.', false)
            ->assertSee('"@type": "Article"', false)
            ->assertSee('<meta name="robots" content="index,follow"', false);
    }

    public function test_lesson_show_is_noindex_when_the_lesson_is_not_indexed(): void
    {
        Lesson::factory()->create([
            'slug' => 'noindex-lesson',
            'is_indexed' => false,
        ]);

        $this->get('/lecons-gratuites/noindex-lesson')
            ->assertOk()
            ->assertSee('<meta name="robots" content="noindex,nofollow"', false);
    }

    public function test_lesson_og_image_accessor_resolves_uploads_and_absolute_urls(): void
    {
        $lesson = Lesson::factory()->create(['og_image' => 'images/og/cover.jpg']);

        $this->assertSame(asset('storage/images/og/cover.jpg'), $lesson->og_image_url);

        $lesson->update(['og_image' => 'https://example.com/og.jpg']);

        $this->assertSame('https://example.com/og.jpg', $lesson->og_image_url);
    }
}
