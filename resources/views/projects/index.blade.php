<x-app-layout>
    <x-page-header title="Projects" subtitle="Manage all your projects">
        <x-slot name="actions">
            <a href="{{ route('projects.create') }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700">
                + New Project
            </a>
        </x-slot>
    </x-page-header>

    {{-- Filter & Search --}}
    <form method="GET" action="{{ route('projects.index') }}" class="bg-white rounded-xl border border-gray-200 p-4 mb-4 flex gap-3 items-end">
        <div class="flex-1">
            <label class="block text-xs font-medium text-gray-500 mb-1">Search</label>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search project name..."
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
            <select name="status"
                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">All Status</option>
                <option value="active"    {{ request('status') === 'active'    ? 'selected' : '' }}>Active</option>
                <option value="on_hold"   {{ request('status') === 'on_hold'   ? 'selected' : '' }}>On Hold</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>
        <button type="submit"
                class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700">
            Filter
        </button>
        @if(request('search') || request('status'))
            <a href="{{ route('projects.index') }}"
               class="px-4 py-2 rounded-lg text-sm font-medium text-gray-600 border border-gray-300 hover:bg-gray-50">
                Reset
            </a>
        @endif
    </form>

    {{-- project list  --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @forelse($projects as $project)
            <div class="p-5 border-b border-gray-100 last:border-0 hover:bg-gray-50 transition">
                <div class="flex items-start justify-between">
                    <div>
                        <a href="{{ route('projects.show', $project) }}"
                           class="text-lg font-semibold text-gray-800 hover:text-indigo-600">
                            {{ $project->name }}
                        </a>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ Str::limit($project->description, 100) }}
                        </p>
                        <div class="flex items-center gap-4 mt-2 text-xs text-gray-400">
                            <span>Owner: {{ $project->owner->name }}</span>
                            <span>{{ $project->tasks->count() }} tasks</span>
                            <span>{{ $project->members->count() }} members</span>
                        </div>
                    </div>
                    <x-badge :type="$project->status" :text="ucfirst(str_replace('_', ' ', $project->status))" />
                </div>
            </div>
        @empty
            <div class="p-10 text-center text-gray-400">
                No projects yet.
                <a href="{{ route('projects.create') }}" class="text-indigo-600 hover:underline">Create one.</a>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $projects->links() }}
    </div>
</x-app-layout>