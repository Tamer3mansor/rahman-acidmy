<?php

namespace App\Models;

use Database\Factories\BlogPostFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    /** @use HasFactory<BlogPostFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'author_name',
        'author_image',
        'cover_image',
        'reading_time',
        'published_at',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'reading_time' => 'integer',
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (BlogPost $post): void {
            if (blank($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });

        static::updating(function (BlogPost $post): void {
            if ($post->isDirty('title') && blank($post->getOriginal('slug'))) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(BlogCategory::class, 'blog_post_category');
    }

    protected function coverImageUrl(): Attribute
    {
        return Attribute::make(
            get: fn (): ?string => $this->cover_image ? $this->resolveImageUrl($this->cover_image) : null,
        );
    }

    protected function authorImageUrl(): Attribute
    {
        return Attribute::make(
            get: fn (): ?string => $this->author_image ? $this->resolveImageUrl($this->author_image) : null,
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
    protected function published(Builder $query): Builder
    {
        return $query
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }
}
