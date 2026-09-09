<?php

namespace App\Filament\Resources\BlogPosts\Tables;

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
                    ->sortable()
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
            ->defaultSort('published_at', 'desc')
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
