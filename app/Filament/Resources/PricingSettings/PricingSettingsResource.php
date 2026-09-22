<?php

namespace App\Filament\Resources\PricingSettings;

use App\Filament\Resources\PricingSettings\Pages\EditPricingSettings;
use App\Filament\Resources\PricingSettings\Schemas\PricingSettingsForm;
use App\Models\PricingSettings;
use BackedEnum;
use Filament\Navigation\NavigationItem;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

use function Filament\Support\original_request;

class PricingSettingsResource extends Resource
{
    protected static ?string $model = PricingSettings::class;

    protected static null|string|UnitEnum $navigationGroup = 'الأسعار';

    protected static ?string $navigationLabel = 'إعدادات محتويات الباقات';

    protected static ?string $modelLabel = 'إعدادات محتويات الباقات';

    protected static ?string $pluralModelLabel = 'إعدادات محتويات الباقات';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return PricingSettingsForm::configure($schema);
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
            'edit' => EditPricingSettings::route('/'),
        ];
    }
}
