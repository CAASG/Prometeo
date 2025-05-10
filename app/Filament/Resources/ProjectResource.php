<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
// Comment out RelationManagers for now as they are not yet created
// use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectStatus;
use App\Models\ProjectTheme;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Project Management';
    protected static ?int $navigationSort = 0; // Main item in the group

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Project Details')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('description')
                            ->columnSpanFull(),
                        Forms\Components\Select::make('project_category_id')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Category'),
                        Forms\Components\Select::make('project_status_id')
                            ->relationship('status', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Status'),
                        Forms\Components\CheckboxList::make('themes')
                            ->relationship('themes', 'name')
                            ->columns(2)
                            ->columnSpanFull()
                            ->searchable()
                            ->label('Thematic Areas'),
                    ]),
                Section::make('Dates & Scores')
                    ->columns(2)
                    ->schema([
                        Forms\Components\DatePicker::make('submission_date')
                            ->native(false),
                        Forms\Components\DatePicker::make('deadline_for_corrections')
                            ->native(false),
                        Forms\Components\TextInput::make('final_score')
                            ->numeric()
                            // ->prefix('%') // final_score is a decimal, not necessarily a percentage display here.
                            // ->disabled()
                            ->helperText('Calculated automatically or set by admin.'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status.name')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($record) => match ($record->status?->name) { // Corrected match expression
                        'Rejected' => 'danger',
                        'Completed' => 'success',
                        'Corrections Pending' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('submission_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('final_score')
                    ->numeric(decimalPlaces: 2)
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('project_category_id')
                    ->relationship('category', 'name')
                    ->label('Category')
                    ->preload(), // Added preload for better UX
                Tables\Filters\SelectFilter::make('project_status_id')
                    ->relationship('status', 'name')
                    ->label('Status')
                    ->preload(), // Added preload for better UX
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
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            // RelationManagers will be added progressively
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            // 'view' => Pages\ViewProject::route('/{record}'), // ViewAction uses a modal
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
