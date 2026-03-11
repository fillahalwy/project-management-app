<x-app-layout>
    <x-page-header title="Create Project">
        <x-slot name="actions">
            <a href="{{ route('projects.index') }}"
               class="text-sm text-gray-600 hover:text-gray-800">
                ← Back to Projects
            </a>
        </x-slot>
    </x-page-header>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 max-w-2xl">
        <form method="POST" action="{{ route('projects.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Project Name *</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('name') border-red-400 @enderror">
                <x-input-error field="name" />
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description') }}</textarea>
                <x-input-error field="description" />
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                <select name="status"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="active"    {{ old('status') === 'active'    ? 'selected' : '' }}>Active</option>
                    <option value="on_hold"   {{ old('status') === 'on_hold'   ? 'selected' : '' }}>On Hold</option>
                    <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
                <x-input-error field="status" />
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Add Members</label>
                <div class="space-y-2 max-h-40 overflow-y-auto border border-gray-200 rounded-lg p-3">
                    @foreach($users as $user)
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" name="members[]" value="{{ $user->id }}"
                                   {{ in_array($user->id, old('members', [])) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-indigo-600">
                            {{ $user->name }}
                            <span class="text-gray-400">({{ $user->email }})</span>
                        </label>
                    @endforeach
                </div>
                <x-input-error field="members" />
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="bg-indigo-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700">
                    Create Project
                </button>
                <a href="{{ route('projects.index') }}"
                   class="px-5 py-2 rounded-lg text-sm font-medium text-gray-600 border border-gray-300 hover:bg-gray-50">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-app-layout>