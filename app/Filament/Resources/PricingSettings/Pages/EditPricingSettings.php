<?php

namespace App\Filament\Resources\PricingSettings\Pages;

use App\Filament\Resources\PricingSettings\PricingSettingsResource;
use App\Models\PricingSettings;
use Filament\Resources\Pages\EditRecord;

class EditPricingSettings extends EditRecord
{
    protected static string $resource = PricingSettingsResource::class;

    public function mount(int|string|null $record = null): void
    {
        $settings = PricingSettings::singleton();

        parent::mount($settings->getKey());
    }

    public function getBreadcrumbs(): array
    {
        return [
            PricingSettingsResource::getUrl('edit') => PricingSettingsResource::getModelLabel(),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
