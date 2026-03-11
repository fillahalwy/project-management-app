<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('dashboard'));

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        $user = auth()->user();

        $totalProjects  = \App\Models\Project::count();
        $activeTasks    = \App\Models\Task::where('status', '!=', 'done')->count();
        $completedTasks = \App\Models\Task::where('status', 'done')->count();

        return view('dashboard', compact('totalProjects', 'activeTasks', 'completedTasks'));
    })->name('dashboard');

    // Projects
    Route::resource('projects', ProjectController::class);

    // shallow() biar route edit/update/destroy pakai /tasks/{task}
    // jadi nggak perlu bawa-bawa project_id di URL
    Route::resource('projects.tasks', TaskController::class)
        ->only(['create', 'store', 'edit', 'update', 'destroy'])
        ->shallow();
});

require __DIR__ . '/auth.php';