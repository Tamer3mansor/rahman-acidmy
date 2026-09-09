<?php

namespace App\Filament\Resources\PricingPackages\Schemas;

use App\Models\PricingPackage;
use App\Models\PricingSettings;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
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
                    ])
                    ->columns(3),

                Section::make('التسعير')
                    ->description('اختر نوع التسعير: السعر/ساعة يُحسب تلقائياً من السعر العام، أو سعر خاص ثابت.')
                    ->schema([
                        Radio::make('pricing_type')
                            ->label('نوع التسعير')
                            ->options(PricingPackage::PRICING_TYPES)
                            ->default(PricingPackage::TYPE_SPECIAL)
                            ->required()
                            ->live()
                            ->columnSpanFull()
                            ->afterStateUpdated(function (Set $set, ?string $state): void {
                                if ($state === PricingPackage::TYPE_PER_HOUR) {
                                    $set('price', null);
                                }
                            }),
                        TextInput::make('hours')
                            ->label('عدد الساعات')
                            ->helperText('يُحسب السعر تلقائياً: عدد الساعات × السعر العام للساعة')
                            ->numeric()
                            ->minValue(0.25)
                            ->step(0.25)
                            ->live()
                            ->required(fn (Get $get): bool => $get('pricing_type') === PricingPackage::TYPE_PER_HOUR)
                            ->afterStateUpdated(function (Set $set, ?string $state): void {
                                $perHour = PricingSettings::singleton()->per_hour_price;

                                $set('price', $state !== null && $state !== '' ? round((float) $state * $perHour, 2) : null);
                            })
                            ->hint(fn (Get $get): string => match ($get('pricing_type')) {
                                PricingPackage::TYPE_PER_HOUR => 'السعر المحسوب: '.number_format(round((float) ($get('hours') ?? 0) * PricingSettings::singleton()->per_hour_price, 2), 2).' €',
                                default => '',
                            })
                            ->visible(fn (Get $get): bool => $get('pricing_type') === PricingPackage::TYPE_PER_HOUR),
                        TextInput::make('price')
                            ->label('السعر (€)')
                            ->helperText('سعر ثابت يُعتمد كما هو.')
                            ->numeric()
                            ->minValue(0)
                            ->suffix('€')
                            ->default(0)
                            ->dehydrated()
                            ->required(fn (Get $get): bool => $get('pricing_type') === PricingPackage::TYPE_SPECIAL)
                            ->visible(fn (Get $get): bool => $get('pricing_type') === PricingPackage::TYPE_SPECIAL),
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
                                if ($state === null) {
                                    return;
                                }

                                $component->state(array_map(
                                    fn (string|array $item) => is_array($item) ? $item : ['feature' => $item],
                                    $state,
                                ));
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
