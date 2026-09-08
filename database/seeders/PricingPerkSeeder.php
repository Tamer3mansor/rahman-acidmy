<?php

namespace Database\Seeders;

use App\Models\PricingPerk;
use Illuminate\Database\Seeder;

class PricingPerkSeeder extends Seeder
{
    public function run(): void
    {
        $perks = [
            [
                'icon' => 'fa-solid fa-gift',
                'title' => 'Séance d\'essai gratuite',
                'description' => 'Testez notre approche et notre méthode d\'enseignement en toute sérénité et sans aucun engagement.',
            ],
            [
                'icon' => 'fa-solid fa-graduation-cap',
                'title' => 'Enseignants de l\'Al-Azhar',
                'description' => 'Enseignants qualifiés et certifiés pour l\'enseignement aux enfants et aux adultes.',
            ],
            [
                'icon' => 'fa-solid fa-certificate',
                'title' => 'Certificat de réussite officiel',
                'description' => 'Délivré à l\'élève lorsqu\'il termine le niveau avec succès et réussit les examens.',
            ],
            [
                'icon' => 'fa-solid fa-calendar-days',
                'title' => 'Horaires flexibles',
                'description' => 'Planifiez vos cours parfaitement en accord avec l\'emploi du temps de votre enfant et votre vie quotidienne.',
            ],
            [
                'icon' => 'fa-solid fa-book-quran',
                'title' => 'Variété de matières',
                'description' => 'Liberté de choix entre le Coran, le Tajwid, la langue arabe et les études islamiques.',
            ],
        ];

        foreach ($perks as $sort => $perk) {
            PricingPerk::query()->updateOrCreate(
                ['title' => $perk['title']],
                [
                    'icon' => $perk['icon'],
                    'description' => $perk['description'],
                    'is_active' => true,
                    'sort_order' => $sort,
                ]
            );
        }
    }
}
