<?php

namespace App\Filament\Resources\LessonCategories;

use App\Filament\Resources\LessonCategories\Pages\CreateLessonCategory;
use App\Filament\Resources\LessonCategories\Pages\EditLessonCategory;
use App\Filament\Resources\LessonCategories\Pages\ListLessonCategories;
use App\Filament\Resources\LessonCategories\Schemas\LessonCategoryForm;
use App\Filament\Resources\LessonCategories\Tables\LessonCategoriesTable;
use App\Models\LessonCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class LessonCategoryResource extends Resource
{
    protected static ?string $model = LessonCategory::class;

    protected static UnitEnum|string|null $navigationGroup = 'الحصص المجانية';

    protected static ?string $navigationLabel = 'التصنيفات';

    protected static ?string $modelLabel = 'تصنيف';

    protected static ?string $pluralModelLabel = 'التصنيفات';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return LessonCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LessonCategoriesTable::configure($table);
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
            'index' => ListLessonCategories::route('/'),
            'create' => CreateLessonCategory::route('/create'),
            'edit' => EditLessonCategory::route('/{record}/edit'),
        ];
    }
}
