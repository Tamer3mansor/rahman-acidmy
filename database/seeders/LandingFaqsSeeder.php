<?php

namespace Database\Seeders;

use App\Models\LandingFaq;
use Illuminate\Database\Seeder;

class LandingFaqsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'La séance d\'essai est-elle vraiment gratuite ?',
                'answer' => 'Oui, la première séance d\'essai est entièrement gratuite et sans aucun engagement. Le but est que vous découvriez notre approche, nos enseignants et que vous soyez rassuré avant toute décision.',
                'show_cta' => true,
                'cta_text' => 'Réservez votre séance gratuite maintenant',
                'cta_url' => '#',
            ],
            [
                'question' => 'Quelles matières enseigne l\'académie ?',
                'answer' => 'Nous enseignons le Saint Coran (mémorisation, Tajwid et Tafsir), la langue arabe (lecture, écriture et conversation), et l\'éducation islamique. Le programme est adapté aux besoins de chaque élève.',
                'show_cta' => false,
            ],
            [
                'question' => 'Quels sont les horaires disponibles pour les cours ?',
                'answer' => 'Nous sommes ouverts 7 jours sur 7, de 7h du matin à 22h (heure de l\'Europe centrale). C\'est vous qui choisissez les créneaux qui vous conviennent, et ils peuvent être modifiés selon vos besoins.',
                'show_cta' => false,
            ],
            [
                'question' => 'Comment le progrès de l\'élève est-il suivi ?',
                'answer' => 'Après chaque cours, l\'enseignant rédige un rapport détaillé transmis aux parents via le tableau de bord. Le rapport inclut ce qui a été accompli, les points à revoir et le plan du prochain cours.',
                'show_cta' => false,
            ],
            [
                'question' => 'Peut-on annuler l\'abonnement à tout moment ?',
                'answer' => 'Oui, il n\'y a aucun contrat engageant. Vous pouvez suspendre ou annuler votre abonnement à tout moment sans frais supplémentaires. Nous sommes convaincus de la qualité de notre service et nous voulons que vous restiez parce que vous êtes satisfait, pas parce que vous êtes engagé.',
                'show_cta' => true,
                'cta_text' => 'Réservez votre cours maintenant',
                'cta_url' => '#',
            ],
            [
                'question' => 'Quelles sont les qualifications des enseignants ?',
                'answer' => 'Tous nos enseignants sont diplômés de l\'Al-Azhar et détenteurs d\'Ijazah certifiées en Tajwid et en Qira\'at. Ils passent un processus de sélection rigoureux comprenant un test de connaissances et une évaluation pédagogique avant de rejoindre l\'académie.',
                'show_cta' => false,
            ],
        ];

        foreach ($faqs as $sort => $faq) {
            LandingFaq::query()->updateOrCreate(
                ['question' => $faq['question']],
                [
                    'answer' => $faq['answer'],
                    'show_cta' => $faq['show_cta'],
                    'cta_text' => $faq['cta_text'] ?? null,
                    'cta_url' => $faq['cta_url'] ?? null,
                    'is_active' => true,
                    'sort_order' => $sort,
                ]
            );
        }
    }
}
