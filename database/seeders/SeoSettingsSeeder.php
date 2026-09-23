<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CoursePageSettings;
use App\Models\LandingSettings;
use App\Models\PricingSettings;
use Illuminate\Database\Seeder;

class SeoSettingsSeeder extends Seeder
{
    /**
     * Seed default SEO values for every page that exposes SEO controls.
     *
     * The seeder only fills values that are currently empty, so it is safe
     * to re-run after the admin has personalised the content: existing
     * (non-null) values are never overwritten.
     */
    public function run(): void
    {
        $this->seedLandingSettings();
        $this->seedCoursePageSettings();
        $this->seedCourses();
        $this->seedPricingSettings();
    }

    private function seedLandingSettings(): void
    {
        $settings = LandingSettings::singleton();

        if ($settings->meta_title === null) {
            $settings->meta_title = 'Cours de Coran et d\'arabe en ligne | Ar-Rahman Academy';
        }

        if ($settings->meta_description === null) {
            $settings->meta_description = 'Cours particuliers de Coran, Tajwid et langue arabe en ligne pour enfants et adultes. Enseignants diplômés d\'Al-Azhar, horaires flexibles 7j/7. Essai gratuit.';
        }

        if ($settings->isDirty()) {
            $settings->save();
        }
    }

    private function seedCoursePageSettings(): void
    {
        $settings = CoursePageSettings::singleton();

        if ($settings->kids_meta_title === null) {
            $settings->kids_meta_title = 'Cours de Coran et d\'arabe pour enfants | Ar-Rahman Academy';
        }

        if ($settings->kids_meta_description === null) {
            $settings->kids_meta_description = 'Cours de Coran, Tajwid et langue arabe en ligne pour enfants de 4 à 16 ans en France, Belgique et Canada. Mémorisation, adhkar et valeurs islamiques. Essai gratuit.';
        }

        if ($settings->adults_meta_title === null) {
            $settings->adults_meta_title = 'Cours de Coran et Tajwid pour adultes | Ar-Rahman Academy';
        }

        if ($settings->adults_meta_description === null) {
            $settings->adults_meta_description = 'Cours particuliers de Coran, Tajwid et arabe pour adultes : correction de la récitation, mémorisation et études islamiques en ligne, horaires flexibles 7j/7.';
        }

        if ($settings->isDirty()) {
            $settings->save();
        }
    }

    private function seedCourses(): void
    {
        $defaultsBySlug = [
            'initiation-baraaim-quran' => [
                'meta_title' => 'Mémorisation du Coran pour enfants | Ar-Rahman Academy',
            ],
            'memo-coran-tajwid-enfants' => [
                'meta_title' => 'Coran et Tajwid pour enfants | Ar-Rahman Academy',
            ],
            'arabe-valeurs-islamiques-enfants' => [
                'meta_title' => 'Arabe et valeurs islamiques pour enfants | Ar-Rahman Academy',
            ],
            'correction-recitation-tajwid' => [
                'meta_title' => 'Correction de la récitation adultes | Ar-Rahman Academy',
            ],
            'memo-coran-consolidation' => [
                'meta_title' => 'Mémorisation du Coran pour adultes | Ar-Rahman Academy',
            ],
            'arabe-etudes-islamiques' => [
                'meta_title' => 'Arabe et études islamiques pour adultes | Ar-Rahman Academy',
            ],
        ];

        Course::query()
            ->whereNull('meta_title')
            ->get()
            ->each(function (Course $course) use ($defaultsBySlug): void {
                if (! isset($defaultsBySlug[$course->slug])) {
                    return;
                }

                $course->update([
                    'meta_title' => $defaultsBySlug[$course->slug]['meta_title'],
                    'meta_description' => $course->meta_description ?: $course->short_description,
                ]);
            });
    }

    private function seedPricingSettings(): void
    {
        $settings = PricingSettings::singleton();

        if ($settings->meta_title === null) {
            $settings->meta_title = 'Tarifs des cours de Coran en ligne | Ar-Rahman Academy';
        }

        if ($settings->meta_description === null) {
            $settings->meta_description = 'Tarifs clairs des cours particuliers de Coran et arabe en ligne. Packs sans engagement, première séance d\'essai gratuite, pour enfants et adultes.';
        }

        if ($settings->isDirty()) {
            $settings->save();
        }
    }
}
