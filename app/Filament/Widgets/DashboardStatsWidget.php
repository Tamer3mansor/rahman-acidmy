<?php

namespace App\Filament\Widgets;

use App\Enums\SubmissionStatus;
use App\Models\BlogPost;
use App\Models\ContactSubmission;
use App\Models\Course;
use App\Models\LandingTestimonial;
use App\Models\Lesson;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalSubmissions = ContactSubmission::count();
        $newSubmissions = ContactSubmission::where('status', SubmissionStatus::New)->count();
        $scheduledSubmissions = ContactSubmission::where('status', SubmissionStatus::Scheduled)->count();
        $thisWeekSubmissions = ContactSubmission::where('created_at', '>=', now()->startOfWeek())->count();
        $thisMonthSubmissions = ContactSubmission::where('created_at', '>=', now()->startOfMonth())->count();

        return [
            Stat::make('إجمالي الطلبات', $totalSubmissions)
                ->description('جميع طلبات التواصل')
                ->descriptionIcon('heroicon-o-inbox')
                ->color('primary')
                ->chart(ContactSubmission::query()
                    ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                    ->where('created_at', '>=', now()->subDays(30))
                    ->groupBy('date')
                    ->orderBy('date')
                    ->pluck('count', 'date')
                    ->toArray()),
            Stat::make('طلبات جديدة', $newSubmissions)
                ->description('بانتظار المتابعة')
                ->descriptionIcon('heroicon-o-bell-alert')
                ->color('danger'),
            Stat::make('تم الجدولة', $scheduledSubmissions)
                ->description('حصص مجدولة')
                ->descriptionIcon('heroicon-o-calendar')
                ->color('success'),
            Stat::make('طلبات هذا الشهر', $thisMonthSubmissions)
                ->description('طلبات الشهر الحالي')
                ->descriptionIcon('heroicon-o-chart-bar')
                ->color('info')
                ->chart(ContactSubmission::query()
                    ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                    ->where('created_at', '>=', now()->subDays(30))
                    ->groupBy('date')
                    ->orderBy('date')
                    ->pluck('count', 'date')
                    ->toArray()),
            Stat::make('الدورات', Course::count())
                ->description(Course::where('is_active', true)->count().' نشطة')
                ->descriptionIcon('heroicon-o-bookmark')
                ->color('warning'),
            Stat::make('الحصص المجانية', Lesson::count())
                ->description(Lesson::where('is_active', true)->count().' نشطة')
                ->descriptionIcon('heroicon-o-play-circle')
                ->color('success'),
            Stat::make('المقالات', BlogPost::count())
                ->description(BlogPost::where('is_active', true)->count().' منشورة')
                ->descriptionIcon('heroicon-o-document-text')
                ->color('info'),
            Stat::make('الشهادات', LandingTestimonial::count())
                ->description(LandingTestimonial::where('is_active', true)->count().' نشطة')
                ->descriptionIcon('heroicon-o-star')
                ->color('warning'),
        ];
    }
}
