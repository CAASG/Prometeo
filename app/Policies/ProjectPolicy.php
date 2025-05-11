<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log; // Added for debugging

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     * Admins can see all projects in the Filament resource.
     * Other roles (students, evaluators) will have their own UIs.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view the model.
     * Admins can view any project.
     * Students can view their own (needs project ownership logic).
     * Evaluators can view assigned projects (needs assignment logic).
     */
    public function view(User $user, Project $project): bool
    {
        if ($user->hasRole('admin')) {
            Log::info("Policy: Admin {$user->id} viewing project {$project->id}. Allowed.");
            return true;
        }

        // Permitir a los participantes ver los proyectos en los que participan
        if ($user->isParticipant()) {
            $isParticipantOfProject = $project->participants()->where('user_id', $user->id)->exists();
            Log::info("Policy: Participant {$user->id} viewing project {$project->id}. Is participant of this project? " . ($isParticipantOfProject ? 'Yes' : 'No'));
            if ($isParticipantOfProject) {
                return true;
            }
        }

        // Placeholder para la lógica de evaluadores (la implementaremos cuando sea necesario)
        // if ($user->isEvaluator() && $project->evaluators()->where('user_id', $user->id)->exists()) {
        //     return true;
        // }
        Log::warning("Policy: User {$user->id} (Roles: " . implode(', ', $user->roles->pluck('name')->all()) . ") denied viewing project {$project->id}. isParticipant check: " . ($user->isParticipant() ? 'Yes' : 'No'));
        return false; // Default to deny if no specific rule matches for non-admins
    }

    /**
     * Determine whether the user can create models.
     * Admins can create projects.
     * Students/Participants can create projects (likely via a frontend portal).
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('participant');
    }

    /**
     * Determine whether the user can update the model.
     * Admins can update any project.
     * Students might update their own under certain conditions.
     */
    public function update(User $user, Project $project): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }
        // Placeholder for student update logic (e.g., owns project and status is appropriate)
        // Example: if ($user->hasRole('participant') && $project->participants()->where('user_id', $user->id)->exists() && $project->status->name === 'Corrections Pending') {
        //     return true;
        // }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     * Typically only admins.
     */
    public function delete(User $user, Project $project): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Project $project): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Project $project): bool
    {
        return $user->hasRole('admin');
    }
}
