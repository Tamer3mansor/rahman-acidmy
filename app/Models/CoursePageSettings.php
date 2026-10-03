<?php

namespace App\Models;

use App\Enums\CourseAudience;
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
        'kids_cta_url',
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
        'kids_session_label',
        'kids_session_title',
        'kids_session_subtitle',
        'kids_session_items',
        'kids_testimonials_label',
        'kids_testimonials_title',
        'kids_testimonials_subtitle',
        'kids_testimonials_per_page',
        'kids_form_title',
        'kids_form_subtitle',
        'kids_shared_curriculum_items',
        'kids_shared_about_items',
        'kids_shared_session_items',
        'kids_shared_journey_items',
        'kids_shared_faq_items',
        'kids_why_items',
        'kids_shared_why_items',
        'kids_catalog_label',
        'kids_catalog_title',
        'kids_catalog_subtitle',
        'kids_catalog_empty_text',
        'kids_card_cta_text',
        'kids_card_age_template',
        'kids_card_level_prefix',
        'kids_final_title',
        'kids_final_subtitle',
        'kids_final_cta_text',

        'adults_label',
        'adults_title',
        'adults_title_accent',
        'adults_subtitle',
        'adults_badge',
        'adults_cta_title',
        'adults_cta_url',
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
        'adults_session_label',
        'adults_session_title',
        'adults_session_subtitle',
        'adults_session_items',
        'adults_testimonials_label',
        'adults_testimonials_title',
        'adults_testimonials_subtitle',
        'adults_testimonials_per_page',
        'adults_form_title',
        'adults_form_subtitle',
        'adults_shared_curriculum_items',
        'adults_shared_about_items',
        'adults_shared_session_items',
        'adults_shared_journey_items',
        'adults_shared_faq_items',
        'adults_why_items',
        'adults_shared_why_items',
        'adults_catalog_label',
        'adults_catalog_title',
        'adults_catalog_subtitle',
        'adults_catalog_empty_text',
        'adults_card_cta_text',
        'adults_card_age_template',
        'adults_card_level_prefix',
        'adults_final_title',
        'adults_final_subtitle',
        'adults_final_cta_text',

        'details_booking_title',
        'details_booking_subtitle',
        'details_cta_title',
        'details_booking_note',

        'details_kids_hero_label',
        'details_kids_trial_btn_text',
        'details_kids_trial_url',
        'details_kids_whatsapp_btn_text',
        'details_kids_back_label',
        'details_kids_suitability_label',
        'details_kids_suitability_title',
        'details_kids_curriculum_label',
        'details_kids_curriculum_title',
        'details_kids_session_label',
        'details_kids_session_title',
        'details_kids_session_subtitle',
        'details_kids_testimonials_label',
        'details_kids_testimonials_title',
        'details_kids_journey_label',
        'details_kids_journey_title',
        'details_kids_why_label',
        'details_kids_why_title',
        'details_kids_faq_label',
        'details_kids_faq_title',
        'details_kids_related_title',
        'details_kids_related_cta_text',
        'details_kids_booking_title',
        'details_kids_booking_subtitle',
        'details_kids_booking_note',
        'details_kids_sidebar_title',
        'details_adults_hero_label',
        'details_adults_trial_btn_text',
        'details_adults_trial_url',
        'details_adults_whatsapp_btn_text',
        'details_adults_back_label',
        'details_adults_suitability_label',
        'details_adults_suitability_title',
        'details_adults_curriculum_label',
        'details_adults_curriculum_title',
        'details_adults_session_label',
        'details_adults_session_title',
        'details_adults_session_subtitle',
        'details_adults_testimonials_label',
        'details_adults_testimonials_title',
        'details_adults_journey_label',
        'details_adults_journey_title',
        'details_adults_why_label',
        'details_adults_why_title',
        'details_adults_faq_label',
        'details_adults_faq_title',
        'details_adults_related_title',
        'details_adults_related_cta_text',
        'details_adults_booking_title',
        'details_adults_booking_subtitle',
        'details_adults_booking_note',
        'details_adults_sidebar_title',

        'is_active',
        'meta_title',
        'meta_description',
        'og_image',
        'is_indexed',
        'kids_meta_title',
        'kids_meta_description',
        'kids_og_image',
        'adults_meta_title',
        'adults_meta_description',
        'adults_og_image',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_indexed' => 'boolean',
        'kids_testimonials_per_page' => 'integer',
        'adults_testimonials_per_page' => 'integer',
        'kids_about_items' => 'array',
        'kids_journey_items' => 'array',
        'kids_curriculum_items' => 'array',
        'kids_faq_items' => 'array',
        'kids_session_items' => 'array',
        'kids_shared_curriculum_items' => 'array',
        'kids_shared_about_items' => 'array',
        'kids_shared_session_items' => 'array',
        'kids_shared_journey_items' => 'array',
        'kids_shared_faq_items' => 'array',
        'kids_why_items' => 'array',
        'kids_shared_why_items' => 'array',
        'adults_about_items' => 'array',
        'adults_curriculum_items' => 'array',
        'adults_journey_items' => 'array',
        'adults_faq_items' => 'array',
        'adults_session_items' => 'array',
        'adults_shared_curriculum_items' => 'array',
        'adults_shared_about_items' => 'array',
        'adults_shared_session_items' => 'array',
        'adults_shared_journey_items' => 'array',
        'adults_shared_faq_items' => 'array',
        'adults_why_items' => 'array',
        'adults_shared_why_items' => 'array',
    ];

    /**
     * A row created on demand by `singleton()` is not re-read from the database,
     * so the migration defaults have to be mirrored here or a fresh install
     * would render the catalog pages as `noindex`.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'is_active' => true,
        'is_indexed' => true,
    ];

    public static function singleton(): self
    {
        return static::query()->firstOrCreate([]);
    }

    /**
     * Course detail page copy for one audience, keyed the same way for both so
     * the view can drop the per-audience ternaries.
     *
     * @return array<string, string|null>
     */
    public function detailsCopy(CourseAudience $audience): array
    {
        $prefix = 'details_'.$audience->value.'_';

        return [
            'hero_label' => $this->{$prefix.'hero_label'},
            'back_label' => $this->{$prefix.'back_label'},
            'trial_btn_text' => $this->{$prefix.'trial_btn_text'},
            'trial_url' => $this->{$prefix.'trial_url'},
            'whatsapp_btn_text' => $this->{$prefix.'whatsapp_btn_text'},
            'suitability_label' => $this->{$prefix.'suitability_label'},
            'suitability_title' => $this->{$prefix.'suitability_title'},
            'curriculum_label' => $this->{$prefix.'curriculum_label'},
            'curriculum_title' => $this->{$prefix.'curriculum_title'},
            'session_label' => $this->{$prefix.'session_label'},
            'session_title' => $this->{$prefix.'session_title'},
            'session_subtitle' => $this->{$prefix.'session_subtitle'},
            'testimonials_label' => $this->{$prefix.'testimonials_label'},
            'testimonials_title' => $this->{$prefix.'testimonials_title'},
            'journey_label' => $this->{$prefix.'journey_label'},
            'journey_title' => $this->{$prefix.'journey_title'},
            'why_label' => $this->{$prefix.'why_label'},
            'why_title' => $this->{$prefix.'why_title'},
            'faq_label' => $this->{$prefix.'faq_label'},
            'faq_title' => $this->{$prefix.'faq_title'},
            'related_title' => $this->{$prefix.'related_title'},
            'related_cta_text' => $this->{$prefix.'related_cta_text'},
            'booking_title' => $this->{$prefix.'booking_title'},
            'booking_subtitle' => $this->{$prefix.'booking_subtitle'},
            'booking_note' => $this->{$prefix.'booking_note'},
            'sidebar_title' => $this->{$prefix.'sidebar_title'},
        ];
    }

    /**
     * Course card copy for one audience, including the age line built from a
     * template so the French wording lives in the dashboard, not the model.
     *
     * @return array<string, string|null>
     */
    public function cardCopy(CourseAudience $audience): array
    {
        $prefix = $audience->value.'_';

        return [
            'cta_text' => $this->{$prefix.'card_cta_text'},
            'age_template' => $this->{$prefix.'card_age_template'},
            'level_prefix' => $this->{$prefix.'card_level_prefix'},
        ];
    }

    /**
     * How many testimonials one audience shows per page, on the audience page and
     * on the course detail pages of that audience alike.
     */
    public function testimonialsPerPage(CourseAudience $audience): int
    {
        $perPage = (int) $this->{$audience->value.'_testimonials_per_page'};

        return $perPage > 0 ? $perPage : 6;
    }

    /**
     * Age line of a catalog card, e.g. "Âge : Dès 6 ans".
     *
     * The "{age}" token in card_age_template is replaced with the course age
     * label, which already carries its own wording and number ("Dès 6 ans").
     * The template therefore only owns the prefix, otherwise the label gets
     * wrapped twice. Falls back to the previous hardcoded wording so rows
     * migrated before this field existed keep rendering.
     */
    public function courseAgeLabel(CourseAudience $audience, ?string $age): string
    {
        $age = trim((string) $age);

        if ($age === '') {
            return '';
        }

        $template = $this->{$audience->value.'_card_age_template'} ?: 'Âge : {age}';

        return str_replace('{age}', $age, $template);
    }

    /**
     * Level line of a catalog card, e.g. "Niveau : Débutant". Returns the bare
     * level when no prefix is configured.
     */
    public function courseLevelLabel(CourseAudience $audience, ?string $level): string
    {
        $level = trim((string) $level);

        if ($level === '') {
            return '';
        }

        $prefix = trim((string) $this->{$audience->value.'_card_level_prefix'});

        return $prefix === '' ? $level : rtrim($prefix, " \t:").' '.$level;
    }
}
