<?php

namespace Database\Factories;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogPostFactory extends Factory
{
    protected $model = BlogPost::class;

    public function definition(): array
    {
        $title = fake()->unique()->sentence(6);

        return [
            'category_id' => BlogCategory::factory(),
            'title' => $title,
            'slug' => str()->slug($title),
            'excerpt' => fake()->paragraph(),
            'body' => '<p>'.implode('</p><p>', fake()->paragraphs(5)).'</p>',
            'author_name' => fake()->name(),
            'author_image' => null,
            'cover_image' => null,
            'reading_time' => fake()->numberBetween(3, 10),
            'published_at' => fake()->dateTimeBetween('-1 month', 'now'),
            'is_featured' => false,
            'is_active' => true,
        ];
    }

    public function featured(): static
    {
        return $this->state(fn () => ['is_featured' => true]);
    }

    public function draft(): static
    {
        return $this->state(fn () => [
            'is_active' => false,
            'published_at' => null,
        ]);
    }
}
