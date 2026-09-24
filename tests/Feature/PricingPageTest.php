<?php

namespace Tests\Feature;

use App\Models\PricingPackage;
use App\Models\PricingSettings;
use App\Models\SystemSettings;
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

    public function test_packages_fallback_to_system_settings_whatsapp_number(): void
    {
        $this->seed(DatabaseSeeder::class);

        SystemSettings::singleton()->update(['whatsapp_number' => '2021987654']);

        $this->get('/price')
            ->assertOk()
            ->assertSee('data-wa-phone="2021987654"', false);
    }

    public function test_package_whatsapp_url_overrides_system_settings_default(): void
    {
        $this->seed(DatabaseSeeder::class);

        SystemSettings::singleton()->update(['whatsapp_number' => '2021987654']);

        $pack = PricingPackage::query()->where('name', 'Pack Découverte')->firstOrFail();
        $pack->update(['whatsapp_url' => 'https://wa.me/3312345678']);

        $this->get('/price')
            ->assertOk()
            ->assertSee('data-wa-phone="3312345678"', false);
    }

    public function test_special_price_package_uses_stored_price(): void
    {
        PricingSettings::query()->create(['per_hour_price' => 8.00]);

        $package = PricingPackage::factory()->special()->create([
            'classes_count' => 24,
            'price' => 6.00,
        ]);

        $this->assertTrue($package->isOffer());
        $this->assertSame(6.00, $package->hourlyRate());
        $this->assertSame(144.00, $package->effectivePrice());
        $this->assertSame(6.00, $package->ratePerLesson());
        $this->assertSame(192.00, $package->generalPrice());
    }

    public function test_per_hour_price_package_tracks_global_rate(): void
    {
        PricingSettings::query()->create(['per_hour_price' => 8.00]);

        $package = PricingPackage::factory()->perHour()->create([
            'classes_count' => 4,
        ]);

        $this->assertFalse($package->isOffer());
        $this->assertSame(8.00, $package->hourlyRate());
        $this->assertSame(32.00, $package->effectivePrice());
        $this->assertSame(8.00, $package->ratePerLesson());

        $settings = PricingSettings::firstOrFail();
        $settings->update(['per_hour_price' => 9.00]);

        $this->assertSame(36.00, $package->effectivePrice());
    }

    public function test_effective_price_follows_lesson_duration(): void
    {
        PricingSettings::query()->create(['per_hour_price' => 8.00]);

        $general = PricingPackage::factory()->perHour()->create(['classes_count' => 4]);
        $special = PricingPackage::factory()->special()->create(['classes_count' => 4, 'price' => 6.00]);

        $this->assertSame(16.00, $general->effectivePrice(0.5));
        $this->assertSame(24.00, $general->effectivePrice(0.75));
        $this->assertSame(32.00, $general->effectivePrice(1.0));

        $this->assertSame(12.00, $special->effectivePrice(0.5));
        $this->assertSame(18.00, $special->effectivePrice(0.75));
        $this->assertSame(24.00, $special->effectivePrice(1.0));
        $this->assertSame(32.00, $special->generalPrice(1.0));
    }

    public function test_price_page_renders_duration_filter(): void
    {
        $this->seed([
            PricingSettingsSeeder::class,
            PricingPackageSeeder::class,
        ]);

        $this->get('/price')
            ->assertOk()
            ->assertSee('duration-filter', false)
            ->assertSee('30 min')
            ->assertSee('45 min')
            ->assertSee('60 min');
    }

    public function test_special_package_displays_offer_badge_and_general_price(): void
    {
        $this->seed(PricingSettingsSeeder::class);

        PricingPackage::factory()->special()->create([
            'name' => 'Pack Offre Test',
            'classes_count' => 8,
            'price' => 6.00,
        ]);

        $this->get('/price')
            ->assertOk()
            ->assertSee('Pack Offre Test')
            ->assertSee('Offre spéciale')
            ->assertSee('Valeur normale')
            ->assertSee('data-offer="1"', false)
            ->assertSee('>64.00€</del>', false)
            ->assertSee('>48.00', false);
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
            ->assertSee('تعديل السعر العام')
            ->assertSee('toggleTableReordering', false);

        $this->actingAs($user)
            ->get('/admin/pricing-settings')
            ->assertOk()
            ->assertSee('إعدادات محتويات الباقات')
            ->assertSee('قسم محتويات الباقات');
    }
}
