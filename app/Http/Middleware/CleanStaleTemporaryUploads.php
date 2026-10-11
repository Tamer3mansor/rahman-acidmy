<?php

namespace App\Http\Middleware;

use App\Support\TemporaryUploads;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class CleanStaleTemporaryUploads
{
    private const THROTTLE_KEY = 'temporary-uploads:last-clean';

    private const THROTTLE_HOURS = 6;

    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (Cache::add(self::THROTTLE_KEY, now()->timestamp, now()->addHours(self::THROTTLE_HOURS))) {
                app(TemporaryUploads::class)->clean();
            }
        } catch (Throwable $e) {
            Log::warning('Temporary upload cleanup failed.', ['exception' => $e]);
        }

        return $next($request);
    }
}
