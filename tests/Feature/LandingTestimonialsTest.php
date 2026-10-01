<?php

namespace Tests\Feature;

use App\Enums\CourseAudience;
use App\Enums\TestimonialPlacement;
use App\Enums\TestimonialType;
use App\Filament\Resources\LandingTestimonials\Pages\CreateLandingTestimonial;
use App\Filament\Resources\LandingTestimonials\Pages\ListLandingTestimonials;
use App\Models\Course;
use App\Models\LandingTestimonial;
use App\Models\User;
use Database\Seeders\CoursePageSettingsSeeder;
use Database\Seeders\CourseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LandingTestimonialsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_form_shows_video_upload_for_video_type(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin);

        Livewire::test(CreateLandingTestimonial::class)
            ->fillForm(['type' => TestimonialType::Video->value])
            ->assertFormFieldVisible('media_path')
            ->assertFormFieldHidden('content')
            ->assertFormFieldHidden('rating');
    }

    public function test_admin_form_hides_video_upload_for_whatsapp_type(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin);

        Livewire::test(CreateLandingTestimonial::class)
            ->fillForm(['type' => TestimonialType::Whatsapp->value])
            ->assertFormFieldHidden('media_path')
            ->assertFormFieldVisible('content');
    }

    public function test_admin_form_hides_media_upload_for_google_type(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin);

        Livewire::test(CreateLandingTestimonial::class)
            ->fillForm(['type' => TestimonialType::Google->value])
            ->assertFormFieldHidden('media_path')
            ->assertFormFieldVisible('rating');
    }

    public function test_video_testimonials_render_on_landing_page(): void
    {
        LandingTestimonial::create([
            'type' => TestimonialType::Video,
            'placements' => [TestimonialPlacement::Landing],
            'author_name' => 'أم محمد',
            'author_location' => 'الرياض',
            'media_path' => 'landing/testimonials/temoignage.mp4',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('storage/landing/testimonials/temoignage.mp4', false)
            ->assertSee('data-tv-video', false)
            ->assertDontSee('trust-label', false);
    }

    public function test_trust_layout_orders_whatsapp_left_video_center_google_right(): void
    {
        LandingTestimonial::create([
            'type' => TestimonialType::Whatsapp,
            'placements' => [TestimonialPlacement::Landing],
            'author_name' => 'متصل واتساب',
            'content' => '<p>شهادة واتساب</p>',
            'is_active' => true,
            'sort_order' => 1,
        ]);
        LandingTestimonial::create([
            'type' => TestimonialType::Video,
            'placements' => [TestimonialPlacement::Landing],
            'author_name' => 'صاحب فيديو',
            'media_path' => 'landing/testimonials/center.mp4',
            'is_active' => true,
            'sort_order' => 2,
        ]);
        LandingTestimonial::create([
            'type' => TestimonialType::Google,
            'placements' => [TestimonialPlacement::Landing],
            'author_name' => 'مقييم جوجل',
            'content' => '<p>تقييم جوجل مكتوب هنا</p>',
            'rating' => 5,
            'is_active' => true,
            'sort_order' => 3,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSeeInOrder([
                'شهادة واتساب',
                'storage/landing/testimonials/center.mp4',
                'تقييم جوجل مكتوب هنا',
            ], false);
    }

    public function test_landing_page_shows_video_placeholder_when_no_video_testimonials(): void
    {
        LandingTestimonial::create([
            'type' => TestimonialType::Whatsapp,
            'placements' => [TestimonialPlacement::Landing],
            'author_name' => 'مثال',
            'content' => '<p>شهادة</p>',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Test vidéo · Parents', false);
    }

    public function test_landing_page_shows_video_placeholder_when_video_testimonial_has_no_media(): void
    {
        LandingTestimonial::create([
            'type' => TestimonialType::Video,
            'placements' => [TestimonialPlacement::Landing],
            'author_name' => 'أم محمد',
            'media_path' => null,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Test vidéo · Parents', false)
            ->assertDontSee('storage/landing/testimonials', false);
    }

    public function test_landing_page_does_not_crash_with_invalid_type_value(): void
    {
        $record = LandingTestimonial::query()->updateOrCreate(
            ['id' => 1],
            [
                'type' => TestimonialType::Whatsapp,
                'placements' => [TestimonialPlacement::Landing],
                'author_name' => 'مثال',
                'content' => '<p>بيانات</p>',
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        $record->type = 'not-a-real-type';
        $this->assertNull($record->type);

        $this->get('/')
            ->assertOk()
            ->assertSee('Test vidéo · Parents', false);
    }

    public function test_invalid_type_value_in_database_is_handled_gracefully(): void
    {
        $this->assertNull((new LandingTestimonial(['type' => '', 'author_name' => 'x']))->type);
    }

    public function test_admin_form_includes_placements_checkbox_list(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin);

        Livewire::test(CreateLandingTestimonial::class)
            ->assertFormFieldExists('placements');
    }

    public function test_video_testimonial_renders_on_the_kids_page_and_course_detail_page(): void
    {
        $this->seed([
            CourseSeeder::class,
            CoursePageSettingsSeeder::class,
        ]);

        LandingTestimonial::create([
            'type' => TestimonialType::Video,
            'placements' => [TestimonialPlacement::Landing, TestimonialPlacement::Kids],
            'media_path' => 'landing/testimonials/kids.mp4',
            'is_active' => true,
            'sort_order' => 0,
        ]);

        $kidsCourse = Course::query()->where('audience', CourseAudience::Kids->value)->firstOrFail();

        $this->get('/enfants')
            ->assertOk()
            ->assertSee('storage/landing/testimonials/kids.mp4', false)
            ->assertSee('data-tv-video', false);

        $this->get("/cours/{$kidsCourse->slug}")
            ->assertOk()
            ->assertSee('storage/landing/testimonials/kids.mp4', false)
            ->assertSee('data-tv-video', false);
    }

    public function test_unknown_placement_values_are_dropped_on_read(): void
    {
        $testimonial = LandingTestimonial::query()->create([
            'type' => TestimonialType::Google,
            'placements' => ['kids', 'not-a-real-placement'],
            'author_name' => 'مثال',
            'content' => '<p>شهادة</p>',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $testimonial->refresh();

        $this->assertSame([TestimonialPlacement::Kids], $testimonial->placements);
    }

    public function test_dashboard_order_is_kept_per_placement(): void
    {
        $kidsFirst = LandingTestimonial::query()->create([
            'type' => TestimonialType::Google,
            'placements' => [TestimonialPlacement::Landing, TestimonialPlacement::Kids],
            'author_name' => 'اطفال أول',
            'content' => '<p>أول</p>',
            'rating' => 5,
            'is_active' => true,
            'sort_order' => 1,
        ]);
        $adultsOnly = LandingTestimonial::query()->create([
            'type' => TestimonialType::Google,
            'placements' => [TestimonialPlacement::Landing, TestimonialPlacement::Adults],
            'author_name' => 'كبار بس',
            'content' => '<p>كبار</p>',
            'rating' => 5,
            'is_active' => true,
            'sort_order' => 2,
        ]);
        $kidsSecond = LandingTestimonial::query()->create([
            'type' => TestimonialType::Google,
            'placements' => [TestimonialPlacement::Landing, TestimonialPlacement::Kids],
            'author_name' => 'اطفال تاني',
            'content' => '<p>تاني</p>',
            'rating' => 5,
            'is_active' => true,
            'sort_order' => 3,
        ]);

        $this->assertSame(
            [$kidsFirst->id, $kidsSecond->id],
            LandingTestimonial::query()->forAudience(CourseAudience::Kids)->pluck('id')->all()
        );
        $this->assertSame(
            [$adultsOnly->id],
            LandingTestimonial::query()->forAudience(CourseAudience::Adults)->pluck('id')->all()
        );
        $this->assertSame(
            [$kidsFirst->id, $adultsOnly->id, $kidsSecond->id],
            LandingTestimonial::query()->forLanding()->pluck('id')->all()
        );
    }

    public function test_reordering_a_filtered_subset_does_not_collide_with_hidden_testimonials(): void
    {
        $this->actingAs(User::factory()->create());

        $kidsFirst = LandingTestimonial::query()->create([
            'type' => TestimonialType::Google,
            'placements' => [TestimonialPlacement::Landing, TestimonialPlacement::Kids],
            'author_name' => 'اطفال أول',
            'content' => '<p>أول</p>',
            'rating' => 5,
            'is_active' => true,
            'sort_order' => 1,
        ]);
        $adultsOnly = LandingTestimonial::query()->create([
            'type' => TestimonialType::Google,
            'placements' => [TestimonialPlacement::Landing, TestimonialPlacement::Adults],
            'author_name' => 'كبار بس',
            'content' => '<p>كبار</p>',
            'rating' => 5,
            'is_active' => true,
            'sort_order' => 2,
        ]);
        $kidsSecond = LandingTestimonial::query()->create([
            'type' => TestimonialType::Google,
            'placements' => [TestimonialPlacement::Landing, TestimonialPlacement::Kids],
            'author_name' => 'اطفال تاني',
            'content' => '<p>تاني</p>',
            'rating' => 5,
            'is_active' => true,
            'sort_order' => 3,
        ]);

        Livewire::test(ListLandingTestimonials::class)
            ->call('reorderTable', [$kidsSecond->id, $kidsFirst->id]);

        $this->assertSame(
            [$kidsSecond->id, $kidsFirst->id],
            LandingTestimonial::query()->forAudience(CourseAudience::Kids)->pluck('id')->all()
        );
        $this->assertSame(
            [$kidsSecond->id, $kidsFirst->id, $adultsOnly->id],
            LandingTestimonial::query()->forLanding()->pluck('id')->all()
        );
        $this->assertSame(
            [1, 2, 3],
            LandingTestimonial::query()->orderBy('sort_order')->pluck('sort_order')->all()
        );
    }
}
