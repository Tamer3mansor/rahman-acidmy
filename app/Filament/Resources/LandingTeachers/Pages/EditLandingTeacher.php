<?php

namespace App\Filament\Resources\LandingTeachers\Pages;

use App\Filament\Resources\LandingTeachers\LandingTeacherResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLandingTeacher extends EditRecord
{
    protected static string $resource = LandingTeacherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
