<?php

namespace App\Filament\Resources\PricingPerks;

use App\Filament\Resources\PricingPerks\Pages\CreatePricingPerk;
use App\Filament\Resources\PricingPerks\Pages\EditPricingPerk;
use App\Filament\Resources\PricingPerks\Pages\ListPricingPerks;
use App\Filament\Resources\PricingPerks\Schemas\PricingPerkForm;
use App\Filament\Resources\PricingPerks\Tables\PricingPerksTable;
use App\Models\PricingPerk;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PricingPerkResource extends Resource
{
    protected static ?string $model = PricingPerk::class;

    protected static null|string|UnitEnum $navigationGroup = 'الأسعار';

    protected static ?string $navigationLabel = 'مميزات الباقات';

    protected static ?string $modelLabel = 'ميزة';

    protected static ?string $pluralModelLabel = 'مميزات الباقات';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return PricingPerkForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PricingPerksTable::configure($table);
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
            'index' => ListPricingPerks::route('/'),
            'create' => CreatePricingPerk::route('/create'),
            'edit' => EditPricingPerk::route('/{record}/edit'),
        ];
    }
}
