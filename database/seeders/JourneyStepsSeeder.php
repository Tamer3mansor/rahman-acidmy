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
            ['step_number' => 1, 'title' => 'Évaluation du niveau', 'description' => 'Test gratuit pour déterminer votre niveau avec précision et identifier le point de départ optimal'],
            ['step_number' => 2, 'title' => 'Programme personnalisé', 'description' => 'Un parcours éducatif conçu spécialement pour votre niveau, vos objectifs et votre emploi du temps'],
            ['step_number' => 3, 'title' => 'Cours particuliers', 'description' => 'Séances en visio en face à face avec votre enseignant dédié, au moment qui vous convient'],
            ['step_number' => 4, 'title' => 'Suivi continu', 'description' => 'Un rapport détaillé après chaque cours, transmis directement aux parents via le tableau de bord'],
            ['step_number' => 5, 'title' => 'Progrès garanti', 'description' => 'Des objectifs clairs et mesurables. Vous constatez les progrès semaine après semaine'],
        ];

        foreach ($steps as $sort => $step) {
            JourneyStep::query()->updateOrCreate(
                ['step_number' => $step['step_number']],
                [
                    'title' => $step['title'],
                    'description' => $step['description'],
                    'is_active' => true,
                    'sort_order' => $sort,
                ]
            );
        }
    }
}
