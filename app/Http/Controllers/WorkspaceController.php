<?php

namespace App\Http\Controllers;

use App\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkspaceController extends Controller
{
    /**
     * Display a listing of the user's workspaces
     */
    public function index()
    {
        $workspaces = Auth::user()->workspaces()->with('owner')->get();
        return view('workspaces.index', compact('workspaces'));
    }

    /**
     * Show the form for creating a new workspace
     */
    public function create()
    {
        return view('workspaces.create');
    }

    /**
     * Store a newly created workspace
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:personal,business',
            'description' => 'nullable|string|max:1000',
        ]);

        $workspace = Workspace::create([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'description' => $validated['description'] ?? null,
            'owner_id' => Auth::id(),
            'is_active' => true,
        ]);

        // Add the creator to the workspace as owner
        $workspace->users()->attach(Auth::id(), ['role' => 'owner']);

        // Switch to the new workspace
        Auth::user()->update(['current_workspace_id' => $workspace->id]);

        return redirect()->route('workspaces.index')
            ->with('success', 'Workspace created successfully!');
    }

    /**
     * Display the specified workspace
     */
    public function show(Workspace $workspace)
    {
        // Check if user has access to this workspace
        if (!$workspace->users->contains(Auth::id())) {
            abort(403, 'You do not have access to this workspace.');
        }

        return view('workspaces.show', compact('workspace'));
    }

    /**
     * Show the form for editing the specified workspace
     */
    public function edit(Workspace $workspace)
    {
        // Only owner can edit
        if ($workspace->owner_id !== Auth::id()) {
            abort(403, 'Only the workspace owner can edit it.');
        }

        return view('workspaces.edit', compact('workspace'));
    }

    /**
     * Update the specified workspace
     */
    public function update(Request $request, Workspace $workspace)
    {
        // Only owner can update
        if ($workspace->owner_id !== Auth::id()) {
            abort(403, 'Only the workspace owner can update it.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ]);

        $workspace->update($validated);

        return redirect()->route('workspaces.index')
            ->with('success', 'Workspace updated successfully!');
    }

    /**
     * Remove the specified workspace
     */
    public function destroy(Workspace $workspace)
    {
        // Only owner can delete
        if ($workspace->owner_id !== Auth::id()) {
            abort(403, 'Only the workspace owner can delete it.');
        }

        // Don't allow deleting if it's the only workspace
        if (Auth::user()->workspaces()->count() <= 1) {
            return back()->with('error', 'You must have at least one workspace.');
        }

        // If this is the current workspace, switch to another one
        if (Auth::user()->current_workspace_id === $workspace->id) {
            $newWorkspace = Auth::user()->workspaces()
                ->where('id', '!=', $workspace->id)
                ->first();
            
            Auth::user()->update(['current_workspace_id' => $newWorkspace->id]);
        }

        $workspace->delete();

        return redirect()->route('workspaces.index')
            ->with('success', 'Workspace deleted successfully!');
    }

    /**
     * Switch to a different workspace
     */
    public function switch(Request $request, Workspace $workspace)
    {
        // Check if user has access to this workspace
        if (!$workspace->users->contains(Auth::id())) {
            abort(403, 'You do not have access to this workspace.');
        }

        Auth::user()->update(['current_workspace_id' => $workspace->id]);

        return redirect()->back()->with('success', 'Switched to ' . $workspace->name);
    }
}

