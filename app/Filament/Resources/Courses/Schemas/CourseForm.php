<?php

namespace App\Filament\Resources\Courses\Schemas;

use App\Enums\CourseAudience;
use Filament\Forms\Components\FileUpload;
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
                        Select::make('card_theme')
                            ->label('لون رأس البطاقة')
                            ->options([
                                'green' => 'أخضر',
                                'teal' => 'أزرق مخضر',
                                'amber' => 'ذهبي',
                                'indigo' => 'نيلي',
                                'emerald' => 'زمردي',
                                'dark-green' => 'أخضر داكن',
                            ])
                            ->searchable()
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
                                        RichEditor::make('description')->label('الوصف')->columnSpanFull(),
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
                                        RichEditor::make('description')->label('الوصف')->columnSpan(1),
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
                                        Select::make('htmlClass')
                                            ->label('النمط')
                                            ->options([
                                                'gold' => 'ذهبي',
                                                'dark-green' => 'أخضر داكن',
                                            ])
                                            ->searchable()
                                            ->columnSpan(1),
                                        TextInput::make('number')->label('الرقم')->maxLength(10)->columnSpan(1),
                                        TextInput::make('title')->label('العنوان')->required()->columnSpan(1),
                                        RichEditor::make('description')->label('الوصف')->columnSpanFull(),
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
                                        RichEditor::make('answer')->label('الإجابة')->required()->columnSpan(1),
                                    ])
                                    ->columns(2)
                                    ->defaultItems(3)
                                    ->addActionLabel('إضافة سؤال')
                                    ->reorderableWithButtons()
                                    ->collapsible(),
                            ]),
                        Tab::make('تحسين محركات البحث (SEO)')
                            ->schema([
                                TextInput::make('meta_title')
                                    ->label('عنوان الميتا (Meta Title)')
                                    ->helperText('يُوصى بألا يتجاوز 60 حرفاً')
                                    ->maxLength(60)
                                    ->live()
                                    ->hint(fn (?string $state): string => mb_strlen((string) $state).'/60')
                                    ->columnSpan(1),
                                Textarea::make('meta_description')
                                    ->label('وصف الميتا (Meta Description)')
                                    ->helperText('يُوصى بألا يتجاوز 160 حرفاً')
                                    ->maxLength(160)
                                    ->rows(3)
                                    ->live()
                                    ->hint(fn (?string $state): string => mb_strlen((string) $state).'/160')
                                    ->columnSpan(1),
                                FileUpload::make('og_image')
                                    ->label('صورة المشاركة (Open Graph)')
                                    ->image()
                                    ->disk('public')
                                    ->directory('images/og')
                                    ->imageResizeMode('contain')
                                    ->imageResizeTargetWidth('1200')
                                    ->imageResizeTargetHeight('630')
                                    ->columnSpan(1),
                                Select::make('schema_type')
                                    ->label('نوع Schema')
                                    ->options([
                                        'EducationalOrganization' => 'EducationalOrganization',
                                        'Course' => 'Course',
                                        'FAQPage' => 'FAQPage',
                                        'Article' => 'Article',
                                    ])
                                    ->default('Course')
                                    ->columnSpan(1),
                                Toggle::make('is_indexed')
                                    ->label('السماح لفهارس البحث (Allow search engine indexing)')
                                    ->default(true),
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
