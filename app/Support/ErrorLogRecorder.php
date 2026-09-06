<?php

namespace App\Support;

use App\Models\ErrorLog;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class ErrorLogRecorder
{
    public function log(Throwable $e): void
    {
        if (! $this->isEnabled() || $this->isNoise($e)) {
            return;
        }

        try {
            ErrorLog::create([
                'level' => 'error',
                'exception' => $e::class,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'code' => $e->getCode(),
                'trace' => array_slice($e->getTrace(), 0, 100),
                'url' => request()?->fullUrl(),
                'method' => request()?->method(),
                'user_id' => Auth::check() ? Auth::id() : null,
                'ip' => request()?->ip(),
            ]);
        } catch (Throwable) {
            // Persisting the error must never break the application or recurse into the handler.
        }
    }

    protected function isEnabled(): bool
    {
        return (bool) config('app.log_database_errors', false);
    }

    protected function isNoise(Throwable $e): bool
    {
        if (! $e instanceof HttpExceptionInterface) {
            return false;
        }

        return $e->getStatusCode() < 500;
    }
}
