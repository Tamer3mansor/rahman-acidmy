<?php

use App\Http\Controllers\AdultsController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\KidsController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\PricingController;
use App\Models\BlogPost;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

Route::get('/', [LandingController::class, 'index'])->name('home');
Route::post('/contact-submission', [LandingController::class, 'store'])->name('contact.submission');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/price', [PricingController::class, 'index'])->name('price.index');
Route::get('/enfants', [KidsController::class, 'index'])->name('kids.index');
Route::get('/adultes', [AdultsController::class, 'index'])->name('adults.index');
Route::get('/cours/{course:slug}', [CourseController::class, 'show'])->name('courses.show');
Route::get('/lecons-gratuites', [LessonController::class, 'index'])->name('lessons.index');
Route::get('/lecons-gratuites/{lesson:slug}', [LessonController::class, 'show'])->name('lessons.show');
Route::get('/sitemap.xml', function () {
    $baseUrl = rtrim((string) config('seo.url'), '/');

    $sitemap = Sitemap::create();

    $staticPages = [
        [$baseUrl.'/', 'weekly', 1.0],
        [$baseUrl.'/enfants', 'weekly', 0.9],
        [$baseUrl.'/adultes', 'weekly', 0.9],
        [$baseUrl.'/price', 'monthly', 0.8],
        [$baseUrl.'/blog', 'daily', 0.7],
        [$baseUrl.'/lecons-gratuites', 'weekly', 0.8],
    ];

    foreach ($staticPages as [$loc, $changeFrequency, $priority]) {
        $sitemap->add(
            Url::create($loc)
                ->setChangeFrequency($changeFrequency)
                ->setPriority($priority)
        );
    }

    Course::query()
        ->active()
        ->orderBy('sort_order')
        ->get()
        ->each(function (Course $course) use ($sitemap, $baseUrl): void {
            $sitemap->add(
                Url::create($baseUrl.'/cours/'.$course->slug)
                    ->setLastModificationDate($course->updated_at)
                    ->setChangeFrequency('monthly')
                    ->setPriority(0.8)
            );
        });

    BlogPost::published()
        ->latest('published_at')
        ->get()
        ->each(function (BlogPost $post) use ($sitemap, $baseUrl): void {
            $sitemap->add(
                Url::create($baseUrl.'/blog/'.$post->slug)
                    ->setLastModificationDate($post->updated_at)
                    ->setChangeFrequency('weekly')
                    ->setPriority(0.6)
            );
        });

    Lesson::query()
        ->active()
        ->orderBy('sort_order')
        ->get()
        ->each(function (Lesson $lesson) use ($sitemap, $baseUrl): void {
            $sitemap->add(
                Url::create($baseUrl.'/lecons-gratuites/'.$lesson->slug)
                    ->setLastModificationDate($lesson->updated_at)
                    ->setChangeFrequency('weekly')
                    ->setPriority(0.7)
            );
        });

    return $sitemap;
});
