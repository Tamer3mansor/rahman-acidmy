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
            ['name' => 'أطفال', 'slug' => 'atfal'],
            ['name' => 'كبار', 'slug' => 'kibar'],
            ['name' => 'القرآن الكريم', 'slug' => 'quran'],
            ['name' => 'اللغة العربية', 'slug' => 'arabic-language'],
            ['name' => 'التجويد', 'slug' => 'tajweed'],
            ['name' => 'نصائح للأهل', 'slug' => 'parent-tips'],
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
