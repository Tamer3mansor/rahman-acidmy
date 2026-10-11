<?php

namespace App\Filament\Resources\LessonCategories\Pages;

use App\Filament\Resources\LessonCategories\LessonCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLessonCategory extends EditRecord
{
    protected static string $resource = LessonCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
