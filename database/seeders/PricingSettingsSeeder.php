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
            ]
        );
    }
}
