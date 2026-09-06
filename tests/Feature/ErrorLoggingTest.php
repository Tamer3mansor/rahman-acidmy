<?php

namespace Tests\Feature;

use App\Models\ErrorLog;
use App\Models\User;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use RuntimeException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class ErrorLoggingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config()->set('app.log_database_errors', true);
    }

    public function test_reported_exceptions_are_recorded_in_database(): void
    {
        app(ExceptionHandler::class)->report(new RuntimeException('database boom'));

        $this->assertDatabaseHas('error_logs', [
            'exception' => RuntimeException::class,
            'message' => 'database boom',
        ]);

        $this->assertSame(1, ErrorLog::count());
    }

    public function test_client_errors_are_not_recorded_as_noise(): void
    {
        app(ExceptionHandler::class)->report(new NotFoundHttpException('missing'));

        $this->assertDatabaseCount('error_logs', 0);
    }

    public function test_error_log_resource_is_read_only_and_renders(): void
    {
        $admin = User::factory()->create();
        ErrorLog::create([
            'exception' => RuntimeException::class,
            'message' => 'review me',
            'trace' => [],
        ]);

        $this->actingAs($admin)
            ->get('/admin/error-logs')
            ->assertOk()
            ->assertSee('سجل الأخطاء')
            ->assertSee('review me');
    }

    public function test_error_log_resource_has_no_create_or_edit_routes(): void
    {
        $admin = User::factory()->create();
        $record = ErrorLog::create([
            'exception' => RuntimeException::class,
            'message' => 'locked down',
            'trace' => [],
        ]);

        $this->actingAs($admin)
            ->get('/admin/error-logs/create')
            ->assertNotFound();

        $this->actingAs($admin)
            ->get("/admin/error-logs/{$record->id}/edit")
            ->assertNotFound();
    }
}
