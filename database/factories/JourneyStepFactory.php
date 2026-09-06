<?php

namespace Database\Factories;

use App\Models\JourneyStep;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<JourneyStep>
 */
class JourneyStepFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'step_number' => fake()->numberBetween(1, 10),
            'icon' => fake()->randomElement(['clipboard', 'document', 'video', 'chart', 'trend']),
            'title' => fake()->realText(25),
            'description' => fake()->realText(60),
            'is_active' => true,
            'sort_order' => 0,
        ];
    }
}
