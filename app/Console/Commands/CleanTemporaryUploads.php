<?php

namespace App\Console\Commands;

use App\Support\TemporaryUploads;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('temporary-uploads:clean')]
#[Description('Delete abandoned Livewire temporary uploads older than 7 days')]
class CleanTemporaryUploads extends Command
{
    public function handle(TemporaryUploads $temporaryUploads): void
    {
        $deleted = $temporaryUploads->clean();

        $this->info("Deleted {$deleted} stale temporary upload(s).");
    }
}
