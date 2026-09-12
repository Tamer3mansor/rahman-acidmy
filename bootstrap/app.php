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

            $hint = str_contains($e->getMessage(), 'Maximum number of input variables exceeded')
                ? 'يحتوي النموذج على عدد كبير جداً من الحقول. أعد المحاولة بعد اختصار البيانات أو تقليل عدد العناصر.'
                : null;

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
            app(ErrorLogRecorder::class)->log($e);
        });
    })->create();
