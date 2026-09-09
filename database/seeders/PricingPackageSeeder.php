<?php

namespace Database\Seeders;

use App\Models\PricingPackage;
use Illuminate\Database\Seeder;

class PricingPackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Pack Découverte',
                'badge' => 'Débutant',
                'badge_style' => 'default',
                'description' => 'Idéal pour tester le programme et rencontrer l\'enseignant sans engagement à long terme.',
                'classes_count' => 4,
                'pricing_type' => 'per_hour',
                'hours' => 4,
                'features' => [
                    '4 cours particuliers interactifs',
                    'Durée du cours au choix',
                    'Suivi personnalisé et évaluation continue',
                ],
                'is_featured' => false,
            ],
            [
                'name' => 'Pack Mémorisation',
                'badge' => 'Régulier',
                'badge_style' => 'default',
                'description' => 'Pour commencer un parcours d\'apprentissage régulier et établir une habitude quotidienne de mémorisation.',
                'classes_count' => 8,
                'pricing_type' => 'per_hour',
                'hours' => 8,
                'features' => [
                    '8 cours particuliers interactifs',
                    'Durée du cours au choix',
                    'Suivi et rapports périodiques pour les parents',
                ],
                'is_featured' => false,
            ],
            [
                'name' => 'Pack Excellence',
                'badge' => 'Avancé',
                'badge_style' => 'default',
                'description' => 'Pour un progrès rapide et significatif en mémorisation et Tajwid à un rythme optimal.',
                'classes_count' => 12,
                'pricing_type' => 'per_hour',
                'hours' => 12,
                'features' => [
                    '12 cours particuliers interactifs',
                    'Durée du cours au choix',
                    'Programme personnalisé pour votre enfant',
                ],
                'is_featured' => false,
            ],
            [
                'name' => 'Pack Bronze',
                'badge' => 'Bronze',
                'badge_style' => 'default',
                'description' => 'Un volume de cours confortable et régulier pour assurer la continuité et la progression.',
                'classes_count' => 16,
                'pricing_type' => 'per_hour',
                'hours' => 16,
                'features' => [
                    '16 cours particuliers interactifs',
                    'Durée du cours au choix',
                    'Flexibilité totale pour planifier vos rendez-vous',
                ],
                'is_featured' => false,
            ],
            [
                'name' => 'Pack Argent',
                'badge' => 'Argent',
                'badge_style' => 'gold',
                'description' => 'L\'option équilibrée offrant le meilleur rapport qualité-prix pour des résultats excellents et durables.',
                'classes_count' => 24,
                'pricing_type' => 'per_hour',
                'hours' => 24,
                'features' => [
                    '24 cours particuliers interactifs',
                    'Durée du cours au choix',
                    'Priorité dans le choix des créneaux et des enseignants',
                ],
                'is_featured' => true,
            ],
            [
                'name' => 'Pack Or',
                'badge' => 'Or',
                'badge_style' => 'gold',
                'description' => 'Engagement avancé et intensif pour maîtriser le Coran et la langue arabe rapidement.',
                'classes_count' => 48,
                'pricing_type' => 'per_hour',
                'hours' => 48,
                'features' => [
                    '48 cours particuliers interactifs',
                    'Durée du cours au choix',
                    'Rapports mensuels complets et certificat de réussite',
                ],
                'is_featured' => false,
            ],
            [
                'name' => 'Pack Diamant',
                'badge' => 'Diamant',
                'badge_style' => 'green',
                'description' => 'Le pack complet et le plus économique pour une expérience complète et professionnelle.',
                'classes_count' => 100,
                'pricing_type' => 'per_hour',
                'hours' => 100,
                'features' => [
                    '100 cours particuliers interactifs',
                    'Durée du cours au choix',
                    'Emploi du temps annuel fixé',
                ],
                'is_featured' => false,
            ],
        ];

        foreach ($packages as $sort => $package) {
            PricingPackage::query()->updateOrCreate(
                ['name' => $package['name']],
                [
                    'badge' => $package['badge'],
                    'badge_style' => $package['badge_style'],
                    'description' => $package['description'],
                    'classes_count' => $package['classes_count'],
                    'pricing_type' => $package['pricing_type'],
                    'hours' => $package['hours'],
                    'features' => $package['features'],
                    'is_featured' => $package['is_featured'],
                    'is_active' => true,
                    'sort_order' => $sort,
                ]
            );
        }
    }
}
