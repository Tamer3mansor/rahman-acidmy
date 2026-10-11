<?php

namespace App\Filament\Resources\Lessons\Tables;

use Filament\Actions\Action;
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
                TextColumn::make('categories.name')
                    ->label('الفئات')
                    ->badge(),
                TextColumn::make('courses.title')
                    ->label('الدورات المرتبطة')
                    ->badge(),
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
            ->reorderable('sort_order')
            ->reorderRecordsTriggerAction(function (Action $action): Action {
                return $action
                    ->label('ترتيب الحصص')
                    ->iconButton()
                    ->tooltip('اضغط ثم اسحب الصفوف لتغيير الترتيب')
                    ->color('gray');
            })
            ->filters([
                SelectFilter::make('categories')
                    ->label('الفئة')
                    ->relationship('categories', 'name')
                    ->multiple(),
                SelectFilter::make('courses')
                    ->label('الدورات المرتبطة')
                    ->relationship('courses', 'title')
                    ->multiple(),
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
