<?php

namespace App\Filament\Resources\ContactSubmissions\Tables;

use App\Enums\StudentLevel;
use App\Enums\SubmissionStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ContactSubmissionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student_name')
                    ->label('اسم الطالب')
                    ->searchable(),
                TextColumn::make('parent_name')
                    ->label('ولي الأمر')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('الهاتف')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('البريد')
                    ->searchable(),
                TextColumn::make('level')
                    ->label('المستوى')
                    ->formatStateUsing(fn (StudentLevel $state): string => $state->getLabel())
                    ->badge(),
                TextColumn::make('status')
                    ->label('الحالة')
                    ->formatStateUsing(fn (SubmissionStatus $state): string => $state->getLabel())
                    ->badge()
                    ->color(fn (SubmissionStatus $state): string => $state->color()),
                TextColumn::make('created_at')
                    ->label('تاريخ الإرسال')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('الحالة')
                    ->options(collect(SubmissionStatus::cases())->mapWithKeys(
                        fn (SubmissionStatus $status): array => [$status->value => $status->getLabel()]
                    )->all()),
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
