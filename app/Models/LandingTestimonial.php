<?php

namespace App\Models;

use App\Casts\TestimonialPlacementsCast;
use App\Casts\TestimonialTypeCast;
use App\Enums\CourseAudience;
use App\Enums\TestimonialPlacement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingTestimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'placements',
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
        'placements' => TestimonialPlacementsCast::class,
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Testimonials shown in the landing page trust section.
     */
    public function scopeForLanding(Builder $query): Builder
    {
        return $this->scopeForPlacement($query, TestimonialPlacement::Landing);
    }

    /**
     * Testimonials shown on the kids/adults pages and on the course detail pages
     * of the same audience.
     */
    public function scopeForAudience(Builder $query, CourseAudience $audience): Builder
    {
        return $query
            ->where('is_active', true)
            ->whereJsonContains('placements', $audience->value)
            ->orderBy('sort_order');
    }

    public function scopeForPlacement(Builder $query, TestimonialPlacement $placement): Builder
    {
        return $query
            ->where('is_active', true)
            ->whereJsonContains('placements', $placement->value)
            ->orderBy('sort_order');
    }
}
