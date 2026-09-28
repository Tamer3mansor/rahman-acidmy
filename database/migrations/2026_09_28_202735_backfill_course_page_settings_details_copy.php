<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Seeds the columns added by the preceding three migrations with the exact copy
 * that the Blade templates hardcoded before this change, so deploying does not
 * blank any heading on production. Runs once, then leaves the new columns alone.
 */
return new class extends Migration
{
    /** @var array<string, string> */
    private const SHARED = [
        'trial_btn_text' => "Réserver une séance d'essai",
        'trial_url' => '/#trial-form',
        'whatsapp_btn_text' => 'Discuter avec nous sur WhatsApp',
        'suitability_label' => 'Pour qui ?',
        'suitability_title' => 'Ce cours est-il fait pour vous ?',
        'curriculum_label' => 'Le programme',
        'curriculum_title' => 'Que vas-tu apprendre dans ce programme ?',
        'session_label' => 'Comment ça marche',
        'session_title' => 'Comment se déroule le cours ?',
        'session_subtitle' => 'Nous garantissons une expérience interactive, sûre et motivante à chaque séance :',
        'testimonials_label' => 'Témoignages',
        'testimonials_title' => 'Ce que disent les parents',
        'journey_label' => 'Progression',
        'journey_title' => 'Votre parcours et votre progression',
        'faq_label' => 'FAQ',
        'faq_title' => 'Questions fréquentes',
        'related_title' => 'Autres cours similaires',
        'related_cta_text' => 'Voir les détails',
    ];

    /** @var array<string, array<string, string>> */
    private const PER_AUDIENCE = [
        'kids' => [
            'hero_label' => 'Programme dédié aux enfants et aux jeunes',
            'back_label' => 'Cours des enfants',
            'catalog_title' => 'Cours des enfants disponibles',
            'catalog_subtitle' => "Choisissez le programme adapté à l'âge de votre enfant et cliquez pour voir les détails complets et réserver le cours d'essai.",
            'card_level_prefix' => '',
            'final_title' => 'Offrez à votre enfant la meilleure éducation coranique',
            'final_subtitle' => "Réservez dès maintenant la séance d'essai gratuite. Notre équipe pédagogique vous contactera dans les 24 heures pour évaluer le niveau de votre enfant et fixer le premier créneau.",
            'final_cta_text' => "Réserver une séance d'essai gratuite",
        ],
        'adults' => [
            'hero_label' => 'Programme dédié aux adultes et aux grands',
            'back_label' => 'Cours des adultes',
            'catalog_title' => 'Cours des adultes et des grands',
            'catalog_subtitle' => "Choisissez le cours adapté à votre niveau et à votre objectif, puis cliquez pour voir les détails complets et réserver la séance d'essai.",
            'card_level_prefix' => 'Niveau : ',
            'final_title' => "Commencez votre apprentissage du Coran dès aujourd'hui",
            'final_subtitle' => "Réservez votre séance d'essai gratuite. Votre enseignant vous contactera dans les 24 heures pour évaluer votre niveau et définir votre plan d'étude personnalisé.",
            'final_cta_text' => "Réserver ma séance d'essai gratuite",
        ],
    ];

    /** @var array<string, string> */
    private const SHARED_MAIN_PAGE = [
        'catalog_empty_text' => 'Aucun cours disponible pour le moment.',
        'card_cta_text' => 'Voir les détails et réserver',
        'card_age_template' => 'Âge : À partir de {age} ans',
        'testimonials_label' => 'Témoignages',
    ];

    public function up(): void
    {
        $settings = DB::table('course_page_settings')->first();

        if ($settings === null) {
            return;
        }

        $updates = [];

        foreach (self::PER_AUDIENCE as $audience => $values) {
            // Main-page columns. Every key here maps to a column added by the
            // same release, so no existing copy is touched.
            foreach ($values as $key => $value) {
                $updates[$audience.'_'.$key] = $value;
            }

            foreach (self::SHARED_MAIN_PAGE as $key => $value) {
                $updates[$audience.'_'.$key] = $value;
            }

            // Detail-page columns.
            foreach (self::SHARED as $key => $value) {
                $updates['details_'.$audience.'_'.$key] = $value;
            }

            // Carry the global booking copy over to both audiences, so the
            // legacy columns can be dropped in a later release.
            $updates['details_'.$audience.'_booking_title'] = $settings->details_booking_title;
            $updates['details_'.$audience.'_booking_subtitle'] = $settings->details_booking_subtitle;
            $updates['details_'.$audience.'_booking_note'] = $settings->details_booking_note;
            $updates['details_'.$audience.'_sidebar_title'] = $settings->details_cta_title;
        }

        DB::table('course_page_settings')
            ->where('id', $settings->id)
            ->update($updates);
    }

    public function down(): void
    {
        // The columns stay nullable and the seeder repopulates them.
    }
};
