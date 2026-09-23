<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\PricingSettings;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoMetaTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_renders_seo_head_with_seeded_values(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/')
            ->assertOk()
            ->assertSee('<html lang="fr"', false)
            ->assertSee('<title>Cours de Coran et d&#039;arabe en ligne | Ar-Rahman Academy</title>', false)
            ->assertSee('Cours particuliers de Coran, Tajwid et langue arabe', false)
            ->assertSee('<link rel="canonical"', false)
            ->assertSee('<meta name="robots" content="index,follow"', false)
            ->assertSee('EducationalOrganization', false)
            ->assertSee('application/ld+json', false);
    }

    public function test_kids_and_adults_pages_have_distinct_meta_titles(): void
    {
        $this->seed(DatabaseSeeder::class);

        $kidsResponse = $this->get('/enfants');
        $adultsResponse = $this->get('/adultes');

        $kidsResponse->assertOk();
        $adultsResponse->assertOk();

        $kidsResponse->assertSee('<title>Cours de Coran et d&#039;arabe pour enfants | Ar-Rahman Academy</title>', false);
        $adultsResponse->assertSee('<title>Cours de Coran et Tajwid pour adultes | Ar-Rahman Academy</title>', false);
        $adultsResponse->assertDontSee('Cours de Coran et d&#039;arabe pour enfants', false);
    }

    public function test_price_page_uses_seeded_meta_title_from_settings(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/price')
            ->assertOk()
            ->assertSee('<title>Tarifs des cours de Coran en ligne | Ar-Rahman Academy</title>', false)
            ->assertSee('Packs sans engagement', false);
    }

    public function test_course_page_uses_seeded_meta_title(): void
    {
        $this->seed(DatabaseSeeder::class);

        $course = Course::query()->where('slug', 'initiation-baraaim-quran')->firstOrFail();

        $this->get('/cours/'.$course->slug)
            ->assertOk()
            ->assertSee('<title>'.$course->meta_title.'</title>', false)
            ->assertSee('"@type": "Course"', false);
    }

    public function test_noindex_robots_when_page_is_unindexed(): void
    {
        $this->seed(DatabaseSeeder::class);

        $pricing = PricingSettings::singleton();
        $pricing->update(['is_indexed' => false]);

        $this->get('/price')
            ->assertOk()
            ->assertSee('<meta name="robots" content="noindex,nofollow"', false);
    }

    public function test_sitemap_is_generated_dynamically_with_all_urls(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertSee('<?xml', false)
            ->assertSee('<loc>https://ar-rahman.fr/</loc>', false)
            ->assertSee('<loc>https://ar-rahman.fr/enfants</loc>', false)
            ->assertSee('<loc>https://ar-rahman.fr/adultes</loc>', false)
            ->assertSee('<loc>https://ar-rahman.fr/price</loc>', false)
            ->assertSee('<loc>https://ar-rahman.fr/blog</loc>', false)
            ->assertSee('<loc>https://ar-rahman.fr/lecons-gratuites</loc>', false);
    }

    public function test_sitemap_contains_individual_content_urls(): void
    {
        $this->seed(DatabaseSeeder::class);

        $response = $this->get('/sitemap.xml')->assertOk();
        $content = $response->getContent();

        $this->assertStringContainsString('/cours/', $content);
        $this->assertStringContainsString('/blog/', $content);
        $this->assertStringContainsString('/lecons-gratuites/', $content);
    }
}
