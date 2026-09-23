<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\CoursePageSettings;
use App\Models\LandingSettings;
use App\Models\PricingSettings;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\SeoSettingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoSettingsSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_fills_defaults_for_every_controlled_page(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertNotNull(LandingSettings::singleton()->meta_title);
        $this->assertNotNull(LandingSettings::singleton()->meta_description);

        $pageSettings = CoursePageSettings::singleton();
        $this->assertNotNull($pageSettings->kids_meta_title);
        $this->assertNotNull($pageSettings->kids_meta_description);
        $this->assertNotNull($pageSettings->adults_meta_title);
        $this->assertNotNull($pageSettings->adults_meta_description);
        $this->assertNotSame($pageSettings->kids_meta_title, $pageSettings->adults_meta_title);

        Course::query()->get()->each(function (Course $course): void {
            $this->assertNotNull($course->meta_title);
            $this->assertNotNull($course->meta_description);
            $this->assertLessThanOrEqual(60, mb_strlen((string) $course->meta_title));
        });

        $this->assertNotNull(PricingSettings::singleton()->meta_title);
        $this->assertNotNull(PricingSettings::singleton()->meta_description);
    }

    public function test_seeder_never_overwrites_existing_values(): void
    {
        $this->seed(DatabaseSeeder::class);

        $customTitle = 'Titre personnalisé par l\'admin';
        $customDescription = 'Description personnalisée par l\'admin.';

        $settings = LandingSettings::singleton();
        $settings->update([
            'meta_title' => $customTitle,
            'meta_description' => $customDescription,
        ]);

        $course = Course::query()->first();
        $course->update(['meta_title' => 'Titre de cours personnalisé']);

        $this->seed(SeoSettingsSeeder::class);

        $this->assertSame($customTitle, LandingSettings::singleton()->meta_title);
        $this->assertSame($customDescription, LandingSettings::singleton()->meta_description);

        $course->refresh();
        $this->assertSame('Titre de cours personnalisé', $course->meta_title);
        $this->assertNotNull($course->meta_description);
    }
}
