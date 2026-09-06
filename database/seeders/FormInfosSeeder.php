<?php

namespace Database\Seeders;

use App\Models\FormInfo;
use Illuminate\Database\Seeder;

class FormInfosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $infos = [
            ['icon' => 'fa-solid fa-clock', 'label' => 'وقت الرد', 'value' => 'خلال 24 ساعة'],
            ['icon' => 'fa-solid fa-shield-halved', 'label' => 'ضمان', 'value' => 'بدون أي التزامات'],
            ['icon' => 'fa-solid fa-circle-check', 'label' => 'الحصة الأولى', 'value' => 'مجانية تماماً'],
            ['icon' => 'fa-solid fa-users', 'label' => 'معلمونا', 'value' => 'خريجو الأزهر الشريف'],
        ];

        foreach ($infos as $sort => $info) {
            FormInfo::query()->updateOrCreate(
                ['label' => $info['label']],
                [
                    'icon' => $info['icon'],
                    'value' => $info['value'],
                    'is_active' => true,
                    'sort_order' => $sort,
                ]
            );
        }
    }
}
