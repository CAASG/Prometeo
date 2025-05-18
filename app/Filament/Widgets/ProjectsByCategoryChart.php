<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use App\Models\ProjectCategory;
use Filament\Widgets\ChartWidget;

class ProjectsByCategoryChart extends ChartWidget
{
    protected static ?string $heading = 'Projects by Category';
    protected static ?string $pollingInterval = '30s';
    protected static ?int $sort = 2; // To control widget order on dashboard

    protected function getData(): array
    {
        $categories = ProjectCategory::withCount('projects')->get();

        $data = $categories->pluck('projects_count')->all();
        $labels = $categories->pluck('name')->all();

        return [
            'datasets' => [
                [
                    'label' => 'Projects',
                    'data' => $data,
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    'borderColor' => [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    'borderWidth' => 1
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
