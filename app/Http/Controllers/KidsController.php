<?php

namespace App\Http\Controllers;

use App\Enums\CourseAudience;
use App\Models\Course;
use App\Models\CoursePageSettings;
use App\Models\LandingSettings;

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

        return view('kids.index', [
            'settings' => $settings,
            'pageSettings' => $pageSettings,
            'courses' => $courses,
            'whatsappPhone' => $this->resolveWhatsAppPhone($pageSettings->kids_wa_url),
        ]);
    }

    private function resolveWhatsAppPhone(?string $url): string
    {
        $phone = trim((string) parse_url((string) $url, PHP_URL_PATH), '/');

        return $phone !== '' && preg_match('/^\d+$/', $phone) ? $phone : '';
    }
}
