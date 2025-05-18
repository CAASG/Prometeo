<?php

namespace App\Filament\Widgets;

use App\Models\Evaluation;
use App\Models\Project;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '15s'; // Optional: Auto-refresh interval

    protected function getStats(): array
    {
        return [
            Stat::make('Total Projects', Project::count())
                ->description('All projects in the system')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('primary'),
            Stat::make('Total Users', User::count())
                ->description('All registered users')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
            Stat::make('Total Evaluations', Evaluation::count())
                ->description('All evaluations recorded')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('warning'),
        ];
    }
}
