<?php

namespace Database\Seeders;

use App\Enums\LessonCategory;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courseBySlug = Course::query()->pluck('id', 'slug');

        $lessons = [
            [
                'category' => LessonCategory::Kids,
                'title' => 'Comment prononcer les trois lettres de madd facilement avec votre enfant ?',
                'slug' => 'prononcer-lettres-madd-avec-enfant',
                'excerpt' => 'Un cours audio et visuel pour apprendre à l\'enfant la différence entre la fatha et l\'aleph, la damma et le waw, la kasra et le ya.',
                'cover_image' => 'https://images.unsplash.com/photo-1609599006353-e629aaabfeae?q=80&w=800&auto=format&fit=crop',
                'audio_url' => 'https://www.w3schools.com/html/horse.mp3',
                'reading_time' => 4,
                'course_slug' => 'initiation-baraaim-quran',
                'body' => '<div><h2>Qu\'est-ce que les lettres de madd ?</h2><p>Les lettres de madd en arabe sont au nombre de trois : l\'aleph, le waw et le ya. On les appelle « lettres de madd » car le son s\'y étend sur deux temps ou plus lors de la lecture et de la récitation.</p></div>'
                    .'<h2>Le parallèle visuel entre les harakat et les lettres</h2>'
                    .'<p>Pour simplifier l\'idée à l\'enfant, nous relions toujours les voyelles courtes aux lettres longues correspondantes :</p>'
                    .'<p>الفتحة أخت الألف — نفتح الفم لأعلى أثناء النطق.</p>'
                    .'<p>الضمة أخت الواو — نضم الشفتين للأمام.</p>'
                    .'<p>الكسرة أخت الياء — تخفض الفك لأسفل.</p>'
                    .'<div class="lesson-audio"><p><strong>Écoutez la prononciation correcte des lettres de madd (enregistrement en classe)</strong></p><p>Appuyez sur le bouton de lecture pour écouter la prononciation facilitée par la voix du professeur :</p><audio controls class="audio-player"><source src="https://www.w3schools.com/html/horse.mp3" type="audio/mpeg">Votre navigateur ne prend pas en charge le lecteur audio.</audio></div>'
                    .'<div class="lesson-tip"><h4>💡 Conseil à l\'enseignant ou aux parents :</h4><p>Ne prolongez pas le madd au-delà de deux temps avec les débutants pour éviter les efforts inutiles, et faites répéter l\'enfant en imitant le mouvement de votre main pendant le madd.</p></div>',
            ],
            [
                'category' => LessonCategory::Tajwid,
                'title' => 'Règles de la nun sakina et du tanwin — l\'izhar',
                'slug' => 'regles-nun-sakina-tanwin-izhar',
                'excerpt' => 'Un exemple pratique qui montre les six lettres de l\'izhar et comment appliquer la règle lors de la lecture des sourates, avec un modèle audio à écouter.',
                'cover_image' => 'https://images.unsplash.com/photo-1585036156171-384164a8c675?q=80&w=800&auto=format&fit=crop',
                'audio_url' => 'https://www.w3schools.com/html/horse.mp3',
                'reading_time' => 7,
                'course_slug' => 'correction-recitation-tajwid',
                'body' => '<div><h2>Les lettres de l\'izhar</h2><p>L\'izhar s\'applique lorsque la nun sakina ou le tanwin est suivie d\'une des six lettres de la gorge : أ ه ع ح غ خ. La nun est alors prononcée clairement, sans nasalisation.</p></div>'
                    .'<div class="lesson-audio"><p><strong>Écoutez un exemple appliqué</strong></p><p>Un modèle de lecture récité montrant l\'application de l\'izhar pendant la lecture des sourates :</p><audio controls class="audio-player"><source src="https://www.w3schools.com/html/horse.mp3" type="audio/mpeg">Votre navigateur ne prend pas en charge le lecteur audio.</audio></div>'
                    .'<h2>Comment l\'appliquer en pratique</h2>'
                    .'<p>Lors de la lecture, lorsque vous rencontrez une nun sakina ou un tanwin suivis d\'une lettre de la gorge, prononcez la nun clairement puis enchaînez avec la lettre suivante sans nasalisation.</p>'
                    .'<div class="lesson-tip"><h4>💡 Conseil :</h4><p>Entraînez-vous avec des mots simples puis passez aux versets complets pour installer le réflexe sans réflexion.</p></div>',
            ],
            [
                'category' => LessonCategory::Kids,
                'title' => 'Les adhkar du matin et du soir pour les enfants simplifiés',
                'slug' => 'adhkar-matin-soir-pour-enfants',
                'excerpt' => 'Des cartes interactives et une explication douce des sens des adhkar quotidiens pour ancrer la bonne habitude chez l\'enfant.',
                'cover_image' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?q=80&w=800&auto=format&fit=crop',
                'audio_url' => null,
                'reading_time' => 5,
                'course_slug' => 'arabe-valeurs-islamiques-enfants',
                'body' => '<div><h2>Pourquoi apprendre les adhkar à l\'enfant ?</h2><p>Les adhkar du matin et du soir inculquent à l\'enfant la confiance en Dieu et une sérénité quotidienne. On les présente par de courtes invocations illustrées accompagnées de leur sens simplifié.</p></div>'
                    .'<h2>Comment les intégrer à la routine</h2>'
                    .'<p>Répétez les adhkar ensemble après la prière du matin et avant le sommeil. Associez-les à des gestes et des couleurs pour que l\'enfant les mémorise avec plaisir.</p>'
                    .'<div class="lesson-tip"><h4>💡 Conseil aux parents :</h4><p>La régularité prime sur la quantité : cinq minutes chaque jour valent mieux qu\'une longue séance hebdomadaire.</p></div>',
            ],
        ];

        foreach ($lessons as $sort => $lesson) {
            Lesson::query()->updateOrCreate(
                ['slug' => $lesson['slug']],
                [
                    'category' => $lesson['category']->value,
                    'title' => $lesson['title'],
                    'excerpt' => $lesson['excerpt'],
                    'body' => $lesson['body'],
                    'cover_image' => $lesson['cover_image'],
                    'audio_url' => $lesson['audio_url'],
                    'reading_time' => $lesson['reading_time'],
                    'course_id' => $courseBySlug[$lesson['course_slug']] ?? null,
                    'is_active' => true,
                    'sort_order' => $sort,
                ]
            );
        }
    }
}
