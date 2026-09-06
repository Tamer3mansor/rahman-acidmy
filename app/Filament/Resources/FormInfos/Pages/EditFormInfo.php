<?php

namespace App\Filament\Resources\FormInfos\Pages;

use App\Filament\Resources\FormInfos\FormInfoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFormInfo extends EditRecord
{
    protected static string $resource = FormInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
