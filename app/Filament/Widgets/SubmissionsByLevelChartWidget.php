<?php

namespace App\Filament\Widgets;

use App\Enums\StudentLevel;
use App\Models\ContactSubmission;
use Filament\Widgets\ChartWidget;

class SubmissionsByLevelChartWidget extends ChartWidget
{
    protected static ?int $sort = 30;

    protected ?string $heading = 'الطلبات حسب المستوى';

    protected ?string $description = 'توزيع الطلبات حسب مستوى الطالب';

    protected string $color = 'primary';

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $levelValues = array_column(StudentLevel::cases(), 'value');

        $counts = collect(StudentLevel::cases())
            ->mapWithKeys(fn (StudentLevel $level) => [
                $level->getLabel() => ContactSubmission::where('level', $level->value)->count(),
            ])
            ->put('أخرى', ContactSubmission::whereNotIn('level', $levelValues)->count());

        return [
            'datasets' => [
                [
                    'label' => 'الطلبات',
                    'data' => $counts->values()->toArray(),
                    'backgroundColor' => ['#ef4444', '#f59e0b', '#22c55e', '#6b7280', '#3b82f6'],
                    'borderRadius' => 8,
                    'borderSkipped' => false,
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
}
