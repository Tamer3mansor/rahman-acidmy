<?php

namespace App\Filament\Resources\Courses\Tables;

use App\Enums\CourseAudience;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CoursesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('العنوان')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('audience')
                    ->label('الفئة')
                    ->badge()
                    ->sortable(),
                TextColumn::make('session_minutes')
                    ->label('المدة (دقيقة)')
                    ->sortable(),
                TextColumn::make('age_band_min')
                    ->label('العمر')
                    ->formatStateUsing(fn ($record): string => $record->ageBandLabel() ?? '—')
                    ->sortable()
                    ->placeholder('—'),
                TextColumn::make('level_label')
                    ->label('المستوى')
                    ->toggleable()
                    ->placeholder('—'),
                IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                SelectFilter::make('audience')
                    ->label('الفئة')
                    ->options(CourseAudience::class),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
