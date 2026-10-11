<?php

namespace App\Support;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class TemporaryUploads
{
    private const STALE_AFTER_DAYS = 7;

    public function clean(int $olderThanDays = self::STALE_AFTER_DAYS): int
    {
        $disk = $this->disk();
        $directory = $this->directory();
        $threshold = now()->subDays($olderThanDays)->timestamp;

        $deleted = 0;

        foreach ($disk->allFiles($directory) as $file) {
            if (! $disk->exists($file)) {
                continue;
            }

            if ($disk->lastModified($file) < $threshold) {
                $disk->delete($file);

                $deleted++;
            }
        }

        return $deleted;
    }

    private function disk(): Filesystem
    {
        return Storage::disk(config('livewire.temporary_file_upload.disk') ?: config('filesystems.default'));
    }

    private function directory(): string
    {
        return config('livewire.temporary_file_upload.directory') ?: 'livewire-tmp';
    }
}
