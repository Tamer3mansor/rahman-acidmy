<?php

namespace App\Filament\Resources\LandingFaqs\Pages;

use App\Filament\Resources\LandingFaqs\LandingFaqResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLandingFaqs extends ListRecords
{
    protected static string $resource = LandingFaqResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
