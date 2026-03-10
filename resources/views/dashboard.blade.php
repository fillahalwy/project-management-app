<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-gray-500 mt-1">Welcome back, {{ auth()->user()->name }}!</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <p class="text-sm text-gray-500 uppercase tracking-wide font-medium">Total Projects</p>
            <p class="text-3xl font-bold text-gray-800 mt-2">0</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <p class="text-sm text-gray-500 uppercase tracking-wide font-medium">Active Tasks</p>
            <p class="text-3xl font-bold text-gray-800 mt-2">0</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <p class="text-sm text-gray-500 uppercase tracking-wide font-medium">Completed Tasks</p>
            <p class="text-3xl font-bold text-gray-800 mt-2">0</p>
        </div>
    </div>
</x-app-layout>