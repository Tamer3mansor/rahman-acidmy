<?php

namespace App\Filament\Pages\Auth;

use App\Models\SystemSettings;
use Filament\Auth\Pages\Login;

class CustomLogin extends Login
{
    protected string $view = 'filament.pages.auth.login';

    protected static string $layout = 'filament.auth.login-layout';

    public function getLogo(): ?string
    {
        try {
            $settings = SystemSettings::singleton();

            return $settings->logoUrl();
        } catch (\Throwable) {
            return null;
        }
    }
}
