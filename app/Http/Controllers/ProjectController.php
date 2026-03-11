<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProjectController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $projects = Project::with('owner', 'members', 'tasks')
        ->latest()
        ->paginate(10);

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $this->authorize('create', Project::class);

        $users = User::where('id', '!=', auth()->id())->get();
        return view ('projects.create', compact('users'));
    }

    public function store(StoreProjectRequest $request)
    {
        $this->authorize('create', Project::class);

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

    public function edit(Project $project)
    {
        $this->authorize('update', $project);

        $users = User::where('id', '!=', auth()->id())->get();
        $currentMemberIds = $project->members()->pluck('id')->toArray();
        return view('projects.edit', compact('project', 'users', 'currentMemberIds'));
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $this->authorize('update', $project);

        $project->update([
            'name'        => $request->name,
            'description' => $request->description,
            'status'      => $request->status,
        ]);

        // Sync members
        $project->members()->sync($request->members ?? []);

        return redirect()->route('projects.show', $project)->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
}
