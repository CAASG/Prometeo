<div>
    <x-slot name="header">
        {{ $pageTitle ?? 'My Projects' }}
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-xl filament-card sm:rounded-lg">
                <div class="p-6 lg:p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h1 class="text-2xl font-medium filament-text-primary">
                            {{ $pageTitle ?? 'My Submitted Projects' }}
                        </h1>
                        <a href="{{ route('projects.submit') }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition border border-transparent rounded-md filament-btn-primary hover:bg-opacity-90 focus:outline-none focus:ring focus:ring-opacity-50">
                            Submit New Project
                        </a>
                    </div>

                    <div class="mt-6 leading-relaxed filament-text-white">
                        @if($projects->isNotEmpty())
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-700 filament-table">
                                    <thead class="filament-surface">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left uppercase filament-text-muted">
                                                Title
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left uppercase filament-text-muted">
                                                Category
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left uppercase filament-text-muted">
                                                Status
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left uppercase filament-text-muted">
                                                Submission Date
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left uppercase filament-text-muted">
                                                Documents
                                            </th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">View</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-700">
                                        @foreach ($projects as $project)
                                            <tr>
                                                <td class="px-6 py-4 text-sm font-medium whitespace-nowrap filament-text-white">
                                                    {{ $project->title }}
                                                </td>
                                                <td class="px-6 py-4 text-sm whitespace-nowrap filament-text-muted">
                                                    {{ $project->category->name ?? 'N/A' }}
                                                </td>
                                                <td class="px-6 py-4 text-sm whitespace-nowrap filament-text-muted">
                                                    <span class="inline-flex px-2 text-xs font-semibold leading-5 text-white rounded-full bg-primary-700">
                                                        {{ $project->status->name ?? 'N/A' }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-sm whitespace-nowrap filament-text-muted">
                                                    {{ $project->submission_date ? $project->submission_date->toFormattedDateString() : 'N/A' }}
                                                </td>
                                                <td class="px-6 py-4 text-sm whitespace-nowrap filament-text-muted">
                                                    @if ($project->documents->isNotEmpty())
                                                        <ul class="list-disc list-inside">
                                                            @foreach ($project->documents as $document)
                                                                <li>
                                                                    <a href="{{ route('documents.download', $document) }}" class="filament-text-primary hover:underline">
                                                                        {{ $document->document_type ?: 'View Document' }}
                                                                    </a>
                                                                    <span class="text-xs">({{ $document->upload_date->toFormattedDateString() }})</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        No documents.
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                                    <a href="{{ route('projects.show', $project) }}" class="filament-text-primary hover:underline">View Details</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                {{ $projects->links() }}
                            </div>
                        @else
                            <p class="mt-4">You have not submitted or are not a participant in any projects yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
