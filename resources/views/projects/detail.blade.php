<x-app-layout>
    <x-slot name="header">
        Project Details
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-xl filament-card sm:rounded-lg">
                <div class="p-6 lg:p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h1 class="text-2xl font-medium filament-text-primary">
                            {{ $project->title }}
                        </h1>
                        <a href="{{ route('my-projects.dashboard') }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition border border-transparent rounded-md filament-btn-secondary hover:bg-opacity-90 focus:outline-none focus:ring focus:ring-opacity-50">
                            Back to My Projects
                        </a>
                    </div>

                    <div class="grid grid-cols-1 gap-6 mt-6 md:grid-cols-2">
                        <!-- Project Information -->
                        <div class="p-4 border border-gray-700 rounded-lg filament-surface">
                            <h2 class="mb-4 text-lg font-semibold filament-text-primary">Project Information</h2>
                            
                            <div class="space-y-3 filament-text-white">
                                <div>
                                    <h3 class="text-sm font-medium filament-text-muted">Category</h3>
                                    <p>{{ $project->category->name ?? 'N/A' }}</p>
                                </div>
                                
                                <div>
                                    <h3 class="text-sm font-medium filament-text-muted">Status</h3>
                                    <p>
                                        <span class="inline-flex px-2 text-xs font-semibold leading-5 text-white rounded-full bg-primary-700">
                                            {{ $project->status->name ?? 'N/A' }}
                                        </span>
                                    </p>
                                </div>
                                
                                <div>
                                    <h3 class="text-sm font-medium filament-text-muted">Submission Date</h3>
                                    <p>{{ $project->submission_date ? $project->submission_date->format('F j, Y') : 'N/A' }}</p>
                                </div>
                                
                                <div>
                                    <h3 class="text-sm font-medium filament-text-muted">Thematic Areas</h3>
                                    <ul class="list-disc list-inside">
                                        @forelse($project->themes as $theme)
                                            <li>{{ $theme->name }}</li>
                                        @empty
                                            <li>No themes specified</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Project Documents -->
                        <div class="p-4 border border-gray-700 rounded-lg filament-surface">
                            <h2 class="mb-4 text-lg font-semibold filament-text-primary">Project Documents</h2>
                            
                            @if($project->documents->isNotEmpty())
                                <ul class="space-y-2">
                                    @foreach($project->documents as $document)
                                        <li class="p-3 border border-gray-700 rounded-md">
                                            <div class="flex justify-between">
                                                <div>
                                                    <p class="font-medium filament-text-white">{{ $document->document_type }}</p>
                                                    <p class="text-xs filament-text-muted">Uploaded: {{ $document->upload_date->format('M j, Y') }}</p>
                                                    <p class="text-xs filament-text-muted">By: {{ $document->uploader->name ?? 'Unknown' }}</p>
                                                </div>
                                                <div>
                                                    <a href="{{ route('documents.download', $document) }}" class="inline-flex items-center px-3 py-1 text-xs font-semibold tracking-widest text-white uppercase transition border border-transparent rounded-md filament-btn-primary hover:bg-opacity-90 focus:outline-none focus:ring focus:ring-opacity-50">
                                                        Download
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="filament-text-muted">No documents have been uploaded for this project.</p>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Project Description -->
                    <div class="p-4 mt-6 border border-gray-700 rounded-lg filament-surface">
                        <h2 class="mb-4 text-lg font-semibold filament-text-primary">Project Description</h2>
                        <div class="prose prose-invert max-w-none filament-text-white">
                            {{ $project->description }}
                        </div>
                    </div>
                    
                    <!-- Project Team Members -->
                    <div class="p-4 mt-6 border border-gray-700 rounded-lg filament-surface">
                        <h2 class="mb-4 text-lg font-semibold filament-text-primary">Project Team</h2>
                        
                        @if($project->participants->isNotEmpty())
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-700 filament-table">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2 text-xs font-medium tracking-wider text-left uppercase filament-text-muted">Name</th>
                                            <th class="px-4 py-2 text-xs font-medium tracking-wider text-left uppercase filament-text-muted">Role</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-700">
                                        @foreach($project->participants as $participant)
                                            <tr>
                                                <td class="px-4 py-2 whitespace-nowrap filament-text-white">
                                                    {{ $participant->name }}
                                                </td>
                                                <td class="px-4 py-2 whitespace-nowrap filament-text-white">
                                                    {{ $participant->pivot->is_director ? 'Director' : 'Participant' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="filament-text-muted">No team members assigned to this project.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 