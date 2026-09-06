<?php

namespace App\Filament\Resources\JourneySteps\Schemas;

use App\Support\FontAwesomeIcons;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class JourneyStepForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات الخطوة')
                    ->schema([
                        TextInput::make('step_number')
                            ->label('رقم الخطوة')
                            ->required()
                            ->numeric(),
                        Select::make('icon')
                            ->label('الأيقونة')
                            ->options(FontAwesomeIcons::all())
                            ->searchable(),
                        TextInput::make('title')
                            ->label('العنوان')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        RichEditor::make('description')
                            ->label('الوصف')
                            ->extraAttributes(['style' => 'direction: rtl; text-align: right;'])
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
