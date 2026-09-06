<?php

namespace Database\Seeders;

use App\Models\PricingPackage;
use Illuminate\Database\Seeder;

class PricingPackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'name' => 'باقة الاكتشاف',
                'badge' => 'مبتدئ',
                'badge_style' => 'default',
                'description' => 'مثالية لتجربة المنهج والتعرف على المعلم بدون أي التزام طويل.',
                'classes_count' => 4,
                'price_per_30' => 5.00,
                'price_per_45' => 7.50,
                'price_per_60' => 10.00,
                'features' => [
                    '4 حصص فردية تفاعلية',
                    'مدة الحصة حسب الاختيار',
                    'متابعة شخصية وتقييم مستمر',
                ],
                'is_featured' => false,
            ],
            [
                'name' => 'باقة حافظ',
                'badge' => 'منتظم',
                'badge_style' => 'default',
                'description' => 'لبدء رحلة التعلم المنتظم وبناء عادة حفظ يومية ثابتة.',
                'classes_count' => 8,
                'price_per_30' => 5.00,
                'price_per_45' => 7.50,
                'price_per_60' => 10.00,
                'features' => [
                    '8 حصص فردية تفاعلية',
                    'مدة الحصة حسب الاختيار',
                    'متابعة وتقارير دورية للأهل',
                ],
                'is_featured' => false,
            ],
            [
                'name' => 'باقة مجتهد',
                'badge' => 'متقدم',
                'badge_style' => 'default',
                'description' => 'لتحقيق تقدم سريع وملحوظ في الحفظ والتجويد برتم ممتاز.',
                'classes_count' => 12,
                'price_per_30' => 4.83,
                'price_per_45' => 7.25,
                'price_per_60' => 9.60,
                'features' => [
                    '12 حصة فردية تفاعلية',
                    'مدة الحصة حسب الاختيار',
                    'خطة دراسية مخصصة لطفلك',
                ],
                'is_featured' => false,
            ],
            [
                'name' => 'الباقة البرونزية',
                'badge' => 'برونزي',
                'badge_style' => 'default',
                'description' => 'حجم حصص مريح ومستمر يضمن الاستمرارية وعدم النسيان.',
                'classes_count' => 16,
                'price_per_30' => 4.75,
                'price_per_45' => 7.10,
                'price_per_60' => 9.50,
                'features' => [
                    '16 حصة فردية تفاعلية',
                    'مدة الحصة حسب الاختيار',
                    'مرونة كاملة في تحديد المواعيد',
                ],
                'is_featured' => false,
            ],
            [
                'name' => 'الباقة الفضية',
                'badge' => 'فضي',
                'badge_style' => 'gold',
                'description' => 'الخيار المتوازن والأفضل قيمة للحصول على نتائج ممتازة وراسخة.',
                'classes_count' => 24,
                'price_per_30' => 4.58,
                'price_per_45' => 6.80,
                'price_per_60' => 9.00,
                'features' => [
                    '24 حصة فردية تفاعلية',
                    'مدة الحصة حسب الاختيار',
                    'أولوية في اختيار الأوقات والمعلمين',
                ],
                'is_featured' => true,
            ],
            [
                'name' => 'الباقة الذهبية',
                'badge' => 'ذهبي',
                'badge_style' => 'gold',
                'description' => 'التزام متقدم ومكثف لإتقان القرآن الكريم واللغة العربية بسرعة.',
                'classes_count' => 48,
                'price_per_30' => 4.58,
                'price_per_45' => 6.80,
                'price_per_60' => 8.90,
                'features' => [
                    '48 حصة فردية تفاعلية',
                    'مدة الحصة حسب الاختيار',
                    'تقارير شهرية شاملة وشهادة إتمام',
                ],
                'is_featured' => false,
            ],
            [
                'name' => 'الباقة الماسية',
                'badge' => 'ماسي',
                'badge_style' => 'green',
                'description' => 'الباقة الشاملة والأعلى توفيراً لمعايشة كاملة واحترافية.',
                'classes_count' => 100,
                'price_per_30' => 4.50,
                'price_per_45' => 6.50,
                'price_per_60' => 8.50,
                'features' => [
                    '100 حصة فردية تفاعلية',
                    'مدة الحصة حسب الاختيار',
                    'تثبيت جدول المواعيد السنوي',
                ],
                'is_featured' => false,
            ],
        ];

        foreach ($packages as $sort => $package) {
            PricingPackage::query()->updateOrCreate(
                ['name' => $package['name']],
                [
                    'badge' => $package['badge'],
                    'badge_style' => $package['badge_style'],
                    'description' => $package['description'],
                    'classes_count' => $package['classes_count'],
                    'price_per_30' => $package['price_per_30'],
                    'price_per_45' => $package['price_per_45'],
                    'price_per_60' => $package['price_per_60'],
                    'features' => $package['features'],
                    'is_featured' => $package['is_featured'],
                    'is_active' => true,
                    'sort_order' => $sort,
                ]
            );
        }
    }
}
