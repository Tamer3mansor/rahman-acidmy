<?php

namespace App\Filament\Pages\Auth;

use App\Models\SystemSettings;
use Filament\Auth\Pages\Login;
use Filament\Support\Enums\Width;

class CustomLogin extends Login
{
    protected string $view = 'filament.pages.auth.login';

    protected function getMaxWidth(): Width | string | null
    {
        return Width::Full;
    }

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
