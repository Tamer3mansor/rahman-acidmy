<?php

use App\Http\Controllers\AdultsController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\KidsController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\PricingController;
use Illuminate\Support\Facades\Route;

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
