<?php

namespace App\Filament\Resources\PricingPerks\Pages;

use App\Filament\Resources\PricingPerks\PricingPerkResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPricingPerks extends ListRecords
{
    protected static string $resource = PricingPerkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
