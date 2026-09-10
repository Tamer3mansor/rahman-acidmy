<?php

namespace Database\Seeders;

use App\Models\FormInfo;
use Illuminate\Database\Seeder;

class FormInfosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $infos = [
            ['icon' => '⏰', 'label' => 'Temps de réponse', 'value' => 'Sous 24 heures'],
            ['icon' => '🛡️', 'label' => 'Garantie', 'value' => 'Sans aucun engagement'],
            ['icon' => '✅', 'label' => 'Première séance', 'value' => 'Entièrement gratuite'],
            ['icon' => '👥', 'label' => 'Nos enseignants', 'value' => 'Diplômés de l\'Al-Azhar'],
        ];

        foreach ($infos as $sort => $info) {
            FormInfo::query()->updateOrCreate(
                ['label' => $info['label']],
                [
                    'icon' => $info['icon'],
                    'value' => $info['value'],
                    'is_active' => true,
                    'sort_order' => $sort,
                ]
            );
        }
    }
}
