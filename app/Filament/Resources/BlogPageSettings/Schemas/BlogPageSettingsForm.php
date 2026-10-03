<?php

namespace App\Filament\Resources\BlogPageSettings\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BlogPageSettingsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('ترويسة الصفحة')
                    ->description('الأسطر الثلاثة أعلى شبكة المقالات في صفحة المدونة /blog.')
                    ->schema([
                        TextInput::make('label')
                            ->label('التسمية')
                            ->helperText('السطر الصغير فوق العنوان — مثال: Blog éducatif')
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
                    ->description('إعدادات صفحة المدونة /blog — تُترك قيم HTML أساسية كاحتياطي إذا كانت فارغة.')
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
