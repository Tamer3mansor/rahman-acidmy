<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class FriendlyErrorHandlingTest extends TestCase
{
    use RefreshDatabase;

    public function test_unknown_route_renders_friendly_404_page(): void
    {
        $this->get('/this-page-does-not-exist')
            ->assertStatus(404)
            ->assertSee('الصفحة غير موجودة')
            ->assertDontSee('Stack trace');
    }

    public function test_forbidden_request_renders_friendly_403_page(): void
    {
        Route::get('/friendly-forbidden', fn () => abort(403));

        $this->get('/friendly-forbidden')
            ->assertStatus(403)
            ->assertSee('وصول مرفوض');
    }

    public function test_server_error_renders_friendly_500_page(): void
    {
        Route::get('/friendly-server-error', fn () => abort(500));

        $this->get('/friendly-server-error')
            ->assertStatus(500)
            ->assertSee('خطأ غير متوقع')
            ->assertDontSee('vendor/');
    }

    public function test_unhandled_throwable_never_leaks_internal_details(): void
    {
        Route::get('/friendly-boom', fn () => throw new \RuntimeException('secret-db-dsn leaked'));

        $this->get('/friendly-boom')
            ->assertStatus(500)
            ->assertSee('خطأ غير متوقع')
            ->assertDontSee('secret-db-dsn leaked');
    }

    public function test_dashboard_pages_still_work_after_error_handling_changes(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)
            ->get('/admin')
            ->assertOk()
            ->assertSee('Dashboard')
            ->assertSee('/build/assets/app-', false);
    }
}
