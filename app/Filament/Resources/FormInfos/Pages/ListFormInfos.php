<?php

namespace App\Filament\Resources\FormInfos\Pages;

use App\Filament\Resources\FormInfos\FormInfoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFormInfos extends ListRecords
{
    protected static string $resource = FormInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
