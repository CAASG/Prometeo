<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EvaluatorsRelationManager extends RelationManager
{
    protected static string $relationship = 'evaluators';

    // Form for editing existing pivot data (assigned_by, assigned_date)
    // Potentially, these should not be editable after creation.
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Pivot data like assigned_by and assigned_date are typically not edited.
                // If they were, fields would go here.
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name') // From the related User (evaluator) model
            ->columns([
                TextColumn::make('name') // Evaluator's name
                    ->label('Evaluator Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email') // Evaluator's email
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('pivot.assigned_date')
                    ->label('Assigned Date')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('pivot.assigned_by')
                    ->label('Assigned By (ID)') // Displaying ID for now
                    // For name: ->formatStateUsing(fn ($state) => User::find($state)?->name ?? 'N/A')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->preloadRecordSelect()
                    ->form(fn (Tables\Actions\AttachAction $action): array => [
                        $action->getRecordSelect()
                            ->label('Evaluator')
                            // Filter the selectable users to only those with the 'evaluator' role
                            ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('roles', fn(Builder $q) => $q->where('name', 'evaluator'))),
                        // No need for other fields here; assigned_by & assigned_date are auto-filled
                    ])
                    ->mutateFormDataBeforeAttach(function (array $data): array {
                        // $data will contain the selected 'recordId' (evaluator_id)
                        $data['assigned_by'] = Auth::id();
                        $data['assigned_date'] = now();
                        return $data;
                    })
            ])
            ->actions([
                // EditAction is usually for pivot fields. If assigned_by/date are not editable, no EditAction.
                // Tables\Actions\EditAction::make(), 
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }

    // To display 'assignedBy.name', we would need a relationship on the pivot model.
    // Laravel doesn't have an out-of-the-box "Pivot Model" for belongsToMany by default,
    // but you can define one if you need to add relationships to the pivot table itself.
    // For example, if you create an App\Models\ProjectEvaluator pivot model:
    // class ProjectEvaluator extends Illuminate\Database\Eloquent\Relations\Pivot {
    //     public function assignedBy() { return $this->belongsTo(User::class, 'assigned_by'); }
    // }
    // And then in Project model: return $this->belongsToMany(...)->using(ProjectEvaluator::class);
    // Then in table: TextColumn::make('assignedBy.name') would work.
    // For now, we'll use 'assignedByPivot.name' which won't work directly without further setup,
    // or display assigned_by ID: TextColumn::make('pivot.assigned_by')
}
