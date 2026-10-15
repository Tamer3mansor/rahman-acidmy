<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingSettings extends Model
{
    protected $fillable = [
        'per_hour_price',
        'hero_label',
        'hero_label_icon',
        'hero_title',
        'hero_subtitle',
        'cta_badge',
        'cta_title',
        'cta_text',
        'cta_whatsapp_label',
        'cta_whatsapp_url',
        'cta_trial_label',
        'cta_trial_url',
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
