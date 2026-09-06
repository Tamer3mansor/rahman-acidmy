<?php

namespace Database\Factories;

use App\Models\PricingPackage;
use Illuminate\Database\Eloquent\Factories\Factory;

class PricingPackageFactory extends Factory
{
    protected $model = PricingPackage::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
            'badge' => fake()->word(),
            'badge_style' => 'default',
            'description' => fake()->sentence(8),
            'classes_count' => fake()->randomElement([4, 8, 12, 16, 24, 48, 100]),
            'price_per_30' => fake()->randomFloat(2, 3.5, 6),
            'price_per_45' => fake()->randomFloat(2, 5.5, 8),
            'price_per_60' => fake()->randomFloat(2, 7.5, 11),
            'features' => fake()->sentences(3),
            'is_featured' => false,
            'is_active' => true,
            'sort_order' => 0,
        ];
    }

    public function featured(): static
    {
        return $this->state(fn () => ['is_featured' => true]);
    }
}
