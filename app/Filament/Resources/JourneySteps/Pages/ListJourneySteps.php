<?php

namespace App\Filament\Resources\JourneySteps\Pages;

use App\Filament\Resources\JourneySteps\JourneyStepResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListJourneySteps extends ListRecords
{
    protected static string $resource = JourneyStepResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
