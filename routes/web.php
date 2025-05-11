<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\MyProjectsDashboard;
use App\Livewire\ProjectSubmissionForm;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProjectDetailController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/my-projects', MyProjectsDashboard::class)->name('my-projects.dashboard');
    Route::get('/projects/submit', ProjectSubmissionForm::class)->name('projects.submit');
    
    // Project detail page
    Route::get('/projects/{project}', [ProjectDetailController::class, 'show'])->name('projects.show');
    
    // Document download route
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
});
