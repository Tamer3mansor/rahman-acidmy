<?php

namespace Tests\Feature;

use App\Enums\CompareItemType;
use App\Filament\Resources\LandingSettings\Pages\EditLandingSettings;
use App\Models\CompareItem;
use App\Models\ContactSubmission;
use App\Models\FormInfo;
use App\Models\HeroTrustPill;
use App\Models\JourneyStep;
use App\Models\LandingSettings;
use App\Models\User;
use Database\Seeders\CompareItemsSeeder;
use Database\Seeders\FormInfosSeeder;
use Database\Seeders\HeroTrustPillsSeeder;
use Database\Seeders\JourneyStepsSeeder;
use Database\Seeders\LandingSettingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class LandingPageSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeders_populate_singleton_and_repeatable_tables(): void
    {
        $this->seed([
            LandingSettingsSeeder::class,
            HeroTrustPillsSeeder::class,
            JourneyStepsSeeder::class,
            CompareItemsSeeder::class,
            FormInfosSeeder::class,
        ]);

        $settings = LandingSettings::query()->first();

        $this->assertNotNull($settings);
        $this->assertSame('Ar-Rahman', $settings->header_brand_name);
        $this->assertSame('ACADEMY', $settings->header_brand_sub);
        $this->assertSame('واتساب', $settings->header_btn1_title);
        $this->assertSame('https://wa.me/0000000000', $settings->header_btn1_url);
        $this->assertSame('احجز حصتك التجريبية', $settings->header_btn2_title);
        $this->assertSame('#trial-form', $settings->header_btn2_url);
        $this->assertSame('video', $settings->hero_media_type->value);
        $this->assertSame('تعلّم القرآن والعربية', $settings->hero_title);
        $this->assertSame('مخصّص لك', $settings->hero_title_accent);
        $this->assertSame('الفرق واضح من البداية', $settings->compare_title);
        $this->assertSame('© 2025 Ar-Rahman Academy. جميع الحقوق محفوظة.', $settings->footer_copyright);

        $this->assertSame(3, HeroTrustPill::query()->count());
        $this->assertSame(5, JourneyStep::query()->count());
        $this->assertSame(5, CompareItem::query()->where('type', CompareItemType::Problem)->count());
        $this->assertSame(5, CompareItem::query()->where('type', CompareItemType::Solution)->count());
        $this->assertSame(4, FormInfo::query()->count());
    }

    public function test_singleton_model_creates_missing_row(): void
    {
        $settings = LandingSettings::singleton();

        $this->assertSame(1, LandingSettings::query()->count());
        $this->assertTrue($settings->exists);

        $again = LandingSettings::singleton();

        $this->assertSame($settings->getKey(), $again->getKey());
        $this->assertSame(1, LandingSettings::query()->count());
    }

    public function test_admin_can_open_landing_settings_page(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/admin/landing-settings')
            ->assertOk();

        $this->assertSame(1, LandingSettings::query()->count());
    }

    public function test_admin_can_list_hero_trust_pills(): void
    {
        HeroTrustPill::factory()->count(2)->create();

        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/admin/hero-trust-pills')
            ->assertOk();
    }

    public function test_hero_media_accepts_image_type_and_hides_video_options(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin);

        Storage::fake('public');

        Livewire::test(EditLandingSettings::class, ['record' => LandingSettings::singleton()->getKey()])
            ->fillForm(['hero_media_type' => 'video'])
            ->set('data.hero_video_path', UploadedFile::fake()->create('hero.mp4', 1024, 'video/mp4'))
            ->assertFormFieldVisible('hero_video_autoplay')
            ->assertFormFieldVisible('hero_video_loop')
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame('video', LandingSettings::singleton()->hero_media_type->value);
        $this->assertNotNull(LandingSettings::singleton()->hero_video_path);

        Livewire::test(EditLandingSettings::class, ['record' => LandingSettings::singleton()->getKey()])
            ->fillForm(['hero_media_type' => 'image'])
            ->set('data.hero_video_path', UploadedFile::fake()->image('hero.jpg'))
            ->assertFormFieldHidden('hero_video_autoplay')
            ->assertFormFieldHidden('hero_video_loop')
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame('image', LandingSettings::singleton()->hero_media_type->value);
        $this->assertNotNull(LandingSettings::singleton()->hero_video_path);
    }

    public function test_admin_enum_tables_and_forms_render(): void
    {
        $this->seed([CompareItemsSeeder::class, JourneyStepsSeeder::class, FormInfosSeeder::class]);

        ContactSubmission::create([
            'student_name' => 'أحمد',
            'parent_name' => 'محمد',
            'student_age' => 8,
            'phone' => '+33600000000',
            'email' => 'parent@example.com',
            'level' => 'Débutant',
            'schedule' => ['الإثنين'],
            'message' => 'مرحباً',
            'status' => 'new',
        ]);

        $user = User::factory()->create();

        foreach (['/admin/compare-items', '/admin/journey-steps', '/admin/form-infos', '/admin/contact-submissions', '/admin/landing-teachers'] as $url) {
            $this->actingAs($user)->get($url)->assertOk();
        }

        $this->actingAs($user)->get('/admin/compare-items/1/edit')->assertOk();
        $this->actingAs($user)->get('/admin/contact-submissions/1/edit')->assertOk();
    }
}
