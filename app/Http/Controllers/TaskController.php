<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use AuthorizesRequests;

    public function create(Project $project)
    {
        // yang boleh buat task: owner atau member project
        if (!$project->isOwner(auth()->user()) && !$project->isMember(auth()->user())) {
            abort(403);
        }

        // owner juga masuk daftar supaya bisa di-assign
        $members = $project->members()->get()->push($project->owner)->unique('id');
        return view('tasks.create', compact('project', 'members'));
    }

    public function store(StoreTaskRequest $request, Project $project)
    {
        if (!$project->isOwner(auth()->user()) && !$project->isMember(auth()->user())) {
            abort(403);
        }

        $project->tasks()->create($request->validated());
        return redirect()->route('projects.show', $project)->with('success', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        $this->authorize('update', $task);

        $project = $task->project;
        // owner juga masuk daftar supaya bisa di-assign
        $members = $project->members()->get()->push($project->owner)->unique('id');
        return view('tasks.edit', compact('project', 'task', 'members'));
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        $task->update($request->validated());
        return redirect()->route('projects.show', $task->project)->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();
        return redirect()->route('projects.show', $task->project)->with('success', 'Task deleted successfully.');
    }
}
