<?php

namespace Tests\Feature;

use App\Http\Middleware\CleanStaleTemporaryUploads;
use App\Support\TemporaryUploads;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TemporaryUploadErrorHandlingTest extends TestCase
{
    public function test_non_json_request_with_missing_temp_file_returns_422_with_reupload_hint(): void
    {
        Route::get('/_test/missing-temp-upload', fn () => throw new \TypeError(
            'stream_copy_to_stream(): Argument #1 ($from) must be of type resource, null given',
        ));

        $this->get('/_test/missing-temp-upload')
            ->assertStatus(422)
            ->assertSee('أعد رفع الملف ثم أعد الحفظ');
    }

    public function test_json_request_with_missing_temp_file_returns_422_with_reupload_message(): void
    {
        Route::get('/_test/missing-temp-upload', fn () => throw new \TypeError(
            'stream_copy_to_stream(): Argument #1 ($from) must be of type resource, null given',
        ));

        $this->getJson('/_test/missing-temp-upload')
            ->assertStatus(422)
            ->assertJsonPath('message', 'الملف الذي رفعته لم يعد متاحاً (انتهت صلاحية الرفع). أعد رفع الملف ثم أعد الحفظ.');
    }

    public function test_unrelated_type_error_still_returns_500(): void
    {
        Route::get('/_test/unrelated-type-error', fn () => throw new \TypeError('boom'));

        $this->get('/_test/unrelated-type-error')->assertStatus(500);
    }

    public function test_clean_deletes_only_temporary_uploads_untouched_for_seven_days(): void
    {
        [$disk, $old, $recent] = $this->fakeTemporaryUploadsWithStaleAndFreshFiles();

        app(TemporaryUploads::class)->clean();

        $this->assertFalse($disk->exists($old));
        $this->assertTrue($disk->exists($recent));
    }

    public function test_upload_middleware_sweeps_stale_temporaries_and_passes_the_request_on(): void
    {
        [$disk, $old, $recent] = $this->fakeTemporaryUploadsWithStaleAndFreshFiles();

        $response = app(CleanStaleTemporaryUploads::class)->handle(
            Request::create('/livewire/upload-file', 'POST'),
            fn () => response('continued'),
        );

        $this->assertSame('continued', $response->getContent());
        $this->assertFalse($disk->exists($old));
        $this->assertTrue($disk->exists($recent));
    }

    /**
     * @return array{0: Filesystem, 1: string, 2: string}
     */
    private function fakeTemporaryUploadsWithStaleAndFreshFiles(): array
    {
        config()->set('livewire.temporary_file_upload.disk', 'temp-uploads-test');
        Storage::fake('temp-uploads-test');

        $disk = Storage::disk('temp-uploads-test');
        $root = $disk->path('');
        $old = 'livewire-tmp/old-file.txt';
        $recent = 'livewire-tmp/recent-file.txt';

        $disk->put($old, 'old');
        $disk->put($recent, 'recent');
        touch("{$root}/{$old}", now()->subDays(8)->timestamp);
        touch("{$root}/{$recent}", now()->subDay()->timestamp);

        return [$disk, $old, $recent];
    }
}
