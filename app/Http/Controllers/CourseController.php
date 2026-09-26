<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CoursePageSettings;
use App\Models\LandingSettings;
use App\Models\LandingTestimonial;
use App\Support\CourseContentResolver;
use Illuminate\Support\Collection;

class CourseController extends Controller
{
    public function show(Course $course)
    {
        abort_unless($course->is_active, 404);

        $settings = LandingSettings::singleton();
        $pageSettings = CoursePageSettings::singleton();

        CourseContentResolver::resolve($course, $pageSettings);

        $relatedCourses = $this->relatedCoursesFor($course);

        $testimonials = LandingTestimonial::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('courses.show', [
            'settings' => $settings,
            'pageSettings' => $pageSettings,
            'course' => $course,
            'relatedCourses' => $relatedCourses,
            'testimonials' => $testimonials,
            'isIndexed' => $course->is_indexed,
        ]);
    }

    /**
     * Courses shown in the "Autres cours similaires" sidebar: the ones picked in
     * the dashboard, or — when none were picked — other active courses sharing
     * the same audience, so the sidebar is never empty.
     *
     * @return Collection<int, Course>
     */
    private function relatedCoursesFor(Course $course): Collection
    {
        $relatedCourses = $course->relatedCourses()
            ->where('courses.id', '!=', $course->id)
            ->where('is_active', true)
            ->take(3)
            ->get();

        if ($relatedCourses->isNotEmpty()) {
            return $relatedCourses;
        }

        return Course::query()
            ->forAudience($course->audience)
            ->where('id', '!=', $course->id)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->take(3)
            ->get();
    }
}
