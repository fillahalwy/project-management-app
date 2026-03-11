<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;

class TaskController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
     {
        $members = $project->members();
        return view('tasks.create', compact('project', 'members'));
     }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request, Project $project)
    {
        $project->tasks()->create($request->validated());

        return redirect()->route('projects.show', $project)->with('success', 'Task created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project, Task $task)
    {
        $members = $project->members();
        return view('tasks.edit', compact('project', 'task', 'members'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Project $project, Task $task)
    {
        $task->update($request->validated());

        return redirect()->route('projects.show', $project)->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Task $task)
    {
        $task->delete();

        return redirect()->route('projects.show', $project)->with('success', 'Task deleted successfully.');
    }
}
