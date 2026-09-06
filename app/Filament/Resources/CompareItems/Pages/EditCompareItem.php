<?php

namespace App\Filament\Resources\CompareItems\Pages;

use App\Filament\Resources\CompareItems\CompareItemResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCompareItem extends EditRecord
{
    protected static string $resource = CompareItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
