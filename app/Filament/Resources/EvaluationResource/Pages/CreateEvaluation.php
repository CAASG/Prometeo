<?php

namespace App\Filament\Resources\EvaluationResource\Pages;

use App\Filament\Resources\EvaluationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CreateEvaluation extends CreateRecord
{
    protected static string $resource = EvaluationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        /** @var User $user */
        $user = Auth::user();

        // If the current user is an evaluator and evaluator_id is not set (e.g. by a disabled field),
        // set it to the current user's ID.
        if ($user->hasRole('evaluator') && empty($data['evaluator_id'])) {
            $data['evaluator_id'] = $user->id;
        }

        // Ensure project_id is set if passed via URL and pre-filled by afterFill
        // This ensures it's part of the data array before creation if it was disabled in the form
        if ($user->hasRole('evaluator') && empty($data['project_id']) && request()->query('project_id')) {
            $data['project_id'] = (int)request()->query('project_id');
        }
        
        // Ensure evaluation_date is set if not provided
        if (empty($data['evaluation_date'])) {
            $data['evaluation_date'] = now()->toDateString();
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        // Consider redirecting evaluators back to their dashboard
        /** @var User $user */
        $user = Auth::user();
        if ($user->hasRole('evaluator')) {
            // Assuming you have a route name for your EvaluatorDashboard
            // return route('filament.pages.evaluator-dashboard'); // This needs verification
            // For now, stick to the resource index
        }
        return $this->getResource()::getUrl('index');
    }

    /**
     * Pre-fills form data based on URL parameters and user role.
     */
    protected function afterFill(): void
    {
        parent::afterFill(); // Call parent method if it exists and does something important

        /** @var User $user */
        $user = Auth::user();
        $projectIdFromQuery = request()->query('project_id');

        if ($user->hasRole('evaluator')) {
            $this->form->fill([
                'evaluator_id' => $user->id,
                'project_id' => $projectIdFromQuery ? (int)$projectIdFromQuery : null,
            ]);
        }
    }
}
