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
                'hero_label' => 'Première séance gratuite',
                'hero_label_icon' => 'fa-solid fa-gift',
                'hero_title' => 'Des offres claires pour apprendre en toute sérénité',
                'hero_subtitle' => 'Un tarif transparent calculé au taux horaire. Choisissez la durée de vos cours, puis le pack qui convient à votre enfant.',
                'cta_badge' => 'Sans aucun engagement',
                'cta_title' => 'Vous hésitez sur le pack qui convient à votre enfant ?',
                'cta_text' => 'Notre équipe pédagogique vous accompagne gratuitement pour évaluer le niveau, choisir le pack adapté et planifier les cours.',
                'cta_whatsapp_label' => 'Discutez avec nous via WhatsApp',
                'cta_trial_label' => 'Réservez votre essai gratuit',
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
