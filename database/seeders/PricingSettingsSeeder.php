<?php

namespace Database\Seeders;

use App\Models\PricingSettings;
use Illuminate\Database\Seeder;

class PricingSettingsSeeder extends Seeder
{
    public function run(): void
    {
        PricingSettings::query()->firstOrCreate(
            ['id' => 1],
            [
                'per_hour_price' => 8.00,
                'contents_label' => 'Sans aucun engagement',
                'contents_title' => 'Tous les packs incluent',
                'contents_subtitle' => 'Les mêmes garanties de qualité pour chaque formule, des cours particuliers au suivi pédagogique.',
                'contents_items' => [
                    [
                        'icon' => '🕌',
                        'title' => 'Cours particuliers',
                        'description' => 'Séances en tête-à-tête avec un enseignant spécialisé.',
                    ],
                    [
                        'icon' => '🧑‍🏫',
                        'title' => 'Enseignants qualifiés',
                        'description' => 'Titulaires de diplômes Al-Azhar et d\'Ijazah.',
                    ],
                    [
                        'icon' => '📋',
                        'title' => 'Suivi personnalisé',
                        'description' => 'Évaluations continues et rapports de progression.',
                    ],
                    [
                        'icon' => '⏰',
                        'title' => 'Emploi du temps flexible',
                        'description' => 'Créneaux adaptés à votre rythme et votre fuseau.',
                    ],
                ],
            ]
        );
    }
}
