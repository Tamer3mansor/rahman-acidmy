<?php

namespace App\Filament\Resources\LandingTeachers\Pages;

use App\Filament\Resources\LandingTeachers\LandingTeacherResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLandingTeachers extends ListRecords
{
    protected static string $resource = LandingTeacherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
