<?php

namespace App\Filament\Pages;

use App\Models\Project;
use App\Models\User;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class EvaluatorDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static string $view = 'filament.pages.evaluator-dashboard';

    protected static ?string $navigationLabel = 'My Assigned Projects';

    protected static ?string $navigationGroup = 'Evaluations';

    protected static ?int $navigationSort = 1;

    public Collection $projects;

    public static function canAccess(): bool
    {
        /** @var User $user */
        $user = Auth::user();
        return $user && $user->hasRole('evaluator');
    }

    public function mount(): void
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user && $user->hasRole('evaluator')) {
            $this->projects = Project::whereHas('evaluators', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            })
            ->with(['projectStatus', 'evaluations' => function ($query) use ($user) {
                $query->where('evaluator_id', $user->id)->latest();
            }])
            ->get();
        } else {
            $this->projects = new Collection();
        }
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // Potentially add widgets later, e.g., stats about assigned projects
        ];
    }

    public function getTitle(): string
    {
        return __('My Assigned Projects');
    }
}
