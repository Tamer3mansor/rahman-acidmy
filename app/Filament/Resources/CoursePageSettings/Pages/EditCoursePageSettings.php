<?php

namespace App\Filament\Resources\CoursePageSettings\Pages;

use App\Filament\Resources\CoursePageSettings\CoursePageSettingsResource;
use App\Models\CoursePageSettings;
use Filament\Resources\Pages\EditRecord;

class EditCoursePageSettings extends EditRecord
{
    protected static string $resource = CoursePageSettingsResource::class;

    public function mount(int|string|null $record = null): void
    {
        $settings = CoursePageSettings::singleton();

        parent::mount($settings->getKey());
    }

    public function getBreadcrumbs(): array
    {
        return [
            CoursePageSettingsResource::getUrl('edit') => CoursePageSettingsResource::getModelLabel(),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
