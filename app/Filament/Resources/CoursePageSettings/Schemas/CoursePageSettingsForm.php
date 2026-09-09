<?php

namespace App\Filament\Resources\CoursePageSettings\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class CoursePageSettingsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make()
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('صفحة الأطفال')
                            ->schema([
                                Section::make('نصوص رأس الصفحة')
                                    ->schema([
                                        TextInput::make('kids_label')->label('التسمية')->required()->columnSpan(3),
                                        TextInput::make('kids_badge')->label('الشارة')->required()->columnSpan(3),
                                        TextInput::make('kids_title')->label('العنوان')->required()->columnSpan(3),
                                        TextInput::make('kids_title_accent')->label('الجزء المميز من العنوان')->columnSpan(3),
                                        Textarea::make('kids_subtitle')->label('الوصف')->required()->columnSpanFull()->rows(2),
                                    ])
                                    ->columns(6),
                                Section::make('الأزرار')
                                    ->schema([
                                        TextInput::make('kids_cta_title')->label('نص زر الحث')->required()->columnSpan(2),
                                        TextInput::make('kids_wa_title')->label('نص زر واتساب')->required()->columnSpan(2),
                                        TextInput::make('kids_wa_url')->label('رابط واتساب')->columnSpan(2),
                                    ])
                                    ->columns(2),

                                Section::make('بطاقة عرض البطل')
                                    ->schema([
                                        TextInput::make('kids_showcase_emoji')->label('إيموجي البطاقة')->default('📖 ✨')->columnSpan(2),
                                        TextInput::make('kids_showcase_title')->label('عنوان البطاقة')->columnSpan(2),
                                        Textarea::make('kids_showcase_subtitle')->label('وصف البطاقة')->rows(2)->columnSpanFull(),
                                    ])
                                    ->columns(2),
                            ]),
                        Tab::make('صفحة الكبار')
                            ->schema([
                                Section::make('نصوص رأس الصفحة')
                                    ->schema([
                                        TextInput::make('adults_label')->label('التسمية')->required()->columnSpan(3),
                                        TextInput::make('adults_badge')->label('الشارة')->required()->columnSpan(3),
                                        TextInput::make('adults_title')->label('العنوان')->required()->columnSpan(3),
                                        TextInput::make('adults_title_accent')->label('الجزء المميز من العنوان')->columnSpan(3),
                                        Textarea::make('adults_subtitle')->label('الوصف')->required()->columnSpanFull()->rows(2),
                                    ])
                                    ->columns(6),
                                Section::make('الأزرار')
                                    ->schema([
                                        TextInput::make('adults_cta_title')->label('نص زر الحث')->required()->columnSpan(2),
                                        TextInput::make('adults_wa_title')->label('نص زر واتساب')->required()->columnSpan(2),
                                        TextInput::make('adults_wa_url')->label('رابط واتساب')->columnSpan(2),
                                    ])
                                    ->columns(2),

                                Section::make('بطاقة عرض البطل')
                                    ->schema([
                                        TextInput::make('adults_showcase_emoji')->label('إيموجي البطاقة')->default('📖')->columnSpan(2),
                                        TextInput::make('adults_showcase_title')->label('عنوان البطاقة')->columnSpan(2),
                                        Textarea::make('adults_showcase_subtitle')->label('وصف البطاقة')->rows(2)->columnSpanFull(),
                                    ])
                                    ->columns(2),
                            ]),
                        Tab::make('صفحة تفاصيل الدورة')
                            ->schema([
                                Section::make('نصوص الحجز والاستمارة')
                                    ->schema([
                                        TextInput::make('details_cta_title')->label('نص زر الحث')->required()->columnSpan(2),
                                        TextInput::make('details_booking_title')->label('عنوان الحجز')->required()->columnSpan(2),
                                        TextInput::make('details_form_title')->label('عنوان الاستمارة')->required()->columnSpan(2),
                                        Textarea::make('details_booking_subtitle')->label('وصف الحجز')->required()->columnSpanFull()->rows(2),
                                        TextInput::make('details_booking_note')->label('ملاحظة الحجز')->columnSpan(2),
                                    ])
                                    ->columns(3),
                            ]),
                        Tab::make('تحسين محركات البحث (SEO)')
                            ->schema([
                                Section::make('إعدادات SEO العامة لصفحات الكورسات')
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
                                        Toggle::make('is_indexed')
                                            ->label('السماح لفهارس البحث (Allow search engine indexing)')
                                            ->default(true),
                                    ])
                                    ->columns(2),
                            ]),
                    ]),

                Section::make('الحالة')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('نشط')
                            ->default(true),
                    ])
                    ->columns(1),
            ]);
    }
}
