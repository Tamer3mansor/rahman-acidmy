<?php

namespace App\Filament\Resources\LessonPageSettings;

use App\Filament\Resources\LessonPageSettings\Pages\EditLessonPageSettings;
use App\Filament\Resources\LessonPageSettings\Schemas\LessonPageSettingsForm;
use App\Models\LessonPageSettings;
use BackedEnum;
use Filament\Navigation\NavigationItem;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

use function Filament\Support\original_request;

class LessonPageSettingsResource extends Resource
{
    protected static ?string $model = LessonPageSettings::class;

    protected static UnitEnum|string|null $navigationGroup = 'الحصص المجانية';

    protected static ?string $navigationLabel = 'إعدادات صفحة الحصص المجانية';

    protected static ?string $modelLabel = 'إعدادات صفحة الحصص المجانية';

    protected static ?string $pluralModelLabel = 'إعدادات صفحة الحصص المجانية';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return LessonPageSettingsForm::configure($schema);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getNavigationItems(): array
    {
        $activeRoutePattern = static::getNavigationItemActiveRoutePattern();

        return [
            NavigationItem::make(static::getNavigationLabel())
                ->key(static::class)
                ->group(static::getNavigationGroup())
                ->icon(static::getNavigationIcon())
                ->isActiveWhen(fn (): bool => original_request()->routeIs($activeRoutePattern))
                ->sort(static::getNavigationSort())
                ->url(static::getUrl('edit')),
        ];
    }

    public static function getPages(): array
    {
        return [
            'edit' => EditLessonPageSettings::route('/'),
        ];
    }
}
