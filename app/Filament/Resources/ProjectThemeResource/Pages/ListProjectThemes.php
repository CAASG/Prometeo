<?php

namespace App\Filament\Resources\ProjectThemeResource\Pages;

use App\Filament\Resources\ProjectThemeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectThemes extends ListRecords
{
    protected static string $resource = ProjectThemeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
