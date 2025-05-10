<?php

namespace App\Observers;

use App\Models\Project;
use App\Models\ProjectStatusHistory;
use Illuminate\Support\Facades\Auth;

class ProjectObserver
{
    /**
     * Handle the Project "created" event.
     */
    public function created(Project $project): void
    {
        ProjectStatusHistory::create([
            'project_id' => $project->id,
            'project_status_id' => $project->project_status_id,
            'changed_by' => Auth::id() ?? $project->user_id, // Use authenticated user or project creator if available
            'comments' => 'Project created with initial status.',
        ]);
    }

    /**
     * Handle the Project "updated" event.
     */
    public function updated(Project $project): void
    {
        // Check if project_status_id was changed
        if ($project->isDirty('project_status_id')) {
            ProjectStatusHistory::create([
                'project_id' => $project->id,
                'project_status_id' => $project->project_status_id,
                'changed_by' => Auth::id(), // Assumes change is done by an authenticated user
                'comments' => 'Project status changed.', // Consider allowing specific comments later if needed
            ]);
        }
    }

    /**
     * Handle the Project "deleted" event.
     */
    public function deleted(Project $project): void
    {
        //
    }

    /**
     * Handle the Project "restored" event.
     */
    public function restored(Project $project): void
    {
        //
    }

    /**
     * Handle the Project "force deleted" event.
     */
    public function forceDeleted(Project $project): void
    {
        //
    }
}
