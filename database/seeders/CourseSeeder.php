<?php

namespace Database\Seeders;

use App\Enums\CourseAudience;
use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $journeySteps = [
            ['htmlClass' => 'gold', 'number' => '01', 'title' => 'Évaluation du niveau', 'description' => 'Un cours d\'essai pour déterminer le niveau et les besoins.'],
            ['htmlClass' => 'dark-green', 'number' => '02', 'title' => 'Programme adapté', 'description' => 'Un plan d\'apprentissage personnalisé selon votre emploi du temps.'],
            ['htmlClass' => 'dark-green', 'number' => '03', 'title' => 'Cours réguliers', 'description' => 'Des rendez-vous hebdomadaires fixes et des sessions interactives.'],
            ['htmlClass' => 'dark-green', 'number' => '04', 'title' => 'Suivi précis', 'description' => 'Rapports et tests courts continus.'],
            ['htmlClass' => 'dark-green', 'number' => '05', 'title' => 'Progression et maîtrise', 'description' => 'Passer aux niveaux et aux sections suivants.'],
        ];

        $sessionFeatures = [
            ['title' => 'Cours particulier en ligne', 'description' => 'Concentration totale de l\'enseignant sur l\'élève (1-1) sans aucune distraction.'],
            ['title' => 'Interaction adaptée à l\'âge', 'description' => 'Utilisation de jeux, d\'énigmes et de moyens visuels attrayants.'],
            ['title' => 'Enseignant ou enseignante adapté(e)', 'description' => 'Possibilité de choisir une enseignante spécialisée pour les filles et les plus jeunes.'],
            ['title' => 'Un programme qui évolue avec l\'élève', 'description' => 'La vitesse d\'explication s\'adapte entièrement à la capacité de l\'élève.'],
            ['title' => 'Suivi des parents', 'description' => 'Un rapport écrit après chaque cours pour vous informer de la progression.'],
        ];

        $courses = [
            // ============================================================
            // ENFANTS
            // ============================================================
            [
                'audience' => CourseAudience::Kids,
                'title' => 'Initiation des Baraa\'im et mémorisation du Coran',
                'slug' => 'initiation-baraaim-quran',
                'icon' => '🌱',
                'card_theme' => 'teal',
                'short_description' => 'Mémorisation des sourates courtes avec apprentissage de la lecture (fatha, damma, kasra) de façon simple et interactive.',
                'description' => '<p>Ce programme initie les plus petits à la mémorisation des sourates courtes et à la lecture de base, avec une méthode simple et interactive adaptée aux enfants de 5 à 8 ans.</p>',
                'age_band_min' => 5,
                'age_band_max' => 8,
                'session_minutes' => 30,
                'level_label' => 'Débutant',
                'curriculum_items' => [
                    ['icon' => '📖', 'title' => 'Lecture du Coran', 'description' => 'Correction de la prononciation et apprentissage des lettres.'],
                    ['icon' => '🌱', 'title' => 'Mémorisation facilitée', 'description' => 'Plan de mémorisation progressif adapté à l\'énergie de l\'enfant.'],
                ],
            ],
            [
                'audience' => CourseAudience::Kids,
                'title' => 'Mémorisation du Coran et Tajwid pour enfants',
                'slug' => 'memo-coran-tajwid-enfants',
                'icon' => '📖',
                'card_theme' => 'amber',
                'short_description' => 'Programme complet pour mémoriser les Juz\' et appliquer les règles simplifiées du Tajwid avec révision continue.',
                'description' => '<p>Un programme intégré de mémorisation des différentes parties du Coran, avec application des règles simplifiées du Tajwid et une révision continue pour consolider la mémorisation.</p>',
                'age_band_min' => 8,
                'age_band_max' => 14,
                'session_minutes' => 45,
                'level_label' => 'Intermédiaire',
                'curriculum_items' => [
                    ['icon' => '✨', 'title' => 'Règles du Tajwid', 'description' => 'Application des règles fondamentales de manière pratique et accessible.'],
                    ['icon' => '🧠', 'title' => 'Mémorisation facilitée', 'description' => 'Un plan de mémorisation progressif adapté à l\'âge de l\'enfant.'],
                ],
            ],
            [
                'audience' => CourseAudience::Kids,
                'title' => 'Langue arabe et valeurs islamiques',
                'slug' => 'arabe-valeurs-islamiques-enfants',
                'icon' => '🗣️',
                'card_theme' => 'indigo',
                'short_description' => 'Conversation, lecture et écriture en arabe avec apprentissage des adhkar (invocations) et des bonnes valeurs.',
                'description' => '<p>Ce cours développe les compétences de conversation, de lecture et d\'écriture en arabe, tout en enseignant les invocations quotidiennes et les bonnes valeurs islamiques de manière captivante.</p>',
                'age_band_min' => 6,
                'age_band_max' => 15,
                'session_minutes' => 45,
                'level_label' => 'Intermédiaire',
                'curriculum_items' => [
                    ['icon' => '🗣️', 'title' => 'Langue arabe', 'description' => 'Conversation, lecture et écriture en arabe moderne.'],
                    ['icon' => '🤲', 'title' => 'Adhkar et valeurs', 'description' => 'Apprentissage des invocations quotidiennes et des bonnes valeurs.'],
                ],
            ],

            // ============================================================
            // ADULTES
            // ============================================================
            [
                'audience' => CourseAudience::Adults,
                'title' => 'Correction de la récitation et règles du Tajwid',
                'slug' => 'correction-recitation-tajwid',
                'icon' => '✨',
                'card_theme' => 'emerald',
                'short_description' => 'Parfaire la prononciation des lettres et appliquer les règles pratiques du Tajwid lors de la lecture en direct avec l\'enseignant.',
                'description' => '<p>Un cours individuel pour les adultes souhaitant corriger leur récitation et maîtriser les règles pratiques du Tajwid, avec un plan adapté à leur niveau et à leur emploi du temps.</p>',
                'age_band_min' => null,
                'age_band_max' => null,
                'session_minutes' => 60,
                'level_label' => 'Débutant / Intermédiaire',
                'curriculum_items' => [
                    ['icon' => '✨', 'title' => 'Makharij des lettres', 'description' => 'Correction de la prononciation et des points d\'articulation.'],
                    ['icon' => '📖', 'title' => 'Tajwid appliqué', 'description' => 'Application pratique des règles lors de la lecture directe.'],
                ],
            ],
            [
                'audience' => CourseAudience::Adults,
                'title' => 'Mémorisation du Coran et consolidation',
                'slug' => 'memo-coran-consolidation',
                'icon' => '🧠',
                'card_theme' => 'dark-green',
                'short_description' => 'Un plan de mémorisation personnalisé adapté à votre temps avec une méthodologie de révision solide pour ne pas oublier.',
                'description' => '<p>Un plan de mémorisation personnalisé qui s\'adapte à votre emploi du temps, avec une méthodologie de révision éprouvée pour garantir la consolidation et éviter l\'oubli.</p>',
                'age_band_min' => null,
                'age_band_max' => null,
                'session_minutes' => 60,
                'level_label' => 'Tous niveaux',
                'curriculum_items' => [
                    ['icon' => '🧠', 'title' => 'Mémorisation', 'description' => 'Un plan personnalisé adapté à votre rythme de vie.'],
                    ['icon' => '🔄', 'title' => 'Révision', 'description' => 'Une méthodologie de révision pour consolider et ne pas oublier.'],
                ],
            ],
            [
                'audience' => CourseAudience::Adults,
                'title' => 'Langue arabe et études islamiques',
                'slug' => 'arabe-etudes-islamiques',
                'icon' => '🗣️',
                'card_theme' => 'green',
                'short_description' => 'Étude de la grammaire, compréhension des sens du Coran, des adhkar et de l\'exégèse des sourates de manière scientifique simplifiée.',
                'description' => '<p>Une étude approfondie et simplifiée de la grammaire arabe, de la compréhension des sens du Coran, des invocations et de l\'exégèse des sourates.</p>',
                'age_band_min' => null,
                'age_band_max' => null,
                'session_minutes' => 60,
                'level_label' => 'Avancé / Général',
                'curriculum_items' => [
                    ['icon' => '📚', 'title' => 'Grammaire arabe', 'description' => 'Étude des règles de grammaire de manière scientifique et simplifiée.'],
                    ['icon' => '🕌', 'title' => 'Études islamiques', 'description' => 'Compréhension des sens du Coran et de l\'exégèse des sourates.'],
                ],
            ],
        ];

        foreach ($courses as $sort => $course) {
            Course::query()->updateOrCreate(
                ['slug' => $course['slug']],
                [
                    'audience' => $course['audience']->value,
                    'title' => $course['title'],
                    'icon' => $course['icon'],
                    'card_theme' => $course['card_theme'],
                    'short_description' => $course['short_description'],
                    'description' => $course['description'],
                    'age_band_min' => $course['age_band_min'],
                    'age_band_max' => $course['age_band_max'],
                    'session_minutes' => $course['session_minutes'],
                    'level_label' => $course['level_label'],
                    'curriculum_items' => $course['curriculum_items'],
                    'session_features' => $sessionFeatures,
                    'journey_steps' => $journeySteps,
                    'suitability_checks' => $this->suitabilityChecksFor($course['audience']),
                    'faqs' => $this->faqsFor($course['audience']),
                    'is_active' => true,
                    'sort_order' => $sort,
                ]
            );
        }
    }

    /**
     * @return array<int, string>
     */
    private function suitabilityChecksFor(CourseAudience $audience): array
    {
        $kids = [
            'Enfants de 5 à 15 ans souhaitant commencer la mémorisation du Coran et des fondations solides.',
            'Ceux qui recherchent la correction de la récitation et l\'application du Tajwid simplifié.',
            'Ceux qui souhaitent apprendre les bases de la langue arabe et la lecture.',
            'Les parents qui privilégient l\'enseignement en ligne interactif individuel (1-1).',
        ];

        $adults = [
            'Adultes souhaitent débuter ou poursuivre la mémorisation du Coran à leur rythme.',
            'Ceux qui recherchent la correction de la récitation et l\'application du Tajwid.',
            'Ceux qui souhaitent apprendre la langue arabe et les études islamiques.',
            'Les personnes actives qui privilégient des horaires flexibles en ligne.',
        ];

        return $audience === CourseAudience::Kids ? $kids : $adults;
    }

    /**
     * @return array<int, array{question: string, answer: string}>
     */
    private function faqsFor(CourseAudience $audience): array
    {
        $base = [
            ['question' => 'Les cours sont-ils individuels ou en groupe ?', 'answer' => 'Tous nos cours sont entièrement individuels (1-1) pour une concentration totale de l\'enseignant sur l\'élève et un rendement maximum.'],
            ['question' => 'Comment l\'enseignant adapté est-il choisi ?', 'answer' => 'La sélection se fait selon l\'âge, le sexe et le niveau actuel de l\'élève, avec un soin particulier pour confier les enfants à des enseignants certifiés et expérimentés.'],
            ['question' => 'Peut-on modifier ou déplacer le créneau du cours ?', 'answer' => 'Oui, une flexibilité de reprogrammation est disponible avant le cours suffisamment à l\'avance en coordination avec notre service client.'],
            ['question' => 'Comment suivre la progression ?', 'answer' => 'Vous recevez un rapport périodique après les cours indiquant ce qui a été mémorisé, lu, les remarques de l\'enseignant et les points à améliorer.'],
            ['question' => 'Le cours d\'essai est-il gratuit ou payant ?', 'answer' => 'Nous offrons un cours d\'essai d\'évaluation pour que l\'élève découvre l\'enseignant et que nous déterminions le niveau et le programme avant l\'inscription officielle.'],
        ];

        return $base;
    }
}
