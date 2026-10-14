<?php

namespace App\Http\Controllers;

use App\Enums\CourseAudience;
use App\Models\Course;
use App\Models\CoursePageSettings;
use App\Models\FormInfo;
use App\Models\LandingSettings;
use App\Models\LandingTestimonial;
use Illuminate\Http\Request;

class AdultsController extends Controller
{
    public function index(Request $request)
    {
        $settings = LandingSettings::singleton();
        $pageSettings = CoursePageSettings::singleton();

        abort_unless($pageSettings->is_active, 404);

        $courses = Course::query()
            ->active()
            ->forAudience(CourseAudience::Adults)
            ->orderBy('sort_order')
            ->get();

        $testimonials = LandingTestimonial::query()
            ->forAudience(CourseAudience::Adults)
            ->paginate($pageSettings->testimonialsPerPage(CourseAudience::Adults), ['*'], 'testimonials');

        if ($request->ajax()) {
            return response()->view('partials.testimonials-section', [
                'testimonials' => $testimonials,
                'settings' => $settings,
                'wrapperClass' => 'testimonials-row',
            ]);
        }

        return view('adults.index', [
            'audience' => CourseAudience::Adults,
            'settings' => $settings,
            'pageSettings' => $pageSettings,
            'courses' => $courses,
            'formInfos' => FormInfo::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get(),
            'testimonials' => $testimonials,
            'whatsappPhone' => $this->resolveWhatsAppPhone($pageSettings->adults_wa_url),
            'isIndexed' => $pageSettings->is_indexed,
        ]);
    }

    private function resolveWhatsAppPhone(?string $url): string
    {
        $phone = trim((string) parse_url((string) $url, PHP_URL_PATH), '/');

        return $phone !== '' && preg_match('/^\d+$/', $phone) ? $phone : '';
    }
}
