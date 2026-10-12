<?php

namespace Database\Seeders;

use App\Models\LandingWhyItem;
use Illuminate\Database\Seeder;

class LandingWhyItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            ['icon' => '🕌', 'title' => 'Enseignants diplômés de l\'Al-Azhar', 'description' => 'Tous nos enseignants sont diplômés de l\'Al-Azhar et titulaires d\'Ijazah certifiées en Tajwid, avec une expérience confirmée auprès des enfants et des adultes.'],
            ['icon' => '👨‍👩‍👧', 'title' => '100% particuliers', 'description' => 'Chaque élève travaille seul avec son enseignant, sans groupe ni distraction, et le rythme s\'ajuste à son niveau réel.'],
            ['icon' => '📊', 'title' => 'Suivi détaillé pour les parents', 'description' => 'Un rapport après chaque séance avec les acquis, les points forts et les points à retravailler.'],
            ['icon' => '⏰', 'title' => 'Horaires flexibles 7j/7', 'description' => 'De 7h à 22h, avec la possibilité de déplacer ou d\'annuler un créneau gratuitement à tout moment.'],
            ['icon' => '📈', 'title' => 'Progression mesurable', 'description' => 'Une évaluation régulière des acquis et des objectifs clairs à chaque étape du parcours.'],
            ['icon' => '🎁', 'title' => 'Première séance offerte', 'description' => 'La première séance est gratuite et sans engagement, pour évaluer la méthode et l\'enseignant en toute tranquillité.'],
        ];

        foreach ($items as $sort => $item) {
            LandingWhyItem::query()->updateOrCreate(
                ['title' => $item['title']],
                ['icon' => $item['icon'], 'description' => $item['description'], 'is_active' => true, 'sort_order' => $sort]
            );
        }
    }
}
