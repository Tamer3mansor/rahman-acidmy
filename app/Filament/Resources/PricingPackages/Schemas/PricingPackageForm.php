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
                    ->description('اختر نوع التسعير: تسعير عام يُحسب من السعر العام للساعة، أو تسعير خاص بسعر ساعة مخفّض يظهر كعرض على البطاقة. السعر الكلي = عدد الحصص × مدة الدرس (30/45/60 دقيقة) × السعر.')
                    ->schema([
                        Radio::make('pricing_type')
                            ->label('نوع التسعير')
                            ->options(PricingPackage::PRICING_TYPES)
                            ->default(PricingPackage::TYPE_PER_HOUR)
                            ->required()
                            ->live()
                            ->columnSpanFull()
                            ->afterStateUpdated(function (Get $get, Set $set, ?string $state): void {
                                if ($state === PricingPackage::TYPE_PER_HOUR) {
                                    $set('price', null);
                                }
                            }),
                        TextInput::make('price')
                            ->label('السعر الخاص (€/ساعة)')
                            ->helperText(fn (Get $get): string => $get('pricing_type') === PricingPackage::TYPE_SPECIAL
                                ? 'سعر الساعة الخاص بهذه الباقة. يُحسب السعر الكلي: عدد الحصص × مدة الدرس × هذا السعر.'
                                : 'يُعتمد السعر العام للساعة ('.\number_format(PricingSettings::singleton()->per_hour_price, 2).' €) عند التسعير العام.')
                            ->numeric()
                            ->minValue(0.5)
                            ->step(0.5)
                            ->suffix('€/ساعة')
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

                Section::make('زر واتساب')
                    ->description('نص الزر ورقم الواتساب الذي يفتحه عند النقر. إذا تُرك الرقم فارغاً يُستخدم الرقم الافتراضي العام.')
                    ->schema([
                        TextInput::make('button_label')
                            ->label('اسم الزر')
                            ->helperText('الافتراضي: Ce pack me convient')
                            ->maxLength(100)
                            ->placeholder('Ce pack me convient'),
                        TextInput::make('whatsapp_url')
                            ->label('رابط واتساب')
                            ->helperText('مثال: https://wa.me/201028268553')
                            ->url()
                            ->placeholder('https://wa.me/20201028268553'),
                    ])
                    ->columns(2),

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
