<?php

namespace Database\Factories;

use App\Models\LessonCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class LessonCategoryFactory extends Factory
{
    protected $model = LessonCategory::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'name' => $name,
            'slug' => str()->slug($name),
            'is_active' => true,
            'sort_order' => 0,
        ];
    }
}
