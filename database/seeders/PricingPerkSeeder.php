<?php

namespace Database\Seeders;

use App\Models\PricingPerk;
use Illuminate\Database\Seeder;

class PricingPerkSeeder extends Seeder
{
    public function run(): void
    {
        $perks = [
            [
                'icon' => 'fa-solid fa-gift',
                'title' => 'حصة تجريبية مجاناً',
                'description' => 'اختبر أسلوبنا وطريقتنا في التدريس بكل أريحية وبدون أي التزام.',
            ],
            [
                'icon' => 'fa-solid fa-graduation-cap',
                'title' => 'معلمون من الأزهر',
                'description' => 'معلمون ومعلمات مجازون ومختصون لتدريس الأطفال والكبار.',
            ],
            [
                'icon' => 'fa-solid fa-certificate',
                'title' => 'شهادة إتمام معتمدة',
                'description' => 'تُمنح للطالب عند إتمام المستوى وتجاوز الاختبارات بنجاح.',
            ],
            [
                'icon' => 'fa-solid fa-calendar-days',
                'title' => 'مواعيد مرنة',
                'description' => 'جدولة الحصص بما يتناسب تماماً مع جدول طفلك وحياتكم اليومية.',
            ],
            [
                'icon' => 'fa-solid fa-book-quran',
                'title' => 'تنوّع المواد',
                'description' => 'حرية الاختيار بين القرآن الكريم، التجويد، اللغة العربية، والدراسات الإسلامية.',
            ],
        ];

        foreach ($perks as $sort => $perk) {
            PricingPerk::query()->updateOrCreate(
                ['title' => $perk['title']],
                [
                    'icon' => $perk['icon'],
                    'description' => $perk['description'],
                    'is_active' => true,
                    'sort_order' => $sort,
                ]
            );
        }
    }
}
