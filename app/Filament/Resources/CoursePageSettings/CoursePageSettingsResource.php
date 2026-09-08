<?php

namespace App\Filament\Resources\CoursePageSettings;

use App\Filament\Resources\CoursePageSettings\Pages\EditCoursePageSettings;
use App\Filament\Resources\CoursePageSettings\Schemas\CoursePageSettingsForm;
use App\Models\CoursePageSettings;
use BackedEnum;
use Filament\Navigation\NavigationItem;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

use function Filament\Support\original_request;

class CoursePageSettingsResource extends Resource
{
    protected static ?string $model = CoursePageSettings::class;

    protected static null|string|UnitEnum $navigationGroup = 'إعدادات الصفحة';

    protected static ?string $navigationLabel = 'إعدادات الدورات';

    protected static ?string $modelLabel = 'إعدادات الدورات';

    protected static ?string $pluralModelLabel = 'إعدادات الدورات';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return CoursePageSettingsForm::configure($schema);
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
            'edit' => EditCoursePageSettings::route('/'),
        ];
    }
}
