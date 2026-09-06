<?php

namespace App\Filament\Resources\PricingPackages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PricingPackagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('الباقة')
                    ->searchable(),
                TextColumn::make('classes_count')
                    ->label('عدد الحصص')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('price_per_30')
                    ->label('سعر 30 دقيقة (€)')
                    ->money('EUR')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('price_per_45')
                    ->label('سعر 45 دقيقة (€)')
                    ->money('EUR')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('price_per_60')
                    ->label('سعر 60 دقيقة (€)')
                    ->money('EUR')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('features')
                    ->label('المميزات')
                    ->formatStateUsing(fn (mixed $state): int => is_array($state) ? count($state) : 0)
                    ->badge(),
                IconColumn::make('is_featured')
                    ->label('مميزة')
                    ->boolean(),
                IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean(),
                TextColumn::make('sort_order')
                    ->label('الترتيب')
                    ->numeric()
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
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
