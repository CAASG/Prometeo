<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EvaluationResource\Pages;
use App\Filament\Resources\EvaluationResource\RelationManagers\ScoresRelationManager;
use App\Models\Evaluation;
use App\Models\Project; // For Select options
use App\Models\User;    // For Select options
use App\Models\EvaluationPhase; // For Select options
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\Section;
use Illuminate\Support\Facades\Auth; // Added for checking user role
use App\Filament\Resources\EvaluationResource\Pages\CreateEvaluation; // Added for type checking
use App\Filament\Resources\EvaluationResource\Pages\EditEvaluation; // Added for type checking

class EvaluationResource extends Resource
{
    protected static ?string $model = Evaluation::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Evaluation Management';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Evaluation Details')->columns(2)->schema([
                    Select::make('project_id')
                        ->relationship('project', 'title')
                        ->searchable()
                        ->required()
                        ->disabled(function ($livewire) {
                            /** @var \App\Models\User $user */
                            $user = Auth::user();
                            return $user->hasRole('evaluator') && 
                                   ($livewire instanceof CreateEvaluation || $livewire instanceof EditEvaluation);
                        }),
                    Select::make('evaluator_id')
                        ->relationship('evaluator', 'name', fn (Builder $query) => $query->whereHas('roles', fn(Builder $q) => $q->where('name', 'evaluator')))
                        ->searchable()
                        ->required()
                        ->disabled(function ($livewire) {
                            /** @var \App\Models\User $user */
                            $user = Auth::user();
                            return $user->hasRole('evaluator') && 
                                   ($livewire instanceof CreateEvaluation || $livewire instanceof EditEvaluation);
                        }),
                    Select::make('evaluation_phase_id')
                        ->relationship('evaluationPhase', 'name')
                        ->searchable()
                        ->required()
                        ->disabled(function ($livewire) {
                            /** @var \App\Models\User $user */
                            $user = Auth::user();
                            // Disable phase if evaluator is editing, not creating
                            return $user->hasRole('evaluator') && $livewire instanceof EditEvaluation;
                        }),
                    DatePicker::make('evaluation_date')
                        ->native(false)
                        ->default(now()),
                    TextInput::make('total_score')
                        ->numeric()
                        ->disabled()
                        ->helperText('Calculated from individual scores.'),
                    Toggle::make('is_completed')
                        ->label('Evaluation Completed?')
                        ->required(),
                ]),
                Section::make('Feedback')->schema([
                     RichEditor::make('comments')
                        ->columnSpanFull(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project.title')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->wrap(),
                TextColumn::make('evaluator.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('evaluationPhase.name')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                IconColumn::make('is_completed')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-clock'),
                TextColumn::make('total_score')
                    ->numeric(decimalPlaces: 2)
                    ->sortable(),
                TextColumn::make('evaluation_date')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('project_id')
                    ->relationship('project', 'title')
                    ->searchable()
                    ->label('Project'),
                Tables\Filters\SelectFilter::make('evaluator_id')
                    ->relationship('evaluator', 'name', fn (Builder $query) => $query->whereHas('roles', fn(Builder $q) => $q->where('name', 'evaluator')))
                    ->searchable()
                    ->label('Evaluator'),
                Tables\Filters\TernaryFilter::make('is_completed')
                    ->label('Status')
                    ->trueLabel('Completed')
                    ->falseLabel('Pending'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    // ->visible(fn (Evaluation $record): bool => !$record->is_completed), // Example: only allow edit if not completed
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('evaluation_date', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            ScoresRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageEvaluations::route('/'),
            'create' => Pages\CreateEvaluation::route('/create'),
            'edit' => Pages\EditEvaluation::route('/{record}/edit'),
            // 'view' => Pages\ViewEvaluation::route('/{record}'), // If we create a custom view page
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with([
            'project',
            'evaluator',
            'evaluationPhase'
        ]);
    }
}
