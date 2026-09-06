<?php

namespace App\Filament\Resources\HeroTrustPills;

use App\Filament\Resources\HeroTrustPills\Pages\CreateHeroTrustPill;
use App\Filament\Resources\HeroTrustPills\Pages\EditHeroTrustPill;
use App\Filament\Resources\HeroTrustPills\Pages\ListHeroTrustPills;
use App\Filament\Resources\HeroTrustPills\Schemas\HeroTrustPillForm;
use App\Filament\Resources\HeroTrustPills\Tables\HeroTrustPillsTable;
use App\Models\HeroTrustPill;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class HeroTrustPillResource extends Resource
{
    protected static ?string $model = HeroTrustPill::class;

    protected static null|string|UnitEnum $navigationGroup = 'إعدادات الصفحة';

    protected static ?string $navigationLabel = 'شارات الثقة بالهيرو';

    protected static ?string $modelLabel = 'شارة ثقة';

    protected static ?string $pluralModelLabel = 'شارات الثقة';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return HeroTrustPillForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HeroTrustPillsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHeroTrustPills::route('/'),
            'create' => CreateHeroTrustPill::route('/create'),
            'edit' => EditHeroTrustPill::route('/{record}/edit'),
        ];
    }
}
