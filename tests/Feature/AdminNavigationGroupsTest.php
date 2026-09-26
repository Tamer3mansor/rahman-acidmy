<?php

namespace Tests\Feature;

use App\Filament\Resources\CompareItems\CompareItemResource;
use App\Filament\Resources\CoursePageSettings\CoursePageSettingsResource;
use App\Filament\Resources\Courses\CourseResource;
use App\Filament\Resources\FormInfos\FormInfoResource;
use App\Filament\Resources\HeroTrustPills\HeroTrustPillResource;
use App\Filament\Resources\JourneySteps\JourneyStepResource;
use App\Filament\Resources\LandingFaqs\LandingFaqResource;
use App\Filament\Resources\LandingSettings\LandingSettingsResource;
use App\Filament\Resources\LandingTeachers\LandingTeacherResource;
use App\Filament\Resources\LandingTestimonials\LandingTestimonialResource;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class AdminNavigationGroupsTest extends TestCase
{
    public function test_courses_and_course_page_settings_share_the_course_pages_group(): void
    {
        $this->assertSame('صفحات الدورات', CourseResource::getNavigationGroup());
        $this->assertSame('صفحات الدورات', CoursePageSettingsResource::getNavigationGroup());
        $this->assertSame(1, CourseResource::getNavigationSort());
        $this->assertSame(2, CoursePageSettingsResource::getNavigationSort());
    }

    public function test_all_landing_page_content_shares_one_group_in_the_expected_order(): void
    {
        $expectedOrder = [
            LandingSettingsResource::class => 1,
            HeroTrustPillResource::class => 2,
            JourneyStepResource::class => 3,
            CompareItemResource::class => 4,
            FormInfoResource::class => 5,
            LandingFaqResource::class => 6,
            LandingTeacherResource::class => 7,
            LandingTestimonialResource::class => 8,
        ];

        foreach ($expectedOrder as $resource => $sort) {
            $this->assertSame('إعدادات الصفحة الرئيسية', $resource::getNavigationGroup(), $resource);
            $this->assertSame($sort, $resource::getNavigationSort(), $resource);
        }
    }

    public function test_no_resource_still_points_at_a_retired_navigation_group(): void
    {
        $retired = ['إدارة الصفحة الرئيسية', 'إعدادات الصفحة', 'الدورات'];

        foreach ($this->discoverResources() as $resource) {
            $this->assertNotContains(
                $resource::getNavigationGroup(),
                $retired,
                $resource.' still uses a retired navigation group.',
            );
        }
    }

    /**
     * @return array<int, class-string<resource>>
     */
    private function discoverResources(): array
    {
        $resources = collect(File::allFiles(app_path('Filament/Resources')))
            ->filter(fn ($file): bool => str_ends_with($file->getFilename(), 'Resource.php'))
            ->map(function ($file): string {
                $relative = str_replace(['\\', '.php'], ['/', ''], $file->getRelativePathname());

                return 'App\\Filament\\Resources\\'.str_replace('/', '\\', $relative);
            })
            ->filter(fn (string $class): bool => class_exists($class) && is_subclass_of($class, Resource::class))
            ->values()
            ->all();

        $this->assertNotEmpty($resources, 'No Filament resources were discovered.');

        return $resources;
    }
}
