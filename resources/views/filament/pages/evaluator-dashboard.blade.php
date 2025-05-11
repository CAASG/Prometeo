<x-filament-panels::page>
    <div class="space-y-4">
        @if($projects->count() > 0)
            @foreach($projects as $project)
                <x-filament::card class="mb-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $project->title }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Current Status: 
                                <span class="px-2 py-1 text-xs font-medium rounded-full"
                                      style="background-color: {{ $project->projectStatus->color ?? '#9ca3af' }}; color: {{ \App\Helpers\ColorHelper::isColorDark($project->projectStatus->color ?? '#9ca3af') ? '#ffffff' : '#000000' }};">
                                    {{ $project->projectStatus->name ?? 'N/A' }}
                                </span>
                            </p>
                            @if($project->evaluations->first())
                                @php
                                    $evaluation = $project->evaluations->first();
                                @endphp
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    Your Evaluation Status: 
                                    @if($evaluation->is_completed)
                                        <span class="text-green-500">Completed</span>
                                    @else
                                        <span class="text-yellow-500">Pending</span>
                                    @endif
                                    (Score: {{ $evaluation->total_score ?? 'N/A' }})
                                </p>
                            @else
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">No evaluation started yet.</p>
                            @endif
                        </div>
                        <div>
                            @if($project->evaluations->first())
                                <x-filament::button
                                    tag="a"
                                    href="{{ \App\Filament\Resources\EvaluationResource::getUrl('edit', ['record' => $project->evaluations->first()->id]) }}"
                                    icon="heroicon-o-pencil-square"
                                >
                                    {{ $project->evaluations->first()->is_completed ? 'View Evaluation' : 'Edit Evaluation' }}
                                </x-filament::button>
                            @else
                                {{-- Link to create a new evaluation if one doesn't exist --}}
                                {{-- This might need adjustment based on how evaluations are initiated by evaluators --}}
                                <x-filament::button
                                    tag="a"
                                    href="{{ \App\Filament\Resources\EvaluationResource::getUrl('create', ['project_id' => $project->id, 'evaluator_id' => auth()->id()]) }}" 
                                    icon="heroicon-o-plus-circle"
                                    color="secondary"
                                >
                                    Start Evaluation
                                </x-filament::button>
                            @endif
                        </div>
                    </div>
                </x-filament::card>
            @endforeach
        @else
            <x-filament::card>
                <div class="text-center py-4">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No projects assigned</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">You currently have no projects assigned for evaluation.</p>
                </div>
            </x-filament::card>
        @endif
    </div>
</x-filament-panels::page>
