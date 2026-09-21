<?php

namespace App\Models;

use App\Casts\TestimonialAudienceCast;
use App\Casts\TestimonialTypeCast;
use App\Enums\CourseAudience;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingTestimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'page_audience',
        'author_name',
        'author_location',
        'content',
        'media_path',
        'rating',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'type' => TestimonialTypeCast::class,
        'page_audience' => TestimonialAudienceCast::class,
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Scope testimonials additionally shown on a course page.
     */
    public function scopeForCoursePage(Builder $query, CourseAudience $audience): Builder
    {
        return $query
            ->where('is_active', true)
            ->whereIn('page_audience', ['kids', 'adults', 'both'])
            ->whereRaw('page_audience = ? OR page_audience = ?', ['both', $audience->value])
            ->orderBy('sort_order');
    }
}
