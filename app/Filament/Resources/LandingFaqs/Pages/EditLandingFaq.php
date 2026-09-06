<?php

namespace App\Filament\Resources\LandingFaqs\Pages;

use App\Filament\Resources\LandingFaqs\LandingFaqResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLandingFaq extends EditRecord
{
    protected static string $resource = LandingFaqResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
