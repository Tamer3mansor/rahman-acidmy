<?php

use App\Support\ErrorLogRecorder;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\SuspiciousOperationException;
use Symfony\Component\HttpKernel\Exception\ThrottleRequestsException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withSchedule(function (Schedule $schedule): void {
        $schedule->command('sitemap:generate')->daily();
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->stopIgnoring(HttpException::class);

        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        $exceptions->render(function (Throwable $e, Request $request): ?Response {
            if ($e instanceof HttpResponseException
                || $e instanceof ValidationException
                || $e instanceof AuthenticationException
                || $e instanceof MaintenanceModeException) {
                return null;
            }

            $status = match (true) {
                $e instanceof TokenMismatchException => 419,
                $e instanceof NotFoundHttpException => 404,
                $e instanceof MethodNotAllowedHttpException => 405,
                $e instanceof AccessDeniedHttpException,
                $e instanceof AuthorizationException => 403,
                $e instanceof ThrottleRequestsException => 429,
                $e instanceof SuspiciousOperationException => 400,
                $e instanceof HttpExceptionInterface => $e->getStatusCode() ?: 500,
                default => 500,
            };

            if (! in_array($status, [400, 401, 403, 404, 405, 413, 419, 422, 429, 500, 503], true)) {
                $status = 500;
            }

            $hint = match (true) {
                str_contains($e->getMessage(), 'stream_copy_to_stream') => 'تعذر قراءة الملف المؤقت أثناء التحقق من أبعاد الصورة. أعد رفع الملف.',
                str_contains($e->getMessage(), 'Maximum number of input variables exceeded') => 'يحتوي النموذج على عدد كبير جداً من الحقول. أعد المحاولة بعد اختصار البيانات أو تقليل عدد العناصر.',
                default => null,
            };

            if ($request->expectsJson() && ! $request->header('X-Livewire')) {
                return response()->json([
                    'message' => 'حدث خطأ غير متوقع، يرجى المحاولة لاحقاً.',
                    'status' => $status,
                ], $status);
            }

            return response()->view('errors.generic', [
                'status' => $status,
                'hint' => $hint,
            ], $status);
        });

        $exceptions->report(function (Throwable $e): void {
            if (str_contains($e->getMessage(), 'stream_copy_to_stream')) {
                $diskName = (string) (config('livewire.temporary_file_upload.disk') ?? config('filesystems.default', 'local'));
                $diskConfig = config("filesystems.disks.{$diskName}", []);
                $req = request();

                Log::error('Temporary upload stream error (stream_copy_to_stream)', [
                    'diagnosis' => 'Livewire/Filament attempted to inspect image dimensions via TemporaryUploadedFile::dimensions(), but the stream resource was null.',
                    'possible_causes' => [
                        'LIVEWIRE_UPLOAD_DISK is set to a private disk (should usually be public on production)',
                        'Temporary upload file was deleted before validation ran',
                        'File permissions prevent PHP from opening the temporary stream',
                        'Image dimensions validation or imageCropAspectRatio triggered on an unreadable temporary file',
                    ],
                    'disk' => [
                        'name' => $diskName,
                        'driver' => $diskConfig['driver'] ?? 'unknown',
                        'root' => $diskConfig['root'] ?? 'unknown',
                        'visibility' => $diskConfig['visibility'] ?? 'default',
                    ],
                    'livewire_config' => [
                        'temporary_file_upload_disk' => config('livewire.temporary_file_upload.disk'),
                        'default_filesystem' => config('filesystems.default'),
                        'max_upload_time' => config('livewire.temporary_file_upload.max_upload_time'),
                        'cleanup' => config('livewire.temporary_file_upload.cleanup'),
                    ],
                    'request' => [
                        'url' => $req?->fullUrl(),
                        'method' => $req?->method(),
                        'ip' => $req?->ip(),
                        'user_agent' => $req?->userAgent(),
                        'is_livewire' => (bool) $req?->hasHeader('X-Livewire'),
                        'files' => array_keys($req?->allFiles() ?? []),
                    ],
                    'auth' => [
                        'user_id' => auth()->id(),
                        'user_email' => auth()->user()?->email,
                    ],
                    'exception' => [
                        'class' => $e::class,
                        'message' => $e->getMessage(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                    ],
                ]);
            }

            app(ErrorLogRecorder::class)->log($e);
        });
    })->create();
