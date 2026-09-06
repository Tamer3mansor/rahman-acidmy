<?php

namespace App\Filament\Resources\SystemSettings;

use App\Filament\Resources\SystemSettings\Pages\EditSystemSettings;
use App\Filament\Resources\SystemSettings\Schemas\SystemSettingsForm;
use App\Models\SystemSettings;
use BackedEnum;
use Filament\Navigation\NavigationItem;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

use function Filament\Support\original_request;

class SystemSettingsResource extends Resource
{
    protected static ?string $model = SystemSettings::class;

    protected static null|string|UnitEnum $navigationGroup = 'النظام';

    protected static ?string $navigationLabel = 'إعدادات النظام';

    protected static ?string $modelLabel = 'إعدادات النظام';

    protected static ?string $pluralModelLabel = 'إعدادات النظام';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?string $slug = 'system-settings';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return SystemSettingsForm::configure($schema);
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
            'edit' => EditSystemSettings::route('/'),
        ];
    }
}
