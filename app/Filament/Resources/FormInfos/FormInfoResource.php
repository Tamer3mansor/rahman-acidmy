<?php

namespace App\Filament\Resources\FormInfos;

use App\Filament\Resources\FormInfos\Pages\CreateFormInfo;
use App\Filament\Resources\FormInfos\Pages\EditFormInfo;
use App\Filament\Resources\FormInfos\Pages\ListFormInfos;
use App\Filament\Resources\FormInfos\Schemas\FormInfoForm;
use App\Filament\Resources\FormInfos\Tables\FormInfosTable;
use App\Models\FormInfo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class FormInfoResource extends Resource
{
    protected static ?string $model = FormInfo::class;

    protected static null|string|UnitEnum $navigationGroup = 'إعدادات الصفحة';

    protected static ?string $navigationLabel = 'نقاط نموذج التواصل';

    protected static ?string $modelLabel = 'نقطة';

    protected static ?string $pluralModelLabel = 'نقاط نموذج التواصل';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInformationCircle;

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return FormInfoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FormInfosTable::configure($table);
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
            'index' => ListFormInfos::route('/'),
            'create' => CreateFormInfo::route('/create'),
            'edit' => EditFormInfo::route('/{record}/edit'),
        ];
    }
}
