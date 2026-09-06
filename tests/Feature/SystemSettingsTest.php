<?php

namespace Tests\Feature;

use App\Filament\Resources\AdminUsers\Pages\CreateAdminUser;
use App\Filament\Resources\AdminUsers\Pages\EditAdminUser;
use App\Filament\Resources\SystemSettings\Pages\EditSystemSettings;
use App\Models\SystemSettings;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class SystemSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_system_settings_singleton_creates_missing_row(): void
    {
        $settings = SystemSettings::singleton();

        $this->assertSame(1, SystemSettings::query()->count());
        $this->assertTrue($settings->exists);

        $again = SystemSettings::singleton();

        $this->assertSame($settings->getKey(), $again->getKey());
        $this->assertSame(1, SystemSettings::query()->count());
    }

    public function test_admin_can_open_and_save_system_settings_page(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)
            ->get('/admin/system-settings')
            ->assertOk();

        Livewire::test(EditSystemSettings::class, ['record' => SystemSettings::singleton()->getKey()])
            ->fillForm([
                'title' => 'لوحة أكاديمية الرحمن',
                'description' => 'إدارة المحتوى والإعدادات',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame('لوحة أكاديمية الرحمن', SystemSettings::singleton()->title);
        $this->assertSame('إدارة المحتوى والإعدادات', SystemSettings::singleton()->description);
    }

    public function test_panel_uses_configured_branding(): void
    {
        SystemSettings::singleton()->update([
            'title' => 'لوحة أكاديمية الرحمن',
            'logo_path' => 'system/logo.png',
            'favicon_path' => 'system/favicon.png',
        ]);

        $admin = User::factory()->create();

        $this->actingAs($admin)
            ->get('/admin')
            ->assertOk()
            ->assertSee('لوحة أكاديمية الرحمن')
            ->assertSee('/storage/system/logo.png')
            ->assertSee('/storage/system/favicon.png');
    }

    public function test_panel_falls_back_to_app_name_when_unset(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)
            ->get('/admin')
            ->assertOk()
            ->assertSee(config('app.name'));
    }

    public function test_admin_users_pages_render(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)->get('/admin/admin-users')->assertOk();
        $this->actingAs($admin)->get('/admin/admin-users/create')->assertOk();
        $this->actingAs($admin)->get('/admin/admin-users/'.$admin->id.'/edit')->assertOk();
    }

    public function test_admin_can_create_user_with_hashed_password(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin);

        Livewire::test(CreateAdminUser::class)
            ->fillForm([
                'name' => 'أحمد محمد',
                'email' => 'ahmed@example.com',
                'password' => 'secret-pass-123',
                'password_confirmation' => 'secret-pass-123',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $created = User::query()->where('email', 'ahmed@example.com')->first();

        $this->assertNotNull($created);
        $this->assertNotSame('secret-pass-123', $created->getRawOriginal('password'));
        $this->assertTrue(Hash::check('secret-pass-123', $created->password));
        $this->assertTrue($created->is_active);
    }

    public function test_mismatched_password_confirmation_is_rejected(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin);

        Livewire::test(CreateAdminUser::class)
            ->fillForm([
                'name' => 'أحمد محمد',
                'email' => 'ahmed@example.com',
                'password' => 'secret-pass-123',
                'password_confirmation' => 'different-pass',
            ])
            ->call('create')
            ->assertHasFormErrors(['password']);
    }

    public function test_editing_user_without_password_keeps_existing_password(): void
    {
        $admin = User::factory()->create();
        $target = User::factory()->create(['password' => 'original-pass-123']);

        $this->actingAs($admin);

        Livewire::test(EditAdminUser::class, ['record' => $target->id])
            ->fillForm(['name' => 'الاسم المحدث'])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame('الاسم المحدث', $target->fresh()->name);
        $this->assertTrue(Hash::check('original-pass-123', $target->fresh()->password));
    }

    public function test_user_cannot_delete_or_deactivate_self(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin);

        Livewire::test(EditAdminUser::class, ['record' => $admin->id])
            ->assertActionHidden('delete')
            ->assertFormFieldHidden('is_active');

        $other = User::factory()->create();

        Livewire::test(EditAdminUser::class, ['record' => $other->id])
            ->assertActionVisible('delete')
            ->assertFormFieldVisible('is_active');
    }

    public function test_inactive_user_cannot_access_panel(): void
    {
        $inactive = User::factory()->create(['is_active' => false]);

        $this->actingAs($inactive)
            ->get('/admin')
            ->assertForbidden();
    }

    public function test_profile_page_renders(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)
            ->get('/admin/profile')
            ->assertOk();
    }
}
