<?php

namespace App\Filament\Resources\CoursePageSettings\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class CoursePageSettingsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make()
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('صفحة الأطفال')
                            ->schema([
                                Section::make('نصوص رأس الصفحة')
                                    ->schema([
                                        TextInput::make('kids_label')->label('التسمية')->required()->columnSpan(3),
                                        TextInput::make('kids_badge')->label('الشارة')->required()->columnSpan(3),
                                        TextInput::make('kids_title')->label('العنوان')->required()->columnSpan(3),
                                        TextInput::make('kids_title_accent')->label('الجزء المميز من العنوان')->columnSpan(3),
                                        Textarea::make('kids_subtitle')->label('الوصف')->required()->columnSpanFull()->rows(2),
                                    ])
                                    ->columns(6),
                                Section::make('الأزرار')
                                    ->schema([
                                        TextInput::make('kids_cta_title')->label('نص زر الحث')->required()->columnSpan(2),
                                        TextInput::make('kids_cta_url')->label('رابط زر الحث')->default('#')->columnSpan(2),
                                        TextInput::make('kids_wa_title')->label('نص زر واتساب')->required()->columnSpan(2),
                                        TextInput::make('kids_wa_url')->label('رابط واتساب')->default('#')->columnSpan(2),
                                    ])
                                    ->columns(2),
                            ]),
                        Tab::make('صفحة الكبار')
                            ->schema([
                                Section::make('نصوص رأس الصفحة')
                                    ->schema([
                                        TextInput::make('adults_label')->label('التسمية')->required()->columnSpan(3),
                                        TextInput::make('adults_badge')->label('الشارة')->required()->columnSpan(3),
                                        TextInput::make('adults_title')->label('العنوان')->required()->columnSpan(3),
                                        TextInput::make('adults_title_accent')->label('الجزء المميز من العنوان')->columnSpan(3),
                                        Textarea::make('adults_subtitle')->label('الوصف')->required()->columnSpanFull()->rows(2),
                                    ])
                                    ->columns(6),
                                Section::make('الأزرار')
                                    ->schema([
                                        TextInput::make('adults_cta_title')->label('نص زر الحث')->required()->columnSpan(2),
                                        TextInput::make('adults_cta_url')->label('رابط زر الحث')->default('#')->columnSpan(2),
                                        TextInput::make('adults_wa_title')->label('نص زر واتساب')->required()->columnSpan(2),
                                        TextInput::make('adults_wa_url')->label('رابط واتساب')->default('#')->columnSpan(2),
                                    ])
                                    ->columns(2),
                            ]),
                        Tab::make('صفحة تفاصيل الدورة')
                            ->schema([
                                Section::make('نصوص الحجز والاستمارة')
                                    ->schema([
                                        TextInput::make('details_cta_title')->label('نص زر الحث')->required()->columnSpan(2),
                                        TextInput::make('details_booking_title')->label('عنوان الحجز')->required()->columnSpan(2),
                                        TextInput::make('details_form_title')->label('عنوان الاستمارة')->required()->columnSpan(2),
                                        Textarea::make('details_booking_subtitle')->label('وصف الحجز')->required()->columnSpanFull()->rows(2),
                                        TextInput::make('details_booking_note')->label('ملاحظة الحجز')->columnSpan(2),
                                    ])
                                    ->columns(3),
                            ]),
                    ]),

                Section::make('الحالة')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('نشط')
                            ->default(true),
                    ])
                    ->columns(1),
            ]);
    }
}
