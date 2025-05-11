<?php

namespace App\Filament\Resources\EvaluationResource\Pages;

use App\Filament\Resources\EvaluationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Evaluation;

class EditEvaluation extends EditRecord
{
    protected static string $resource = EvaluationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            // Add other actions like ViewAction if needed
            // Actions\ViewAction::make(), // We would need to create ViewEvaluation.php for this
        ];
    }

    protected function getRedirectUrl(): string
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user->hasRole('evaluator')) {
            // Redirect evaluators back to their dashboard
            // This requires the EvaluatorDashboard page to have a route name.
            // For now, we can attempt to get its URL if it's registered.
            // Replace 'filament.admin.pages.evaluator-dashboard' with the actual route name if different.
            try {
                return route(config('filament.path') . '.pages.evaluator-dashboard');
            } catch (\Exception $e) {
                // Fallback if route not found
                return $this->getResource()::getUrl('index');
            }
        }
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        /** @var User $user */
        $user = Auth::user();
        /** @var Evaluation $evaluation */
        $evaluation = $this->getRecord();

        // If an evaluator tries to un-mark a completed evaluation, prevent it.
        if ($user->hasRole('evaluator') && $evaluation->is_completed && !isset($data['is_completed'])) {
            $data['is_completed'] = true; // Force it back to completed
        }
        // Or, if an evaluator tries to set is_completed to false explicitly when it was true
        if ($user->hasRole('evaluator') && $evaluation->is_completed && isset($data['is_completed']) && !$data['is_completed']) {
            $data['is_completed'] = true; // Force it back to completed
        }

        return $data;
    }

    // Optional: Modify save action behavior
    // protected function getFormActions(): array
    // {
    //     return [
    //         $this->getSaveFormAction()->label(
    //             $this->getRecord()->is_completed && Auth::user()->hasRole('evaluator') ? 'View Details' : 'Save Changes'
    //         )
    //         // Potentially disable if completed for evaluators and no changes allowed.
    //         // ->disabled($this->getRecord()->is_completed && Auth::user()->hasRole('evaluator')),
    //         $this->getCancelFormAction(),
    //     ];
    // }
}
