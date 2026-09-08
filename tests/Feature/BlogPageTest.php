<?php

namespace Tests\Feature;

use App\Models\BlogCategory;
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

    public function test_blog_show_renders_article_with_toc_and_related(): void
    {
        $this->seed([
            BlogCategorySeeder::class,
            BlogPostSeeder::class,
        ]);

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

    public function test_blog_admin_resources_render(): void
    {
        $this->seed([
            BlogCategorySeeder::class,
            BlogPostSeeder::class,
        ]);

        $user = User::factory()->create();

        foreach (['/admin/blog-posts', '/admin/blog-categories'] as $url) {
            $this->actingAs($user)->get($url)->assertOk();
        }
    }
}
