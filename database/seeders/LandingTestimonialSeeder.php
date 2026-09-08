<?php

namespace Database\Seeders;

use App\Enums\TestimonialType;
use App\Models\LandingTestimonial;
use Illuminate\Database\Seeder;

class LandingTestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'type' => TestimonialType::Whatsapp,
                'author_name' => 'Mme Ahmed',
                'author_location' => 'Paris',
                'content' => 'Mon fils a mémorisé sourate Al-Mulk en seulement deux semaines ! L\'enseignant est excellent et l\'approche est merveilleuse.',
                'rating' => null,
            ],
            [
                'type' => TestimonialType::Whatsapp,
                'author_name' => 'M. Omar',
                'author_location' => 'Lyon',
                'content' => 'Que Dieu vous récompense pour votre attention et votre suivi avec mon fils.',
                'rating' => null,
            ],
            [
                'type' => TestimonialType::Whatsapp,
                'author_name' => 'Mme Sara',
                'author_location' => 'Amsterdam',
                'content' => 'L\'enseignante est très patiente avec ma fille et explique de manière ludique.',
                'rating' => null,
            ],
            [
                'type' => TestimonialType::Google,
                'author_name' => 'Fatima M.',
                'author_location' => 'Montréal',
                'content' => 'La meilleure académie de mémorisation. Ma fille adore son enseignante et les cours sont organisés et passionnants. Je recommande vivement !',
                'rating' => 5,
            ],
            [
                'type' => TestimonialType::Google,
                'author_name' => 'Youssef K.',
                'author_location' => 'Berlin',
                'content' => 'Depuis deux mois avec l\'académie, j\'ai fait des progrès remarquables en Tajwid. Les horaires flexibles sont parfaits pour ceux qui travaillent.',
                'rating' => 5,
            ],
            [
                'type' => TestimonialType::Google,
                'author_name' => 'Mme Yasmin',
                'author_location' => 'Bruxelles',
                'content' => 'Expérience excellente dès le début. La séance d\'essai gratuite nous a convaincus de nous inscrire immédiatement.',
                'rating' => 5,
            ],
        ];

        foreach ($testimonials as $sort => $testimonial) {
            LandingTestimonial::query()->updateOrCreate(
                ['type' => $testimonial['type'], 'author_name' => $testimonial['author_name']],
                [
                    'author_location' => $testimonial['author_location'],
                    'content' => $testimonial['content'],
                    'media_path' => null,
                    'rating' => $testimonial['rating'],
                    'is_active' => true,
                    'sort_order' => $sort,
                ]
            );
        }
    }
}
