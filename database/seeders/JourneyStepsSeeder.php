<?php

namespace Database\Seeders;

use App\Models\JourneyStep;
use Illuminate\Database\Seeder;

class JourneyStepsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $steps = [
            ['step_number' => 1, 'icon' => 'fa-solid fa-clipboard-list', 'title' => 'اختبار المستوى', 'description' => 'اختبار مجاني لتحديد مستواك بدقة وتحديد نقطة الانطلاق المثلى'],
            ['step_number' => 2, 'icon' => 'fa-solid fa-file-lines', 'title' => 'برنامج مخصص', 'description' => 'خطة تعليمية مصممة خصيصاً لمستواك وأهدافك وجدولك الزمني'],
            ['step_number' => 3, 'icon' => 'fa-solid fa-circle-play', 'title' => 'حصص فردية', 'description' => 'جلسات وجهاً لوجه بالفيديو مع معلمك المخصص، في الوقت الذي يناسبك'],
            ['step_number' => 4, 'icon' => 'fa-solid fa-chart-line', 'title' => 'متابعة مستمرة', 'description' => 'تقرير تفصيلي بعد كل حصة يصل لولي الأمر مباشرة على لوحة التحكم'],
            ['step_number' => 5, 'icon' => 'fa-solid fa-arrow-trend-up', 'title' => 'تقدّم مضمون', 'description' => 'أهداف واضحة وقابلة للقياس. ترى التطور أسبوعاً بعد أسبوع'],
        ];

        foreach ($steps as $sort => $step) {
            JourneyStep::query()->updateOrCreate(
                ['step_number' => $step['step_number']],
                [
                    'icon' => $step['icon'],
                    'title' => $step['title'],
                    'description' => $step['description'],
                    'is_active' => true,
                    'sort_order' => $sort,
                ]
            );
        }
    }
}
