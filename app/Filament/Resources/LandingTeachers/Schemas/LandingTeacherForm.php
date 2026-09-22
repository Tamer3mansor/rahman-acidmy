<?php

namespace App\Filament\Resources\LandingTeachers\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
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
                        Textarea::make('specialty')
                            ->label('التخصص')
                            ->helperText('يُسمح حتى 400 حرف ويُعرض كوصف في الكارت.')
                            ->required()
                            ->maxLength(400)
                            ->rows(4)
                            ->columnSpanFull(),
                        TextInput::make('emoji')
                            ->label('الأيقونة (إيموجي)')
                            ->maxLength(50)
                            ->placeholder('أدخل إيموجي أو رمزاً نصياً'),
                        TagsInput::make('badges')
                            ->label('الشارات')
                            ->helperText('شارات تظهر أسفل الكارت (أسماء الشهادات، الخبرة...)')
                            ->suggestions([
                                'حافظ للقرآن',
                                'إجازة في القراءات',
                                'ماجستير شريعة',
                                'خبرة +5 سنوات',
                                'خبرة +10 سنوات',
                                'متخصص أطفال',
                            ])
                            ->columnSpanFull(),
                        Grid::make(2)
                            ->schema([
                                Toggle::make('is_featured')
                                    ->label('مدرّس مميز')
                                    ->live()
                                    ->default(false)
                                    ->helperText('يعرض وسامًا ذهبيًا بارزًا فوق صورة الكارت.')
                                    ->columnSpanFull(),
                                TextInput::make('featured_label')
                                    ->label('نص الوسام')
                                    ->placeholder('مدرس مميز')
                                    ->helperText('يُعرض فوق الصورة. اتركه فارغًا لاستخدام النص الافتراضي.')
                                    ->maxLength(100)
                                    ->disabled(fn ($get): bool => ! $get('is_featured'))
                                    ->columnSpanFull(),
                            ]),
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
