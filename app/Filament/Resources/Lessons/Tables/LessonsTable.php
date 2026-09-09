<?php

namespace App\Filament\Resources\Lessons\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class LessonsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('العنوان')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('category')
                    ->label('الفئة')
                    ->badge()
                    ->sortable(),
                TextColumn::make('course.title')
                    ->label('الدورة المرتبطة')
                    ->placeholder('—')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('reading_time')
                    ->label('وقت القراءة')
                    ->sortable(),
                IconColumn::make('has_audio')
                    ->label('صوت')
                    ->state(fn ($record) => filled($record->audio_url))
                    ->boolean(),
                IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                SelectFilter::make('course')
                    ->label('الدورة المرتبطة')
                    ->relationship('course', 'title'),
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
