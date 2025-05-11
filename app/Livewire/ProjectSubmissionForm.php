<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ProjectCategory;
use App\Models\ProjectTheme;
use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // For transactions
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;

class ProjectSubmissionForm extends Component
{
    use WithFileUploads;

    public string $title = '';
    public string $description = '';
    public ?int $project_category_id = null;
    public array $selected_themes = [];
    public $document;

    public $categories = [];
    public $themes = [];

    public string $pageTitle = 'Submit New Project';

    public function mount()
    {
        $this->categories = ProjectCategory::where('is_active', true)->orderBy('name')->get(['id', 'name']);
        $this->themes = ProjectTheme::where('is_active', true)->orderBy('name')->get(['id', 'name']);
    }

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:50',
            'project_category_id' => 'required|exists:project_categories,id',
            'selected_themes' => 'required|array|min:1',
            'selected_themes.*' => 'exists:project_themes,id',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:10240', // 10MB max
        ];
    }

    protected $messages = [
        'description.min' => 'The project description must be at least 50 characters.',
        'selected_themes.min' => 'Please select at least one thematic area.',
    ];

    public function submit()
    {
        $this->validate();

        try {
            DB::transaction(function () {
                $initialStatus = ProjectStatus::where('sequence_order', 1)->first(); // Assuming sequence 1 is 'Proposal Submitted'
                if (!$initialStatus) {
                    // Fallback or error if the default status isn't found
                    session()->flash('error', 'System error: Default project status not found. Please contact admin.');
                    return;
                }

                $project = Project::create([
                    'title' => $this->title,
                    'description' => $this->description,
                    'project_category_id' => $this->project_category_id,
                    'created_by' => Auth::id(),
                    'project_status_id' => $initialStatus->id,
                    'submission_date' => now(),
                ]);

                $project->themes()->attach($this->selected_themes);

                // Add the logged-in user as the project director
                $project->participants()->attach(Auth::id(), ['is_director' => true]);

                if ($this->document) {
                    Log::info('[ProjectSubmit] Document detected. Attempting to store file.');
                    $filePath = $this->document->store('project_documents', 'public');
                    Log::info('[ProjectSubmit] File stored at: ' . $filePath);
                    try {
                        $newDocument = $project->documents()->create([
                            'document_type' => 'Project Proposal',
                            'file_path' => $filePath,
                            'uploaded_by' => Auth::id(),
                            'upload_date' => now(),
                        ]);
                        Log::info('[ProjectSubmit] ProjectDocument record created with ID: ' . $newDocument->id . ' for Project ID: ' . $project->id);
                    } catch (\Exception $docException) {
                        Log::error('[ProjectSubmit] Error creating ProjectDocument record: ' . $docException->getMessage());
                    }
                } else {
                    Log::info('[ProjectSubmit] No document was submitted with the form.');
                }

                session()->flash('message', 'Project submitted successfully!');
                $this->redirectRoute('my-projects.dashboard', navigate: true);
            });
        } catch (\Exception $e) {
            Log::error('[ProjectSubmit] General error in submit method: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while submitting the project. Please try again. ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.project-submission-form')
            ->layout('layouts.app', ['header' => $this->pageTitle]);
    }
} 