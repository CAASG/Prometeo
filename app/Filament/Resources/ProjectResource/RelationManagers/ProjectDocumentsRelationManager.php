<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use App\Models\ProjectDocument;
use Illuminate\Support\Facades\Auth;

class ProjectDocumentsRelationManager extends RelationManager
{
    protected static string $relationship = 'documents';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('document_type')
                    ->required()
                    ->maxLength(255),
                FileUpload::make('file_path')
                    ->label('Document')
                    ->disk('public')
                    ->directory('project-documents')
                    ->visibility('private')
                    ->downloadable()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('document_type')
            ->columns([
                TextColumn::make('document_type')
                    ->searchable(),
                TextColumn::make('upload_date')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('uploader.name')
                    ->label('Uploaded By')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataBeforeCreate(function (array $data): array {
                        $data['uploaded_by'] = Auth::id();
                        $data['upload_date'] = now();
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function (ProjectDocument $record) {
                        if (filled($record->file_path) && Storage::disk('public')->exists($record->file_path)) {
                            return Storage::disk('public')->download($record->file_path);
                        }
                        return null;
                    })
                    ->visible(fn (ProjectDocument $record): bool => filled($record->file_path)),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
