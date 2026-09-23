<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingSettings extends Model
{
    protected $fillable = [
        'per_hour_price',
        'contents_label',
        'contents_title',
        'contents_subtitle',
        'contents_items',
        'meta_title',
        'meta_description',
        'og_image',
        'is_indexed',
    ];

    protected $casts = [
        'per_hour_price' => 'float',
        'contents_items' => 'array',
        'is_indexed' => 'boolean',
    ];

    public static function singleton(): self
    {
        return static::query()->first() ?? static::create();
    }
}
