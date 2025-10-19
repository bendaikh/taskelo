<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects
     */
    public function index(Request $request)
    {
        $query = Project::with('client');

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by client
        if ($request->has('client_id') && $request->client_id !== '') {
            $query->where('client_id', $request->client_id);
        }

        $projects = $query->latest()->paginate(15);
        $clients = Client::orderBy('name')->get();

        return view('projects.index', compact('projects', 'clients'));
    }

    /**
     * Show the form for creating a new project
     */
    public function create()
    {
        $clients = Client::orderBy('name')->get();
        return view('projects.create', compact('clients'));
    }

    /**
     * Store a newly created project
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'title' => 'required|string|max:255',
            'budget' => 'nullable|numeric|min:0',
            'status' => 'required|in:planning,active,on_hold,completed,cancelled',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        // Default budget to 0 when omitted
        if (!array_key_exists('budget', $validated) || $validated['budget'] === null || $validated['budget'] === '') {
            $validated['budget'] = 0;
        }

        Project::create($validated);

        return redirect()->route('projects.index')
            ->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified project
     */
    public function show(Project $project)
    {
        $project->load(['client', 'tasks', 'payments']);
        
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified project
     */
    public function edit(Project $project)
    {
        $clients = Client::orderBy('name')->get();
        return view('projects.edit', compact('project', 'clients'));
    }

    /**
     * Update the specified project
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'title' => 'required|string|max:255',
            'budget' => 'nullable|numeric|min:0',
            'status' => 'required|in:planning,active,on_hold,completed,cancelled',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        if (!array_key_exists('budget', $validated) || $validated['budget'] === null || $validated['budget'] === '') {
            $validated['budget'] = 0;
        }

        $project->update($validated);

        return redirect()->route('projects.index')
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified project
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully.');
    }
}

