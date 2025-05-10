<?php

namespace App\Filament\Resources\EvaluationPhaseResource\Pages;

use App\Filament\Resources\EvaluationPhaseResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageEvaluationPhases extends ManageRecords
{
    protected static string $resource = EvaluationPhaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
