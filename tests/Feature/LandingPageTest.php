<?php

namespace Tests\Feature;

use App\Enums\StudentLevel;
use App\Models\ContactSubmission;
use App\Models\LandingFaq;
use App\Models\LandingSettings;
use App\Models\LandingTeacher;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandingPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_route_renders_landing_page(): void
    {
        $this->seed(DatabaseSeeder::class);

        $response = $this->get('/');

        $response->assertOk()
            ->assertViewIs('landing.index')
            ->assertSee('Ar-Rahman')
            ->assertSee('Apprenez le Coran')
            ->assertSee('Cheikh Mohamed Amine')
            ->assertSee('essai est-elle vraiment gratuite')
            ->assertSee('id="trialForm"', false);
    }

    public function test_landing_page_uses_landing_assets_and_no_tailwind(): void
    {
        $this->seed(DatabaseSeeder::class);

        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('build/assets/landing-', false)
            ->assertDontSee('build/assets/app-', false)
            ->assertDontSee('tailwindcss', false);
    }

    public function test_contact_submission_stores_valid_record(): void
    {
        $this->seed(DatabaseSeeder::class);

        $payload = [
            'student_name' => 'أحمد',
            'parent_name' => 'محمد',
            'student_age' => 8,
            'phone' => '+33600000000',
            'email' => 'parent@example.com',
            'level' => StudentLevel::Intermediaire->value,
            'schedule' => ['الإثنين', 'الجمعة'],
            'message' => 'مرحباً، أود حجز حصة تجريبية',
        ];

        $this->postJson('/contact-submission', $payload)
            ->assertOk()
            ->assertJson(['ok' => true]);

        $this->assertDatabaseHas('contact_submissions', [
            'student_name' => 'أحمد',
            'parent_name' => 'محمد',
            'email' => 'parent@example.com',
            'status' => 'new',
        ]);

        $submission = ContactSubmission::query()->firstOrFail();

        $this->assertSame(StudentLevel::Intermediaire->value, $submission->level);
        $this->assertSame(['الإثنين', 'الجمعة'], $submission->schedule);
    }

    public function test_contact_submission_accepts_optional_fields_without_email_level_schedule(): void
    {
        $this->seed(DatabaseSeeder::class);

        $payload = [
            'student_name' => 'أحمد',
            'parent_name' => 'محمد',
            'student_age' => 8,
            'phone' => '+33600000000',
        ];

        $this->postJson('/contact-submission', $payload)
            ->assertOk()
            ->assertJson(['ok' => true]);

        $this->assertDatabaseHas('contact_submissions', [
            'student_name' => 'أحمد',
            'parent_name' => 'محمد',
            'student_age' => 8,
            'phone' => '+33600000000',
            'email' => null,
            'level' => null,
        ]);
    }

    public function test_contact_submission_accepts_free_text_level_and_schedule(): void
    {
        $this->seed(DatabaseSeeder::class);

        $payload = [
            'student_name' => 'أحمد',
            'parent_name' => 'محمد',
            'student_age' => 8,
            'phone' => '+33600000000',
            'level' => 'Débutant renforcé',
            'schedule' => ['Les après-midis'],
            'message' => 'مرحباً، أود حجز حصة تجريبية',
        ];

        $this->postJson('/contact-submission', $payload)
            ->assertOk()
            ->assertJson(['ok' => true]);

        $submission = ContactSubmission::query()->firstOrFail();

        $this->assertSame('Débutant renforcé', $submission->level);
        $this->assertSame(['Les après-midis'], $submission->schedule);
    }

    public function test_teachers_and_faqs_seed_and_render(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertSame(3, LandingTeacher::query()->count());
        $this->assertSame(6, LandingFaq::query()->count());

        $settings = LandingSettings::singleton();

        $page = $this->get('/');

        $this->assertStringContainsString('Réservez votre essai gratuit', $page->getContent());
    }

    public function test_featured_teacher_renders_golden_badge_on_card(): void
    {
        $this->seed(DatabaseSeeder::class);

        LandingTeacher::create([
            'name' => 'Cheikh Test Distingué',
            'specialty' => 'Spécialiste du Tajwid et des lectures',
            'emoji' => '👨‍🏫',
            'badges' => ['Al-Azhar'],
            'is_featured' => true,
            'is_active' => true,
            'sort_order' => 99,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Cheikh Test Distingué')
            ->assertSee('teacher-featured', false)
            ->assertSee('Membre distingué');
    }

    public function test_featured_teacher_uses_custom_badge_label(): void
    {
        $this->seed(DatabaseSeeder::class);

        LandingTeacher::create([
            'name' => 'Cheikh Test Label',
            'specialty' => 'Récitation du Coran',
            'emoji' => '👨‍🏫',
            'badges' => [],
            'is_featured' => true,
            'featured_label' => 'مدرس مميز',
            'is_active' => true,
            'sort_order' => 99,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Cheikh Test Label')
            ->assertSee('teacher-featured', false)
            ->assertSee('مدرس مميز');
    }

    public function test_non_featured_teacher_has_no_badge(): void
    {
        $this->seed(DatabaseSeeder::class);

        LandingTeacher::create([
            'name' => 'Cheikh Test Normal',
            'specialty' => 'Langue arabe',
            'emoji' => '👨‍🏫',
            'badges' => [],
            'is_featured' => false,
            'is_active' => true,
            'sort_order' => 98,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Cheikh Test Normal')
            ->assertDontSee('Membre distingué');
    }

    public function test_faq_renders_two_admin_controlled_ctas(): void
    {
        $this->seed(DatabaseSeeder::class);

        LandingFaq::create([
            'question' => 'Question CTA Test ?',
            'answer' => '<p>Réponse de test.</p>',
            'show_cta' => true,
            'cta_text' => 'Bouton Un',
            'cta_url' => '#',
            'show_cta2' => true,
            'cta2_text' => 'Bouton Deux',
            'cta2_url' => 'https://example.com',
            'is_active' => true,
            'sort_order' => 99,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Question CTA Test ?')
            ->assertSee('Bouton Un')
            ->assertSee('Bouton Deux')
            ->assertSee('faq-cta-row', false)
            ->assertSee('https://example.com', false);
    }
}
