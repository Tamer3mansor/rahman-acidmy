<?php

namespace Tests\Feature;

use App\Filament\Resources\LandingTeachers\Pages\CreateLandingTeacher;
use App\Filament\Resources\Lessons\Pages\CreateLesson;
use App\Models\LandingTeacher;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class LessonUploadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'filesystems.disks.tmp-for-tests' => [
                'driver' => 'local',
                'root' => storage_path('framework/testing/upload-probe'),
                'throw' => true,
            ],
        ]);
    }

    public function test_lesson_can_be_created_with_cover_image_and_main_audio(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $this->actingAs($user);

        $cover = UploadedFile::fake()->image('cover.jpg', 1600, 900);
        $audio = UploadedFile::fake()->create('lesson.mp3', 2048, 'audio/mpeg');

        Livewire::test(CreateLesson::class)
            ->upload('data.cover_image', [$cover])
            ->upload('data.audio_url', [$audio])
            ->set('data.title', 'Lesson de test')
            ->set('data.slug', 'lesson-de-test')
            ->call('create')
            ->assertHasNoErrors()
            ->assertRedirect();

        $lesson = Lesson::firstOrFail();

        $this->assertNotEmpty($lesson->cover_image);
        $this->assertNotEmpty($lesson->audio_url);

        Storage::disk('public')->assertExists($lesson->cover_image);
        Storage::disk('public')->assertExists($lesson->audio_url);
    }

    public function test_livewire_temp_upload_accepts_audio_larger_than_default_cap(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $audio = UploadedFile::fake()->create('lesson-long.mp3', 13000, 'audio/mpeg');

        Livewire::test(CreateLesson::class)
            ->upload('data.audio_url', [$audio])
            ->assertHasNoErrors();
    }

    public function test_teacher_photo_upload_is_stored_on_the_public_disk(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $this->actingAs($user);

        $photo = UploadedFile::fake()->image('teacher.jpg', 600, 600);

        Livewire::test(CreateLandingTeacher::class)
            ->upload('data.photo_path', [$photo])
            ->set('data.name', 'Cheikh Test')
            ->set('data.specialty', 'القرآن الكريم')
            ->set('data.badges', [])
            ->set('data.is_active', true)
            ->set('data.sort_order', 0)
            ->call('create')
            ->assertHasNoErrors()
            ->assertRedirect();

        $teacher = LandingTeacher::firstOrFail();

        $this->assertNotEmpty($teacher->photo_path);
        Storage::disk('public')->assertExists($teacher->photo_path);
        $this->assertStringStartsWith('http', $teacher->photo_url);
    }

    public function test_rich_editor_attachment_upload_through_livewire(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $image = UploadedFile::fake()->image('body-image.jpg', 800, 600);

        Livewire::test(CreateLesson::class)
            ->upload('data.body', [$image])
            ->assertHasNoErrors();
    }
}
