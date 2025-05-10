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
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use App\Models\User; // To query users for Select

class ParticipantsRelationManager extends RelationManager
{
    protected static string $relationship = 'participants';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Toggle::make('is_director')
                    ->label('Is Director?')
                    ->helperText('Is this participant a director of the project?')
                    ->default(false),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name') // User's name
            ->columns([
                TextColumn::make('name') // From the User model
                    ->label('Participant Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email') // From the User model
                    ->label('Email')
                    ->searchable(),
                IconColumn::make('is_director') // Pivot data
                    ->label('Director')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_director')
                    ->label('Is Director'),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->preloadRecordSelect()
                    ->form(fn (Tables\Actions\AttachAction $action): array => [
                        $action->getRecordSelect()
                            ->label('User')
                            ->options(User::query()->whereHas('roles', fn (Builder $query) => $query->where('name', 'participant'))->pluck('name', 'id'))
                            ->searchable(),
                        Toggle::make('is_director')
                            ->label('Is Director?')
                            ->default(false),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(), // To edit pivot data (is_director)
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}
