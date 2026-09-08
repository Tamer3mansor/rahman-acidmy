<?php

namespace Database\Seeders;

use App\Models\HeroTrustPill;
use Illuminate\Database\Seeder;

class HeroTrustPillsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pills = [
            ['icon' => 'fa-solid fa-circle-check', 'text' => 'Cours 100% particuliers'],
            ['icon' => 'fa-solid fa-clock', 'text' => '7j/7 de 7h à 22h'],
            ['icon' => 'fa-solid fa-shield-halved', 'text' => 'Sans engagement'],
        ];

        foreach ($pills as $sort => $pill) {
            HeroTrustPill::query()->updateOrCreate(
                ['text' => $pill['text']],
                ['icon' => $pill['icon'], 'is_active' => true, 'sort_order' => $sort]
            );
        }
    }
}
