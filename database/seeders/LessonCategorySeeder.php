<?php

namespace Database\Seeders;

use App\Models\LessonCategory;
use Illuminate\Database\Seeder;

class LessonCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'أطفال', 'slug' => 'kids'],
            ['name' => 'كبار', 'slug' => 'adults'],
            ['name' => 'تجويد وتلاوة', 'slug' => 'tajwid'],
        ];

        foreach ($categories as $sort => $category) {
            LessonCategory::query()->updateOrCreate(
                ['slug' => $category['slug']],
                [
                    'name' => $category['name'],
                    'is_active' => true,
                    'sort_order' => $sort,
                ]
            );
        }
    }
}
