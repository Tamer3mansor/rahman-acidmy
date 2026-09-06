<?php

namespace App\Filament\Resources\LandingTestimonials\Pages;

use App\Filament\Resources\LandingTestimonials\LandingTestimonialResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLandingTestimonial extends EditRecord
{
    protected static string $resource = LandingTestimonialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
