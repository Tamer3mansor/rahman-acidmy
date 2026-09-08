<?php

namespace Tests\Feature;

use App\Models\PricingPackage;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\PricingPackageSeeder;
use Database\Seeders\PricingPerkSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PricingPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_price_page_renders_packages_perks_and_duration_selector(): void
    {
        $this->seed([
            PricingPackageSeeder::class,
            PricingPerkSeeder::class,
        ]);

        $response = $this->get('/price');

        $response->assertOk()
            ->assertViewIs('price.index')
            ->assertSee('Des offres claires pour apprendre en toute sérénité')
            ->assertSee('Pack Découverte')
            ->assertSee('Pack Argent')
            ->assertSee('Le plus demandé')
            ->assertSee('Avantages inclus dans tous les packs')
            ->assertSee('essai gratuite')
            ->assertSee('30 min')
            ->assertSee('45 min')
            ->assertSee('60 min')
            ->assertSee('build/assets/price-', false)
            ->assertDontSee('data-scroll-to-form');
    }

    public function test_price_cards_embed_precomputed_duration_states(): void
    {
        $this->seed([
            PricingPackageSeeder::class,
            PricingPerkSeeder::class,
        ]);

        $this->get('/price')
            ->assertOk()
            ->assertSee('data-price-30', false)
            ->assertSee('data-price-45', false)
            ->assertSee('data-price-60', false)
            ->assertSee('data-duration="30"', false)
            ->assertSee('data-duration="45"', false)
            ->assertSee('data-duration="60"', false);
    }

    public function test_page_embeds_whatsapp_phone_from_settings(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/price')
            ->assertOk()
            ->assertSee('data-wa-phone="0000000000"', false);
    }

    public function test_pricing_model_calculations(): void
    {
        $package = PricingPackage::factory()->create([
            'classes_count' => 24,
            'price_per_30' => 4.58,
            'price_per_45' => 6.80,
            'price_per_60' => 9.00,
        ]);

        $this->assertSame(4.58, $package->rateFor(30));
        $this->assertSame(109.92, $package->totalFor(30));
        $this->assertSame(120.0, $package->originalFor(30));
        $this->assertSame(10.08, $package->savingsFor(30));

        $this->assertSame(6.80, $package->rateFor(45));
        $this->assertSame(163.2, $package->totalFor(45));
        $this->assertSame(180.0, $package->originalFor(45));
        $this->assertSame(16.8, $package->savingsFor(45));
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
            PricingPackageSeeder::class,
            PricingPerkSeeder::class,
        ]);

        $user = User::factory()->create();

        foreach (['/admin/pricing-packages', '/admin/pricing-packages/create', '/admin/pricing-perks'] as $url) {
            $this->actingAs($user)->get($url)->assertOk();
        }
    }
}
