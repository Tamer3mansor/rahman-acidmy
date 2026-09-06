<?php

namespace App\Filament\Resources\ContactSubmissions\Schemas;

use App\Enums\StudentLevel;
use App\Enums\SubmissionStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactSubmissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات الطالب')
                    ->schema([
                        TextInput::make('student_name')
                            ->label('اسم الطالب')
                            ->required()
                            ->disabled(),
                        TextInput::make('parent_name')
                            ->label('اسم ولي الأمر')
                            ->required()
                            ->disabled(),
                        TextInput::make('student_age')
                            ->label('عمر الطالب')
                            ->numeric()
                            ->disabled(),
                        Select::make('level')
                            ->label('المستوى')
                            ->options(collect(StudentLevel::cases())->mapWithKeys(
                                fn (StudentLevel $level): array => [$level->value => $level->getLabel()]
                            )->all())
                            ->disabled(),
                    ])
                    ->columns(2),

                Section::make('معلومات التواصل')
                    ->schema([
                        TextInput::make('phone')
                            ->label('رقم الهاتف')
                            ->tel()
                            ->disabled(),
                        TextInput::make('email')
                            ->label('البريد الإلكتروني')
                            ->email()
                            ->disabled(),
                        Textarea::make('message')
                            ->label('الرسالة')
                            ->disabled()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('إدارة الطلب')
                    ->schema([
                        Select::make('status')
                            ->label('الحالة')
                            ->options(SubmissionStatus::class)
                            ->enum(SubmissionStatus::class)
                            ->required(),
                        Textarea::make('notes')
                            ->label('ملاحظات المسؤول')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
