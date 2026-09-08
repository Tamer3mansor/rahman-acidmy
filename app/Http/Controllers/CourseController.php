<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CoursePageSettings;
use App\Models\LandingSettings;

class CourseController extends Controller
{
    public function show(Course $course)
    {
        abort_unless($course->is_active, 404);

        $settings = LandingSettings::singleton();
        $pageSettings = CoursePageSettings::singleton();

        return view('courses.show', [
            'settings' => $settings,
            'pageSettings' => $pageSettings,
            'course' => $course,
            'isIndexed' => $course->is_indexed,
        ]);
    }
}
