<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RubricCriterionResource\Pages;
use App\Filament\Resources\RubricCriterionResource\RelationManagers;
use App\Models\RubricCriterion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class RubricCriterionResource extends Resource
{
    protected static ?string $model = RubricCriterion::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';
    protected static ?string $navigationGroup = 'Evaluation Management';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('evaluation_phase_id')
                    ->relationship('evaluationPhase', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Evaluation Phase')
                    ->columnSpanFull(),
                Textarea::make('name') // Criterion Text
                    ->required()
                    ->label('Criterion Text')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                TextInput::make('max_score')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->default(10)
                    ->helperText('Maximum score for this criterion.'),
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
                TextColumn::make('name') // Criterion Text
                    ->label('Criterion Text')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->wrap(),
                TextColumn::make('evaluationPhase.name')
                    ->label('Evaluation Phase')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('max_score')
                    ->numeric(decimalPlaces: 2)
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
                Tables\Filters\SelectFilter::make('evaluation_phase_id')
                    ->relationship('evaluationPhase', 'name')
                    ->label('Evaluation Phase')
                    ->preload(),
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
            ->defaultSort('name', 'asc');
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
            'index' => Pages\ManageRubricCriteria::route('/'),
        ];
    }
}
