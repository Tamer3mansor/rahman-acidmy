<?php

namespace App\Models;

use App\Enums\LessonCategory;
use Database\Factories\LessonFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    /** @use HasFactory<LessonFactory> */
    use HasFactory;

    protected $fillable = [
        'category',
        'title',
        'slug',
        'excerpt',
        'body',
        'cover_image',
        'audio_url',
        'reading_time',
        'course_id',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'category' => LessonCategory::class,
        'reading_time' => 'integer',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    protected function coverImageUrl(): Attribute
    {
        return Attribute::make(
            get: fn (): ?string => $this->cover_image ? $this->resolveImageUrl($this->cover_image) : null,
        );
    }

    private function resolveImageUrl(string $path): string
    {
        foreach (['https://', 'http://', 'data:'] as $prefix) {
            if (str_starts_with($path, $prefix)) {
                return $path;
            }
        }

        return asset('storage/'.$path);
    }

    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
