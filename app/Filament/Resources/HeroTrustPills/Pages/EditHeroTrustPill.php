<?php

namespace App\Filament\Resources\HeroTrustPills\Pages;

use App\Filament\Resources\HeroTrustPills\HeroTrustPillResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHeroTrustPill extends EditRecord
{
    protected static string $resource = HeroTrustPillResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
