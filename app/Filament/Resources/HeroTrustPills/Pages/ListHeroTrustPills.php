<?php

namespace App\Filament\Resources\HeroTrustPills\Pages;

use App\Filament\Resources\HeroTrustPills\HeroTrustPillResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHeroTrustPills extends ListRecords
{
    protected static string $resource = HeroTrustPillResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
