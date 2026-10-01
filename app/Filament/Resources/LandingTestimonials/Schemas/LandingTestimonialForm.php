<?php

namespace App\Filament\Resources\LandingTestimonials\Schemas;

use App\Enums\TestimonialPlacement;
use App\Enums\TestimonialType;
use App\Models\LandingTestimonial;
use Filament\Forms\Components\CheckboxList;
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
                            ->required(fn ($get): bool => $get('type') !== TestimonialType::Video)
                            ->maxLength(255),
                        TextInput::make('author_location')
                            ->label('الموقع / البلد')
                            ->maxLength(255),
                    ])
                    ->columns(2)
                    ->hidden(fn ($get): bool => $get('type') === TestimonialType::Video),

                Section::make('المحتوى')
                    ->schema([
                        RichEditor::make('content')
                            ->label('نص الشهادة')
                            ->extraAttributes(['style' => 'direction: rtl; text-align: right;'])
                            ->columnSpanFull()
                            ->hidden(fn ($get) => $get('type') !== TestimonialType::Google && $get('type') !== TestimonialType::Whatsapp),
                        FileUpload::make('media_path')
                            ->label('ملف الفيديو')
                            ->disk('public')
                            ->directory('landing/testimonials')
                            ->acceptedFileTypes(['video/mp4', 'video/webm'])
                            ->maxSize(1000000)
                            ->helperText('ارفع الفيديو (MP4، WebM). الحد الأقصى 1 جيجابايت.')
                            ->columnSpanFull()
                            ->hidden(fn ($get) => $get('type') !== TestimonialType::Video),
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
                        CheckboxList::make('placements')
                            ->label('أماكن الظهور')
                            ->helperText('اختر الصفحات التي تظهر فيها هذه الشهادة. اختيار «الصفحة الرئيسية» وحدها يعني أنها لا تظهر في صفحات الكورسات.')
                            ->options(TestimonialPlacement::class)
                            ->default([TestimonialPlacement::Landing])
                            ->required()
                            ->bulkToggleable()
                            ->columns(2)
                            ->columnSpanFull(),
                        TextInput::make('sort_order')
                            ->label('ترتيب العرض')
                            ->helperText('الترتيب بين الشهادات اللي بتظهر في نفس المكان. الشهادة الجديدة بتتحط في الآخر.')
                            ->required()
                            ->numeric()
                            ->default(fn (): int => (int) LandingTestimonial::query()->max('sort_order') + 1),
                    ])
                    ->columns(2),
            ]);
    }
}
