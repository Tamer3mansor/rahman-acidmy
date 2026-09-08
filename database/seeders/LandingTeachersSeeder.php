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
                'name' => 'Cheikh Mohamed Amine',
                'specialty' => 'Mémorisation du Coran et Tajwid',
                'emoji' => '👨🏫',
                'badges' => ['Ijazah', 'Al-Azhar', 'Tajwid', 'Enfants', 'Adultes'],
            ],
            [
                'name' => 'Cheikha Fatima El-Zahra',
                'specialty' => 'Enseignement du Coran aux enfants',
                'emoji' => '👩‍🏫',
                'badges' => ['Ijazah', 'Al-Azhar', 'Enfants'],
            ],
            [
                'name' => 'Professeur Youssef El-Bekri',
                'specialty' => 'Langue arabe et éducation islamique',
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
