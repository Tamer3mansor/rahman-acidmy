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
        'badge_text',
        'level_label',
        'curriculum_items',
        'session_features',
        'journey_steps',
        'suitability_checks',
        'faqs',
        'is_active',
        'sort_order',
        'meta_title',
        'meta_description',
        'og_image',
        'schema_type',
        'is_indexed',
    ];

    protected $casts = [
        'audience' => CourseAudience::class,
        'age_band_min' => 'integer',
        'curriculum_items' => 'array',
        'session_features' => 'array',
        'journey_steps' => 'array',
        'suitability_checks' => 'array',
        'faqs' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'is_indexed' => 'boolean',
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

    public function minAgeLabel(): ?string
    {
        if ($this->age_band_min === null) {
            return null;
        }

        return 'À partir de '.$this->age_band_min.' ans';
    }
}
