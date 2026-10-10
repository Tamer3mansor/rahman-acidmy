<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonPageSettings extends Model
{
    protected $fillable = [
        'label',
        'title',
        'description',
        'meta_title',
        'meta_description',
        'og_image',
        'is_indexed',
        'sidebar_trial_label',
        'sidebar_trial_url',
        'sidebar_whatsapp_label',
        'sidebar_whatsapp_url',
        'sidebar_title',
        'sidebar_text',
    ];

    protected $casts = [
        'is_indexed' => 'boolean',
    ];

    /**
     * A row created on demand by `singleton()` is not re-read from the database,
     * so the migration default has to be mirrored here for `is_indexed` to be
     * true on a fresh install.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'is_indexed' => true,
    ];

    public static function singleton(): self
    {
        return static::query()->firstOrCreate([]);
    }
}
