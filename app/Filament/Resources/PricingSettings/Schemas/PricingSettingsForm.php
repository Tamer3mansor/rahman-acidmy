<?php

namespace App\Filament\Resources\PricingSettings\Schemas;

use App\Rules\CtaUrl;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PricingSettingsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('هيرو الصفحة')
                    ->description('الجزء العلوي من صفحة الأسعار — تُترك فارغة للعودة إلى النص الافتراضي.')
                    ->schema([
                        TextInput::make('hero_label')
                            ->label('التسمية')
                            ->helperText('السطر الصغير فوق العنوان — مثال: Première séance gratuite')
                            ->placeholder('Première séance gratuite')
                            ->maxLength(100)
                            ->columnSpan(1),
                        TextInput::make('hero_label_icon')
                            ->label('أيقونة التسمية')
                            ->helperText('صنف Font Awesome — مثال: fa-solid fa-gift')
                            ->placeholder('fa-solid fa-gift')
                            ->maxLength(100)
                            ->columnSpan(1),
                        TextInput::make('hero_title')
                            ->label('العنوان')
                            ->placeholder('Des offres claires pour apprendre en toute sérénité')
                            ->maxLength(255)
                            ->columnSpan(2),
                        Textarea::make('hero_subtitle')
                            ->label('الوصف')
                            ->placeholder('Un tarif transparent calculé au taux horaire...')
                            ->rows(2)
                            ->columnSpan(2),
                    ])
                    ->columns(2),
                Section::make('قسم محتويات الباقات')
                    ->description('القسم المعروض أسفل الباقات على صفحة الأسعار — العنوان والوصف وبطاقات المحتوى.')
                    ->schema([
                        TextInput::make('contents_label')
                            ->label('التسمية')
                            ->maxLength(100)
                            ->columnSpan(2),
                        TextInput::make('contents_title')
                            ->label('العنوان')
                            ->maxLength(255)
                            ->columnSpan(2),
                        Textarea::make('contents_subtitle')
                            ->label('الوصف')
                            ->rows(2)
                            ->columnSpan(2),
                        Repeater::make('contents_items')
                            ->label('البطاقات')
                            ->schema([
                                TextInput::make('icon')->label('الأيقونة')->columnSpan(1),
                                TextInput::make('title')->label('العنوان')->required()->columnSpan(1),
                                TextInput::make('description')->label('الوصف')->columnSpan(2),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->addActionLabel('إضافة بطاقة')
                            ->reorderableWithButtons()
                            ->collapsible()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Section::make('شريط الدعوة الأخير (CTA)')
                    ->description('الصندوق في نهاية صفحة الأسعار — الشارة والعنوان والنص وزرا الواتساب والحجز. تُترك فارغة للعودة إلى الوضع الافتراضي.')
                    ->schema([
                        TextInput::make('cta_badge')
                            ->label('الشارة')
                            ->placeholder('Sans aucun engagement')
                            ->maxLength(100)
                            ->columnSpan(2),
                        TextInput::make('cta_title')
                            ->label('العنوان')
                            ->placeholder('Vous hésitez sur le pack qui convient à votre enfant ?')
                            ->maxLength(255)
                            ->columnSpan(2),
                        Textarea::make('cta_text')
                            ->label('النص')
                            ->placeholder('Notre équipe pédagogique vous accompagne gratuitement...')
                            ->rows(2)
                            ->columnSpan(2),
                        TextInput::make('cta_whatsapp_label')
                            ->label('نص زر واتساب')
                            ->placeholder('Discutez avec nous via WhatsApp')
                            ->maxLength(100)
                            ->columnSpan(1),
                        TextInput::make('cta_whatsapp_url')
                            ->label('رابط زر واتساب')
                            ->helperText('فارغ = رابط الواتساب الافتراضي من إعدادات الرئيسية')
                            ->placeholder('https://wa.me/...')
                            ->rules([new CtaUrl])
                            ->maxLength(255)
                            ->columnSpan(1),
                        TextInput::make('cta_trial_label')
                            ->label('نص زر الحجز')
                            ->placeholder('Réservez votre essai gratuit')
                            ->maxLength(100)
                            ->columnSpan(1),
                        TextInput::make('cta_trial_url')
                            ->label('رابط زر الحجز')
                            ->helperText('فارغ = فورم الحجز في الصفحة الرئيسية. مثال: #trial-form أو رابط كامل.')
                            ->placeholder('#trial-form')
                            ->rules([new CtaUrl])
                            ->maxLength(255)
                            ->columnSpan(1),
                    ])
                    ->columns(2),
                Section::make('تحسين محركات البحث (SEO)')
                    ->description('إعدادات صفحة الأسعار /price — تُترك قيم HTML أساسية كاحتياطي إذا كانت فارغة.')
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
            ]);
    }
}
