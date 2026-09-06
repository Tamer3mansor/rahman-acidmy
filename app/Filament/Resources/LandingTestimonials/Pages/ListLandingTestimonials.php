<?php

namespace App\Filament\Resources\LandingTestimonials\Pages;

use App\Filament\Resources\LandingTestimonials\LandingTestimonialResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLandingTestimonials extends ListRecords
{
    protected static string $resource = LandingTestimonialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
