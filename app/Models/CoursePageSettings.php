<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoursePageSettings extends Model
{
    protected $fillable = [
        'kids_label',
        'kids_title',
        'kids_title_accent',
        'kids_subtitle',
        'kids_badge',
        'kids_cta_title',
        'kids_cta_url',
        'kids_wa_title',
        'kids_wa_url',

        'adults_label',
        'adults_title',
        'adults_title_accent',
        'adults_subtitle',
        'adults_badge',
        'adults_cta_title',
        'adults_cta_url',
        'adults_wa_title',
        'adults_wa_url',

        'details_booking_title',
        'details_booking_subtitle',
        'details_cta_title',
        'details_form_title',
        'details_booking_note',

        'is_active',
        'meta_title',
        'meta_description',
        'og_image',
        'is_indexed',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_indexed' => 'boolean',
    ];

    public static function singleton(): self
    {
        return static::query()->firstOrCreate([]);
    }
}
