<?php

namespace Database\Factories;

use App\Models\FormInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FormInfo>
 */
class FormInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'icon' => fake()->randomElement(['⏰', '🛡️', '✅', '👥']),
            'label' => fake()->realText(20),
            'value' => fake()->realText(25),
            'is_active' => true,
            'sort_order' => 0,
        ];
    }
}
