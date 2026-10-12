<?php

namespace App\Filament\Resources\LandingWhyItems\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LandingWhyItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات البند')
                    ->schema([
                        TextInput::make('icon')
                            ->label('الأيقونة (إيموجي)')
                            ->helperText('إيموجي واحد فقط، مثال 📖 — لو سايبها فاضية هتظهر أيقونة افتراضية.')
                            ->maxLength(16)
                            ->columnSpan(1),
                        TextInput::make('title')
                            ->label('العنوان')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),
                        Textarea::make('description')
                            ->label('الوصف')
                            ->rows(3)
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
