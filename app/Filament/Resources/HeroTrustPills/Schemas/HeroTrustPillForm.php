<?php

namespace App\Filament\Resources\HeroTrustPills\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HeroTrustPillForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات الشارة')
                    ->schema([
                        TextInput::make('icon')
                            ->label('الأيقونة (إيموجي)')
                            ->maxLength(50)
                            ->placeholder('أدخل إيموجي أو رمزاً نصياً'),
                        TextInput::make('text')
                            ->label('النص')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('الحالة')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('نشط')
                            ->default(true),
                        TextInput::make('sort_order')
                            ->label('ترتيب العرض')
                            ->required()
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(2),
            ]);
    }
}
