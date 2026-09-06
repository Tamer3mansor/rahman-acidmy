<?php

namespace App\Filament\Resources\PricingPackages\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PricingPackageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات الباقة')
                    ->schema([
                        TextInput::make('name')
                            ->label('اسم الباقة')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('badge')
                            ->label('الشارة')
                            ->maxLength(50),
                        Select::make('badge_style')
                            ->label('نمط الشارة')
                            ->options([
                                'default' => 'افتراضي',
                                'gold' => 'ذهبي',
                                'green' => 'أخضر',
                            ])
                            ->default('default')
                            ->required(),
                        Textarea::make('description')
                            ->label('الوصف')
                            ->rows(2)
                            ->columnSpanFull(),
                        TextInput::make('classes_count')
                            ->label('عدد الحصص')
                            ->required()
                            ->numeric()
                            ->minValue(1),
                        TextInput::make('price_per_30')
                            ->label('سعر الحصة (30 دقيقة)')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->default(5.00),
                        TextInput::make('price_per_45')
                            ->label('سعر الحصة (45 دقيقة)')
                            ->numeric()
                            ->minValue(0)
                            ->default(7.50),
                        TextInput::make('price_per_60')
                            ->label('سعر الحصة (60 دقيقة)')
                            ->numeric()
                            ->minValue(0)
                            ->default(10.00),
                        Repeater::make('features')
                            ->label('المميزات')
                            ->schema([
                                TextInput::make('feature')
                                    ->label('ميزة')
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->defaultItems(3)
                            ->addActionLabel('إضافة ميزة')
                            ->reorderableWithButtons()
                            ->collapsible()
                            ->afterStateHydrated(function (Repeater $component, ?array $state): void {
                                if ($state !== null) {
                                    $component->state(array_map(fn (string $feature) => ['feature' => $feature], $state));
                                }
                            })
                            ->dehydrateStateUsing(fn (?array $state): array => array_column($state ?? [], 'feature'))
                            ->columnSpanFull(),
                    ])
                    ->columns(3),

                Section::make('الحالة')
                    ->schema([
                        Toggle::make('is_featured')
                            ->label('باقة مميزة')
                            ->default(false),
                        Toggle::make('is_active')
                            ->label('نشط')
                            ->default(true),
                        TextInput::make('sort_order')
                            ->label('ترتيب العرض')
                            ->required()
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(3),
            ]);
    }
}
