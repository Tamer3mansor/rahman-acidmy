<?php

namespace App\Filament\Resources\PricingPackages\Pages;

use App\Filament\Resources\PricingPackages\PricingPackageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPricingPackage extends EditRecord
{
    protected static string $resource = PricingPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
