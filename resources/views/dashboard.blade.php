<x-app-layout>
    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="filament-card overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4 filament-text-primary">Welcome to Prometeo</h2>
                
                <p class="mb-4 filament-text-white">Your academic conference and research project management platform.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                    @if (Auth::user()->isParticipant())
                    <a href="{{ route('my-projects.dashboard') }}" class="filament-surface border border-gray-700 hover:border-gray-600 p-6 rounded-lg shadow-md hover:shadow-lg transition">
                        <h3 class="text-lg font-semibold filament-text-primary mb-2">My Projects</h3>
                        <p class="text-sm text-gray-300">View and manage your submitted research projects.</p>
                    </a>
                    
                    <a href="{{ route('projects.submit') }}" class="filament-surface border border-gray-700 hover:border-gray-600 p-6 rounded-lg shadow-md hover:shadow-lg transition">
                        <h3 class="text-lg font-semibold filament-text-primary mb-2">Submit New Project</h3>
                        <p class="text-sm text-gray-300">Submit a new research project proposal.</p>
                    </a>
                    @endif
                    
                    @if (Auth::user()->isAdmin())
                    <a href="/admin" class="filament-surface border border-gray-700 hover:border-gray-600 p-6 rounded-lg shadow-md hover:shadow-lg transition">
                        <h3 class="text-lg font-semibold filament-text-primary mb-2">Admin Panel</h3>
                        <p class="text-sm text-gray-300">Access the administrative dashboard.</p>
                    </a>
                    @endif
                    
                    <a href="{{ route('profile.show') }}" class="filament-surface border border-gray-700 hover:border-gray-600 p-6 rounded-lg shadow-md hover:shadow-lg transition">
                        <h3 class="text-lg font-semibold filament-text-primary mb-2">Profile</h3>
                        <p class="text-sm text-gray-300">View and edit your profile settings.</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
