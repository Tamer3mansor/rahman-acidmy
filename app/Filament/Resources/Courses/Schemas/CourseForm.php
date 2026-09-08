<?php

namespace App\Filament\Resources\Courses\Schemas;

use App\Enums\CourseAudience;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('معلومات الدورة')
                    ->description('بيانات أساسية تُعرض في بطاقات الدورة وقوائم الفئات.')
                    ->schema([
                        Select::make('audience')
                            ->label('الفئة المستهدفة')
                            ->options(CourseAudience::class)
                            ->required()
                            ->columnSpan(1),
                        TextInput::make('title')
                            ->label('العنوان')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', str($state)->slug()))
                            ->columnSpan(1),
                        TextInput::make('slug')
                            ->label('الرابط (Slug)')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->columnSpan(1),
                        TextInput::make('icon')
                            ->label('الأيقونة (إيموجي)')
                            ->maxLength(10)
                            ->default('📖')
                            ->columnSpan(1),
                        TextInput::make('card_theme')
                            ->label('لون رأس البطاقة')
                            ->maxLength(30)
                            ->default('green')
                            ->columnSpan(1),
                        TextInput::make('short_description')
                            ->label('وصف مختصر')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        RichEditor::make('description')
                            ->label('الوصف التفصيلي')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columns(3)
                    ->collapsible(),

                Section::make('معلومات الحصة والمستوى')
                    ->schema([
                        TextInput::make('age_band_min')
                            ->label('الحد الأدنى للعمر')
                            ->numeric()
                            ->minValue(0)
                            ->columnSpan(1),
                        TextInput::make('age_band_max')
                            ->label('الحد الأقصى للعمر')
                            ->numeric()
                            ->minValue(0)
                            ->columnSpan(1),
                        TextInput::make('session_minutes')
                            ->label('مدة الحصة (دقائق)')
                            ->numeric()
                            ->required()
                            ->default(45)
                            ->columnSpan(1),
                        TextInput::make('level_label')
                            ->label('المستوى')
                            ->maxLength(100)
                            ->columnSpan(1),
                    ])
                    ->columns(4)
                    ->collapsible(),

                Tabs::make()
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('ماذا سيتعلم')
                            ->schema([
                                Repeater::make('curriculum_items')
                                    ->label('نقاط التعلم')
                                    ->schema([
                                        TextInput::make('icon')->label('الأيقونة')->maxLength(10)->columnSpan(1),
                                        TextInput::make('title')->label('العنوان')->required()->columnSpan(1),
                                        Textarea::make('description')->label('الوصف')->columnSpanFull(),
                                    ])
                                    ->columns(2)
                                    ->defaultItems(2)
                                    ->addActionLabel('إضافة نقطة')
                                    ->reorderableWithButtons()
                                    ->collapsible(),
                            ]),
                        Tab::make('كيف تكون الحصة')
                            ->schema([
                                Repeater::make('session_features')
                                    ->label('مميزات الحصة')
                                    ->schema([
                                        TextInput::make('title')->label('العنوان')->required()->columnSpan(1),
                                        Textarea::make('description')->label('الوصف')->columnSpan(1),
                                    ])
                                    ->columns(2)
                                    ->defaultItems(2)
                                    ->addActionLabel('إضافة ميزة')
                                    ->reorderableWithButtons()
                                    ->collapsible(),
                            ]),
                        Tab::make('الرحلة')
                            ->schema([
                                Repeater::make('journey_steps')
                                    ->label('خطوات الرحلة')
                                    ->schema([
                                        TextInput::make('htmlClass')->label('النمط (gold / dark-green)')->maxLength(30)->columnSpan(1),
                                        TextInput::make('number')->label('الرقم')->maxLength(10)->columnSpan(1),
                                        TextInput::make('title')->label('العنوان')->required()->columnSpan(1),
                                        Textarea::make('description')->label('الوصف')->columnSpanFull(),
                                    ])
                                    ->columns(3)
                                    ->defaultItems(5)
                                    ->addActionLabel('إضافة خطوة')
                                    ->reorderableWithButtons()
                                    ->collapsible(),
                            ]),
                        Tab::make('مناسب لـ')
                            ->schema([
                                Repeater::make('suitability_checks')
                                    ->label('نقاط الملاءمة')
                                    ->schema([
                                        TextInput::make('text')->label('نقطة الملاءمة')->required(),
                                    ])
                                    ->defaultItems(1)
                                    ->addActionLabel('إضافة نقطة')
                                    ->reorderableWithButtons()
                                    ->collapsible()
                                    ->afterStateHydrated(function (Repeater $component, ?array $state): void {
                                        if ($state === null) {
                                            return;
                                        }

                                        $component->state(array_map(
                                            fn (string|array $item) => is_array($item) ? $item : ['text' => $item],
                                            $state,
                                        ));
                                    })
                                    ->dehydrateStateUsing(fn (?array $state): array => array_column($state ?? [], 'text')),
                            ]),
                        Tab::make('الأسئلة الشائعة')
                            ->schema([
                                Repeater::make('faqs')
                                    ->label('الأسئلة الشائعة')
                                    ->schema([
                                        TextInput::make('question')->label('السؤال')->required()->columnSpan(1),
                                        Textarea::make('answer')->label('الإجابة')->required()->columnSpan(1),
                                    ])
                                    ->columns(2)
                                    ->defaultItems(3)
                                    ->addActionLabel('إضافة سؤال')
                                    ->reorderableWithButtons()
                                    ->collapsible(),
                            ]),
                    ]),

                Section::make('الحالة')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('نشط')
                            ->default(true),
                        TextInput::make('sort_order')
                            ->label('ترتيب العرض')
                            ->numeric()
                            ->required()
                            ->default(0),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ]);
    }
}
