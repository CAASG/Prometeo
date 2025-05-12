<?php

namespace App\Filament\Resources\EvaluationResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use App\Models\RubricCriterion;
use App\Models\Evaluation;
use App\Models\EvaluationScore;
use Closure;
use Filament\Forms\Get;
use Filament\Forms\Set;

class ScoresRelationManager extends RelationManager
{
    protected static string $relationship = 'scores';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('rubric_criteria_id')
                    ->label('Rubric Criterion')
                    ->options(function (callable $get) {
                        /** @var Evaluation $evaluation */
                        $evaluation = $this->getOwnerRecord();
                        if (!$evaluation || !$evaluation->evaluation_phase_id) {
                            return [];
                        }
                        // Obtener los criterios ya calificados
                        $usedCriteriaIds = $evaluation->scores()->pluck('rubric_criteria_id')->toArray();
                        // Si estamos editando, incluir el criterio actual
                        $currentCriterionId = $get('rubric_criteria_id');
                        if ($currentCriterionId) {
                            $usedCriteriaIds = array_diff($usedCriteriaIds, [$currentCriterionId]);
                        }
                        return RubricCriterion::where('evaluation_phase_id', $evaluation->evaluation_phase_id)
                            ->where('is_active', true)
                            ->whereNotIn('id', $usedCriteriaIds)
                            ->pluck('name', 'id');
                    })
                    ->reactive()
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('score', null))
                    ->required(),
                TextInput::make('score')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->rule(function (Get $get): Closure {
                        return function (string $attribute, $value, Closure $fail) use ($get) {
                            $criterionId = $get('rubric_criteria_id');
                            if (!$criterionId) return;
                            $criterion = RubricCriterion::find($criterionId);
                            if ($criterion && $value > $criterion->max_score) {
                                $fail("The score cannot exceed the criterion's max score of {$criterion->max_score}.");
                            }
                        };
                    }),
                Textarea::make('comments')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('rubricCriterion.name')
            ->columns([
                TextColumn::make('rubricCriterion.name')
                    ->label('Criterion')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('score')
                    ->numeric(decimalPlaces: 2)
                    ->sortable(),
                TextColumn::make('comments')
                    ->searchable()
                    ->limit(50)
                    ->wrap(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->after(function (\App\Models\EvaluationScore $record) {
                        /** @var Evaluation $evaluation */
                        $evaluation = $this->getOwnerRecord();
                        $evaluation->calculateTotalScore();
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->after(function (\App\Models\EvaluationScore $record) {
                        /** @var Evaluation $evaluation */
                        $evaluation = $this->getOwnerRecord();
                        $evaluation->calculateTotalScore();
                    }),
                Tables\Actions\DeleteAction::make()
                    ->after(function (\App\Models\EvaluationScore $record) {
                        /** @var Evaluation $evaluation */
                        $evaluation = $this->getOwnerRecord();
                        $evaluation->calculateTotalScore();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->after(function () {
                            /** @var Evaluation $evaluation */
                            $evaluation = $this->getOwnerRecord();
                            $evaluation->calculateTotalScore();
                        }),
                ]),
            ]);
    }
}
