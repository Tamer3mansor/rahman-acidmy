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
                'icon' => null,
                'card_theme' => 'teal',
                'short_description' => 'Mémorisation des sourates courtes avec apprentissage de la lecture (fatha, damma, kasra) de façon simple et interactive.',
                'description' => '<p>Ce programme initie les plus petits à la mémorisation des sourates courtes et à la lecture de base, avec une méthode simple et interactive adaptée aux enfants de 5 à 8 ans.</p>',
                'age_band_min' => 5,
                'badge_text' => '30 à 45 min/séance',
                'level_label' => 'Débutant',
            ],
            [
                'audience' => CourseAudience::Kids,
                'title' => 'Mémorisation du Coran et Tajwid pour enfants',
                'slug' => 'memo-coran-tajwid-enfants',
                'icon' => null,
                'card_theme' => 'amber',
                'short_description' => 'Programme complet pour mémoriser les Juz\' et appliquer les règles simplifiées du Tajwid avec révision continue.',
                'description' => '<p>Un programme intégré de mémorisation des différentes parties du Coran, avec application des règles simplifiées du Tajwid et une révision continue pour consolider la mémorisation.</p>',
                'age_band_min' => 8,
                'badge_text' => '45 min/séance',
                'level_label' => 'Intermédiaire',
            ],
            [
                'audience' => CourseAudience::Kids,
                'title' => 'Langue arabe et valeurs islamiques',
                'slug' => 'arabe-valeurs-islamiques-enfants',
                'icon' => null,
                'card_theme' => 'indigo',
                'short_description' => 'Conversation, lecture et écriture en arabe avec apprentissage des adhkar (invocations) et des bonnes valeurs.',
                'description' => '<p>Ce cours développe les compétences de conversation, de lecture et d\'écriture en arabe, tout en enseignant les invocations quotidiennes et les bonnes valeurs islamiques de manière captivante.</p>',
                'age_band_min' => 6,
                'badge_text' => '45 min/séance',
                'level_label' => 'Intermédiaire',
            ],

            // ============================================================
            // ADULTES
            // ============================================================
            [
                'audience' => CourseAudience::Adults,
                'title' => 'Correction de la récitation et règles du Tajwid',
                'slug' => 'correction-recitation-tajwid',
                'icon' => null,
                'card_theme' => 'emerald',
                'short_description' => 'Parfaire la prononciation des lettres et appliquer les règles pratiques du Tajwid lors de la lecture en direct avec l\'enseignant.',
                'description' => '<p>Un cours individuel pour les adultes souhaitant corriger leur récitation et maîtriser les règles pratiques du Tajwid, avec un plan adapté à leur niveau et à leur emploi du temps.</p>',
                'age_band_min' => null,
                'badge_text' => '45 à 60 min/séance',
                'level_label' => 'Débutant / Intermédiaire',
            ],
            [
                'audience' => CourseAudience::Adults,
                'title' => 'Mémorisation du Coran et consolidation',
                'slug' => 'memo-coran-consolidation',
                'icon' => null,
                'card_theme' => 'dark-green',
                'short_description' => 'Un plan de mémorisation personnalisé adapté à votre temps avec une méthodologie de révision solide pour ne pas oublier.',
                'description' => '<p>Un plan de mémorisation personnalisé qui s\'adapte à votre emploi du temps, avec une méthodologie de révision éprouvée pour garantir la consolidation et éviter l\'oubli.</p>',
                'age_band_min' => null,
                'badge_text' => '45 à 60 min/séance',
                'level_label' => 'Tous niveaux',
            ],
            [
                'audience' => CourseAudience::Adults,
                'title' => 'Langue arabe et études islamiques',
                'slug' => 'arabe-etudes-islamiques',
                'icon' => null,
                'card_theme' => 'green',
                'short_description' => 'Étude de la grammaire, compréhension des sens du Coran, des adhkar et de l\'exégèse des sourates de manière scientifique simplifiée.',
                'description' => '<p>Une étude approfondie et simplifiée de la grammaire arabe, de la compréhension des sens du Coran, des invocations et de l\'exégèse des sourates.</p>',
                'age_band_min' => null,
                'badge_text' => '45 à 60 min/séance',
                'level_label' => 'Avancé / Général',
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
                    'badge_text' => $course['badge_text'],
                    'level_label' => $course['level_label'],
                    'session_features' => $sessionFeatures,
                    'is_active' => true,
                    'sort_order' => $sort,
                ]
            );
        }

        $relatedBySlug = [
            'initiation-baraaim-quran' => ['memo-coran-tajwid-enfants', 'arabe-valeurs-islamiques-enfants'],
            'memo-coran-tajwid-enfants' => ['initiation-baraaim-quran', 'arabe-valeurs-islamiques-enfants'],
            'arabe-valeurs-islamiques-enfants' => ['initiation-baraaim-quran', 'memo-coran-tajwid-enfants'],
            'correction-recitation-tajwid' => ['memo-coran-consolidation', 'arabe-etudes-islamiques'],
            'memo-coran-consolidation' => ['correction-recitation-tajwid', 'arabe-etudes-islamiques'],
            'arabe-etudes-islamiques' => ['correction-recitation-tajwid', 'memo-coran-consolidation'],
        ];

        foreach ($relatedBySlug as $slug => $relatedSlugs) {
            $course = Course::query()->where('slug', $slug)->first();

            if ($course === null) {
                continue;
            }

            $course->relatedCourses()->sync(
                Course::query()
                    ->whereIn('slug', $relatedSlugs)
                    ->pluck('id')
                    ->all()
            );
        }
    }
}
