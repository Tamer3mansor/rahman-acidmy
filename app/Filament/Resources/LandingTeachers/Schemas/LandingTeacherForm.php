<?php

namespace App\Filament\Resources\LandingTeachers\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LandingTeacherForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات المعلم')
                    ->schema([
                        TextInput::make('name')
                            ->label('الاسم')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('specialty')
                            ->label('التخصص')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('emoji')
                            ->label('الأيقونة (إيموجي)')
                            ->maxLength(50)
                            ->placeholder('أدخل إيموجي أو رمزاً نصياً'),
                        TagsInput::make('badges')
                            ->label('الشارات')
                            ->suggestions([
                                'حافظ للقرآن',
                                'إجازة في القراءات',
                                'ماجستير شريعة',
                                'خبرة +5 سنوات',
                                'خبرة +10 سنوات',
                                'متخصص أطفال',
                            ])
                            ->columnSpanFull(),
                        FileUpload::make('photo_path')
                            ->label('الصورة الشخصية')
                            ->image()
                            ->disk('public')
                            ->directory('landing/teachers')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

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
