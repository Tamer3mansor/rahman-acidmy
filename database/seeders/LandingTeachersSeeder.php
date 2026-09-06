<?php

namespace Database\Seeders;

use App\Models\LandingTeacher;
use Illuminate\Database\Seeder;

class LandingTeachersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = [
            [
                'name' => 'الشيخ محمد أمين',
                'specialty' => 'حفظ القرآن الكريم والتجويد',
                'emoji' => '👨🏫',
                'badges' => ['Ijazah', 'Al-Azhar', 'Tajwid', 'Enfants', 'Adultes'],
            ],
            [
                'name' => 'الشيخة فاطمة الزهراء',
                'specialty' => 'تعليم القرآن للأطفال',
                'emoji' => '👩‍🏫',
                'badges' => ['Ijazah', 'Al-Azhar', 'Enfants'],
            ],
            [
                'name' => 'الأستاذ يوسف البكري',
                'specialty' => 'اللغة العربية والتربية الإسلامية',
                'emoji' => '👨‍💼',
                'badges' => ['Al-Azhar', 'Adultes', 'Tajwid'],
            ],
        ];

        foreach ($teachers as $sort => $teacher) {
            LandingTeacher::query()->updateOrCreate(
                ['name' => $teacher['name']],
                [
                    'specialty' => $teacher['specialty'],
                    'emoji' => $teacher['emoji'],
                    'badges' => $teacher['badges'],
                    'is_active' => true,
                    'sort_order' => $sort,
                ]
            );
        }
    }
}
