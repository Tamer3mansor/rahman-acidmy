<?php

namespace App\Filament\Resources\LandingFaqs;

use App\Filament\Resources\LandingFaqs\Pages\CreateLandingFaq;
use App\Filament\Resources\LandingFaqs\Pages\EditLandingFaq;
use App\Filament\Resources\LandingFaqs\Pages\ListLandingFaqs;
use App\Filament\Resources\LandingFaqs\Schemas\LandingFaqForm;
use App\Filament\Resources\LandingFaqs\Tables\LandingFaqsTable;
use App\Models\LandingFaq;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class LandingFaqResource extends Resource
{
    protected static ?string $model = LandingFaq::class;

    protected static null|string|UnitEnum $navigationGroup = 'إدارة الصفحة الرئيسية';

    protected static ?string $navigationLabel = 'الأسئلة الشائعة';

    protected static ?string $modelLabel = 'سؤال';

    protected static ?string $pluralModelLabel = 'الأسئلة الشائعة';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQuestionMarkCircle;

    public static function form(Schema $schema): Schema
    {
        return LandingFaqForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LandingFaqsTable::configure($table);
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
            'index' => ListLandingFaqs::route('/'),
            'create' => CreateLandingFaq::route('/create'),
            'edit' => EditLandingFaq::route('/{record}/edit'),
        ];
    }
}
