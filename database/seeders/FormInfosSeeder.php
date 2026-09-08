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
            ['icon' => 'fa-solid fa-clock', 'label' => 'Temps de réponse', 'value' => 'Sous 24 heures'],
            ['icon' => 'fa-solid fa-shield-halved', 'label' => 'Garantie', 'value' => 'Sans aucun engagement'],
            ['icon' => 'fa-solid fa-circle-check', 'label' => 'Première séance', 'value' => 'Entièrement gratuite'],
            ['icon' => 'fa-solid fa-users', 'label' => 'Nos enseignants', 'value' => 'Diplômés de l\'Al-Azhar'],
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
