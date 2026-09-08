<?php

namespace Database\Seeders;

use App\Enums\MediaType;
use App\Models\LandingSettings;
use Illuminate\Database\Seeder;

class LandingSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LandingSettings::query()->updateOrCreate(
            ['id' => 1],
            [
                'header_brand_name' => 'Ar-Rahman',
                'header_brand_sub' => 'ACADEMY',
                'header_logo_path' => null,
                'header_btn1_title' => 'WhatsApp',
                'header_btn1_url' => 'https://wa.me/0000000000',
                'header_btn2_title' => 'Réservez votre essai gratuit',
                'header_btn2_url' => '#trial-form',

                'hero_badge' => 'Éducation islamique en ligne · 7 jours × 7',
                'hero_title' => 'Apprenez le Coran et l\'arabe',
                'hero_title_accent' => 'Personnalisé pour vous',
                'hero_subtitle' => 'Cours particuliers en ligne pour enfants et adultes, avec des enseignants spécialisés diplômés de l\'Al-Azhar et détenteurs d\'Ijazah. Un programme adapté à votre niveau et à votre emploi du temps.',
                'hero_btn1_title' => 'Réservez votre essai gratuit',
                'hero_btn1_url' => '#trial-form',
                'hero_btn2_title' => 'Contactez-nous',
                'hero_btn2_url' => 'https://wa.me/0000000000',
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
            ]
        );
    }
}
