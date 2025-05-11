<div>
    <x-slot name="header">
        {{ $pageTitle }}
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-xl filament-card sm:rounded-lg">
                <div class="p-6 lg:p-8">
                    <h1 class="mb-6 text-2xl font-medium filament-text-primary">
                        {{ $pageTitle }}
                    </h1>

                    @if (session()->has('message'))
                        <div class="relative px-4 py-3 mb-4 text-white bg-green-600 border border-green-700 rounded" role="alert">
                            <strong class="font-bold">Success!</strong>
                            <span class="block sm:inline">{{ session('message') }}</span>
                        </div>
                    @endif

                    @if (session()->has('error'))
                        <div class="relative px-4 py-3 mb-4 text-white bg-red-600 border border-red-700 rounded" role="alert">
                            <strong class="font-bold">Error!</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <form wire:submit.prevent="submit">
                        @csrf

                        <!-- Project Title -->
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium filament-text-white">Project Title</label>
                            <input type="text" wire:model.defer="title" id="title" class="block w-full mt-1 rounded-md shadow-sm filament-input focus:ring focus:ring-opacity-50">
                            @error('title') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <!-- Project Description -->
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium filament-text-white">Project Description (min. 50 characters)</label>
                            <textarea wire:model.defer="description" id="description" rows="6" class="block w-full mt-1 rounded-md shadow-sm filament-input focus:ring focus:ring-opacity-50"></textarea>
                            @error('description') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <!-- Project Category -->
                        <div class="mb-4">
                            <label for="project_category_id" class="block text-sm font-medium filament-text-white">Project Category</label>
                            <select wire:model.defer="project_category_id" id="project_category_id" class="block w-full mt-1 rounded-md shadow-sm filament-input focus:ring focus:ring-opacity-50">
                                <option value="">Select Category...</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('project_category_id') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <!-- Project Themes -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium filament-text-white">Thematic Areas (select at least one)</label>
                            <div class="grid grid-cols-1 gap-4 mt-2 md:grid-cols-2 lg:grid-cols-3">
                                @foreach ($themes as $theme)
                                    <label class="flex items-center p-2 space-x-3 border border-gray-700 rounded-md filament-surface hover:bg-gray-800">
                                        <input type="checkbox" wire:model.defer="selected_themes" value="{{ $theme->id }}" class="border-gray-600 rounded shadow-sm text-primary-600 focus:border-primary-300 focus:ring focus:ring-offset-0 focus:ring-primary-200 focus:ring-opacity-50">
                                        <span class="text-sm filament-text-white">{{ $theme->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('selected_themes') <span class="mt-2 text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>
                        
                        <!-- Document Upload -->
                        <div class="mb-6">
                            <label for="document" class="block text-sm font-medium filament-text-white">Initial Project Document (Optional, PDF/DOC/DOCX, max 10MB)</label>
                            <input type="file" wire:model="document" id="document" class="block w-full mt-1 text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-600 file:text-white hover:file:bg-primary-700">
                            <div wire:loading wire:target="document" class="mt-1 text-sm text-gray-400">Uploading...</div>
                            @error('document') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" wire:loading.attr="disabled" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition rounded-md filament-btn-primary hover:bg-opacity-90 focus:outline-none focus:ring focus:ring-opacity-50 disabled:opacity-50">
                                <svg wire:loading wire:target="submit" class="w-5 h-5 mr-3 -ml-1 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                  </svg>
                                Submit Project
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 