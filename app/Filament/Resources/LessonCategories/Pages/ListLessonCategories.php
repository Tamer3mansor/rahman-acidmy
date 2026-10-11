<?php

namespace App\Filament\Resources\LessonCategories\Pages;

use App\Filament\Resources\LessonCategories\LessonCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLessonCategories extends ListRecords
{
    protected static string $resource = LessonCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
