<?php

namespace App\Filament\Resources\LandingSettings\Schemas;

use App\Enums\MediaType;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class LandingSettingsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make()
                    ->columnSpanFull()
                    ->tabs([

                        Tab::make('الترويسة')
                            ->schema([
                                Section::make('الشعار والاسم')
                                    ->schema([
                                        FileUpload::make('header_logo_path')
                                            ->label('شعار الهيدر')
                                            ->image()
                                            ->disk('public')
                                            ->directory('landing/header')
                                            ->helperText('يظهر في شريط التنقل أعلى الصفحة. اتركه فارغاً لاستخدام الأيقونة الافتراضية')
                                            ->columnSpanFull(),
                                        TextInput::make('header_brand_name')
                                            ->label('اسم العلامة التجارية')
                                            ->maxLength(255),
                                        TextInput::make('header_brand_sub')
                                            ->label('الشعار الفرعي')
                                            ->helperText('مثال: ACADEMY')
                                            ->maxLength(255),
                                    ])
                                    ->columns(2),

                                Section::make('الأزرار')
                                    ->schema([
                                        TextInput::make('header_btn1_title')
                                            ->label('نص الزر الأول')
                                            ->maxLength(255),
                                        TextInput::make('header_btn1_url')
                                            ->label('رابط الزر الأول')
                                            ->maxLength(255),
                                        TextInput::make('header_btn2_title')
                                            ->label('نص الزر الثاني')
                                            ->maxLength(255),
                                        TextInput::make('header_btn2_url')
                                            ->label('رابط الزر الثاني')
                                            ->maxLength(255),
                                    ])
                                    ->columns(2),
                            ]),

                        Tab::make('الهيرو')
                            ->schema([
                                Section::make('نص الهيرو')
                                    ->schema([
                                        TextInput::make('hero_badge')
                                            ->label('الشارة')
                                            ->maxLength(255),
                                        TextInput::make('hero_title')
                                            ->label('العنوان الرئيسي')
                                            ->columnSpan(2)
                                            ->maxLength(255),
                                        TextInput::make('hero_title_accent')
                                            ->label('العنوان المميز (بالذهب)')
                                            ->maxLength(255),
                                        RichEditor::make('hero_subtitle')
                                            ->label('العنوان الفرعي')
                                            ->extraAttributes(['style' => 'direction: rtl; text-align: right;'])
                                            ->columnSpan(2),
                                    ])
                                    ->columns(2),

                                Section::make('الأزرار')
                                    ->schema([
                                        TextInput::make('hero_btn1_title')
                                            ->label('نص الزر الأساسي')
                                            ->maxLength(255),
                                        TextInput::make('hero_btn1_url')
                                            ->label('رابط الزر الأساسي')
                                            ->url()
                                            ->maxLength(255),
                                        TextInput::make('hero_btn2_title')
                                            ->label('نص الزر الثانوي')
                                            ->maxLength(255),
                                        TextInput::make('hero_btn2_url')
                                            ->label('رابط الزر الثانوي')
                                            ->url()
                                            ->maxLength(255),
                                    ])
                                    ->columns(2),

                                Section::make('وسائط الهيرو')
                                    ->schema([
                                        Select::make('hero_media_type')
                                            ->label('نوع الوسائط')
                                            ->options(MediaType::class)
                                            ->enum(MediaType::class)
                                            ->default(MediaType::Video->value)
                                            ->live(),
                                        FileUpload::make('hero_video_path')
                                            ->label('ملف الوسائط (فيديو أو صورة)')
                                            ->acceptedFileTypes(['video/mp4', 'video/quicktime', 'video/webm', 'image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                                            ->directory('hero-media')
                                            ->disk('public')
                                            ->helperText('ارفع صورة أو فيديو — منطبقاً على نوع الوسائط. فيديو (mp4/mov/webm) أو صورة (jpg/png/webp).')
                                            ->columnSpan(2),
                                        Toggle::make('hero_video_autoplay')
                                            ->label('تشغيل تلقائي')
                                            ->hidden(fn (Get $get): bool => $get('hero_media_type') !== MediaType::Video),
                                        Toggle::make('hero_video_loop')
                                            ->label('تكرار الفيديو')
                                            ->hidden(fn (Get $get): bool => $get('hero_media_type') !== MediaType::Video),
                                    ])
                                    ->columns(2),
                            ]),

                        Tab::make('شهادات العملاء')
                            ->schema([
                                TextInput::make('trust_label')
                                    ->label('التسمية')
                                    ->maxLength(255),
                                TextInput::make('trust_title')
                                    ->label('العنوان')
                                    ->columnSpan(2)
                                    ->maxLength(255),
                                RichEditor::make('trust_subtitle')
                                    ->label('العنوان الفرعي')
                                    ->extraAttributes(['style' => 'direction: rtl; text-align: right;'])
                                    ->columnSpan(2),
                                TextInput::make('trust_cta_title')
                                    ->label('نص زر الدعوة')
                                    ->columnSpan(2)
                                    ->maxLength(255),
                            ]),

                        Tab::make('الخطوات')
                            ->schema([
                                TextInput::make('journey_label')
                                    ->label('التسمية')
                                    ->maxLength(255),
                                TextInput::make('journey_title')
                                    ->label('العنوان')
                                    ->columnSpan(2)
                                    ->maxLength(255),
                                RichEditor::make('journey_subtitle')
                                    ->label('العنوان الفرعي')
                                    ->extraAttributes(['style' => 'direction: rtl; text-align: right;'])
                                    ->columnSpan(2),
                                TextInput::make('journey_cta_title')
                                    ->label('نص زر الدعوة')
                                    ->columnSpan(2)
                                    ->maxLength(255),
                            ]),

                        Tab::make('المقارنة')
                            ->schema([
                                TextInput::make('compare_label')
                                    ->label('التسمية')
                                    ->maxLength(255),
                                TextInput::make('compare_title')
                                    ->label('العنوان')
                                    ->columnSpan(2)
                                    ->maxLength(255),
                                RichEditor::make('compare_subtitle')
                                    ->label('العنوان الفرعي')
                                    ->extraAttributes(['style' => 'direction: rtl; text-align: right;'])
                                    ->columnSpan(2),
                                TextInput::make('compare_problems_title')
                                    ->label('عنوان عمود المشكلات')
                                    ->maxLength(255),
                                TextInput::make('compare_solutions_title')
                                    ->label('عنوان عمود الحلول')
                                    ->maxLength(255),
                                TextInput::make('compare_cta_title')
                                    ->label('نص زر الدعوة')
                                    ->columnSpan(2)
                                    ->maxLength(255),
                            ])
                            ->columns(2),

                        Tab::make('المعلمون')
                            ->schema([
                                TextInput::make('teachers_label')
                                    ->label('التسمية')
                                    ->maxLength(255),
                                TextInput::make('teachers_title')
                                    ->label('العنوان')
                                    ->columnSpan(2)
                                    ->maxLength(255),
                                RichEditor::make('teachers_subtitle')
                                    ->label('العنوان الفرعي')
                                    ->extraAttributes(['style' => 'direction: rtl; text-align: right;'])
                                    ->columnSpan(2),
                                TextInput::make('teachers_cta_title')
                                    ->label('نص زر الدعوة')
                                    ->columnSpan(2)
                                    ->maxLength(255),
                            ]),

                        Tab::make('الأسئلة الشائعة')
                            ->schema([
                                TextInput::make('faq_label')
                                    ->label('التسمية')
                                    ->maxLength(255),
                                TextInput::make('faq_title')
                                    ->label('العنوان')
                                    ->columnSpan(2)
                                    ->maxLength(255),
                                RichEditor::make('faq_subtitle')
                                    ->label('العنوان الفرعي')
                                    ->extraAttributes(['style' => 'direction: rtl; text-align: right;'])
                                    ->columnSpan(2),
                            ]),

                        Tab::make('نموذج التواصل')
                            ->schema([
                                TextInput::make('form_label')
                                    ->label('التسمية')
                                    ->maxLength(255),
                                TextInput::make('form_title')
                                    ->label('العنوان')
                                    ->maxLength(255),
                                TextInput::make('form_title_accent')
                                    ->label('العنوان المميز (بالذهب)')
                                    ->maxLength(255),
                                RichEditor::make('form_subtitle')
                                    ->label('النص الجانبي')
                                    ->extraAttributes(['style' => 'direction: rtl; text-align: right;'])
                                    ->columnSpan(2),
                                TextInput::make('form_card_title')
                                    ->label('عنوان البطاقة')
                                    ->maxLength(255),
                                RichEditor::make('form_card_subtitle')
                                    ->label('العنوان الفرعي للبطاقة')
                                    ->extraAttributes(['style' => 'direction: rtl; text-align: right;'])
                                    ->columnSpan(2),
                                RichEditor::make('form_note')
                                    ->label('ملاحظة إضافية')
                                    ->extraAttributes(['style' => 'direction: rtl; text-align: right;'])
                                    ->columnSpan(2),
                                TextInput::make('form_privacy_note')
                                    ->label('ملاحظة الخصوصية')
                                    ->columnSpan(2)
                                    ->maxLength(255),
                            ])
                            ->columns(2),

                        Tab::make('الفوتر')
                            ->schema([
                                TextInput::make('footer_brand_name')
                                    ->label('اسم العلامة التجارية')
                                    ->maxLength(255),
                                TextInput::make('footer_brand_sub')
                                    ->label('الشعار الفرعي')
                                    ->maxLength(255),
                                RichEditor::make('footer_description')
                                    ->label('الوصف')
                                    ->extraAttributes(['style' => 'direction: rtl; text-align: right;'])
                                    ->columnSpan(2),
                                TextInput::make('footer_copyright')
                                    ->label('نص الحقوق')
                                    ->columnSpan(2)
                                    ->maxLength(255),
                            ]),
                    ]),
            ]);
    }
}
