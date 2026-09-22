<?php

namespace App\Filament\Resources\LandingFaqs\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
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

                Section::make('أزرار الدعوة للإجراء (CTA)')
                    ->description('لكل سؤال زرّا دعوة يتحكم بهما المشرف. الرابط «#» يُمرّر المستخدم لنموذج التواصل.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Toggle::make('show_cta')
                                    ->label('إظهار الزر الأول')
                                    ->live()
                                    ->default(false),
                                Toggle::make('show_cta2')
                                    ->label('إظهار الزر الثاني')
                                    ->live()
                                    ->default(false),
                                TextInput::make('cta_text')
                                    ->label('نص الزر الأول')
                                    ->maxLength(255)
                                    ->placeholder('مثال: احجز جلسة تجريبية مجانية')
                                    ->disabled(fn ($get) => ! $get('show_cta')),
                                TextInput::make('cta2_text')
                                    ->label('نص الزر الثاني')
                                    ->maxLength(255)
                                    ->placeholder('مثال: تواصل عبر واتساب')
                                    ->disabled(fn ($get) => ! $get('show_cta2')),
                                TextInput::make('cta_url')
                                    ->label('رابط الزر الأول')
                                    ->url()
                                    ->placeholder('# أو https://...')
                                    ->helperText('«#» للتمرير لنموذج التواصل.')
                                    ->disabled(fn ($get) => ! $get('show_cta')),
                                TextInput::make('cta2_url')
                                    ->label('رابط الزر الثاني')
                                    ->url()
                                    ->placeholder('# أو https://...')
                                    ->helperText('«#» للتمرير لنموذج التواصل.')
                                    ->disabled(fn ($get) => ! $get('show_cta2')),
                            ]),
                    ]),

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
