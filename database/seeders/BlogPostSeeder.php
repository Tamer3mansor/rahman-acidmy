<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = BlogCategory::pluck('id', 'slug');

        $featuredBody = '<p>Beaucoup de parents rencontrent des difficultés à motivar leurs enfants pour la mémorisation du Saint Coran sans recourir à la pression ou la contrainte. L\'objectif n\'est pas seulement la mémorisation, mais d\'inculquer l\'amour de la parole de Dieu dans leurs cœurs dès le plus jeune âge.</p>'
            .'<h2>Préparer le terrain et donner le bon exemple à la maison</h2>'
            .'<p>L\'enfant imite ce qu\'il voit, pas ce qu\'il entend. Lorsque l\'enfant voit ses parents consacrer un moment quotidien à la lecture du Coran avec calme et bonheur, il développe de la curiosité et de la passion pour partager ce moment.</p>'
            .'<h2>Transformer la mémorisation en récompenses et défis ludiques</h2>'
            .'<p>Associer les courtes sourates à des récompenses morales et matérielles encourage l\'enfant, comme l\'"arbre de la mémorisation" où l\'enfant colore une feuille chaque fois qu\'il mémorise une nouvelle sourate.</p>'
            .'<h2>Utiliser la technologie et l\'enseignement en ligne</h2>'
            .'<p>Les plateformes interactives d\'aujourd\'hui offrent un environnement ludique qui combine la compétition entre les enfants et les jeux éducatifs innovants, permettant à l\'enfant de mémoriser à tout moment et depuis n\'importe où.</p>';

        $posts = [
            [
                'category_slug' => 'parent-tips',
                'title' => 'Comment faire aimer la mémorisation du Coran à votre enfant sans contrainte ?',
                'slug' => 'how-to-make-kids-love-quran',
                'excerpt' => 'Méthodes éducatives et pratiques pour aider vos enfants à s\'attacher au Saint Coran, en utilisant les technologies modernes pour rendre la mémorisation ludique et interactive.',
                'body' => $featuredBody,
                'author_name' => 'Dr. Ahmed El-Menchaoui',
                'author_image' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=200',
                'cover_image' => 'https://images.unsplash.com/photo-1584286595398-a59f21d313f5?q=80&w=800&auto=format&fit=crop',
                'reading_time' => 6,
                'published_at' => Carbon::now()->subDays(3),
                'is_featured' => true,
            ],
            [
                'category_slug' => 'tajweed',
                'title' => 'Les 5 règles essentielles du Tajwid pour les débutants',
                'slug' => 'tajweed-rules-for-beginners',
                'excerpt' => 'Explication simplifiée des règles principales de la Nun Sakinah, du Tanwin et de leur application lors de la lecture quotidienne.',
                'body' => '<p>Explication simplifiée des règles principales de la Nun Sakinah, du Tanwin et de leur application lors de la lecture quotidienne.</p>'
                    .'<h2>Règles de la Nun Sakinah et du Tanwin</h2>'
                    .'<p>Les règles de la Nun Sakinah et du Tanwin se divisent en quatre catégories : Izhar, Idgham, Qalb et Ikhfa, chacune avec ses cas et ses lettres qui en déterminent l\'application.</p>',
                'author_name' => 'Dr. Ahmed El-Menchaoui',
                'author_image' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=200',
                'cover_image' => 'https://images.unsplash.com/photo-1609599006353-e629aaabfeae?q=80&w=600&auto=format&fit=crop',
                'reading_time' => 5,
                'published_at' => Carbon::now()->subDays(8),
                'is_featured' => false,
            ],
            [
                'category_slug' => 'arabic-language',
                'title' => 'Méthodes modernes pour enseigner la langue arabe aux enfants non francophones',
                'slug' => 'teaching-arabic-to-non-native-kids',
                'excerpt' => 'Présentation des programmes interactifs et des jeux linguistiques qui accélèrent l\'apprentissage de la langue arabe chez l\'enfant.',
                'body' => '<p>Présentation des programmes interactifs et des jeux linguistiques qui accélèrent l\'apprentissage de la langue arabe chez l\'enfant.</p>'
                    .'<h2>Apprendre par le jeu</h2>'
                    .'<p>Les jeux linguistiques aident l\'enfant à acquérir du vocabulaire de manière naturelle, surtout lorsqu\'ils sont associés à des images et des situations de la vie quotidienne.</p>',
                'author_name' => 'Mme Sara Al-Jabri',
                'author_image' => null,
                'cover_image' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?q=80&w=600&auto=format&fit=crop',
                'reading_time' => 7,
                'published_at' => Carbon::now()->subDays(15),
                'is_featured' => false,
            ],
            [
                'category_slug' => 'kibar',
                'title' => 'Plan d\'organisation du temps pour la mémorisation du Coran pour les personnes actives',
                'slug' => 'time-plan-for-quran-memorization',
                'excerpt' => 'Comment concilier travail et mémorisation du Coran ? Un emploi du temps pratique et éprouvé pour accomplir votre quota quotidien sans épuisement.',
                'body' => '<p>Comment concilier travail et mémorisation du Coran ? Un emploi du temps pratique et éprouvé pour accomplir votre quota quotidien sans épuisement.</p>'
                    .'<h2>Les fondamentaux du succès du quota quotidien</h2>'
                    .'<p>La régularité avec une petite quantité chaque jour vaut mieux que l\'interruption pendant de longues périodes. Fixer un moment précis pour la mémorisation rend l\'habitude plus facile à maintenir.</p>',
                'author_name' => 'Ahmed El-Hammadi',
                'author_image' => null,
                'cover_image' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?q=80&w=600&auto=format&fit=crop',
                'reading_time' => 4,
                'published_at' => Carbon::now()->subDays(25),
                'is_featured' => false,
            ],
        ];

        foreach ($posts as $sort => $post) {
            BlogPost::query()->updateOrCreate(
                ['slug' => $post['slug']],
                [
                    'category_id' => $categories[$post['category_slug']],
                    'title' => $post['title'],
                    'excerpt' => $post['excerpt'],
                    'body' => $post['body'],
                    'author_name' => $post['author_name'],
                    'author_image' => $post['author_image'],
                    'cover_image' => $post['cover_image'],
                    'reading_time' => $post['reading_time'],
                    'published_at' => $post['published_at'],
                    'is_featured' => $post['is_featured'],
                    'is_active' => true,
                ]
            );
        }
    }
}
