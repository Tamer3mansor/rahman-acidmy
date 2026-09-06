<?php

namespace App\Filament\Resources\LandingTeachers;

use App\Filament\Resources\LandingTeachers\Pages\CreateLandingTeacher;
use App\Filament\Resources\LandingTeachers\Pages\EditLandingTeacher;
use App\Filament\Resources\LandingTeachers\Pages\ListLandingTeachers;
use App\Filament\Resources\LandingTeachers\Schemas\LandingTeacherForm;
use App\Filament\Resources\LandingTeachers\Tables\LandingTeachersTable;
use App\Models\LandingTeacher;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class LandingTeacherResource extends Resource
{
    protected static ?string $model = LandingTeacher::class;

    protected static null|string|UnitEnum $navigationGroup = 'إدارة الصفحة الرئيسية';

    protected static ?string $navigationLabel = 'المعلمين';

    protected static ?string $modelLabel = 'معلم';

    protected static ?string $pluralModelLabel = 'المعلمين';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    public static function form(Schema $schema): Schema
    {
        return LandingTeacherForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LandingTeachersTable::configure($table);
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
            'index' => ListLandingTeachers::route('/'),
            'create' => CreateLandingTeacher::route('/create'),
            'edit' => EditLandingTeacher::route('/{record}/edit'),
        ];
    }
}
