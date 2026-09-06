<?php

namespace App\Filament\Resources\LandingTestimonials\Schemas;

use App\Enums\TestimonialType;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LandingTestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('نوع الشهادة')
                    ->schema([
                        Select::make('type')
                            ->label('النوع')
                            ->options(TestimonialType::class)
                            ->enum(TestimonialType::class)
                            ->required()
                            ->live(),
                    ]),

                Section::make('بيانات صاحب الرأي')
                    ->schema([
                        TextInput::make('author_name')
                            ->label('الاسم')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('author_location')
                            ->label('الموقع / البلد')
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('المحتوى')
                    ->schema([
                        RichEditor::make('content')
                            ->label('نص الشهادة')
                            ->extraAttributes(['style' => 'direction: rtl; text-align: right;'])
                            ->columnSpanFull()
                            ->hidden(fn ($get) => $get('type') !== TestimonialType::Google && $get('type') !== TestimonialType::Whatsapp),
                        FileUpload::make('media_path')
                            ->label('ملف الفيديو / صورة المحادثة')
                            ->directory('landing/testimonials')
                            ->acceptedFileTypes(['video/mp4', 'video/webm', 'image/jpeg', 'image/png', 'image/webp'])
                            ->columnSpanFull()
                            ->hidden(fn ($get) => $get('type') !== TestimonialType::Google),
                        TextInput::make('rating')
                            ->label('التقييم (من 5)')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(5)
                            ->hidden(fn ($get) => $get('type') !== TestimonialType::Google),
                    ]),

                Section::make('الحالة')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('نشط')
                            ->default(true),
                        TextInput::make('sort_order')
                            ->label('ترتيب العرض')
                            ->required()
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(2),
            ]);
    }
}
