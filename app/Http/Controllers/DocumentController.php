<?php

namespace App\Http\Controllers;

use App\Models\ProjectDocument;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function download(ProjectDocument $document)
    {
        // Check if user is authorized to download this document
        /** @var User $user */
        $user = Auth::user();
        
        // Allow if admin
        if ($user->isAdmin()) {
            return Storage::download($document->file_path);
        }
        
        // Allow if user is a participant in the project
        $project = $document->project;
        if ($user->isParticipant() && 
            $project->participants()->where('user_id', $user->id)->exists()) {
            return Storage::download($document->file_path);
        }
        
        // Allow if user is an evaluator assigned to the project
        if ($user->isEvaluator() && 
            $project->evaluators()->where('user_id', $user->id)->exists()) {
            return Storage::download($document->file_path);
        }
        
        return abort(403, 'Unauthorized to download this document');
    }
} 