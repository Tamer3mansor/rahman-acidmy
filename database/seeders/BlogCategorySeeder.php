<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Seeder;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Enfants', 'slug' => 'atfal'],
            ['name' => 'Adultes', 'slug' => 'kibar'],
            ['name' => 'Le Saint Coran', 'slug' => 'quran'],
            ['name' => 'Langue arabe', 'slug' => 'arabic-language'],
            ['name' => 'Tajwid', 'slug' => 'tajweed'],
            ['name' => 'Conseils aux parents', 'slug' => 'parent-tips'],
        ];

        foreach ($categories as $sort => $category) {
            BlogCategory::query()->updateOrCreate(
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
