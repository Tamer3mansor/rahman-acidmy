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
        'kids_curriculum_label',
        'kids_curriculum_title',
        'kids_curriculum_subtitle',
        'kids_curriculum_items',
        'kids_cta_title',
        'kids_wa_title',
        'kids_wa_url',
        'kids_showcase_emoji',
        'kids_showcase_title',
        'kids_showcase_subtitle',
        'kids_showcase_image',
        'kids_about_label',
        'kids_about_title',
        'kids_about_subtitle',
        'kids_about_items',
        'kids_journey_label',
        'kids_journey_title',
        'kids_journey_subtitle',
        'kids_journey_items',
        'kids_faq_label',
        'kids_faq_title',
        'kids_faq_subtitle',
        'kids_faq_items',
        'kids_faq_cta1_text',
        'kids_faq_cta1_url',
        'kids_faq_cta2_text',
        'kids_faq_cta2_url',
        'kids_testimonials_title',
        'kids_testimonials_subtitle',
        'kids_form_title',
        'kids_form_subtitle',

        'adults_label',
        'adults_title',
        'adults_title_accent',
        'adults_subtitle',
        'adults_badge',
        'adults_cta_title',
        'adults_wa_title',
        'adults_wa_url',
        'adults_showcase_emoji',
        'adults_showcase_title',
        'adults_showcase_subtitle',
        'adults_showcase_image',
        'adults_about_label',
        'adults_about_title',
        'adults_about_subtitle',
        'adults_about_items',
        'adults_curriculum_label',
        'adults_curriculum_title',
        'adults_curriculum_subtitle',
        'adults_curriculum_items',
        'adults_journey_label',
        'adults_journey_title',
        'adults_journey_subtitle',
        'adults_journey_items',
        'adults_faq_label',
        'adults_faq_title',
        'adults_faq_subtitle',
        'adults_faq_items',
        'adults_faq_cta1_text',
        'adults_faq_cta1_url',
        'adults_faq_cta2_text',
        'adults_faq_cta2_url',
        'adults_testimonials_title',
        'adults_testimonials_subtitle',
        'adults_form_title',
        'adults_form_subtitle',

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
        'kids_about_items' => 'array',
        'kids_journey_items' => 'array',
        'kids_curriculum_items' => 'array',
        'kids_faq_items' => 'array',
        'adults_about_items' => 'array',
        'adults_curriculum_items' => 'array',
        'adults_journey_items' => 'array',
        'adults_faq_items' => 'array',
    ];

    public static function singleton(): self
    {
        return static::query()->firstOrCreate([]);
    }
}
