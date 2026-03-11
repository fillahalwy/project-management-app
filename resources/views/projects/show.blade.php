<x-app-layout>
    <x-page-header :title="$project->name">
        <x-slot name="actions">
            @can('update', $project)
            <a href="{{ route('projects.edit', $project) }}"
            class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50">
                Edit Project
            </a>
            @endcan

            @can('delete', $project)
            <form method="POST" action="{{ route('projects.destroy', $project) }}"
                onsubmit="return confirm('Delete this project? This cannot be undone.')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-600">
                    Delete
                </button>
            </form>
            @endcan
        </x-slot>
    </x-page-header>

    {{-- Project Info --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center gap-3 mb-3">
                <h2 class="text-lg font-semibold text-gray-800">Overview</h2>
                <x-badge :type="$project->status" :text="ucfirst(str_replace('_', ' ', $project->status))" />
            </div>
            <p class="text-gray-600 text-sm">{{ $project->description ?? 'No description provided.' }}</p>
            <p class="text-xs text-gray-400 mt-3">Owner: {{ $project->owner->name }}</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="text-lg font-semibold text-gray-800 mb-3">Members</h2>
            @forelse($project->members as $member)
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-7 h-7 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs font-bold">
                        {{ strtoupper(substr($member->name, 0, 1)) }}
                    </div>
                    <span class="text-sm text-gray-700">{{ $member->name }}</span>
                </div>
            @empty
                <p class="text-sm text-gray-400">No members yet.</p>
            @endforelse
        </div>
    </div>

    {{-- Task Filter --}}
    <form method="GET" action="{{ route('projects.show', $project) }}"
        class="p-4 border-b border-gray-100 flex gap-3 items-end bg-gray-50">
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
            <select name="task_status"
                    class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">All</option>
                <option value="todo"        {{ request('task_status') === 'todo'        ? 'selected' : '' }}>To Do</option>
                <option value="in_progress" {{ request('task_status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="done"        {{ request('task_status') === 'done'        ? 'selected' : '' }}>Done</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Priority</label>
            <select name="task_priority"
                    class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">All</option>
                <option value="low"    {{ request('task_priority') === 'low'    ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ request('task_priority') === 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="high"   {{ request('task_priority') === 'high'   ? 'selected' : '' }}>High</option>
            </select>
        </div>
        <button type="submit"
                class="bg-indigo-600 text-white px-3 py-1.5 rounded-lg text-sm font-medium hover:bg-indigo-700">
            Filter
        </button>
        @if(request('task_status') || request('task_priority'))
            <a href="{{ route('projects.show', $project) }}"
            class="px-3 py-1.5 rounded-lg text-sm text-gray-600 border border-gray-300 hover:bg-gray-50">
                Reset
            </a>
        @endif
    </form>

    {{-- Tasks --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800">Tasks</h2>
            @if($project->isOwner(auth()->user()) || $project->isMember(auth()->user()))
                <a href="{{ route('projects.tasks.create', $project) }}"class="bg-indigo-600 text-white px-3 py-1.5 rounded-lg text-sm font-medium hover:bg-indigo-700">
                    + Add Task
                </a>
            @endif
        </div>

        @forelse($tasks as $task)
            <div class="p-4 border-b border-gray-50 last:border-0 hover:bg-gray-50 transition">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-800">{{ $task->title }}</p>
                        @if($task->description)
                            <p class="text-xs text-gray-400 mt-0.5">{{ Str::limit($task->description, 80) }}</p>
                        @endif
                        <div class="flex items-center gap-2 mt-1.5 flex-wrap">
                            <x-badge :type="$task->priority" :text="ucfirst($task->priority)" />
                            <span class="text-xs text-gray-400">
                                {{ $task->assignee ? 'Assigned to: ' . $task->assignee->name : 'Unassigned' }}
                            </span>
                            @if($task->deadline)
                                @php
                                    $isOverdue = $task->deadline->isPast() && $task->status !== 'done';
                                    $isToday   = $task->deadline->isToday();
                                @endphp
                                <span class="text-xs flex items-center gap-1 {{ $isOverdue ? 'text-red-500 font-medium' : ($isToday ? 'text-amber-500 font-medium' : 'text-gray-400') }}">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 9v7.5" />
                                    </svg>
                                    {{ $isOverdue ? 'Overdue · ' : ($isToday ? 'Due today · ' : '') }}{{ $task->deadline->format('d M Y') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    {{-- Task actions --}}
                    <div class="flex items-center gap-2">
                        <x-badge :type="$task->status" :text="ucfirst(str_replace('_', ' ', $task->status))" />
                        
                        @can('update', $task)
                        <a href="{{ route('tasks.edit', $task) }}"
                        class="text-xs text-indigo-600 hover:underline">Edit</a>
                        @endcan
                        
                        @can('delete', $task)
                        <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                            onsubmit="return confirm('Delete this task?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-red-500 hover:underline">Delete</button>
                        </form>
                        @endcan
                    </div>
                </div>
            </div>
        @empty
            <div class="p-8 text-center text-gray-400 text-sm">
                No tasks yet.
                <a href="{{ route('projects.tasks.create', $project) }}" class="text-indigo-600 hover:underline">Add the first one.</a>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $tasks->links() }}
    </div>
</x-app-layout>