<?php

namespace Tests\Feature;

use App\Models\PricingPackage;
use App\Models\PricingSettings;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\PricingPackageSeeder;
use Database\Seeders\PricingSettingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PricingPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_price_page_renders_packages_and_perks(): void
    {
        $this->seed([
            PricingSettingsSeeder::class,
            PricingPackageSeeder::class,
        ]);

        $response = $this->get('/price');

        $response->assertOk()
            ->assertViewIs('price.index')
            ->assertSee('Des offres claires pour apprendre en toute sérénité')
            ->assertSee('Pack Découverte')
            ->assertSee('Pack Argent')
            ->assertSee('Le plus demandé')
            ->assertSee('essai gratuit')
            ->assertSee('build/assets/price-', false)
            ->assertDontSee('data-scroll-to-form');
    }

    public function test_price_cards_embed_total_price(): void
    {
        $this->seed([
            PricingSettingsSeeder::class,
            PricingPackageSeeder::class,
        ]);

        $pack = PricingPackage::query()->where('name', 'Pack Découverte')->firstOrFail();

        $expected = number_format((float) $pack->effectivePrice(), 2);

        $this->get('/price')
            ->assertOk()
            ->assertSee("data-price=\"{$expected}\"", false);
    }

    public function test_price_contents_section_renders_from_settings(): void
    {
        $this->seed([
            PricingSettingsSeeder::class,
            PricingPackageSeeder::class,
        ]);

        $settings = PricingSettings::singleton();
        $settings->update([
            'contents_label' => 'Tout inclus',
            'contents_title' => 'Ce qui est inclus dans chaque pack',
            'contents_subtitle' => 'Une description courte.',
            'contents_items' => [
                ['icon' => '🕌', 'title' => 'Cours particuliers', 'description' => 'Des séances en tête-à-tête.'],
                ['icon' => '📋', 'title' => 'Suivi personnalisé', 'description' => 'Rapports réguliers.'],
            ],
        ]);

        $this->get('/price')
            ->assertOk()
            ->assertSee('Ce qui est inclus dans chaque pack')
            ->assertSee('Cours particuliers')
            ->assertSee('Suivi personnalisé')
            ->assertSee('Des séances en tête-à-tête.');
    }

    public function test_package_cta_button_uses_custom_label_and_whatsapp_number(): void
    {
        $this->seed([
            PricingSettingsSeeder::class,
            PricingPackageSeeder::class,
        ]);

        $pack = PricingPackage::query()->where('name', 'Pack Découverte')->firstOrFail();
        $pack->update([
            'button_label' => 'Choisir ce pack',
            'whatsapp_url' => 'https://wa.me/3312345678',
        ]);

        $this->get('/price')
            ->assertOk()
            ->assertSee('Choisir ce pack')
            ->assertSee('data-wa-phone="3312345678"', false);

        $this->assertSame('3312345678', $pack->whatsappPhone());
    }

    public function test_package_cta_falls_back_to_default_label_and_phone(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/price')
            ->assertOk()
            ->assertSee('Ce pack me convient')
            ->assertSee('data-wa-phone="201028268553"', false);
    }

    public function test_page_embeds_whatsapp_phone_from_settings(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/price')
            ->assertOk()
            ->assertSee('data-wa-phone="201028268553"', false);
    }

    public function test_special_price_package_uses_stored_price(): void
    {
        PricingSettings::query()->create(['per_hour_price' => 8.00]);

        $package = PricingPackage::factory()->special()->create([
            'classes_count' => 24,
            'price' => 160.00,
        ]);

        $this->assertSame(160.00, $package->effectivePrice());
        $this->assertSame(6.67, $package->ratePerLesson());
    }

    public function test_per_hour_price_package_tracks_global_rate(): void
    {
        PricingSettings::query()->create(['per_hour_price' => 8.00]);

        $package = PricingPackage::factory()->perHour()->create([
            'classes_count' => 4,
            'hours' => 4,
        ]);

        $this->assertSame(32.00, $package->effectivePrice());
        $this->assertSame(8.00, $package->ratePerLesson());

        $settings = PricingSettings::firstOrFail();
        $settings->update(['per_hour_price' => 9.00]);

        $this->assertSame(36.00, $package->effectivePrice());
    }

    public function test_landing_nav_includes_price_link(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/')
            ->assertOk()
            ->assertSee('Tarifs');
    }

    public function test_price_admin_resources_render(): void
    {
        $this->seed([
            PricingSettingsSeeder::class,
            PricingPackageSeeder::class,
        ]);

        $user = User::factory()->create();

        foreach (['/admin/pricing-packages', '/admin/pricing-packages/create', '/admin/pricing-settings'] as $url) {
            $this->actingAs($user)->get($url)->assertOk();
        }

        $this->actingAs($user)
            ->get('/admin/pricing-packages')
            ->assertOk()
            ->assertSee('السعر العام للساعة')
            ->assertSee('تعديل السعر العام');

        $this->actingAs($user)
            ->get('/admin/pricing-settings')
            ->assertOk()
            ->assertSee('إعدادات محتويات الباقات')
            ->assertSee('قسم محتويات الباقات');
    }
}
