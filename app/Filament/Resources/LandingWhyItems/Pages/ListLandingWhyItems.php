<?php

namespace App\Filament\Resources\LandingWhyItems\Pages;

use App\Filament\Resources\LandingWhyItems\LandingWhyItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLandingWhyItems extends ListRecords
{
    protected static string $resource = LandingWhyItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
