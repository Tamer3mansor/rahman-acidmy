<?php

namespace App\Filament\Resources\LessonPageSettings\Pages;

use App\Filament\Resources\LessonPageSettings\LessonPageSettingsResource;
use App\Models\LessonPageSettings;
use Filament\Resources\Pages\EditRecord;

class EditLessonPageSettings extends EditRecord
{
    protected static string $resource = LessonPageSettingsResource::class;

    public function mount(int|string|null $record = null): void
    {
        $settings = LessonPageSettings::singleton();

        parent::mount($settings->getKey());
    }

    public function getBreadcrumbs(): array
    {
        return [
            LessonPageSettingsResource::getUrl('edit') => LessonPageSettingsResource::getModelLabel(),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
