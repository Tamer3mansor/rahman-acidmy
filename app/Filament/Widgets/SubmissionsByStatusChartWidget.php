<?php

namespace App\Filament\Widgets;

use App\Enums\SubmissionStatus;
use App\Models\ContactSubmission;
use Filament\Widgets\ChartWidget;

class SubmissionsByStatusChartWidget extends ChartWidget
{
    protected static ?int $sort = 20;

    protected ?string $heading = 'الطلبات حسب الحالة';

    protected ?string $description = 'توزيع الطلبات حسب حالة المعالجة';

    protected ?string $maxHeight = '300px';

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        $counts = collect(SubmissionStatus::cases())
            ->mapWithKeys(fn (SubmissionStatus $status) => [
                $status->getLabel() => ContactSubmission::where('status', $status)->count(),
            ])
            ->filter(fn ($count) => $count > 0);

        $colors = [
            SubmissionStatus::New->getLabel() => '#ef4444',
            SubmissionStatus::Contacted->getLabel() => '#3b82f6',
            SubmissionStatus::Scheduled->getLabel() => '#22c55e',
            SubmissionStatus::Postponed->getLabel() => '#f59e0b',
        ];

        return [
            'datasets' => [
                [
                    'data' => $counts->values()->toArray(),
                    'backgroundColor' => $counts->keys()->map(fn ($label) => $colors[$label] ?? '#6b7280')->toArray(),
                    'borderWidth' => 0,
                ],
            ],
            'labels' => $counts->keys()->toArray(),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'labels' => [
                        'padding' => 20,
                        'usePointStyle' => true,
                    ],
                ],
            ],
            'cutout' => '65%',
        ];
    }
}
