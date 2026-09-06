<?php

namespace App\Filament\Resources\SystemSettings\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SystemSettingsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('هوية لوحة التحكم')
                    ->description('تظهر هذه البيانات في شريط الجانب، أعلى الصفحات، وصفحة تسجيل الدخول.')
                    ->schema([
                        TextInput::make('title')
                            ->label('عنوان اللوحة')
                            ->placeholder(config('app.name'))
                            ->maxLength(255),
                        Textarea::make('description')
                            ->label('الوصف')
                            ->rows(2)
                            ->maxLength(500),
                        FileUpload::make('logo_path')
                            ->label('الشعار')
                            ->image()
                            ->disk('public')
                            ->directory('system')
                            ->imageEditor()
                            ->imageResizeMode('contain')
                            ->imageResizeTargetWidth('240')
                            ->imageResizeTargetHeight('120')
                            ->columnSpanFull(),
                        FileUpload::make('favicon_path')
                            ->label('الأيقونة المفضلة (Favicon)')
                            ->image()
                            ->disk('public')
                            ->directory('system')
                            ->imageEditor()
                            ->imageResizeMode('contain')
                            ->imageResizeTargetWidth('64')
                            ->imageResizeTargetHeight('64')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
