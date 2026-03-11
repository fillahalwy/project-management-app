<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Models\User;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with('owner', 'members', 'tasks')
        ->latest()
        ->paginate(10);

        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        return view ('projects.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $project = Project::create([
            'name'        => $request->name,
            'description' => $request->description,
            'status'      => $request->status,
            'owner_id'    => auth()->id(),
        ]);
        
        if ($request->filled('members')) {
            $project->members()->attach($request->members);
        }

        return redirect()->route('projects.show', $project  )->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->load([
            'owner',
            'members',
            'tasks.assignee',
        ]);

        $tasks = $project->tasks()->with('assignee')->latest()->paginate(10);

        return view('projects.show', compact('project', 'tasks'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $users = User::where('id', '!=', auth()->id())->get();
        $currentMemberIds = $project->members()->pluck('id')->toArray();
        return view('projects.edit', compact('project', 'users', 'currentMemberIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->update([
            'name'        => $request->name,
            'description' => $request->description,
            'status'      => $request->status,
        ]);

        // Sync members
        $project->members()->sync($request->members ?? []);

        return redirect()->route('projects.show', $project)->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
}
