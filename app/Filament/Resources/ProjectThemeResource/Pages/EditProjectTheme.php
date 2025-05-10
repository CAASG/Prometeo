<?php

namespace App\Filament\Resources\ProjectThemeResource\Pages;

use App\Filament\Resources\ProjectThemeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProjectTheme extends EditRecord
{
    protected static string $resource = ProjectThemeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
