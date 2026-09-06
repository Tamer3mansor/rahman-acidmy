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

        $featuredBody = '<p>يواجه الكثير من الآباء والأمهات تحدياً في ترغيب أبنائهم في حفظ القرآن الكريم بدون استخدام أسلوب الضغط أو الإجبار. الهدف ليس فقط الحفظ، بل غرس حب كلام الله في قلوبهم منذ الصغر.</p>'
            .'<h2>التمهيد والقدوة الحسنة في المنزل</h2>'
            .'<p>الطفل يقلد ما يراه لا ما يسمعه. عندما يرى الطفل والديه يخصصان وقتاً يومياً لقراءة القرآن بكل هدوء وسعادة، يتولد لديه الفضول والشغف لمشاركتهم هذا الوقت.</p>'
            .'<h2>تحويل الحفظ إلى مكافآت وتحديات ممتعة</h2>'
            .'<p>ربط السور القصيرة بمكافآت معنوية ومادية يشجع الطفل، مثل "شجرة الحفظ" التي يلون فيها الطفل ورقة كلما حفظ سورة جديدة.</p>'
            .'<h2>استخدام التكنولوجيا والتعليم الأونلاين</h2>'
            .'<p>المنصات التفاعلية اليوم توفر بيئة ممتعة تجمع بين التنافس بين الأطفال والألعاب التعليمية المبتكرة، وتمكن الطفل من الحفظ في أي وقت ومن أي مكان.</p>';

        $posts = [
            [
                'category_slug' => 'parent-tips',
                'title' => 'كيف تجعل طفلك يحب حفظ القرآن الكريم بدون إجبار؟',
                'slug' => 'how-to-make-kids-love-quran',
                'excerpt' => 'طرق تربوية وعملية لمساعدة أطفالك على التعلق بالقرآن الكريم، واستغلال التقنيات الحديثة في جعل عملية الحفظ ممتعة وتفاعلية.',
                'body' => $featuredBody,
                'author_name' => 'د. أحمد المنشاوي',
                'author_image' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=200',
                'cover_image' => 'https://images.unsplash.com/photo-1584286595398-a59f21d313f5?q=80&w=800&auto=format&fit=crop',
                'reading_time' => 6,
                'published_at' => Carbon::now()->subDays(3),
                'is_featured' => true,
            ],
            [
                'category_slug' => 'tajweed',
                'title' => 'أهم 5 أحكام تجويد يجب أن يبدأ بها المبتدئون',
                'slug' => 'tajweed-rules-for-beginners',
                'excerpt' => 'شرح مبسط لأهم أحكام النون الساكنة والتنوين وكيفية تطبيقها أثناء القراءة اليومية بسهولة.',
                'body' => '<p>شرح مبسط لأهم أحكام النون الساكنة والتنوين وكيفية تطبيقها أثناء القراءة اليومية بسهولة.</p>'
                    .'<h2>أحكام النون الساكنة والتنوين</h2>'
                    .'<p>تنقسم أحكام النون الساكنة والتنوين إلى أربعة أقسام: الإظهار، الإدغام، الإقلاب، والإخفاء، ولكل قسم حالاته وحروفه التي تتحكم في تطبيقه.</p>',
                'author_name' => 'د. أحمد المنشاوي',
                'author_image' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=200',
                'cover_image' => 'https://images.unsplash.com/photo-1609599006353-e629aaabfeae?q=80&w=600&auto=format&fit=crop',
                'reading_time' => 5,
                'published_at' => Carbon::now()->subDays(8),
                'is_featured' => false,
            ],
            [
                'category_slug' => 'arabic-language',
                'title' => 'طرق حديثة لتعليم اللغة العربية للأطفال غير الناطقين بها',
                'slug' => 'teaching-arabic-to-non-native-kids',
                'excerpt' => 'استعراض لأبرز المناهج التفاعلية والألعاب اللغوية التي تسرع من استيعاب الطفل للغة العربية.',
                'body' => '<p>استعراض لأبرز المناهج التفاعلية والألعاب اللغوية التي تسرع من استيعاب الطفل للغة العربية.</p>'
                    .'<h2>التعلم عبر الألعاب</h2>'
                    .'<p>الألعاب اللغوية تساعد الطفل على اكتساب المفردات بشكل طبيعي، خاصة عندما ترتبط بصور ومواقف حياتية تعيشها يومياً.</p>',
                'author_name' => 'أ. سارة الجابري',
                'author_image' => null,
                'cover_image' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?q=80&w=600&auto=format&fit=crop',
                'reading_time' => 7,
                'published_at' => Carbon::now()->subDays(15),
                'is_featured' => false,
            ],
            [
                'category_slug' => 'kibar',
                'title' => 'خطة تنظيم الوقت لحفظ القرآن الكريم أسبوعياً للأشخاص المشغولين',
                'slug' => 'time-plan-for-quran-memorization',
                'excerpt' => 'كيف توفق بين عملك وحفظ القرآن؟ جدول عملي ومجرب لإنجاز وردك اليومي بدون إرهاق.',
                'body' => '<p>كيف توفق بين عملك وحفظ القرآن؟ جدول عملي ومجرب لإنجاز وردك اليومي بدون إرهاق.</p>'
                    .'<h2>أساسيات نجاح الورد اليومي</h2>'
                    .'<p>الانتظام على قدر قليل يومياً خير من الانقطاع لفترات طويلة، مع تثبيت وقت محدد للحفظ يجعل العادة أسهل في الاستمرار.</p>',
                'author_name' => 'أحمد الحمادي',
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
