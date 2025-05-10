<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;

class StatusHistoryRelationManager extends RelationManager
{
    protected static string $relationship = 'statusHistory';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // No form fields needed for a read-only history view.
                // If a ViewAction is used, you might populate fields here for the modal.
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id') // Or another meaningful attribute from ProjectStatusHistory
            ->columns([
                TextColumn::make('status.name') // From ProjectStatus model via status() relationship
                    ->label('Status')
                    ->badge()
                    ->searchable(),
                TextColumn::make('user.name') // From User model via user() relationship (changed_by)
                    ->label('Changed By')
                    ->searchable(),
                TextColumn::make('comments')
                    ->searchable(),
                TextColumn::make('created_at') // This is the 'changed_at' timestamp
                    ->label('Date Changed')
                    ->dateTime()
                    ->sortable()
                    ->defaultSort('desc'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // No header actions for a read-only history
            ])
            ->actions([
                // No row actions (like Edit, Delete) for a read-only history.
                // Tables\Actions\ViewAction::make(), // Optional: if you want a modal to view details
            ])
            ->bulkActions([
                // No bulk actions
            ])
            ->defaultSort('created_at', 'desc'); // Sort by most recent change
    }
}
