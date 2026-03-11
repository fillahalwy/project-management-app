<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use Symfony\Component\HttpKernel\HttpCache\Store;

class TaskController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
     {
        $members = $project->members()->get()->push($project->owner)->unique('id');
        return view('tasks.create', compact('project', 'members'));
     }

    public function store(StoreTaskRequest $request, Project $project)
    {
        // dd($request->input('status'), $request->input('priority'));
        $project->tasks()->create($request->validated());

        return redirect()->route('projects.show', $project)->with('success', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        $project = $task->project;
        $members = $project->members()->get()->push($project->owner)->unique('id');
        return view('tasks.edit', compact('project', 'task', 'members'));
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        return redirect()->route('projects.show', $task->project)->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('projects.show', $task->project)->with('success', 'Task deleted successfully.');
    }
}
