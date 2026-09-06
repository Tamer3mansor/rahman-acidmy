<?php

namespace App\Filament\Resources\CompareItems;

use App\Filament\Resources\CompareItems\Pages\CreateCompareItem;
use App\Filament\Resources\CompareItems\Pages\EditCompareItem;
use App\Filament\Resources\CompareItems\Pages\ListCompareItems;
use App\Filament\Resources\CompareItems\Schemas\CompareItemForm;
use App\Filament\Resources\CompareItems\Tables\CompareItemsTable;
use App\Models\CompareItem;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CompareItemResource extends Resource
{
    protected static ?string $model = CompareItem::class;

    protected static null|string|UnitEnum $navigationGroup = 'إعدادات الصفحة';

    protected static ?string $navigationLabel = 'بنود المقارنة';

    protected static ?string $modelLabel = 'بند مقارنة';

    protected static ?string $pluralModelLabel = 'بنود المقارنة';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAdjustmentsHorizontal;

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return CompareItemForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CompareItemsTable::configure($table);
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
            'index' => ListCompareItems::route('/'),
            'create' => CreateCompareItem::route('/create'),
            'edit' => EditCompareItem::route('/{record}/edit'),
        ];
    }
}
