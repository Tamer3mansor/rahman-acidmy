<?php

namespace App\Filament\Resources\ErrorLogs\Tables;

use Filament\Actions\ViewAction;
use Filament\Infolists\Components\CodeEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ErrorLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('التاريخ')
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable(),
                TextColumn::make('exception')
                    ->label('نوع الخطأ')
                    ->searchable(),
                TextColumn::make('message')
                    ->label('الرسالة')
                    ->limit(90)
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('المستخدم')
                    ->placeholder('-'),
                TextColumn::make('url')
                    ->label('الرابط')
                    ->limit(45)
                    ->copyable(),
                TextColumn::make('ip')
                    ->label('العنوان'),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                ViewAction::make()
                    ->label('عرض')
                    ->infolist([
                        Grid::make([
                            'default' => 1,
                            'md' => 2,
                        ])
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('التاريخ')
                                    ->dateTime('Y-m-d H:i:s'),
                                TextEntry::make('exception')
                                    ->label('نوع الخطأ'),
                                TextEntry::make('code')
                                    ->label('الكود')
                                    ->placeholder('-'),
                                TextEntry::make('user.name')
                                    ->label('المستخدم')
                                    ->placeholder('-'),
                                TextEntry::make('url')
                                    ->label('الرابط')
                                    ->columnSpanFull(),
                                TextEntry::make('message')
                                    ->label('الرسالة')
                                    ->columnSpanFull(),
                                TextEntry::make('file')
                                    ->label('الملف')
                                    ->columnSpanFull(),
                                TextEntry::make('line')
                                    ->label('السطر'),
                                TextEntry::make('ip')
                                    ->label('العنوان'),
                            ]),
                        CodeEntry::make('trace_preview')
                            ->label('التتبع')
                            ->columnSpanFull(),
                    ]),
            ])
            ->toolbarActions([]);
    }
}
