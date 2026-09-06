<?php

namespace App\Filament\Resources\PricingPackages;

use App\Filament\Resources\PricingPackages\Pages\CreatePricingPackage;
use App\Filament\Resources\PricingPackages\Pages\EditPricingPackage;
use App\Filament\Resources\PricingPackages\Pages\ListPricingPackages;
use App\Filament\Resources\PricingPackages\Schemas\PricingPackageForm;
use App\Filament\Resources\PricingPackages\Tables\PricingPackagesTable;
use App\Models\PricingPackage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PricingPackageResource extends Resource
{
    protected static ?string $model = PricingPackage::class;

    protected static null|string|UnitEnum $navigationGroup = 'الأسعار';

    protected static ?string $navigationLabel = 'باقات الأسعار';

    protected static ?string $modelLabel = 'باقة';

    protected static ?string $pluralModelLabel = 'باقات الأسعار';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return PricingPackageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PricingPackagesTable::configure($table);
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
            'index' => ListPricingPackages::route('/'),
            'create' => CreatePricingPackage::route('/create'),
            'edit' => EditPricingPackage::route('/{record}/edit'),
        ];
    }
}
