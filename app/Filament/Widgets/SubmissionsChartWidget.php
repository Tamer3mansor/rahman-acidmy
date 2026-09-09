<?php

namespace App\Filament\Widgets;

use App\Models\ContactSubmission;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class SubmissionsChartWidget extends ChartWidget
{
    protected static ?int $sort = 10;

    protected ?string $heading = 'طلبات التواصل';

    protected ?string $description = 'عدد الطلبات خلال آخر 30 يوم';

    protected string $color = 'primary';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $data = ContactSubmission::query()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        $dates = collect();
        for ($i = 29; $i >= 0; $i--) {
            $dates->push(now()->subDays($i)->format('Y-m-d'));
        }

        return [
            'datasets' => [
                [
                    'label' => 'الطلبات',
                    'data' => $dates->map(fn ($date) => $data->get($date, 0))->toArray(),
                    'borderColor' => '#d97706',
                    'backgroundColor' => 'rgba(217, 119, 6, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $dates->map(fn ($date) => Carbon::parse($date)->format('d/m'))->toArray(),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
        ];
    }

    protected function getFilters(): ?array
    {
        return [
            '7' => 'آخر 7 أيام',
            '30' => 'آخر 30 يوم',
            '90' => 'آخر 3 أشهر',
        ];
    }
}
