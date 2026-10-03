<?php

namespace Database\Seeders;

use App\Models\BlogPageSettings;
use Illuminate\Database\Seeder;

class BlogPageSettingsSeeder extends Seeder
{
    /**
     * The wording the blog listing page shipped with, now editable from the
     * dashboard. SEO defaults live in SeoSettingsSeeder so that re-running this
     * seeder never overwrites an admin's meta title.
     */
    public function run(): void
    {
        BlogPageSettings::query()->firstOrCreate(
            ['id' => 1],
            [
                'label' => 'Blog éducatif',
                'title' => 'Derniers articles et conseils éducatifs',
                'description' => "Votre guide complet pour la mémorisation du Coran et l'apprentissage de la langue arabe pour enfants et adultes avec des méthodes modernes.",
            ]
        );
    }
}
