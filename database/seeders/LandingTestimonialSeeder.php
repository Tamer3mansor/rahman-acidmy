<?php

namespace Database\Seeders;

use App\Enums\TestimonialType;
use App\Models\LandingTestimonial;
use Illuminate\Database\Seeder;

class LandingTestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'type' => TestimonialType::Whatsapp,
                'author_name' => 'أم أحمد',
                'author_location' => 'باريس',
                'content' => 'ابني حفظ سورة الملك في أسبوعين فقط! المعلم ممتاز والأسلوب رائع',
                'rating' => null,
            ],
            [
                'type' => TestimonialType::Whatsapp,
                'author_name' => 'أبو عمر',
                'author_location' => 'ليون',
                'content' => 'جزاكم الله خيراً على الاهتمام والمتابعة مع ولدي',
                'rating' => null,
            ],
            [
                'type' => TestimonialType::Whatsapp,
                'author_name' => 'أم سارة',
                'author_location' => 'أمستردام',
                'content' => 'المعلمة صبورة جداً مع بنتي وتشرح بطريقة ممتعة',
                'rating' => null,
            ],
            [
                'type' => TestimonialType::Google,
                'author_name' => 'فاطمة م.',
                'author_location' => 'مونتريال',
                'content' => 'أفضل أكاديمية للتحفيظ. ابنتي تحبّ المعلمة كثيراً والحصص منظمة ومشوقة. أنصح بها بشدة!',
                'rating' => 5,
            ],
            [
                'type' => TestimonialType::Google,
                'author_name' => 'يوسف ك.',
                'author_location' => 'برلين',
                'content' => 'منذ شهرين مع الأكاديمية ولدي تقدّم ملحوظ في التجويد. المواعيد المرنة رائعة لمن يعمل.',
                'rating' => 5,
            ],
            [
                'type' => TestimonialType::Google,
                'author_name' => 'أم ياسمين',
                'author_location' => 'بروكسل',
                'content' => 'تجربة ممتازة من البداية. الحصة التجريبية المجانية أقنعتنا بالاشتراك فوراً.',
                'rating' => 5,
            ],
        ];

        foreach ($testimonials as $sort => $testimonial) {
            LandingTestimonial::query()->updateOrCreate(
                ['type' => $testimonial['type'], 'author_name' => $testimonial['author_name']],
                [
                    'author_location' => $testimonial['author_location'],
                    'content' => $testimonial['content'],
                    'media_path' => null,
                    'rating' => $testimonial['rating'],
                    'is_active' => true,
                    'sort_order' => $sort,
                ]
            );
        }
    }
}
