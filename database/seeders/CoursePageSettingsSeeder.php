<?php

namespace Database\Seeders;

use App\Models\CoursePageSettings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoursePageSettingsSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CoursePageSettings::query()->updateOrCreate(
            ['id' => 1],
            [
                // ---- Page Enfants ----
                'kids_label' => 'Cours pour enfants',
                'kids_title' => 'Simplifions le Coran et la langue arabe',
                'kids_title_accent' => 'pour vos enfants',
                'kids_subtitle' => 'Des cours particuliers en ligne avec des enseignants spécialisés dans le fondement et l\'inculcation des valeurs islamiques, d\'une manière encourageante adaptée à la nature de l\'enfant.',
                'kids_badge' => '🌱 Un parcours spirituel ludique pour les 5 - 15 ans',
                'kids_cta_title' => 'Voir les cours des enfants',
                'kids_cta_url' => '#catalog',
                'kids_wa_title' => 'Contactez-nous via WhatsApp',
                'kids_wa_url' => 'https://wa.me/0000000000',

                // ---- Page Adultes ----
                'adults_label' => 'Cours pour adultes',
                'adults_title' => 'Apprendre le Coran et le Tajwid',
                'adults_title_accent' => 'pour adultes',
                'adults_subtitle' => 'Des cours particuliers pour adultes afin de maîtriser et corriger la récitation et la mémorisation, avec une flexibilité totale dans les horaires et le plan d\'étude.',
                'adults_badge' => '🕌 Enseignement individuel en ligne avec une flexibilité totale',
                'adults_cta_title' => 'Voir les cours des adultes',
                'adults_cta_url' => '#catalog',
                'adults_wa_title' => 'Contactez-nous via WhatsApp',
                'adults_wa_url' => 'https://wa.me/0000000000',

                // ---- Page Détails du cours ----
                'details_booking_title' => 'Commencez votre parcours d\'apprentissage dès aujourd\'hui',
                'details_booking_subtitle' => 'Remplissez le formulaire et nous vous contacterons immédiatement pour fixer le créneau du cours d\'essai adapté.',
                'details_cta_title' => 'Réserver un cours d\'essai',
                'details_form_title' => 'Réservation du cours d\'essai',
                'details_booking_note' => 'Nos équipes vous répondent sous 24 heures.',
            ]
        );
    }
}
