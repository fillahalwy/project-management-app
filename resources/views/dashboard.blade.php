<x-app-layout>
    <x-page-header title="Dashboard" :subtitle="'Welcome back, ' . auth()->user()->name . '!'" />

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <p class="text-sm text-gray-500 uppercase tracking-wide font-medium">Total Projects</p>
            <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalProjects }}</p>
            <a href="{{ route('projects.index') }}" class="text-xs text-indigo-600 hover:underline mt-1 inline-block">
                View all →
            </a>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <p class="text-sm text-gray-500 uppercase tracking-wide font-medium">Active Tasks</p>
            <p class="text-3xl font-bold text-gray-800 mt-2">{{ $activeTasks }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <p class="text-sm text-gray-500 uppercase tracking-wide font-medium">Completed Tasks</p>
            <p class="text-3xl font-bold text-gray-800 mt-2">{{ $completedTasks }}</p>
        </div>
    </div>
</x-app-layout>