<?php

namespace Database\Seeders;

use App\Models\LessonPageSettings;
use Illuminate\Database\Seeder;

class LessonPageSettingsSeeder extends Seeder
{
    /**
     * The wording the free lessons page shipped with, now editable from the
     * dashboard. SEO defaults live in SeoSettingsSeeder so that re-running this
     * seeder never overwrites an admin's meta title.
     */
    public function run(): void
    {
        LessonPageSettings::query()->firstOrCreate(
            ['id' => 1],
            [
                'label' => 'Exemples et explications gratuits',
                'title' => 'Découvrez par vous-même notre méthode et la qualité de l\'enseignement',
                'description' => "Un ensemble d'exemples et de mini-leçons qui expliquent le tajwid, la lecture et la langue arabe d'une façon simplifiée, soutenue par l'audio et les visuels.",
                'sidebar_trial_label' => 'Essai gratuit',
                'sidebar_whatsapp_label' => 'Contactez-nous via WhatsApp',
                'sidebar_title' => 'Commencez le parcours de votre enfant',
                'sidebar_text' => "Donnez à votre enfant les bonnes orientations dès le début pour gagner des années d'essais.",
            ]
        );
    }
}
