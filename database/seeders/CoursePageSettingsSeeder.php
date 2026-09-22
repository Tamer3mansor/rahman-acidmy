<?php

namespace Database\Seeders;

use App\Models\CoursePageSettings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoursePageSettingsSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CoursePageSettings::query()->updateOrCreate(
            ['id' => 1],
            [
                // ---- Page Enfants ----
                'kids_label' => 'Cours pour enfants',
                'kids_title' => 'Simplifions le Coran et la langue arabe',
                'kids_title_accent' => 'pour vos enfants',
                'kids_subtitle' => 'Des cours particuliers en ligne avec des enseignants spécialisés dans le fondement et l\'inculcation des valeurs islamiques, d\'une manière encourageante adaptée à la nature de l\'enfant.',
                'kids_badge' => '🌱 Un parcours spirituel ludique pour les 5 - 15 ans',

                'kids_curriculum_label' => 'Le programme',
                'kids_curriculum_title' => '📚 Que va apprendre mon enfant ?',
                'kids_curriculum_subtitle' => 'Un programme complet qui couvre le Coran, la langue arabe et l\'éducation islamique.',
                'kids_curriculum_items' => [
                    ['icon' => '📖', 'title' => 'Récitation du Coran', 'description' => 'Une lecture correcte, fluide et appliquée, lettre par lettre, dès le premier jour.'],
                    ['icon' => '🎵', 'title' => 'Tajwid', 'description' => 'Les règles de récitation enseignées de façon ludique et progressive, adaptées à chaque âge.'],
                    ['icon' => '🧠', 'title' => 'Mémorisation', 'description' => 'Un programme de mémorisation (Hifz) structuré avec révision continue des sourates apprises.'],
                    ['icon' => '🗣️', 'title' => 'Langue arabe', 'description' => 'Le vocabulaire, la lecture et la conversation en arabe avec une méthode simple et interactive.'],
                    ['icon' => '🤲', 'title' => 'Invocations', 'description' => 'Les invocations quotidiennes et adhkar du matin et du soir mémorisés avec leur signification.'],
                    ['icon' => '🌿', 'title' => 'Valeurs islamiques', 'description' => 'Les bonnes manières, le respect des parents et les valeurs de l\'Islam enseignées avec bienveillance.'],
                ],
                'kids_cta_title' => 'Voir les cours des enfants',
                'kids_cta_url' => '#catalog',
                'kids_wa_title' => 'Contactez-nous via WhatsApp',
                'kids_wa_url' => 'https://wa.me/201028268553',

                'kids_about_label' => 'À propos des cours',
                'kids_about_title' => 'À propos des cours',
                'kids_about_subtitle' => 'Nos programmes sont conçus pour répondre aux besoins spécifiques des enfants et des familles.',
                'kids_about_items' => [
                    ['icon' => '', 'title' => '', 'description' => 'Apprentissage 100% en ligne, sans déplacement ni perte de temps'],
                    ['icon' => '', 'title' => '', 'description' => 'Enseignant dédié qui s\'adapte à la personnalité et au rythme de votre enfant'],
                    ['icon' => '', 'title' => '', 'description' => 'Méthode ludique, positive et bienveillante qui motive l\'enfant'],
                    ['icon' => '', 'title' => '', 'description' => 'Rapports périodiques aux parents pour suivre chaque séance'],
                    ['icon' => '', 'title' => '', 'description' => 'Horaires flexibles compatibles avec l\'école et les activités familiales'],
                    ['icon' => '', 'title' => '', 'description' => 'Enseignant pour les garçons et enseignante pour les filles, selon votre préférence'],
                    ['icon' => '', 'title' => '', 'description' => 'Programme personnalisé selon l\'âge, le niveau et les objectifs de l\'enfant'],
                    ['icon' => '', 'title' => '', 'description' => 'Première séance d\'essai gratuite et sans engagement'],
                ],

                'kids_journey_label' => 'Comment ça marche',
                'kids_journey_title' => '💡 😊 Comment se déroule la séance ?',
                'kids_journey_subtitle' => 'Nous garantissons une expérience interactive, sûre et motivante à chaque séance :',
                'kids_journey_items' => [
                    ['title' => '👨‍🏫 Enseignant dédié', 'description' => 'Un même enseignant suit votre enfant toute l\'année pour assurer une continuité et une relation de confiance.'],
                    ['title' => '💻 Séance interactive', 'description' => 'Une plateforme en ligne sûre, avec partage d\'écran, exercices visuels et outils pédagogiques.'],
                    ['title' => '🏠 Sans déplacement', 'description' => 'Votre enfant apprend depuis la maison, à un horaire choisi selon votre emploi du temps familial.'],
                    ['title' => '📝 Suivi parental', 'description' => 'Un rapport après chaque séance pour suivre la progression, les points forts et les points à améliorer.'],
                    ['title' => '⏰ Horaires flexibles', 'description' => 'Disponibilité 7 jours sur 7, de 7h à 22h, avec possibilité de modifier les créneaux à tout moment.'],
                ],

                'kids_faq_label' => 'Questions fréquentes',
                'kids_faq_title' => '❓ Questions fréquentes — Cours enfants',
                'kids_faq_subtitle' => 'Toutes les réponses aux questions que se posent les parents avant de commencer.',
                'kids_faq_items' => [
                    ['question' => 'Les cours de Coran pour enfants sont-ils individuels ?', 'answer' => 'Oui, les cours sont 100% particuliers : votre enfant travaille seul avec son enseignant, sans groupe ni distraction.'],
                    ['question' => 'Comment l\'enseignant est-il choisi ?', 'answer' => 'Nous choisissons l\'enseignant en fonction de l\'âge, du niveau et des objectifs de votre enfant. Enseignant pour les garçons et enseignante pour les filles, selon votre préférence.'],
                    ['question' => 'Peut-on changer l\'horaire des cours ?', 'answer' => 'Oui, sans frais et sans engagement. Nous sommes disponibles 7 jours sur 7, de 7h à 22h, et vous pouvez modifier vos créneaux à tout moment.'],
                    ['question' => 'Comment suivre les progrès de mon enfant ?', 'answer' => 'Après chaque séance, l\'enseignant envoie un rapport périodique aux parents avec l\'évaluation de la séance, les acquis et les points à travailler.'],
                    ['question' => 'La séance d\'essai est-elle gratuite ?', 'answer' => 'Oui, la première séance est entièrement gratuite et sans engagement. Vous pourrez évaluer la méthode et l\'enseignant avant de vous inscrire.'],
                    ['question' => 'Quelles sont les qualifications des enseignants ?', 'answer' => 'Tous nos enseignants sont diplômés de l\'Al-Azhar et titulaires d\'Ijazah certifiées en Tajwid, avec une expérience confirmée dans l\'enseignement des enfants.'],
                ],
                'kids_faq_cta1_text' => null,
                'kids_faq_cta1_url' => null,
                'kids_faq_cta2_text' => null,
                'kids_faq_cta2_url' => null,

                'kids_testimonials_title' => 'Ils nous font confiance',
                'kids_testimonials_subtitle' => null,
                'kids_form_title' => 'Contactez-nous',
                'kids_form_subtitle' => 'Remplissez ce formulaire, nous vous répondrons sous 24 heures.',

                // ---- Page Adultes ----
                'adults_label' => 'Cours pour adultes',
                'adults_title' => 'Apprendre le Coran et le Tajwid',
                'adults_title_accent' => 'pour adultes',
                'adults_subtitle' => 'Des cours particuliers pour adultes afin de maîtriser et corriger la récitation et la mémorisation, avec une flexibilité totale dans les horaires et le plan d\'étude.',
                'adults_badge' => '🕌 Enseignement individuel en ligne avec une flexibilité totale',
                'adults_cta_title' => 'Voir les cours des adultes',
                'adults_cta_url' => '#catalog',
                'adults_wa_title' => 'Contactez-nous via WhatsApp',
                'adults_wa_url' => 'https://wa.me/201028268553',

                'adults_about_label' => 'À propos des cours',
                'adults_about_title' => 'À propos des cours',
                'adults_about_subtitle' => 'Une méthode éprouvée, des enseignants qualifiés et une flexibilité totale pour les adultes.',
                'adults_about_items' => [
                    ['icon' => '👨‍🏫', 'title' => 'Enseignants Al-Azhar', 'description' => 'Diplômés de l\'Al-Azhar et titulaires d\'Ijazah, avec une expérience confirmée dans l\'enseignement des adultes.'],
                    ['icon' => '🕰️', 'title' => 'Horaires flexibles', 'description' => 'Cours disponibles 7 jours sur 7, de 7h à 22h, avec la possibilité de les déplacer gratuitement à tout moment.'],
                    ['icon' => '🎯', 'title' => 'Plan personnalisé', 'description' => 'Un programme d\'étude sur mesure, établi après évaluation de votre niveau, pour progresser efficacement vers votre objectif.'],
                    ['icon' => '📊', 'title' => 'Suivi continu', 'description' => 'Une évaluation régulière de votre progression avec des objectifs clairs à chaque étape de votre parcours.'],
                ],

                'adults_curriculum_label' => 'Le programme',
                'adults_curriculum_title' => '📚 Que vas-tu apprendre ?',
                'adults_curriculum_subtitle' => 'Un programme structuré pour maîtriser la lecture, le Tajwid et la langue arabe, adapté à votre niveau.',
                'adults_curriculum_items' => [
                    ['icon' => '📖', 'title' => 'Correction de la récitation', 'description' => 'La lecture est corrigée lettre par lettre, avec les règles essentielles de prononciation (Makharij).'],
                    ['icon' => '🎶', 'title' => 'Règles du Tajwid', 'description' => 'Les règles de récitation appliquées progressivement, de façon pratique durant chaque séance.'],
                    ['icon' => '🧠', 'title' => 'Mémorisation (Hifz)', 'description' => 'Un programme de mémorisation structuré avec révision continue et suivi de votre progression.'],
                    ['icon' => '🗣️', 'title' => 'Langue arabe', 'description' => 'Vocabulaire, lecture et conversation utiles pour comprendre le Coran et pratiquer l\'arabe.'],
                    ['icon' => '🤲', 'title' => 'Adhkar et invocations', 'description' => 'Les invocations du quotidien avec leur signification et leur bonne prononciation.'],
                ],

                'adults_journey_label' => 'Comment ça marche',
                'adults_journey_title' => '🚀 Comment se déroule votre parcours',
                'adults_journey_subtitle' => 'Quatre étapes simples entre vous et votre objectif d\'apprentissage du Coran.',
                'adults_journey_items' => [
                    ['title' => 'Réservez votre essai', 'description' => 'Une séance d\'essai gratuite pour découvrir la méthode et rencontrer votre enseignant.'],
                    ['title' => 'Évaluation du niveau', 'description' => 'L\'enseignant évalue votre récitation, votre niveau en arabe et vos objectifs.'],
                    ['title' => 'Plan d\'étude', 'description' => 'Un programme personnalisé est défini : matière, durée, horaires et fréquence des séances.'],
                    ['title' => 'Progression suivie', 'description' => 'Des cours réguliers avec un suivi détaillé de vos acquis et de vos points de progression.'],
                ],

                'adults_faq_label' => 'Questions fréquentes',
                'adults_faq_title' => '❓ Questions fréquentes — Cours adultes',
                'adults_faq_subtitle' => 'Toutes les réponses aux questions des adultes avant de commencer leur apprentissage.',
                'adults_faq_items' => [
                    ['question' => 'Puis-je apprendre le Coran à mon rythme ?', 'answer' => 'Oui. Après une évaluation initiale, l\'enseignant établit un plan d\'étude personnalisé, adapté à votre niveau, vos objectifs et votre emploi du temps.'],
                    ['question' => 'Les cours pour adultes sont-ils individuels ?', 'answer' => 'Oui, les cours sont 100% particuliers : vous travaillez seul avec un enseignant (homme) ou une enseignante (femme), selon votre préférence.'],
                    ['question' => 'Y a-t-il un engagement ou un contrat ?', 'answer' => 'Non. Sans contrat ni frais d\'annulation : vous pouvez modifier ou annuler vos cours à tout moment.'],
                    ['question' => 'Comment se déroule la correction de la récitation (Tajwid) ?', 'answer' => 'L\'enseignant écoute votre récitation, corrige les erreurs lettre par lettre et applique les règles de Tajwid de façon progressive et pratique.'],
                    ['question' => 'Quelles sont les qualifications des enseignants ?', 'answer' => 'Tous nos enseignants sont diplômés de l\'Al-Azhar et titulaires d\'Ijazah certifiées en Tajwid, avec une expérience confirmée dans l\'enseignement des adultes.'],
                ],
                'adults_faq_cta1_text' => null,
                'adults_faq_cta1_url' => null,
                'adults_faq_cta2_text' => null,
                'adults_faq_cta2_url' => null,

                'adults_testimonials_title' => 'Ils nous font confiance',
                'adults_testimonials_subtitle' => null,
                'adults_form_title' => 'Contactez-nous',
                'adults_form_subtitle' => 'Remplissez ce formulaire, nous vous répondrons sous 24 heures.',

                // ---- Page Détails du cours ----
                'details_booking_title' => 'Commencez votre parcours d\'apprentissage dès aujourd\'hui',
                'details_booking_subtitle' => 'Remplissez le formulaire et nous vous contacterons immédiatement pour fixer le créneau du cours d\'essai adapté.',
                'details_cta_title' => 'Réserver un cours d\'essai',
                'details_form_title' => 'Réservation du cours d\'essai',
                'details_booking_note' => 'Nos équipes vous répondent sous 24 heures.',
            ]
        );
    }
}
