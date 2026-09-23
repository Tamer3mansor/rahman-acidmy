<?php

namespace App\Filament\Resources\PricingSettings\Schemas;

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
