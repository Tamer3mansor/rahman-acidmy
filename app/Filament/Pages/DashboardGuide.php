<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class DashboardGuide extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-map';

    protected static ?string $navigationLabel = 'دليل التحكم بالموقع';

    protected static ?string $title = 'دليل التحكم في عناصر الموقع';

    protected static \UnitEnum|string|null $navigationGroup = 'النظام';

    protected static ?int $navigationSort = 100;

    protected string $view = 'filament.pages.dashboard-guide';
}
