<?php

namespace App\Filament\Resources\JourneySteps;

use App\Filament\Resources\JourneySteps\Pages\CreateJourneyStep;
use App\Filament\Resources\JourneySteps\Pages\EditJourneyStep;
use App\Filament\Resources\JourneySteps\Pages\ListJourneySteps;
use App\Filament\Resources\JourneySteps\Schemas\JourneyStepForm;
use App\Filament\Resources\JourneySteps\Tables\JourneyStepsTable;
use App\Models\JourneyStep;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class JourneyStepResource extends Resource
{
    protected static ?string $model = JourneyStep::class;

    protected static null|string|UnitEnum $navigationGroup = 'إعدادات الصفحة';

    protected static ?string $navigationLabel = 'خطوات الرحلة';

    protected static ?string $modelLabel = 'خطوة';

    protected static ?string $pluralModelLabel = 'الخطوات';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowTrendingUp;

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return JourneyStepForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JourneyStepsTable::configure($table);
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
            'index' => ListJourneySteps::route('/'),
            'create' => CreateJourneyStep::route('/create'),
            'edit' => EditJourneyStep::route('/{record}/edit'),
        ];
    }
}
