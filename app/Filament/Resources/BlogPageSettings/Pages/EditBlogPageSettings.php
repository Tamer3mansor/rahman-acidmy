<?php

namespace App\Filament\Resources\BlogPageSettings\Pages;

use App\Filament\Resources\BlogPageSettings\BlogPageSettingsResource;
use App\Models\BlogPageSettings;
use Filament\Resources\Pages\EditRecord;

class EditBlogPageSettings extends EditRecord
{
    protected static string $resource = BlogPageSettingsResource::class;

    public function mount(int|string|null $record = null): void
    {
        $settings = BlogPageSettings::singleton();

        parent::mount($settings->getKey());
    }

    public function getBreadcrumbs(): array
    {
        return [
            BlogPageSettingsResource::getUrl('edit') => BlogPageSettingsResource::getModelLabel(),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
