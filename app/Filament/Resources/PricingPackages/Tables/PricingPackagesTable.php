<?php

namespace App\Filament\Resources\PricingPackages\Tables;

use App\Models\PricingPackage;
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
                TextColumn::make('pricing_type')
                    ->label('نوع التسعير')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => PricingPackage::PRICING_TYPES[$state] ?? $state)
                    ->color(fn (string $state): string => $state === PricingPackage::TYPE_PER_HOUR ? 'success' : 'gray'),
                TextColumn::make('price')
                    ->label('السعر الإجمالي (€)')
                    ->money('EUR')
                    ->sortable()
                    ->formatStateUsing(fn (PricingPackage $record): float => $record->effectivePrice()),
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
