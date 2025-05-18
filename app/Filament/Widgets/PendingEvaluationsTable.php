<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\EvaluationResource;
use App\Models\Evaluation;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\TextColumn;

class PendingEvaluationsTable extends BaseWidget
{
    protected static ?string $heading = 'Pending Evaluations';
    protected static ?int $sort = 4; // To control widget order on dashboard
    protected int | string | array $columnSpan = 'full'; // Make widget take full width

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Evaluation::query()
                    ->where('is_completed', false)
                    ->orderBy('created_at', 'desc')
            )
            ->columns([
                TextColumn::make('project.title')
                    ->label('Project')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('evaluator.name')
                    ->label('Evaluator')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('evaluationPhase.name')
                    ->label('Phase')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('View Evaluation')
                    ->url(fn (Evaluation $record): string => EvaluationResource::getUrl('edit', ['record' => $record]))
                    ->icon('heroicon-m-eye'),
            ])
            ->emptyStateHeading('No pending evaluations')
            ->emptyStateDescription('All assigned evaluations have been completed.');
    }
}
