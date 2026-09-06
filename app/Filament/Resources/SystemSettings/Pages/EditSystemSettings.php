<?php

namespace App\Filament\Resources\SystemSettings\Pages;

use App\Filament\Resources\SystemSettings\SystemSettingsResource;
use App\Models\SystemSettings;
use Filament\Resources\Pages\EditRecord;

class EditSystemSettings extends EditRecord
{
    protected static string $resource = SystemSettingsResource::class;

    public function mount(int|string|null $record = null): void
    {
        $settings = SystemSettings::singleton();

        parent::mount($settings->getKey());
    }

    public function getBreadcrumbs(): array
    {
        return [
            SystemSettingsResource::getUrl('edit') => SystemSettingsResource::getModelLabel(),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
