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
        ContactSubmission::create($request->validated());

        return response()->json(['ok' => true], 200);
    }
}
