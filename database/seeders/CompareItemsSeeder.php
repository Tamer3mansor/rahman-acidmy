<?php

namespace Database\Seeders;

use App\Enums\CompareItemType;
use App\Models\CompareItem;
use Illuminate\Database\Seeder;

class CompareItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            ['type' => CompareItemType::Problem, 'text' => 'حصص جماعية لا يُتابَع فيها طفلك بشكل فردي'],
            ['type' => CompareItemType::Problem, 'text' => 'لا يوجد تقرير تقدم ولا تغذية راجعة من المعلم'],
            ['type' => CompareItemType::Problem, 'text' => 'مواعيد ثابتة لا تتناسب مع جدولك ووقتك'],
            ['type' => CompareItemType::Problem, 'text' => 'معلمون بدون مؤهلات موثّقة أو إجازات معتمدة'],
            ['type' => CompareItemType::Problem, 'text' => 'عقود طويلة الأجل يصعب إلغاؤها أو تغييرها'],
            ['type' => CompareItemType::Solution, 'text' => 'حصص 100% فردية، تتكيف مع إيقاع كل طالب'],
            ['type' => CompareItemType::Solution, 'text' => 'لوحة تحكم للأهل مع متابعة تفصيلية ورسائل المعلم بعد كل حصة'],
            ['type' => CompareItemType::Solution, 'text' => 'مواعيد مرنة 7 أيام في الأسبوع، من 7 صباحاً حتى 10 مساءً'],
            ['type' => CompareItemType::Solution, 'text' => 'معلمون خريجو الأزهر الشريف وحاملو الإجازات المعتمدة'],
            ['type' => CompareItemType::Solution, 'text' => 'بدون التزامات، يمكن التعديل أو الإلغاء في أي وقت'],
        ];

        foreach ($items as $sort => $item) {
            CompareItem::query()->updateOrCreate(
                ['text' => $item['text']],
                ['type' => $item['type'], 'is_active' => true, 'sort_order' => $sort]
            );
        }
    }
}
