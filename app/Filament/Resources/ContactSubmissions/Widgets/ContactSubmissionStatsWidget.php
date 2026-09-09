<?php

namespace App\Filament\Resources\ContactSubmissions\Widgets;

use App\Enums\SubmissionStatus;
use App\Models\ContactSubmission;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ContactSubmissionStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('الإجمالي', ContactSubmission::count())
                ->description('جميع الطلبات')
                ->icon('heroicon-o-inbox')
                ->color('primary'),
            Stat::make('جديد', ContactSubmission::where('status', SubmissionStatus::New)->count())
                ->description('بانتظار المتابعة')
                ->icon('heroicon-o-bell-alert')
                ->color('danger'),
            Stat::make('تم الجدولة', ContactSubmission::where('status', SubmissionStatus::Scheduled)->count())
                ->description('تم الجدولة')
                ->icon('heroicon-o-calendar')
                ->color('success'),
            Stat::make('هذا الأسبوع', ContactSubmission::where('created_at', '>=', now()->startOfWeek())->count())
                ->description('طلبات هذا الأسبوع')
                ->icon('heroicon-o-chart-bar')
                ->color('info'),
        ];
    }
}
