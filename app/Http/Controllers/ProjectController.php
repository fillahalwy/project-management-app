<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProjectController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Project::with(['owner', 'members', 'tasks'])->latest();

        //search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $projects = $query->paginate(10)->withQueryString();

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

    public function show(Request $request,Project $project)
    {
        $project->load(['owner','members']);

        $taskQuery = $project->tasks()->with('assignee')->latest();

        if($request->filled('task_status')) {
            $taskQuery->where('status', $request->task_status);
        }

        if($request->filled('task_priority')) {
            $taskQuery->where('priority', $request->task_priority);
        }

        $tasks = $taskQuery->paginate(10)->withQueryString();

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
