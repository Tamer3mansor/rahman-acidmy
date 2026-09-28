<?php

namespace Database\Seeders;

use App\Enums\MediaType;
use App\Models\LandingSettings;
use Illuminate\Database\Seeder;

class LandingSettingsSeeder extends Seeder
{
    /**
     * Site chrome copy that used to be hardcoded in the nav, footer, contact
     * form and landing.js. Same values as the backfill migration, so a fresh
     * install and a deployed database render identical text.
     *
     * @var array<string, string>
     */
    private const CHROME_TEXT = [
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
        'testimonial_play_label' => 'تشغيل الفيديو',
        'testimonial_mute_label' => 'كتم الصوت',
        'testimonial_unmute_label' => 'تشغيل الصوت',
        'testimonial_resume_label' => 'تشغيل',
        'testimonial_pause_label' => 'إيقاف مؤقت',
        'testimonial_volume_label' => 'مستوى الصوت',

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

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LandingSettings::query()->updateOrCreate(
            ['id' => 1],
            array_merge(
                [
                    'header_brand_name' => 'Ar-Rahman',
                    'header_brand_sub' => 'ACADEMY',
                    'header_logo_path' => null,
                    'header_btn1_title' => 'poser une question',
                    'header_btn1_url' => 'https://wa.me/201028268553',
                    'header_btn2_title' => 'Réservez votre essai gratuit',
                    'header_btn2_url' => '#trial-form',

                    'hero_badge' => 'Éducation islamique en ligne · 7 jours × 7',
                    'hero_title' => 'Apprenez le Coran et l\'arabe',
                    'hero_title_accent' => 'Personnalisé pour vous',
                    'hero_subtitle' => 'Cours particuliers en ligne pour enfants et adultes, avec des enseignants spécialisés diplômés de l\'Al-Azhar et détenteurs d\'Ijazah. Un programme adapté à votre niveau et à votre emploi du temps.',
                    'hero_btn1_title' => 'Réservez votre essai gratuit',
                    'hero_btn1_url' => '#trial-form',
                    'hero_btn2_title' => 'Contactez-nous',
                    'hero_btn2_url' => 'https://wa.me/201028268553',
                    'hero_video_path' => null,
                    'hero_media_type' => MediaType::Video->value,
                    'hero_video_autoplay' => true,
                    'hero_video_loop' => true,

                    'trust_label' => 'Ce qu\'ils disent de nous',
                    'trust_title' => 'Des milliers de familles font confiance à Ar-Rahman Academy',
                    'trust_subtitle' => 'Témoignages authentiques de nos élèves et parents en Europe, au Canada et dans le monde arabe',
                    'trust_cta_title' => 'Réservez votre essai gratuit',

                    'journey_label' => 'Comment se déroule votre parcours',
                    'journey_title' => '5 étapes simples vers l\'excellence',
                    'journey_subtitle' => 'Du premier contact à l\'atteinte de vos objectifs — un chemin clair et un accompagnement continu',
                    'journey_cta_title' => 'Commencez votre parcours aujourd\'hui',

                    'compare_label' => 'Pourquoi Ar-Rahman Academy ?',
                    'compare_title' => 'La différence est évidente dès le début',
                    'compare_subtitle' => 'Comparez par vous-même l\'enseignement traditionnel et notre approche',
                    'compare_problems_title' => 'Les problèmes de l\'enseignement traditionnel',
                    'compare_solutions_title' => 'La solution Ar-Rahman Academy',
                    'compare_cta_title' => 'Essayez la différence gratuitement',

                    'teachers_label' => 'Nos enseignants',
                    'teachers_title' => 'Une sélection des meilleurs enseignants',
                    'teachers_subtitle' => 'Des enseignants spécialisés, chacun ayant réussi un processus de sélection rigoureux pour garantir la qualité de l\'enseignement',
                    'teachers_cta_title' => 'Réservez votre cours avec un de nos enseignants',

                    'faq_label' => 'Questions fréquentes',
                    'faq_title' => 'Tout ce que vous voulez savoir',
                    'faq_subtitle' => 'Vous n\'avez pas trouvé votre réponse ? Contactez-nous directement',

                    'form_label' => 'Séance d\'essai gratuite',
                    'form_title' => 'Commencez votre parcours avec',
                    'form_title_accent' => 'Ar-Rahman Academy',
                    'form_subtitle' => 'Remplissez ce formulaire et notre équipe vous contactera dans les 24 heures pour organiser un cours gratuit sans engagement.',
                    'form_card_title' => 'Inscrivez vos informations',
                    'form_card_subtitle' => 'Notre équipe vous contactera dans les 24 heures pour organiser votre cours gratuit',
                    'form_note' => 'Veuillez entrer des informations correctes pour faciliter la prise de contact',
                    'form_privacy_note' => '🔒 Vos données sont protégées et ne seront jamais partagées avec des tiers',

                    'footer_brand_name' => 'Ar-Rahman Academy',
                    'footer_brand_sub' => 'Académie Ar-Rahman d\'enseignement islamique',
                    'footer_description' => 'Enseignement du Coran et de la langue arabe en ligne pour enfants et adultes, avec des enseignants spécialisés diplômés de l\'Al-Azhar.',
                    'footer_copyright' => '© 2025 Ar-Rahman Academy. Tous droits réservés.',
                ],
                self::CHROME_TEXT,
            ),
        );
    }
}
