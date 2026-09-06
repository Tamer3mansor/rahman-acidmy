<?php

namespace App\Filament\Resources\BlogPosts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class BlogPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make()
                    ->columnSpanFull()
                    ->tabs([

                        Tab::make('المحتوى')
                            ->schema([
                                TextInput::make('title')
                                    ->label('العنوان')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', str($state)->slug()))
                                    ->columnSpanFull(),
                                TextInput::make('slug')
                                    ->label('الرابط (Slug)')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->columnSpanFull(),
                                Select::make('category_id')
                                    ->label('التصنيف')
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Textarea::make('excerpt')
                                    ->label('الملخص')
                                    ->rows(2)
                                    ->columnSpanFull(),
                                RichEditor::make('body')
                                    ->label('محتوى المقال')
                                    ->required()
                                    ->columnSpanFull(),
                            ]),

                        Tab::make('الإعدادات')
                            ->schema([
                                Section::make('معلومات الكاتب والغطاء')
                                    ->schema([
                                        TextInput::make('author_name')
                                            ->label('اسم الكاتب')
                                            ->required()
                                            ->maxLength(255),
                                        FileUpload::make('author_image')
                                            ->label('صورة الكاتب')
                                            ->image()
                                            ->disk('public')
                                            ->directory('blog/authors')
                                            ->imageResizeMode('cover')
                                            ->imageCropAspectRatio('1:1')
                                            ->imageEditor(),
                                        FileUpload::make('cover_image')
                                            ->label('صورة الغلاف')
                                            ->image()
                                            ->disk('public')
                                            ->directory('blog/covers')
                                            ->imageResizeMode('cover')
                                            ->imageCropAspectRatio('16:9')
                                            ->imageEditor(),
                                        TextInput::make('reading_time')
                                            ->label('وقت القراءة (دقائق)')
                                            ->numeric()
                                            ->required()
                                            ->default(5),
                                    ])
                                    ->columns(2),

                                Section::make('النشر')
                                    ->schema([
                                        DateTimePicker::make('published_at')
                                            ->label('تاريخ النشر')
                                            ->default(now())
                                            ->required(),
                                        Toggle::make('is_featured')
                                            ->label('مقال مميز')
                                            ->default(false),
                                        Toggle::make('is_active')
                                            ->label('نشط')
                                            ->default(true),
                                    ])
                                    ->columns(3),
                            ]),
                    ]),
            ]);
    }
}
