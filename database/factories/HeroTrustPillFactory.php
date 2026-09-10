<?php

namespace Database\Factories;

use App\Models\HeroTrustPill;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HeroTrustPill>
 */
class HeroTrustPillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'icon' => fake()->randomElement(['✅', '⏰', '🛡️']),
            'text' => fake()->realText(30),
            'is_active' => true,
            'sort_order' => 0,
        ];
    }
}
