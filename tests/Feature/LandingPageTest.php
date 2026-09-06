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
            ->assertSee('تعلّم القرآن والعربية')
            ->assertSee('الشيخ محمد أمين')
            ->assertSee('هل الحصة التجريبية مجانية فعلاً؟')
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

        $this->assertSame(StudentLevel::Intermediaire, $submission->level);
        $this->assertSame(['الإثنين', 'الجمعة'], $submission->schedule);
    }

    public function test_contact_submission_rejects_invalid_level(): void
    {
        $this->seed(DatabaseSeeder::class);

        $payload = [
            'student_name' => 'أحمد',
            'parent_name' => 'محمد',
            'student_age' => 8,
            'phone' => '+33600000000',
            'email' => 'parent@example.com',
            'level' => 'not-a-valid-level',
        ];

        $this->postJson('/contact-submission', $payload)
            ->assertUnprocessable()
            ->assertJsonValidationErrors('level');

        $this->assertDatabaseCount('contact_submissions', 0);
    }

    public function test_teachers_and_faqs_seed_and_render(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertSame(3, LandingTeacher::query()->count());
        $this->assertSame(6, LandingFaq::query()->count());

        $settings = LandingSettings::singleton();

        $page = $this->get('/');

        $this->assertStringContainsString('احجز حصتك المجانية الآن', $page->getContent());
    }
}
