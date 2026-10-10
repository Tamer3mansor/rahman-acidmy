<?php

namespace App\Filament\Resources\LessonPageSettings\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LessonPageSettingsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('ترويسة الصفحة')
                    ->description('الأسطر الثلاثة أعلى قائمة الحصص في صفحة /lecons-gratuites.')
                    ->schema([
                        TextInput::make('label')
                            ->label('التسمية')
                            ->helperText('السطر الصغير فوق العنوان — مثال: Exemples et explications gratuits')
                            ->maxLength(100)
                            ->columnSpan(2),
                        TextInput::make('title')
                            ->label('العنوان')
                            ->maxLength(255)
                            ->columnSpan(2),
                        Textarea::make('description')
                            ->label('الوصف')
                            ->rows(2)
                            ->columnSpan(2),
                    ])
                    ->columns(2),
                Section::make('تحسين محركات البحث (SEO)')
                    ->description('إعدادات صفحة الحصص المجانية /lecons-gratuites — تُترك قيم HTML أساسية كاحتياطي إذا كانت فارغة.')
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
                Section::make('الشريط الجانبي (صفحة تفاصيل الحصة)')
                    ->description('عنوان الويدجت والنص وزري الدعوة في الشريط الجانبي بصفحة تفاصيل الحصة — تُترك فارغة للعودة إلى الوضع الافتراضي.')
                    ->schema([
                        TextInput::make('sidebar_title')
                            ->label('عنوان الويدجت')
                            ->placeholder('Commencez le parcours de votre enfant')
                            ->maxLength(255)
                            ->columnSpan(2),
                        Textarea::make('sidebar_text')
                            ->label('نص الويدجت')
                            ->placeholder('Donnez à votre enfant les bonnes orientations dès le début...')
                            ->rows(2)
                            ->columnSpan(2),
                        TextInput::make('sidebar_trial_label')
                            ->label('نص زر التجربة (الأساسي)')
                            ->placeholder('Essai gratuit')
                            ->maxLength(100)
                            ->columnSpan(1),
                        TextInput::make('sidebar_trial_url')
                            ->label('رابط زر التجربة')
                            ->helperText('مثال: /#trial-form أو رابط كامل')
                            ->placeholder('/#trial-form')
                            ->maxLength(255)
                            ->columnSpan(1),
                        TextInput::make('sidebar_whatsapp_label')
                            ->label('نص زر واتساب')
                            ->placeholder('Contactez-nous via WhatsApp')
                            ->maxLength(100)
                            ->columnSpan(1),
                        TextInput::make('sidebar_whatsapp_url')
                            ->label('رابط زر واتساب')
                            ->helperText('فارغ = رابط الواتساب الافتراضي من إعدادات الرئيسية')
                            ->placeholder('https://wa.me/...')
                            ->maxLength(255)
                            ->columnSpan(1),
                    ])
                    ->columns(2),
            ]);
    }
}
