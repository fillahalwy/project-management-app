<x-app-layout>
    <div class="flex flex-col items-center justify-center py-20">
        <p class="text-6xl font-bold text-indigo-600">403</p>
        <h1 class="text-2xl font-bold text-gray-800 mt-4">Access Denied</h1>
        <p class="text-gray-500 mt-2">You don't have permission to perform this action.</p>
        <a href="{{ route('dashboard') }}"
           class="mt-6 bg-indigo-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700">
            Back to Dashboard
        </a>
    </div>
</x-app-layout>