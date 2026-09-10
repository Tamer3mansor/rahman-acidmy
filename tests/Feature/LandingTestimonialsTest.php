<?php

namespace Tests\Feature;

use App\Enums\TestimonialType;
use App\Filament\Resources\LandingTestimonials\Pages\CreateLandingTestimonial;
use App\Models\LandingTestimonial;
use App\Models\User;
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

    public function test_admin_form_shows_media_upload_for_google_type(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin);

        Livewire::test(CreateLandingTestimonial::class)
            ->fillForm(['type' => TestimonialType::Google->value])
            ->assertFormFieldVisible('media_path')
            ->assertFormFieldVisible('rating');
    }

    public function test_video_testimonials_render_on_landing_page(): void
    {
        LandingTestimonial::create([
            'type' => TestimonialType::Video,
            'author_name' => 'أم محمد',
            'author_location' => 'الرياض',
            'media_path' => 'landing/testimonials/temoignage.mp4',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('storage/landing/testimonials/temoignage.mp4', false)
            ->assertSee('أم محمد', false);
    }

    public function test_landing_page_shows_video_placeholder_when_no_video_testimonials(): void
    {
        LandingTestimonial::create([
            'type' => TestimonialType::Whatsapp,
            'author_name' => 'مثال',
            'content' => '<p>شهادة</p>',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Test vidéo · Parents', false);
    }
}
