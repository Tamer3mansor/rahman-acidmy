<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CoursePageSettings;
use App\Models\LandingSettings;
use App\Models\LandingTestimonial;
use App\Support\CourseContentResolver;

class CourseController extends Controller
{
    public function show(Course $course)
    {
        abort_unless($course->is_active, 404);

        $settings = LandingSettings::singleton();
        $pageSettings = CoursePageSettings::singleton();

        CourseContentResolver::resolve($course, $pageSettings);

        $course->load('relatedCourses');

        $testimonials = LandingTestimonial::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('courses.show', [
            'settings' => $settings,
            'pageSettings' => $pageSettings,
            'course' => $course,
            'testimonials' => $testimonials,
            'isIndexed' => $course->is_indexed,
        ]);
    }
}
