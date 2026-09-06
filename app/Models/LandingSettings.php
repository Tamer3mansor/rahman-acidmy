<?php

namespace App\Models;

use App\Enums\MediaType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingSettings extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'header_brand_name',
        'header_brand_sub',
        'header_logo_path',
        'header_btn1_title',
        'header_btn1_url',
        'header_btn2_title',
        'header_btn2_url',

        'hero_badge',
        'hero_title',
        'hero_title_accent',
        'hero_subtitle',
        'hero_btn1_title',
        'hero_btn1_url',
        'hero_btn2_title',
        'hero_btn2_url',
        'hero_video_path',
        'hero_media_type',
        'hero_video_autoplay',
        'hero_video_loop',

        'trust_label',
        'trust_title',
        'trust_subtitle',
        'trust_cta_title',

        'journey_label',
        'journey_title',
        'journey_subtitle',
        'journey_cta_title',

        'compare_label',
        'compare_title',
        'compare_subtitle',
        'compare_problems_title',
        'compare_solutions_title',
        'compare_cta_title',

        'teachers_label',
        'teachers_title',
        'teachers_subtitle',
        'teachers_cta_title',

        'faq_label',
        'faq_title',
        'faq_subtitle',

        'form_label',
        'form_title',
        'form_title_accent',
        'form_subtitle',
        'form_card_title',
        'form_card_subtitle',
        'form_note',
        'form_privacy_note',

        'footer_brand_name',
        'footer_brand_sub',
        'footer_description',
        'footer_copyright',
    ];

    protected $casts = [
        'hero_media_type' => MediaType::class,
        'hero_video_autoplay' => 'boolean',
        'hero_video_loop' => 'boolean',
    ];

    public static function singleton(): self
    {
        return static::query()->first() ?? static::create();
    }
}
