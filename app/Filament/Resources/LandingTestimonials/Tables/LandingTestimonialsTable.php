<?php

namespace App\Filament\Resources\LandingTestimonials\Tables;

use App\Enums\TestimonialType;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LandingTestimonialsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')
                    ->label('النوع')
                    ->formatStateUsing(fn (TestimonialType $state): string => $state->getLabel())
                    ->badge()
                    ->color(fn (TestimonialType $state): string => $state->color()),
                TextColumn::make('author_name')
                    ->label('الاسم')
                    ->searchable(),
                TextColumn::make('author_location')
                    ->label('الموقع')
                    ->searchable(),
                TextColumn::make('rating')
                    ->label('التقييم')
                    ->numeric()
                    ->sortable(),
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
            ->filters([
                //
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
