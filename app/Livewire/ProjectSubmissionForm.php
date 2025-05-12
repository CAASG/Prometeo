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

    public $participantEmail = '';
    public $selectedParticipantId = null;
    public $participants = [];
    public $allParticipantUsers = [];

    public function mount()
    {
        $this->categories = ProjectCategory::where('is_active', true)->orderBy('name')->get(['id', 'name']);
        $this->themes = ProjectTheme::where('is_active', true)->orderBy('name')->get(['id', 'name']);
        // Cargar todos los usuarios con rol participante (para el select)
        $this->allParticipantUsers = User::whereHas('roles', fn($q) => $q->where('name', 'participant'))
            ->orderBy('name')->get();
        // Por defecto, agregar al usuario autenticado como director
        $this->participants = [[
            'id' => Auth::id(),
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'is_director' => true,
        ]];
    }

    public function addParticipantByEmail()
    {
        $this->validate([
            'participantEmail' => 'required|email',
        ]);
        $user = User::where('email', $this->participantEmail)
            ->whereHas('roles', fn($q) => $q->where('name', 'participant'))
            ->first();
        if (!$user) {
            $this->addError('participantEmail', 'No participant user found with that email.');
            return;
        }
        if (collect($this->participants)->contains('id', $user->id)) {
            $this->addError('participantEmail', 'This user is already added.');
            return;
        }
        $this->participants[] = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'is_director' => false,
        ];
        $this->participantEmail = '';
    }

    public function addParticipantBySelect()
    {
        $this->validate([
            'selectedParticipantId' => 'required|integer',
        ]);
        $user = collect($this->allParticipantUsers)->firstWhere('id', $this->selectedParticipantId);
        if (!$user) {
            $this->addError('selectedParticipantId', 'Invalid participant selected.');
            return;
        }
        if (collect($this->participants)->contains('id', $user->id)) {
            $this->addError('selectedParticipantId', 'This user is already added.');
            return;
        }
        $this->participants[] = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'is_director' => false,
        ];
        $this->selectedParticipantId = null;
    }

    public function removeParticipant($id)
    {
        // No permitir quitar al director si es el único
        if (count($this->participants) === 1) return;
        $this->participants = array_values(array_filter($this->participants, fn($p) => $p['id'] != $id));
        // Si el director fue removido, asignar el primero como director
        if (!collect($this->participants)->contains('is_director', true)) {
            $this->participants[0]['is_director'] = true;
        }
    }

    public function makeDirector($id)
    {
        foreach ($this->participants as &$p) {
            $p['is_director'] = ($p['id'] == $id);
        }
        unset($p);
    }

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:50',
            'project_category_id' => 'required|exists:project_categories,id',
            'selected_themes' => 'required|array|min:1',
            'selected_themes.*' => 'exists:project_themes,id',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'participants' => 'required|array|min:1',
            'participants.*.id' => 'required|integer|distinct',
            'participants.*.is_director' => 'boolean',
        ];
    }

    protected $messages = [
        'description.min' => 'The project description must be at least 50 characters.',
        'selected_themes.min' => 'Please select at least one thematic area.',
    ];

    public function submit()
    {
        $this->validate();
        // Validar que haya un director
        if (!collect($this->participants)->contains('is_director', true)) {
            $this->addError('participants', 'You must select a project director.');
            return;
        }
        try {
            DB::transaction(function () {
                $initialStatus = ProjectStatus::where('sequence_order', 1)->first();
                if (!$initialStatus) {
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
                // Participantes
                $syncData = [];
                foreach ($this->participants as $p) {
                    $syncData[$p['id']] = ['is_director' => $p['is_director']];
                }
                $project->participants()->sync($syncData);
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
        return view('livewire.project-submission-form', [
            'header' => $this->pageTitle,
        ]);
    }
} 