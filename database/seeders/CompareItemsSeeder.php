<?php

namespace Database\Seeders;

use App\Enums\CompareItemType;
use App\Models\CompareItem;
use Illuminate\Database\Seeder;

class CompareItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            ['type' => CompareItemType::Problem, 'text' => 'Cours en groupe sans suivi individualisé de votre enfant'],
            ['type' => CompareItemType::Problem, 'text' => 'Aucun rapport de progression ni retour de l\'enseignant'],
            ['type' => CompareItemType::Problem, 'text' => 'Horaires fixes qui ne s\'adaptent pas à votre emploi du temps'],
            ['type' => CompareItemType::Problem, 'text' => 'Enseignants sans qualifications certifiées ni Ijazah'],
            ['type' => CompareItemType::Problem, 'text' => 'Contrats à long terme difficiles à annuler ou modifier'],
            ['type' => CompareItemType::Solution, 'text' => 'Cours 100% particuliers, adaptés au rythme de chaque élève'],
            ['type' => CompareItemType::Solution, 'text' => 'Tableau de bord pour les parents avec suivi détaillé et messages de l\'enseignant après chaque cours'],
            ['type' => CompareItemType::Solution, 'text' => 'Horaires flexibles 7 jours sur 7, de 7h à 22h'],
            ['type' => CompareItemType::Solution, 'text' => 'Enseignants diplômés de l\'Al-Azhar et détenteurs d\'Ijazah certifiées'],
            ['type' => CompareItemType::Solution, 'text' => 'Sans engagement, modification ou annulation possible à tout moment'],
        ];

        foreach ($items as $sort => $item) {
            CompareItem::query()->updateOrCreate(
                ['text' => $item['text']],
                ['type' => $item['type'], 'is_active' => true, 'sort_order' => $sort]
            );
        }
    }
}
