<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Makes the site chrome (navigation, footer, contact form, floating buttons and
 * toast messages) editable from the dashboard instead of hardcoded in Blade and
 * landing.js. All columns are nullable; the seeded values match the copy that is
 * currently rendered so production output does not change.
 */
return new class extends Migration
{
    /** @var array<string, string> */
    private const COPY = [
        'nav_courses_label' => 'Nos cours',
        'nav_kids_label' => 'Cours pour enfants',
        'nav_adults_label' => 'Cours pour adultes',
        'nav_teachers_label' => 'Professeurs',
        'nav_testimonials_label' => 'Témoignages',
        'nav_pricing_label' => 'Tarifs',
        'nav_resources_label' => 'Ressources',
        'nav_blog_label' => 'Blog',
        'nav_lessons_label' => 'Leçons gratuites',
        'nav_faq_label' => 'FAQ',
        'nav_menu_label' => 'Menu',
        'nav_theme_label' => 'Thème',
        'nav_theme_toggle_label' => 'Changer de thème',

        'footer_quicklinks_title' => 'Liens rapides',
        'footer_contact_title' => 'Contactez-nous',
        'footer_link_home' => 'Accueil',
        'footer_link_courses' => 'Nos cours',
        'footer_link_journey' => 'Notre parcours',
        'footer_link_teachers' => 'Nos enseignants',
        'footer_link_faq' => 'FAQ',
        'footer_link_whatsapp' => 'WhatsApp',
        'footer_link_trial' => 'Réservez un essai',
        'footer_link_email' => 'E-mail',
        'footer_made_with' => 'Conçu avec passion ❤️',

        'floating_whatsapp_title' => 'Contactez-nous via WhatsApp',
        'floating_scroll_top_label' => 'Retour en haut',

        'toast_success_text' => 'Votre demande a été envoyée avec succès ! Nous vous contacterons dans les 24 heures ✓',
        'toast_error_text' => 'Une erreur est survenue, veuillez réessayer',
        'toast_received_text' => 'Votre demande a été reçue ! Nous vous contacterons bientôt ✓',
        'form_loading_text' => 'Envoi en cours...',

        'testimonial_tag_whatsapp' => 'Messages WhatsApp',
        'testimonial_tag_google' => 'Avis Google',
        'testimonial_video_placeholder' => 'Test vidéo · Parents',
        'testimonial_play_label' => 'Lire la vidéo',
        'testimonial_mute_label' => 'Couper le son',
        'testimonial_unmute_label' => 'Activer le son',
        'testimonial_resume_label' => 'Lire',
        'testimonial_pause_label' => 'Pause',
        'testimonial_volume_label' => 'Volume du son',

        'field_student_name_label' => "Nom de l'élève",
        'field_student_name_placeholder' => "Entrez le nom de l'élève",
        'field_parent_name_label' => 'Nom du parent',
        'field_parent_name_placeholder' => 'Entrez votre nom',
        'field_student_age_label' => "Âge de l'élève",
        'field_student_age_placeholder' => 'Ex: 8',
        'field_phone_label' => 'Numéro WhatsApp',
        'field_phone_placeholder' => '+33 6 00 00 00 00',
        'field_email_label' => 'Adresse e-mail',
        'field_email_placeholder' => 'example@email.com',
        'field_level_label' => "Niveau de l'élève",
        'field_level_placeholder' => 'Ex: Débutant, Intermédiaire, Avancé...',
        'field_schedule_label' => 'Créneaux souhaités',
        'field_schedule_placeholder' => 'Ex: Jours de semaine après 17h, week-end...',
        'field_message_label' => 'Message supplémentaire',
        'field_message_placeholder' => 'Avez-vous une demande ou une question particulière ?',
        'form_optional_suffix' => '(optionnel)',
        'form_required_suffix' => '*',
        'form_submit_text' => 'Envoyer ma demande et attendre le contact',
    ];

    public function up(): void
    {
        Schema::table('landing_settings', function (Blueprint $table) {
            foreach (array_keys(self::COPY) as $column) {
                $table->text($column)->nullable()->after('is_indexed');
            }
        });

        DB::table('landing_settings')->update(self::COPY);
    }

    public function down(): void
    {
        Schema::table('landing_settings', function (Blueprint $table) {
            $table->dropColumn(array_keys(self::COPY));
        });
    }
};
