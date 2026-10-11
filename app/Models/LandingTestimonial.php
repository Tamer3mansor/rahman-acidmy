<?php

namespace App\Models;

use App\Casts\TestimonialPlacementsCast;
use App\Casts\TestimonialTypeCast;
use App\Enums\CourseAudience;
use App\Enums\TestimonialPlacement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'video_name',
        'poster_path',
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
     * Public URL of the optional admin-uploaded poster, or null when the card
     * should fall back to the first frame the browser generates on its own.
     */
    protected function posterUrl(): Attribute
    {
        return Attribute::make(
            get: fn (): ?string => filled($this->poster_path) ? $this->resolveMediaUrl($this->poster_path) : null,
        );
    }

    private function resolveMediaUrl(string $path): string
    {
        foreach (['https://', 'http://', 'data:'] as $prefix) {
            if (str_starts_with($path, $prefix)) {
                return $path;
            }
        }

        return asset('storage/'.$path);
    }

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
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    public function scopeForPlacement(Builder $query, TestimonialPlacement $placement): Builder
    {
        return $query
            ->where('is_active', true)
            ->whereJsonContains('placements', $placement->value)
            ->orderBy('sort_order')
            ->orderBy('id');
    }
}
