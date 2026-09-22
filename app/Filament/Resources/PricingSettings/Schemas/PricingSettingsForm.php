<?php

namespace App\Filament\Resources\PricingSettings\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PricingSettingsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('قسم محتويات الباقات')
                    ->description('القسم المعروض أسفل الباقات على صفحة الأسعار — العنوان والوصف وبطاقات المحتوى.')
                    ->schema([
                        TextInput::make('contents_label')
                            ->label('التسمية')
                            ->maxLength(100)
                            ->columnSpan(2),
                        TextInput::make('contents_title')
                            ->label('العنوان')
                            ->maxLength(255)
                            ->columnSpan(2),
                        Textarea::make('contents_subtitle')
                            ->label('الوصف')
                            ->rows(2)
                            ->columnSpan(2),
                        Repeater::make('contents_items')
                            ->label('البطاقات')
                            ->schema([
                                TextInput::make('icon')->label('الأيقونة')->columnSpan(1),
                                TextInput::make('title')->label('العنوان')->required()->columnSpan(1),
                                TextInput::make('description')->label('الوصف')->columnSpan(2),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->addActionLabel('إضافة بطاقة')
                            ->reorderableWithButtons()
                            ->collapsible()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
