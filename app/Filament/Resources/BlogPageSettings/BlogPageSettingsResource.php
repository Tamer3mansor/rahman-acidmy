<?php

namespace App\Filament\Resources\BlogPageSettings;

use App\Filament\Resources\BlogPageSettings\Pages\EditBlogPageSettings;
use App\Filament\Resources\BlogPageSettings\Schemas\BlogPageSettingsForm;
use App\Models\BlogPageSettings;
use BackedEnum;
use Filament\Navigation\NavigationItem;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

use function Filament\Support\original_request;

class BlogPageSettingsResource extends Resource
{
    protected static ?string $model = BlogPageSettings::class;

    protected static UnitEnum|string|null $navigationGroup = 'المدونة';

    protected static ?string $navigationLabel = 'إعدادات صفحة المدونة';

    protected static ?string $modelLabel = 'إعدادات صفحة المدونة';

    protected static ?string $pluralModelLabel = 'إعدادات صفحة المدونة';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return BlogPageSettingsForm::configure($schema);
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
            'edit' => EditBlogPageSettings::route('/'),
        ];
    }
}
