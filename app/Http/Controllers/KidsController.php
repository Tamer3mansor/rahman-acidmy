<?php

namespace App\Http\Controllers;

use App\Enums\CourseAudience;
use App\Models\Course;
use App\Models\CoursePageSettings;
use App\Models\LandingSettings;
use App\Models\LandingTestimonial;

class KidsController extends Controller
{
    public function index()
    {
        $settings = LandingSettings::singleton();
        $pageSettings = CoursePageSettings::singleton();

        $courses = Course::query()
            ->active()
            ->forAudience(CourseAudience::Kids)
            ->orderBy('sort_order')
            ->get();

        $testimonials = LandingTestimonial::query()
            ->forCoursePage(CourseAudience::Kids)
            ->get();

        return view('kids.index', [
            'settings' => $settings,
            'pageSettings' => $pageSettings,
            'courses' => $courses,
            'testimonials' => $testimonials,
            'whatsappPhone' => $this->resolveWhatsAppPhone($pageSettings->kids_wa_url),
            'isIndexed' => $pageSettings->is_indexed,
        ]);
    }

    private function resolveWhatsAppPhone(?string $url): string
    {
        $phone = trim((string) parse_url((string) $url, PHP_URL_PATH), '/');

        return $phone !== '' && preg_match('/^\d+$/', $phone) ? $phone : '';
    }
}
