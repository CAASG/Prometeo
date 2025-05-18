<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use App\Models\ProjectStatus;
use Filament\Widgets\ChartWidget;

class ProjectsByStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Projects by Status';
    protected static ?string $pollingInterval = '30s';
    protected static ?int $sort = 3; // To control widget order on dashboard

    protected function getData(): array
    {
        $statuses = ProjectStatus::withCount('projects')->get();

        $data = $statuses->pluck('projects_count')->all();
        $labels = $statuses->pluck('name')->all();

        return [
            'datasets' => [
                [
                    'label' => 'Projects',
                    'data' => $data,
                    'backgroundColor' => [
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#4BC0C0',
                        '#9966FF',
                        '#FF9F40'
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
