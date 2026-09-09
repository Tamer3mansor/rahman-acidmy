<?php

namespace Database\Factories;

use App\Models\PricingPackage;
use Illuminate\Database\Eloquent\Factories\Factory;

class PricingPackageFactory extends Factory
{
    protected $model = PricingPackage::class;

    public function definition(): array
    {
        $pricingType = fake()->randomElement([PricingPackage::TYPE_PER_HOUR, PricingPackage::TYPE_SPECIAL]);

        return [
            'name' => fake()->unique()->word(),
            'badge' => fake()->word(),
            'badge_style' => 'default',
            'description' => fake()->sentence(8),
            'classes_count' => fake()->randomElement([4, 8, 12, 16, 24, 48, 100]),
            'pricing_type' => $pricingType,
            'hours' => $pricingType === PricingPackage::TYPE_PER_HOUR ? fake()->randomFloat(1, 1, 50) : null,
            'price' => $pricingType === PricingPackage::TYPE_SPECIAL ? fake()->randomFloat(2, 20, 500) : 0,
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

    public function perHour(): static
    {
        return $this->state(fn () => [
            'pricing_type' => PricingPackage::TYPE_PER_HOUR,
            'hours' => fake()->randomFloat(1, 1, 50),
            'price' => 0,
        ]);
    }

    public function special(): static
    {
        return $this->state(fn () => [
            'pricing_type' => PricingPackage::TYPE_SPECIAL,
            'hours' => null,
            'price' => fake()->randomFloat(2, 20, 500),
        ]);
    }
}
