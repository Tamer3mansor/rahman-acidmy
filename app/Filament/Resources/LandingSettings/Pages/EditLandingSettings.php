<?php

namespace App\Filament\Resources\LandingSettings\Pages;

use App\Filament\Resources\LandingSettings\LandingSettingsResource;
use App\Models\LandingSettings;
use Filament\Resources\Pages\EditRecord;

class EditLandingSettings extends EditRecord
{
    protected static string $resource = LandingSettingsResource::class;

    public function mount(int|string|null $record = null): void
    {
        $settings = LandingSettings::singleton();

        parent::mount($settings->getKey());
    }

    public function getBreadcrumbs(): array
    {
        return [
            LandingSettingsResource::getUrl('edit') => LandingSettingsResource::getModelLabel(),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
