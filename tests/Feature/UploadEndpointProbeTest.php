<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class UploadEndpointProbeTest extends TestCase
{
    use RefreshDatabase;

    private function signedUploadUrl(): string
    {
        $key = config('app.key');
        $path = route('livewire.upload-file');
        $expires = now()->addMinutes(5)->timestamp;
        $original = $path.'?expires='.$expires;
        $signature = hash_hmac('sha256', $original, $key);

        return $original.'&signature='.$signature;
    }

    public function test_livewire_upload_file_endpoint_with_image(): void
    {
        $url = $this->signedUploadUrl();

        $response = $this->call('POST', $url, [], [], [
            'files' => [UploadedFile::fake()->image('probe.jpg', 1600, 900)],
        ], ['Accept' => 'application/json']);

        fwrite(STDERR, 'UPLOAD_STATUS: '.$response->getStatusCode().PHP_EOL);
        fwrite(STDERR, 'UPLOAD_BODY: '.mb_substr($response->getContent(), 0, 500).PHP_EOL);
        fwrite(STDERR, 'PROBE_PATH: '.$url.PHP_EOL);
        fwrite(STDERR, 'REQ_PATH: '.request()->path().PHP_EOL);
        fwrite(STDERR, 'REQ_QS: '.request()->server->get('QUERY_STRING').PHP_EOL);
        fwrite(STDERR, 'KEY: '.substr(config('app.key'), 0, 20).PHP_EOL);
    }

    public function test_livewire_upload_file_endpoint_rejects_oversize(): void
    {
        $url = $this->signedUploadUrl();

        $response = $this->call('POST', $url, [], [], [
            'files' => [UploadedFile::fake()->create('big.mp3', 13000)],
        ], ['Accept' => 'application/json']);

        fwrite(STDERR, 'BIG_STATUS: '.$response->getStatusCode().PHP_EOL);
        fwrite(STDERR, 'BIG_BODY: '.mb_substr($response->getContent(), 0, 400).PHP_EOL);
    }
}