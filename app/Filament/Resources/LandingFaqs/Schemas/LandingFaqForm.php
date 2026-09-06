<?php

namespace App\Filament\Resources\LandingFaqs\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LandingFaqForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('السؤال والإجابة')
                    ->schema([
                        TextInput::make('question')
                            ->label('السؤال')
                            ->required()
                            ->maxLength(500)
                            ->columnSpanFull(),
                        RichEditor::make('answer')
                            ->label('الإجابة')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Section::make('زر الدعوة للإجراء (CTA)')
                    ->schema([
                        Toggle::make('show_cta')
                            ->label('إظهار زر CTA')
                            ->live()
                            ->default(false),
                        TextInput::make('cta_text')
                            ->label('نص الزر')
                            ->maxLength(255)
                            ->hidden(fn ($get) => ! $get('show_cta')),
                        TextInput::make('cta_url')
                            ->label('رابط الزر')
                            ->url()
                            ->hidden(fn ($get) => ! $get('show_cta')),
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
