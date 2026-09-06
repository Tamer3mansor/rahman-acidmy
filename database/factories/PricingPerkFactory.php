<?php

namespace Database\Factories;

use App\Models\PricingPerk;
use Illuminate\Database\Eloquent\Factories\Factory;

class PricingPerkFactory extends Factory
{
    protected $model = PricingPerk::class;

    public function definition(): array
    {
        return [
            'icon' => 'fa-solid fa-circle-check',
            'title' => fake()->words(3, true),
            'description' => fake()->sentence(7),
            'is_active' => true,
            'sort_order' => 0,
        ];
    }
}
