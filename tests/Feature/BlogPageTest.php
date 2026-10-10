<?php

namespace Tests\Feature;

use App\Models\BlogCategory;
use App\Models\BlogPageSettings;
use App\Models\BlogPost;
use App\Models\User;
use Database\Seeders\BlogCategorySeeder;
use Database\Seeders\BlogPostSeeder;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_blog_index_renders_featured_posts_and_filters(): void
    {
        $this->seed([
            BlogCategorySeeder::class,
            BlogPostSeeder::class,
        ]);

        $response = $this->get('/blog');

        $response->assertOk()
            ->assertViewIs('blog.index')
            ->assertSee('Derniers articles et conseils éducatifs')
            ->assertSee('Comment faire aimer la mémorisation du Coran à votre enfant sans contrainte ?')
            ->assertSee('Les 5 règles essentielles du Tajwid pour les débutants')
            ->assertSee('filter-btn active')
            ->assertDontSee('data-scroll-to-form')
            ->assertSee('build/assets/blog-', false);
    }

    public function test_blog_index_filters_by_category(): void
    {
        $this->seed([
            BlogCategorySeeder::class,
            BlogPostSeeder::class,
        ]);

        $response = $this->get('/blog?k=tajweed');

        $response->assertOk()
            ->assertSee('Les 5 règles essentielles du Tajwid pour les débutants')
            ->assertDontSee('Comment faire aimer la mémorisation du Coran à votre enfant sans contrainte ?');
    }

    public function test_blog_index_paginates_and_keeps_filters_in_page_links(): void
    {
        $category = BlogCategory::factory()->create(['name' => 'Tajweed', 'slug' => 'tajweed']);

        BlogPost::factory()->count(11)->create()->each(
            fn (BlogPost $post) => $post->categories()->sync([$category->id])
        );

        $response = $this->get('/blog?k=tajweed');

        $response->assertOk()
            ->assertSee('k=tajweed&amp;page=2', false)
            ->assertSee('aria-label="Page suivante"', false)
            ->assertSee('<strong>11</strong> articles trouvés', false);

        $response = $this->get('/blog?k=tajweed&page=2');

        $response->assertOk()
            ->assertSee('rel="prev"', false)
            ->assertSee('page-link is-disabled', false);

        $this->get('/blog?k=tajweed&page=99')->assertOk();
    }

    public function test_blog_index_searches_posts_and_keeps_search_in_page_links(): void
    {
        $matching = BlogPost::factory()->create([
            'title' => 'Comprendre la règle de la nun sakina',
            'excerpt' => 'Un article sur la prononciation.',
        ]);

        BlogPost::factory()->create([
            'title' => 'Méthodes modernes pour enseigner la langue arabe',
            'excerpt' => 'Un autre article sans rapport.',
        ]);

        $response = $this->get('/blog?q=sakina');

        $response->assertOk()
            ->assertSee('Comprendre la règle de la nun sakina')
            ->assertSee('<strong>1</strong> article trouvé', false)
            ->assertSee('value="sakina"', false)
            ->assertDontSee('Méthodes modernes pour enseigner la langue arabe');

        $this->assertTrue($matching->exists);

        $this->get('/blog?q=zzzznothing')
            ->assertOk()
            ->assertSee('Aucun article ne correspond à votre recherche');
    }

    public function test_blog_show_renders_article_with_toc_and_related(): void
    {
        $this->seed([
            BlogCategorySeeder::class,
            BlogPostSeeder::class,
        ]);

        $parentTips = BlogCategory::query()->where('slug', 'parent-tips')->firstOrFail();
        BlogPost::query()->where('slug', 'tajweed-rules-for-beginners')->firstOrFail()
            ->categories()->sync([$parentTips->id]);

        $response = $this->get('/blog/how-to-make-kids-love-quran');

        $response->assertOk()
            ->assertViewIs('blog.show')
            ->assertSee('Comment faire aimer la mémorisation du Coran à votre enfant sans contrainte ?')
            ->assertSee('Dr. Ahmed El-Menchaoui')
            ->assertSee('Sommaire')
            ->assertSee('id="Préparer-le-terrain-et-donner-le-bon-exemple-à-la-maison"', false)
            ->assertSee('Articles similaires')
            ->assertSee('application/ld+json', false);
    }

    public function test_blog_show_returns_404_for_unknown_inactive_or_unpublished_posts(): void
    {
        $this->seed([
            BlogCategorySeeder::class,
            BlogPostSeeder::class,
        ]);

        $this->get('/blog/non-existent-slug')->assertNotFound();

        $category = BlogCategory::query()->first();
        BlogPost::factory()->draft()->create(['category_id' => $category->id, 'slug' => 'draft-post']);

        $this->get('/blog/draft-post')->assertNotFound();
    }

    public function test_blog_show_uses_admin_picked_related_posts(): void
    {
        $category = BlogCategory::factory()->create();

        $parent = BlogPost::factory()->create(['slug' => 'parent-post']);
        $parent->categories()->attach($category->id);

        $picked = BlogPost::factory()->create(['title' => 'Article choisi depuis le tableau de bord']);

        $sameCategoryNotPicked = BlogPost::factory()->create(['title' => 'Article même catégorie non choisi']);
        $sameCategoryNotPicked->categories()->attach($category->id);

        $parent->relatedPosts()->attach($picked->id);

        $this->get('/blog/parent-post')
            ->assertOk()
            ->assertSee('Articles similaires')
            ->assertSee('Article choisi depuis le tableau de bord')
            ->assertDontSee('Article même catégorie non choisi');
    }

    public function test_blog_show_falls_back_to_same_category_posts_when_none_picked(): void
    {
        $category = BlogCategory::factory()->create();

        $parent = BlogPost::factory()->create(['slug' => 'parent-post']);
        $parent->categories()->attach($category->id);

        $sameCategory = BlogPost::factory()->create(['title' => 'Article de la même catégorie']);
        $sameCategory->categories()->attach($category->id);

        $this->get('/blog/parent-post')
            ->assertOk()
            ->assertSee('Article de la même catégorie');
    }

    public function test_blog_show_hides_inactive_related_posts(): void
    {
        $parent = BlogPost::factory()->create(['slug' => 'parent-post']);

        $active = BlogPost::factory()->create();
        $inactive = BlogPost::factory()->draft()->create();

        $parent->relatedPosts()->attach([$inactive->id, $active->id]);

        $this->get('/blog/parent-post')
            ->assertOk()
            ->assertSee($active->title)
            ->assertDontSee($inactive->title);
    }

    public function test_landing_nav_always_shows_blog_link(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/')
            ->assertOk()
            ->assertSee('Blog');
    }

    public function test_post_image_accessors_resolve_uploads_and_absolute_urls(): void
    {
        $post = BlogPost::factory()->create([
            'author_image' => 'blog/authors/ahmed.jpg',
            'cover_image' => 'https://example.com/cover.jpg',
        ]);

        $this->assertSame(asset('storage/blog/authors/ahmed.jpg'), $post->author_image_url);
        $this->assertSame('https://example.com/cover.jpg', $post->cover_image_url);
    }

    public function test_blog_index_copy_and_seo_come_from_the_page_settings(): void
    {
        $this->seed([
            BlogCategorySeeder::class,
            BlogPostSeeder::class,
        ]);

        BlogPageSettings::singleton()->update([
            'label' => 'Notre revue',
            'title' => 'Articles du mois',
            'description' => 'Une description choisie depuis le tableau de bord.',
            'meta_title' => 'Blog | Ar-Rahman Academy',
            'meta_description' => 'Description de meta choisie depuis le tableau de bord.',
        ]);

        $this->get('/blog')
            ->assertOk()
            ->assertSee('Notre revue')
            ->assertSee('Articles du mois')
            ->assertSee('Une description choisie depuis le tableau de bord.')
            ->assertSee('<title>Blog | Ar-Rahman Academy</title>', false)
            ->assertSee('Description de meta choisie depuis le tableau de bord.', false)
            ->assertDontSee('Blog éducatif');
    }

    public function test_blog_index_falls_back_to_the_bundled_wording_without_settings(): void
    {
        $this->seed([
            BlogCategorySeeder::class,
            BlogPostSeeder::class,
        ]);

        $settings = BlogPageSettings::singleton();
        $settings->update([
            'label' => null,
            'title' => null,
            'description' => null,
            'meta_title' => null,
            'meta_description' => null,
        ]);

        $this->get('/blog')
            ->assertOk()
            ->assertDontSee('section-label')
            ->assertDontSee('<p class="section-sub">')
            ->assertSee('Derniers articles et conseils éducatifs')
            ->assertSee('<title>Blog islamique - Coran, Tajwid et arabe | Ar-Rahman Academy</title>', false);
    }

    public function test_blog_og_image_prefers_the_page_setting_over_the_featured_cover(): void
    {
        $this->seed([
            BlogCategorySeeder::class,
            BlogPostSeeder::class,
        ]);

        BlogPageSettings::singleton()->update(['og_image' => 'images/og/blog.jpg']);

        $this->get('/blog')
            ->assertOk()
            ->assertSee('<meta property="og:image" content="'.asset('storage/images/og/blog.jpg').'">', false);
    }

    public function test_blog_index_is_noindex_when_the_page_settings_say_so(): void
    {
        $this->seed([
            BlogCategorySeeder::class,
            BlogPostSeeder::class,
        ]);

        BlogPageSettings::singleton()->update(['is_indexed' => false]);

        $this->get('/blog')
            ->assertOk()
            ->assertSee('<meta name="robots" content="noindex,nofollow"', false);
    }

    public function test_blog_admin_resources_render(): void
    {
        $this->seed([
            BlogCategorySeeder::class,
            BlogPostSeeder::class,
        ]);

        $user = User::factory()->create();

        foreach (['/admin/blog-posts', '/admin/blog-categories', '/admin/blog-page-settings'] as $url) {
            $this->actingAs($user)->get($url)->assertOk();
        }

        $this->actingAs($user)
            ->get('/admin/blog-posts')
            ->assertSee('toggleTableReordering', false);
    }
}
