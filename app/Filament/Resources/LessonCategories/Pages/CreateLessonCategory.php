<?php

namespace App\Filament\Resources\LessonCategories\Pages;

use App\Filament\Resources\LessonCategories\LessonCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLessonCategory extends CreateRecord
{
    protected static string $resource = LessonCategoryResource::class;
}
