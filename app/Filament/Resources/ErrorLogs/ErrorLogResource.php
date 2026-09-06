<?php

namespace App\Filament\Resources\ErrorLogs;

use App\Filament\Resources\ErrorLogs\Pages\ListErrorLogs;
use App\Filament\Resources\ErrorLogs\Tables\ErrorLogsTable;
use App\Models\ErrorLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ErrorLogResource extends Resource
{
    protected static ?string $model = ErrorLog::class;

    protected static null|string|UnitEnum $navigationGroup = 'النظام';

    protected static ?string $navigationLabel = 'سجل الأخطاء';

    protected static ?string $modelLabel = 'خطأ';

    protected static ?string $pluralModelLabel = 'سجل الأخطاء';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBugAnt;

    protected static ?int $navigationSort = 99;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return ErrorLogsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListErrorLogs::route('/'),
        ];
    }
}
