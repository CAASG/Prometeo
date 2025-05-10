<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EvaluationPhaseResource\Pages;
// use App\Filament\Resources\EvaluationPhaseResource\RelationManagers; // Not needed for --simple resource initially
use App\Models\EvaluationPhase;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class EvaluationPhaseResource extends Resource
{
    protected static ?string $model = EvaluationPhase::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-3-bottom-left';
    protected static ?string $navigationGroup = 'Evaluation Management';
    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                TextInput::make('sequence_order')
                    ->required()
                    ->numeric()
                    ->integer()
                    ->default(1)
                    ->helperText('Determines the order of phases.'),
                TextInput::make('weight')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->suffix('%')
                    ->helperText('Percentage weight in the final score (0-100).'),
                Toggle::make('is_active')
                    ->required()
                    ->default(true)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('sequence_order')
                    ->sortable(),
                TextColumn::make('weight')
                    ->numeric(decimalPlaces: 2)
                    ->suffix('%')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sequence_order', 'asc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageEvaluationPhases::route('/'),
        ];
    }
}
