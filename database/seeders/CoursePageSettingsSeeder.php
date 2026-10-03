<?php

namespace Database\Seeders;

use App\Models\CoursePageSettings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoursePageSettingsSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Section copy, section items and booking bands that are the same on the
     * main page and on every course detail page of that audience.
     *
     * @var array<string, array<string, string>>
     */
    private const SHARED = [
        'kids' => [
            'trial_btn_text' => "Réserver une séance d'essai",
            'whatsapp_btn_text' => 'Discuter avec nous sur WhatsApp',
            'suitability_label' => 'Pour qui ?',
            'suitability_title' => 'Ce cours est-il fait pour vous ?',
            'curriculum_label' => 'Le programme',
            'curriculum_title' => 'Que vas-tu apprendre dans ce programme ?',
            'session_label' => 'Comment ça marche',
            'session_title' => 'Comment se déroule le cours ?',
            'testimonials_label' => 'Témoignages',
            'testimonials_title' => 'Ce que disent les parents',
            'journey_label' => 'Progression',
            'journey_title' => 'Votre parcours et votre progression',
            'why_label' => 'Madrasat Ar-Rahman',
            'why_title' => 'Pourquoi choisir Madrassat Ar-Rahman ?',
            'faq_label' => 'FAQ',
            'faq_title' => 'Questions fréquentes',
            'related_title' => 'Autres cours similaires',
            'related_cta_text' => 'Voir les détails',
        ],
        'adults' => [
            'trial_btn_text' => "Réserver une séance d'essai",
            'whatsapp_btn_text' => 'Discuter avec nous sur WhatsApp',
            'suitability_label' => 'Pour qui ?',
            'suitability_title' => 'Ce cours est-il fait pour vous ?',
            'curriculum_label' => 'Le programme',
            'curriculum_title' => 'Que vas-tu apprendre dans ce programme ?',
            'session_label' => 'Comment ça marche',
            'session_title' => 'Comment se déroule le cours ?',
            'testimonials_label' => 'Témoignages',
            'testimonials_title' => 'Ce que disent les parents',
            'journey_label' => 'Progression',
            'journey_title' => 'Votre parcours et votre progression',
            'why_label' => 'Madrasat Ar-Rahman',
            'why_title' => 'Pourquoi choisir Madrassat Ar-Rahman ?',
            'faq_label' => 'FAQ',
            'faq_title' => 'Questions fréquentes',
            'related_title' => 'Autres cours similaires',
            'related_cta_text' => 'Voir les détails',
        ],
    ];

    /**
     * The two values that differ per audience on the main page.
     *
     * @var array<string, array<string, string>>
     */
    private const MAIN_PAGE = [
        'kids' => [
            'catalog_label' => 'Cours pour enfants',
            'catalog_title' => 'Cours des enfants disponibles',
            'catalog_subtitle' => "Choisissez le programme adapté à l'âge de votre enfant et cliquez pour voir les détails complets et réserver le cours d'essai.",
            'card_level_prefix' => '',
            'final_title' => 'Offrez à votre enfant la meilleure éducation coranique',
            'final_subtitle' => "Réservez dès maintenant la séance d'essai gratuite. Notre équipe pédagogique vous contactera dans les 24 heures pour évaluer le niveau de votre enfant et fixer le premier créneau.",
            'final_cta_text' => "Réserver une séance d'essai gratuite",
        ],
        'adults' => [
            'catalog_label' => 'Cours pour adultes',
            'catalog_title' => 'Cours des adultes et des grands',
            'catalog_subtitle' => "Choisissez le cours adapté à votre niveau et à votre objectif, puis cliquez pour voir les détails complets et réserver la séance d'essai.",
            'card_level_prefix' => 'Niveau : ',
            'final_title' => "Commencez votre apprentissage du Coran dès aujourd'hui",
            'final_subtitle' => "Réservez votre séance d'essai gratuite. Votre enseignant vous contactera dans les 24 heures pour évaluer votre niveau et définir votre plan d'étude personnalisé.",
            'final_cta_text' => "Réserver ma séance d'essai gratuite",
        ],
    ];

    /**
     * The two values that differ per audience on the course detail page.
     *
     * @var array<string, array<string, string>>
     */
    private const DETAILS = [
        'kids' => [
            'hero_label' => 'Programme dédié aux enfants et aux jeunes',
            'back_label' => 'Cours des enfants',
        ],
        'adults' => [
            'hero_label' => 'Programme dédié aux adultes et aux grands',
            'back_label' => 'Cours des adultes',
        ],
    ];

    /**
     * Main page copy that is identical for both audiences.
     *
     * @var array<string, string>
     */
    private const MAIN_PAGE_SHARED = [
        'catalog_empty_text' => 'Aucun cours disponible pour le moment.',
        'card_cta_text' => 'Voir les détails et réserver',
        'card_age_template' => 'Âge : {age}',
        'testimonials_label' => 'Témoignages',
    ];

    /** @var array<int, array<string, string>> */
    private const SESSION_ITEMS = [
        ['title' => 'Cours particulier en ligne', 'description' => 'Concentration totale de l\'enseignant sur l\'élève (1-1) sans aucune distraction.'],
        ['title' => 'Interaction adaptée à l\'âge', 'description' => 'Utilisation de jeux, d\'énigmes et de moyens visuels attrayants.'],
        ['title' => 'Enseignant ou enseignante adapté(e)', 'description' => 'Possibilité de choisir une enseignante spécialisée pour les filles et les plus jeunes.'],
        ['title' => 'Un programme qui évolue avec l\'élève', 'description' => 'La vitesse d\'explication s\'adapte entièrement à la capacité de l\'élève.'],
        ['title' => 'Suivi des parents', 'description' => 'Un rapport écrit après chaque cours pour vous informer de la progression.'],
    ];

    public function run(): void
    {
        CoursePageSettings::query()->updateOrCreate(
            ['id' => 1],
            array_merge(
                $this->kidsPage(),
                $this->adultsPage(),
                $this->sharedChrome(),
            ),
        );
    }

    /** @return array<string, mixed> */
    private function kidsPage(): array
    {
        return array_merge(
            [
                // ---- Hero ----
                'kids_badge' => '🌱 Un parcours spirituel ludique pour les 5 - 15 ans',
                'kids_label' => 'Cours pour enfants',
                'kids_title' => 'Simplifions le Coran et la langue arabe',
                'kids_title_accent' => 'pour vos enfants',
                'kids_subtitle' => 'Des cours particuliers en ligne avec des enseignants spécialisés dans le fondement et l\'inculcation des valeurs islamiques, d\'une manière encourageante adaptée à la nature de l\'enfant.',
                'kids_cta_title' => 'Voir les cours des enfants',
                'kids_cta_url' => '#catalog',
                'kids_wa_title' => 'Contactez-nous via WhatsApp',
                'kids_wa_url' => 'https://wa.me/201028268553',
                'kids_showcase_emoji' => '📖 ✨',
                'kids_showcase_title' => "Un environnement d'apprentissage joyeux, conçu pour l'enfant",
                'kids_showcase_subtitle' => 'Suivi précis avec des rapports périodiques pour les parents après chaque séance.',

                // ---- Catalog grid ----
                'kids_catalog_label' => self::MAIN_PAGE['kids']['catalog_label'],
                'kids_catalog_title' => self::MAIN_PAGE['kids']['catalog_title'],
                'kids_catalog_subtitle' => self::MAIN_PAGE['kids']['catalog_subtitle'],
                'kids_catalog_empty_text' => self::MAIN_PAGE_SHARED['catalog_empty_text'],
                'kids_card_cta_text' => self::MAIN_PAGE_SHARED['card_cta_text'],
                'kids_card_age_template' => self::MAIN_PAGE_SHARED['card_age_template'],
                'kids_card_level_prefix' => self::MAIN_PAGE['kids']['card_level_prefix'],

                // ---- Sections ----
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

                'kids_session_label' => self::SHARED['kids']['session_label'],
                'kids_session_title' => self::SHARED['kids']['session_title'],
                'kids_session_subtitle' => 'Nous garantissons une expérience interactive, sûre et motivante à chaque séance :',
                'kids_session_items' => self::SESSION_ITEMS,

                'kids_journey_label' => 'Comment ça marche',
                'kids_journey_title' => '💡 😊 Comment se déroule la séance ?',
                'kids_journey_subtitle' => 'Un parcours suivi, étape par étape, pour que votre enfant avance en confiance.',
                'kids_journey_items' => [
                    ['title' => '👨‍🏫 Enseignant dédié', 'description' => 'Un même enseignant suit votre enfant toute l\'année pour assurer une continuité et une relation de confiance.'],
                    ['title' => '💻 Séance interactive', 'description' => 'Une plateforme en ligne sûre, avec partage d\'écran, exercices visuels et outils pédagogiques.'],
                    ['title' => '🏠 Sans déplacement', 'description' => 'Votre enfant apprend depuis la maison, à un horaire choisi selon votre emploi du temps familial.'],
                    ['title' => '📝 Suivi parental', 'description' => 'Un rapport après chaque séance pour suivre la progression, les points forts et les points à améliorer.'],
                    ['title' => '⏰ Horaires flexibles', 'description' => 'Disponibilité 7 jours sur 7, de 7h à 22h, avec possibilité de modifier les créneaux à tout moment.'],
                ],

                'kids_testimonials_label' => self::MAIN_PAGE_SHARED['testimonials_label'],
                'kids_testimonials_title' => 'Ils nous font confiance',
                'kids_testimonials_subtitle' => null,
                'kids_testimonials_per_page' => 6,

                'kids_why_items' => [
                    ['icon' => '🕌', 'title' => 'Enseignants diplômés de l\'Al-Azhar', 'description' => 'Tous nos enseignants sont diplômés de l\'Al-Azhar et titulaires d\'Ijazah certifiées en Tajwid, avec une expérience confirmée auprès des enfants.'],
                    ['icon' => '👨‍👩‍👧', 'title' => '100% particuliers', 'description' => 'Votre enfant travaille seul avec son enseignant, sans groupe ni distraction, et le rythme s\'ajuste à son niveau réel.'],
                    ['icon' => '🎮', 'title' => 'Méthode ludique et bienveillante', 'description' => 'Des exercices interactifs adaptés à son âge qui rendent la récitation agréable et maintiennent sa motivation.'],
                    ['icon' => '📊', 'title' => 'Suivi détaillé pour les parents', 'description' => 'Un rapport après chaque séance avec les acquis, les points forts et les points à retravailler.'],
                    ['icon' => '⏰', 'title' => 'Horaires flexibles 7j/7', 'description' => 'De 7h à 22h, avec la possibilité de déplacer ou d\'annuler un créneau gratuitement à tout moment.'],
                    ['icon' => '🎁', 'title' => 'Première séance offerte', 'description' => 'La première séance est gratuite et sans engagement, pour évaluer la méthode et l\'enseignant en toute tranquillité.'],
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

                'kids_form_title' => 'Contactez-nous',
                'kids_form_subtitle' => 'Remplissez ce formulaire, nous vous répondrons sous 24 heures.',

                // ---- Final band ----
                'kids_final_title' => self::MAIN_PAGE['kids']['final_title'],
                'kids_final_subtitle' => self::MAIN_PAGE['kids']['final_subtitle'],
                'kids_final_cta_text' => self::MAIN_PAGE['kids']['final_cta_text'],
            ],
            $this->detailsCopy('kids'),
        );
    }

    /** @return array<string, mixed> */
    private function adultsPage(): array
    {
        return array_merge(
            [
                // ---- Hero ----
                'adults_badge' => '🕌 Enseignement individuel en ligne avec une flexibilité totale',
                'adults_label' => 'Cours pour adultes',
                'adults_title' => 'Apprendre le Coran et le Tajwid',
                'adults_title_accent' => 'pour adultes',
                'adults_subtitle' => 'Des cours particuliers pour adultes afin de maîtriser et corriger la récitation et la mémorisation, avec une flexibilité totale dans les horaires et le plan d\'étude.',
                'adults_cta_title' => 'Voir les cours des adultes',
                'adults_cta_url' => '#catalog',
                'adults_wa_title' => 'Contactez-nous via WhatsApp',
                'adults_wa_url' => 'https://wa.me/201028268553',
                'adults_showcase_emoji' => '📖',
                'adults_showcase_title' => 'Flexibilité et maîtrise pour les adultes',
                'adults_showcase_subtitle' => "Des plans d'étude adaptés à votre emploi du temps, avec un enseignant pour les hommes et une enseignante pour les femmes.",

                // ---- Catalog grid ----
                'adults_catalog_label' => self::MAIN_PAGE['adults']['catalog_label'],
                'adults_catalog_title' => self::MAIN_PAGE['adults']['catalog_title'],
                'adults_catalog_subtitle' => self::MAIN_PAGE['adults']['catalog_subtitle'],
                'adults_catalog_empty_text' => self::MAIN_PAGE_SHARED['catalog_empty_text'],
                'adults_card_cta_text' => self::MAIN_PAGE_SHARED['card_cta_text'],
                'adults_card_age_template' => self::MAIN_PAGE_SHARED['card_age_template'],
                'adults_card_level_prefix' => self::MAIN_PAGE['adults']['card_level_prefix'],

                // ---- Sections ----
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

                'adults_session_label' => self::SHARED['adults']['session_label'],
                'adults_session_title' => self::SHARED['adults']['session_title'],
                'adults_session_subtitle' => 'Nous garantissons une expérience interactive, sûre et motivante à chaque séance :',
                'adults_session_items' => self::SESSION_ITEMS,

                'adults_journey_label' => 'Comment ça marche',
                'adults_journey_title' => '🚀 Comment se déroule votre parcours',
                'adults_journey_subtitle' => 'Quatre étapes simples entre vous et votre objectif d\'apprentissage du Coran.',
                'adults_journey_items' => [
                    ['title' => 'Réservez votre essai', 'description' => 'Une séance d\'essai gratuite pour découvrir la méthode et rencontrer votre enseignant.'],
                    ['title' => 'Évaluation du niveau', 'description' => 'L\'enseignant évalue votre récitation, votre niveau en arabe et vos objectifs.'],
                    ['title' => 'Plan d\'étude', 'description' => 'Un programme personnalisé est défini : matière, durée, horaires et fréquence des séances.'],
                    ['title' => 'Progression suivie', 'description' => 'Des cours réguliers avec un suivi détaillé de vos acquis et de vos points de progression.'],
                ],

                'adults_testimonials_label' => self::MAIN_PAGE_SHARED['testimonials_label'],
                'adults_testimonials_title' => 'Ils nous font confiance',
                'adults_testimonials_subtitle' => null,
                'adults_testimonials_per_page' => 6,

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
                'adults_why_items' => [
                    ['icon' => '🕌', 'title' => 'Enseignants diplômés de l\'Al-Azhar', 'description' => 'Tous nos enseignants sont diplômés de l\'Al-Azhar et titulaires d\'Ijazah certifiées en Tajwid, avec une expérience confirmée dans l\'enseignement des adultes.'],
                    ['icon' => '📚', 'title' => 'Plan d\'étude personnalisé', 'description' => 'Après une évaluation de votre niveau, l\'enseignant construit un programme sur mesure aligné sur vos objectifs et votre temps disponible.'],
                    ['icon' => '🕰️', 'title' => 'Disponibilité 7j/7', 'description' => 'Des cours de 7h à 22h, y compris le week-end, modifiables ou annulables gratuitement à tout moment.'],
                    ['icon' => '📈', 'title' => 'Progression mesurable', 'description' => 'Une évaluation régulière de vos acquis et des objectifs clairs à chaque étape de votre parcours.'],
                    ['icon' => '🔒', 'title' => 'Cours privés et sécurisés', 'description' => 'Des séances 100% particulières, conformes aux règles de Tajwid, dans un environnement respectueux et confidentiel.'],
                    ['icon' => '🎁', 'title' => 'Première séance offerte', 'description' => 'Une première séance gratuite et sans engagement, pour valider la méthode avant tout engagement durable.'],
                ],

                'adults_faq_cta1_text' => null,
                'adults_faq_cta1_url' => null,
                'adults_faq_cta2_text' => null,
                'adults_faq_cta2_url' => null,

                'adults_form_title' => 'Contactez-nous',
                'adults_form_subtitle' => 'Remplissez ce formulaire, nous vous répondrons sous 24 heures.',

                // ---- Final band ----
                'adults_final_title' => self::MAIN_PAGE['adults']['final_title'],
                'adults_final_subtitle' => self::MAIN_PAGE['adults']['final_subtitle'],
                'adults_final_cta_text' => self::MAIN_PAGE['adults']['final_cta_text'],
            ],
            $this->detailsCopy('adults'),
        );
    }

    /**
     * Detail page copy for one audience. The shared tier stays empty on purpose:
     * an editor only fills it when the course pages need wording that differs
     * from the main page, and the resolver falls through to the main page
     * otherwise.
     *
     * @return array<string, string|null>
     */
    private function detailsCopy(string $audience): array
    {
        $copy = [];

        foreach (self::SHARED[$audience] as $key => $value) {
            $copy['details_'.$audience.'_'.$key] = $value;
        }

        foreach (self::DETAILS[$audience] as $key => $value) {
            $copy['details_'.$audience.'_'.$key] = $value;
        }

        $copy['details_'.$audience.'_trial_url'] = '/#trial-form';
        $copy['details_'.$audience.'_session_subtitle'] = 'Nous garantissons une expérience interactive, sûre et motivante à chaque séance :';
        $copy['details_'.$audience.'_booking_title'] = "Commencez votre parcours d'apprentissage dès aujourd'hui";
        $copy['details_'.$audience.'_booking_subtitle'] = 'Remplissez le formulaire et nous vous contacterons immédiatement pour fixer le créneau du cours d\'essai adapté.';
        $copy['details_'.$audience.'_booking_note'] = 'Nos équipes vous répondent sous 24 heures.';
        $copy['details_'.$audience.'_sidebar_title'] = "Réserver un cours d'essai";

        return $copy;
    }

    /**
     * Copy every audience shares, so the same value is not stored twice.
     *
     * @return array<string, mixed>
     */
    private function sharedChrome(): array
    {
        return [
            'details_booking_title' => "Commencez votre parcours d'apprentissage dès aujourd'hui",
            'details_booking_subtitle' => 'Remplissez le formulaire et nous vous contacterons immédiatement pour fixer le créneau du cours d\'essai adapté.',
            'details_cta_title' => "Réserver un cours d'essai",
            'details_booking_note' => 'Nos équipes vous répondent sous 24 heures.',

            'is_active' => true,
            'is_indexed' => true,
        ];
    }
}
