<?php

namespace App\Filament\Resources\JourneySteps\Pages;

use App\Filament\Resources\JourneySteps\JourneyStepResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditJourneyStep extends EditRecord
{
    protected static string $resource = JourneyStepResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
