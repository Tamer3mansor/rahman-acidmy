<?php

namespace App\Filament\Resources\LandingSettings;

use App\Filament\Resources\LandingSettings\Pages\EditLandingSettings;
use App\Filament\Resources\LandingSettings\Schemas\LandingSettingsForm;
use App\Models\LandingSettings;
use BackedEnum;
use Filament\Navigation\NavigationItem;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

use function Filament\Support\original_request;

class LandingSettingsResource extends Resource
{
    protected static ?string $model = LandingSettings::class;

    protected static null|string|UnitEnum $navigationGroup = 'إعدادات الصفحة';

    protected static ?string $navigationLabel = 'إعدادات الصفحة';

    protected static ?string $modelLabel = 'إعدادات الصفحة';

    protected static ?string $pluralModelLabel = 'إعدادات الصفحة';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return LandingSettingsForm::configure($schema);
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
            'edit' => EditLandingSettings::route('/'),
        ];
    }
}
