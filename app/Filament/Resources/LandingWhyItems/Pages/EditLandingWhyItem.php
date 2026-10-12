<?php

namespace App\Filament\Resources\LandingWhyItems\Pages;

use App\Filament\Resources\LandingWhyItems\LandingWhyItemResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLandingWhyItem extends EditRecord
{
    protected static string $resource = LandingWhyItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
