<x-app-layout>
    <x-page-header title="Edit Task" :subtitle="'Project: ' . $project->name">
        <x-slot name="actions">
            <a href="{{ route('projects.show', $project) }}"
               class="text-sm text-gray-600 hover:text-gray-800">
                ← Back to Project
            </a>
        </x-slot>
    </x-page-header>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 max-w-2xl">
        <form method="POST" action="{{ route('tasks.update', $task) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Task Title *</label>
                <input type="text" name="title" value="{{ old('title', $task->title) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('title') border-red-400 @enderror">
                <x-input-error field="title" />
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description', $task->description) }}</textarea>
                <x-input-error field="description" />
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                    <select name="status"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @foreach(['todo' => 'To Do', 'in_progress' => 'In Progress', 'done' => 'Done'] as $value => $label)
                            <option value="{{ $value }}"
                                {{ old('status', $task->status) === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error field="status" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Priority *</label>
                    <select name="priority"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @foreach(['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'] as $value => $label)
                            <option value="{{ $value }}"
                                {{ old('priority', $task->priority) === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error field="priority" />
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Assign To</label>
                <select name="assigned_to"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">— Unassigned —</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}"
                            {{ old('assigned_to', $task->assigned_to) == $member->id ? 'selected' : '' }}>
                            {{ $member->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error field="assigned_to" />
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="bg-indigo-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700">
                    Update Task
                </button>
                <a href="{{ route('projects.show', $project) }}"
                   class="px-5 py-2 rounded-lg text-sm font-medium text-gray-600 border border-gray-300 hover:bg-gray-50">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-app-layout>