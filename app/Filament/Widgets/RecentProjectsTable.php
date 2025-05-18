<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ProjectResource;
use App\Models\Project;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\TextColumn;

class RecentProjectsTable extends BaseWidget
{
    protected static ?string $heading = 'Recent Projects';
    protected static ?int $sort = 5; // To control widget order on dashboard
    protected int | string | array $columnSpan = 'full'; // Make widget take full width

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Project::query()
                    ->orderBy('created_at', 'desc')
                    ->limit(5) // Show latest 5 projects
            )
            ->columns([
                TextColumn::make('title')
                    ->label('Project Title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('projectCategory.name')
                    ->label('Category')
                    ->sortable(),
                TextColumn::make('projectStatus.name')
                    ->label('Status')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created On')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('View Project')
                    ->url(fn (Project $record): string => ProjectResource::getUrl('view', ['record' => $record]))
                    ->icon('heroicon-m-arrow-top-right-on-square'),
            ])
            ->emptyStateHeading('No projects found')
            ->emptyStateDescription('There are no projects in the system yet.');
    }
}
