<?php

namespace App\Models;

use App\Enums\CourseAudience;
use Database\Factories\CourseFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /** @use HasFactory<CourseFactory> */
    use HasFactory;

    protected $fillable = [
        'audience',
        'title',
        'slug',
        'icon',
        'card_theme',
        'short_description',
        'description',
        'age_band_min',
        'age_band_max',
        'session_minutes',
        'level_label',
        'curriculum_items',
        'session_features',
        'journey_steps',
        'suitability_checks',
        'faqs',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'audience' => CourseAudience::class,
        'age_band_min' => 'integer',
        'age_band_max' => 'integer',
        'session_minutes' => 'integer',
        'curriculum_items' => 'array',
        'session_features' => 'array',
        'journey_steps' => 'array',
        'suitability_checks' => 'array',
        'faqs' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    #[Scope]
    protected function forAudience(Builder $query, CourseAudience $audience): Builder
    {
        return $query->where('audience', $audience->value);
    }

    public function ageBandLabel(): ?string
    {
        if ($this->age_band_min === null && $this->age_band_max === null) {
            return null;
        }

        return $this->age_band_min.' - '.$this->age_band_max.' ans';
    }
}
