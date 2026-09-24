<?php

namespace App\Filament\Resources\BlogPosts\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BlogPostsTable
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
                    ->label('التصنيفات')
                    ->searchable()
                    ->separator(',')
                    ->limitList(2),
                TextColumn::make('author_name')
                    ->label('الكاتب')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('published_at')
                    ->label('تاريخ النشر')
                    ->dateTime()
                    ->sortable(),
                IconColumn::make('is_featured')
                    ->label('مميز')
                    ->boolean(),
                IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->reorderRecordsTriggerAction(function (Action $action): Action {
                return $action
                    ->label('ترتيب المقالات')
                    ->iconButton()
                    ->tooltip('اضغط ثم اسحب الصفوف لتغيير الترتيب')
                    ->color('gray');
            })
            ->filters([
                SelectFilter::make('categories')
                    ->label('التصنيفات')
                    ->relationship('categories', 'name')
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
