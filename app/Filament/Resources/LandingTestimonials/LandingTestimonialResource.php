<?php

namespace App\Filament\Resources\LandingTestimonials;

use App\Filament\Resources\LandingTestimonials\Pages\CreateLandingTestimonial;
use App\Filament\Resources\LandingTestimonials\Pages\EditLandingTestimonial;
use App\Filament\Resources\LandingTestimonials\Pages\ListLandingTestimonials;
use App\Filament\Resources\LandingTestimonials\Schemas\LandingTestimonialForm;
use App\Filament\Resources\LandingTestimonials\Tables\LandingTestimonialsTable;
use App\Models\LandingTestimonial;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class LandingTestimonialResource extends Resource
{
    protected static ?string $model = LandingTestimonial::class;

    protected static null|string|UnitEnum $navigationGroup = 'إدارة الصفحة الرئيسية';

    protected static ?string $navigationLabel = 'آراء العملاء';

    protected static ?string $modelLabel = 'رأي';

    protected static ?string $pluralModelLabel = 'آراء العملاء';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedStar;

    public static function form(Schema $schema): Schema
    {
        return LandingTestimonialForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LandingTestimonialsTable::configure($table);
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
            'index' => ListLandingTestimonials::route('/'),
            'create' => CreateLandingTestimonial::route('/create'),
            'edit' => EditLandingTestimonial::route('/{record}/edit'),
        ];
    }
}
