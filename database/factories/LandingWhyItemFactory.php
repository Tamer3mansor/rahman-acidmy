<?php

namespace Database\Factories;

use App\Models\LandingWhyItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LandingWhyItem>
 */
class LandingWhyItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'icon' => fake()->randomElement(['🕌', '📚', '⏰', '🎁', '📊', '📈']),
            'title' => fake()->sentence(3),
            'description' => fake()->realText(80),
            'is_active' => true,
            'sort_order' => 0,
        ];
    }
}
