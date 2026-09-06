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
            ['icon' => 'fa-solid fa-circle-check', 'text' => 'حصص 100% فردية'],
            ['icon' => 'fa-solid fa-clock', 'text' => '7/7 من 7ص لـ 10م'],
            ['icon' => 'fa-solid fa-shield-halved', 'text' => 'بلا التزامات'],
        ];

        foreach ($pills as $sort => $pill) {
            HeroTrustPill::query()->updateOrCreate(
                ['text' => $pill['text']],
                ['icon' => $pill['icon'], 'is_active' => true, 'sort_order' => $sort]
            );
        }
    }
}
