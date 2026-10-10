<?php

namespace App\Models;

use App\Casts\MediaTypeCast;
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

        'footer_social_whatsapp',
        'footer_social_telegram',
        'footer_social_facebook',
        'footer_social_instagram',
        'footer_social_tiktok',
        'footer_social_x',
        'footer_social_youtube',

        'meta_title',
        'meta_description',
        'og_image',
        'is_indexed',

        'nav_courses_label',
        'nav_kids_label',
        'nav_adults_label',
        'nav_teachers_label',
        'nav_testimonials_label',
        'nav_pricing_label',
        'nav_resources_label',
        'nav_blog_label',
        'nav_lessons_label',
        'nav_faq_label',
        'nav_menu_label',
        'nav_theme_label',
        'nav_theme_toggle_label',

        'footer_quicklinks_title',
        'footer_contact_title',
        'footer_link_home',
        'footer_link_courses',
        'footer_link_journey',
        'footer_link_teachers',
        'footer_link_faq',
        'footer_link_whatsapp',
        'footer_link_trial',
        'footer_link_email',
        'footer_made_with',

        'floating_whatsapp_title',
        'floating_scroll_top_label',

        'toast_success_text',
        'toast_error_text',
        'toast_received_text',
        'form_loading_text',

        'testimonial_tag_whatsapp',
        'testimonial_tag_google',
        'testimonial_video_placeholder',
        'testimonial_play_label',
        'testimonial_mute_label',
        'testimonial_unmute_label',
        'testimonial_resume_label',
        'testimonial_pause_label',
        'testimonial_volume_label',
        'testimonial_seek_label',
        'testimonial_fullscreen_label',

        'field_student_name_label',
        'field_student_name_placeholder',
        'field_parent_name_label',
        'field_parent_name_placeholder',
        'field_student_age_label',
        'field_student_age_placeholder',
        'field_phone_label',
        'field_phone_placeholder',
        'field_email_label',
        'field_email_placeholder',
        'field_level_label',
        'field_level_placeholder',
        'field_schedule_label',
        'field_schedule_placeholder',
        'field_message_label',
        'field_message_placeholder',
        'form_optional_suffix',
        'form_required_suffix',
        'form_submit_text',
    ];

    protected $casts = [
        'hero_media_type' => MediaTypeCast::class,
        'hero_video_autoplay' => 'boolean',
        'hero_video_loop' => 'boolean',
        'is_indexed' => 'boolean',
    ];

    public static function singleton(): self
    {
        return static::query()->first() ?? static::create();
    }
}
