<?php

namespace Database\Factories;

use App\Enums\CompareItemType;
use App\Models\CompareItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CompareItem>
 */
class CompareItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => fake()->randomElement([CompareItemType::Problem, CompareItemType::Solution]),
            'text' => fake()->realText(40),
            'is_active' => true,
            'sort_order' => 0,
        ];
    }
}
