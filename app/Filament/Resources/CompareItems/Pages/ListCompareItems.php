<?php

namespace App\Filament\Resources\CompareItems\Pages;

use App\Filament\Resources\CompareItems\CompareItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCompareItems extends ListRecords
{
    protected static string $resource = CompareItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
