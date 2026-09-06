<?php

namespace App\Filament\Resources\PricingPackages\Pages;

use App\Filament\Resources\PricingPackages\PricingPackageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPricingPackages extends ListRecords
{
    protected static string $resource = PricingPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
