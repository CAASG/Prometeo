<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectDetailController extends Controller
{
    public function show(Project $project)
    {
        /** @var User $user */
        $user = Auth::user();
        
        // Check if user is authorized to view the project
        if (!$user->isAdmin() && 
            !($user->isParticipant() && $project->participants()->where('user_id', $user->id)->exists()) &&
            !($user->isEvaluator() && $project->evaluators()->where('user_id', $user->id)->exists())) {
            abort(403, 'Unauthorized to view this project');
        }
        
        // Load necessary relationships
        $project->load(['category', 'status', 'themes', 'documents.uploader', 'participants', 'statusHistory']);
        
        return view('projects.detail', compact('project'));
    }
} 