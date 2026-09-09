<?php

namespace App\Filament\Pages\Auth;

use App\Models\SystemSettings;
use Filament\Auth\Pages\Login;

class CustomLogin extends Login
{
    protected string $view = 'filament.pages.auth.login';

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
