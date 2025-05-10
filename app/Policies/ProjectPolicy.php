<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

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
            return true;
        }

        // Placeholder for student ownership check - assumes a user_id field on project or a specific participant type
        // This will need to be adapted based on how you define project ownership for students.
        // Example: if ($user->hasRole('participant') && $project->participants()->where('user_id', $user->id)->wherePivot('is_creator', true)->exists()) {
        //     return true;
        // }

        // Placeholder for evaluator assignment check
        // Example: if ($user->hasRole('evaluator') && $project->evaluators()->where('user_id', $user->id)->exists()) {
        //     return true;
        // }

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
