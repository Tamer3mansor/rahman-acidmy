<?php

namespace App\Filament\Resources\Lessons\Schemas;

use App\Enums\LessonCategory;
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

class LessonForm
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
                                Select::make('category')
                                    ->label('الفئة')
                                    ->options(LessonCategory::class)
                                    ->required()
                                    ->default(LessonCategory::Kids),
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
                                Textarea::make('excerpt')
                                    ->label('الملخص')
                                    ->rows(2)
                                    ->columnSpanFull(),
                                RichEditor::make('body')
                                    ->label('محتوى الدرس')
                                    ->required()
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),

                        Tab::make('الإعدادات')
                            ->schema([
                                Section::make('الوسائط والروابط')
                                    ->schema([
                                        FileUpload::make('cover_image')
                                            ->label('صورة الغلاف')
                                            ->image()
                                            ->disk('public')
                                            ->directory('lessons/covers')
                                            ->imageResizeMode('cover')
                                            ->imageCropAspectRatio('16:9')
                                            ->imageEditor(),
                                        TextInput::make('audio_url')
                                            ->label('رابط الصوت')
                                            ->url()
                                            ->placeholder('https://...')
                                            ->columnSpanFull(),
                                        Select::make('course_id')
                                            ->label('الدورة المرتبطة')
                                            ->relationship('course', 'title')
                                            ->searchable()
                                            ->preload(),
                                    ])
                                    ->columns(2),

                                Section::make('النشر')
                                    ->schema([
                                        TextInput::make('reading_time')
                                            ->label('وقت القراءة (دقائق)')
                                            ->numeric()
                                            ->required()
                                            ->default(5),
                                        TextInput::make('sort_order')
                                            ->label('الترتيب')
                                            ->numeric()
                                            ->default(0),
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
