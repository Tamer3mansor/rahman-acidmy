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
            ['icon' => '✅', 'text' => 'Cours 100% particuliers'],
            ['icon' => '⏰', 'text' => '7j/7 de 7h à 22h'],
            ['icon' => '🛡️', 'text' => 'Sans engagement'],
        ];

        foreach ($pills as $sort => $pill) {
            HeroTrustPill::query()->updateOrCreate(
                ['text' => $pill['text']],
                ['icon' => $pill['icon'], 'is_active' => true, 'sort_order' => $sort]
            );
        }
    }
}
