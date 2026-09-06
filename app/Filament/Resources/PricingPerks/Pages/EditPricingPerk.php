<?php

namespace App\Filament\Resources\PricingPerks\Pages;

use App\Filament\Resources\PricingPerks\PricingPerkResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPricingPerk extends EditRecord
{
    protected static string $resource = PricingPerkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
