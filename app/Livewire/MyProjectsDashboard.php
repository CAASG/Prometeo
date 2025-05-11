<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Project; // Asegúrate de importar el modelo Project
use Livewire\WithPagination; // Para paginación si la lista es larga

class MyProjectsDashboard extends Component
{
    use WithPagination;

    public string $pageTitle = 'My Submitted Projects';

    public function render()
    {
        $user = Auth::user();
        $projects = collect(); // Inicializa como una colección vacía

        // Asegurarse de que el usuario esté autenticado y sea un participante
        if ($user && $user->isParticipant()) {
            // Obtener los proyectos donde el usuario es participante
            // Necesitamos la relación 'participatingProjects' que definimos en el modelo User
            $projects = $user->participatingProjects()
                            ->with(['category', 'status', 'documents.uploader']) // Eager load documents and their uploader
                            ->orderBy('submission_date', 'desc')
                            ->paginate(10); // Paginamos, por ejemplo, 10 proyectos por página
        }

        return view('livewire.my-projects-dashboard', [
            'projects' => $projects,
        ])->layout('layouts.app'); // Asumiendo que usas el layout app.blade.php de Jetstream
    }
}
