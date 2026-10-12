<?php

namespace App\Filament\Resources\LandingWhyItems;

use App\Filament\Resources\LandingWhyItems\Pages\CreateLandingWhyItem;
use App\Filament\Resources\LandingWhyItems\Pages\EditLandingWhyItem;
use App\Filament\Resources\LandingWhyItems\Pages\ListLandingWhyItems;
use App\Filament\Resources\LandingWhyItems\Schemas\LandingWhyItemForm;
use App\Filament\Resources\LandingWhyItems\Tables\LandingWhyItemsTable;
use App\Models\LandingWhyItem;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class LandingWhyItemResource extends Resource
{
    protected static ?string $model = LandingWhyItem::class;

    protected static UnitEnum|string|null $navigationGroup = 'إعدادات الصفحة الرئيسية';

    protected static ?string $navigationLabel = 'لماذا تختار مدرسة الرحمن';

    protected static ?string $modelLabel = 'بند';

    protected static ?string $pluralModelLabel = 'بنود لماذا تختار الرحمن';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return LandingWhyItemForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LandingWhyItemsTable::configure($table);
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
            'index' => ListLandingWhyItems::route('/'),
            'create' => CreateLandingWhyItem::route('/create'),
            'edit' => EditLandingWhyItem::route('/{record}/edit'),
        ];
    }
}
