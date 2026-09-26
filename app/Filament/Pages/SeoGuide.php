<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class SeoGuide extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'دليل السيو (SEO)';

    protected static ?string $title = 'كتيب إرشادات تحسين محركات البحث (SEO)';

    protected static \UnitEnum|string|null $navigationGroup = 'النظام';

    protected static ?int $navigationSort = 101;

    protected string $view = 'filament.pages.seo-guide';
}
