<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactSubmissionRequest;
use App\Models\ContactSubmission;
use App\Models\Course;
use App\Models\FormInfo;
use App\Models\HeroTrustPill;
use App\Models\JourneyStep;
use App\Models\LandingFaq;
use App\Models\LandingSettings;
use App\Models\LandingTeacher;
use App\Models\LandingTestimonial;
use App\Models\LandingWhyItem;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LandingController extends Controller
{
    public function index()
    {
        $settings = LandingSettings::singleton();

        $trustPills = HeroTrustPill::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $journeySteps = JourneyStep::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $whyItems = LandingWhyItem::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $teachers = LandingTeacher::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $faqs = LandingFaq::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $formInfos = FormInfo::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $testimonials = LandingTestimonial::query()
            ->forLanding()
            ->get();

        $courses = Course::query()
            ->active()
            ->orderBy('sort_order')
            ->get();

        return view('landing.index', [
            'settings' => $settings,
            'trustPills' => $trustPills,
            'journeySteps' => $journeySteps,
            'whyItems' => $whyItems,
            'teachers' => $teachers,
            'faqs' => $faqs,
            'formInfos' => $formInfos,
            'testimonials' => $testimonials,
            'courses' => $courses,
            'isIndexed' => $settings->is_indexed,
        ]);
    }

    public function store(ContactSubmissionRequest $request)
    {
        $submission = ContactSubmission::create($request->validated());

        $this->forwardToGoogleSheets($submission);

        return response()->json(['ok' => true], 200);
    }

    /**
     * Forward a stored submission to the optional Google Apps Script web app
     * that appends it to a spreadsheet. This runs server-side so the write is
     * not dropped by ad-blockers, page unloads or a browser that closes the tab
     * before the request is flushed. The submission is already persisted, so a
     * Sheets failure is logged but never fails the visitor's request.
     */
    private function forwardToGoogleSheets(ContactSubmission $submission): void
    {
        $url = config('services.google_sheets.form_url');

        if (blank($url)) {
            return;
        }

        try {
            Http::timeout(8)
                ->acceptJson()
                ->post($url, [
                    'studentName' => $submission->student_name,
                    'parentName' => $submission->parent_name,
                    'studentAge' => $submission->student_age,
                    'phone' => $submission->phone,
                    'email' => $submission->email,
                    'level' => $submission->level,
                    'schedule' => is_array($submission->schedule)
                        ? implode(', ', $submission->schedule)
                        : (string) $submission->schedule,
                    'message' => $submission->message,
                    'timestamp' => $submission->created_at?->format('d/m/Y H:i:s'),
                ])
                ->throw();
        } catch (\Throwable $e) {
            Log::warning('Google Sheets forward failed for contact submission #'.$submission->id, [
                'error' => $e->getMessage(),
            ]);
        }
    }
}
