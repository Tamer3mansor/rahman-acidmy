<?php

namespace Database\Factories;

use App\Enums\CourseAudience;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'audience' => CourseAudience::Kids->value,
            'title' => fake()->unique()->words(4, true),
            'slug' => fake()->unique()->slug(4),
            'icon' => '📖',
            'card_theme' => 'green',
            'short_description' => fake()->sentence(8),
            'description' => '<p>'.fake()->paragraphs(3, true).'</p>',
            'age_band_min' => 5,
            'age_band_max' => 8,
            'session_minutes' => 30,
            'level_label' => 'Débutant',
            'curriculum_items' => [
                ['icon' => '📖', 'title' => 'Lecture du Coran', 'description' => fake()->sentence(6)],
                ['icon' => '✨', 'title' => 'Tajwid', 'description' => fake()->sentence(6)],
            ],
            'session_features' => [
                ['title' => 'Cours particulier en ligne', 'description' => fake()->sentence(6)],
            ],
            'journey_steps' => [
                ['number' => 1, 'title' => 'Évaluation du niveau', 'description' => fake()->sentence(6)],
            ],
            'suitability_checks' => [
                'Enfants et jeunes de 5 à 15 ans',
                'Recherche de correction de la récitation',
            ],
            'faqs' => [
                ['question' => 'Les cours sont-ils individuels ?', 'answer' => 'Oui, tous nos cours sont individuels.'],
            ],
            'is_active' => true,
            'sort_order' => 0,
        ];
    }

    public function kids(): static
    {
        return $this->state(fn (): array => ['audience' => CourseAudience::Kids->value]);
    }

    public function adults(): static
    {
        return $this->state(fn (): array => ['audience' => CourseAudience::Adults->value]);
    }
}
