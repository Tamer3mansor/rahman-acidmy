<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\CustomLogin;
use App\Filament\Widgets\DashboardStatsWidget;
use App\Filament\Widgets\SubmissionsByLevelChartWidget;
use App\Filament\Widgets\SubmissionsByStatusChartWidget;
use App\Filament\Widgets\SubmissionsChartWidget;
use App\Models\SystemSettings;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Assets\Css;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentAsset;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Foundation\Vite;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\HtmlString;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Throwable;

class AdminPanelProvider extends PanelProvider
{
    public function boot(): void
    {
        FilamentAsset::register([
            Css::make('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css'),
        ], package: 'landing');
    }

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(CustomLogin::class)
            ->profile()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->brandName(fn (): string => $this->panelTitle())
            ->brandLogo(fn (): ?string => $this->panelLogo())
            ->favicon(fn (): ?string => $this->panelFavicon())
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                DashboardStatsWidget::class,
                SubmissionsChartWidget::class,
                SubmissionsByStatusChartWidget::class,
                SubmissionsByLevelChartWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->renderHook(
                PanelsRenderHook::SCRIPTS_AFTER,
                fn (): HtmlString => app(Vite::class)(['resources/js/app.js']),
            );
    }

    private function panelTitle(): string
    {
        try {
            return SystemSettings::title();
        } catch (Throwable) {
            return config('app.name');
        }
    }

    private function panelLogo(): ?string
    {
        try {
            $settings = SystemSettings::singleton();

            return $settings->logoUrl();
        } catch (Throwable) {
            return null;
        }
    }

    private function panelFavicon(): ?string
    {
        try {
            $settings = SystemSettings::singleton();

            return $settings->faviconUrl();
        } catch (Throwable) {
            return null;
        }
    }
}
