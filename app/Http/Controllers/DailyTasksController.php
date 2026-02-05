<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyTasksController extends Controller
{
    /**
     * Display a listing of daily tasks for the current workspace
     */
    public function index()
    {
        $workspace = Auth::user()->currentWorkspace;
        
        if (!$workspace) {
            return redirect()->route('dashboard')->with('error', 'No workspace selected.');
        }

        // Get all tasks without a project_id (daily tasks) for the current workspace
        $tasks = Task::where('workspace_id', $workspace->id)
            ->whereNull('project_id')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('daily-tasks.index', compact('tasks', 'workspace'));
    }

    /**
     * Store a newly created daily task
     */
    public function store(Request $request)
    {
        $workspace = Auth::user()->currentWorkspace;
        
        if (!$workspace) {
            return response()->json([
                'success' => false,
                'message' => 'No workspace selected.'
            ], 400);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|in:todo,in_progress,done',
            'deadline' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $validated['workspace_id'] = $workspace->id;
        $validated['project_id'] = null; // Daily tasks don't belong to projects

        $task = Task::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Daily task created successfully.',
            'task' => $task
        ]);
    }

    /**
     * Update the specified daily task
     */
    public function update(Request $request, Task $task)
    {
        // Ensure the task belongs to the current workspace and is a daily task
        $workspace = Auth::user()->currentWorkspace;
        
        if ($task->workspace_id !== $workspace->id || $task->project_id !== null) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found or access denied.'
            ], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|in:todo,in_progress,done',
            'deadline' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $task->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Daily task updated successfully.',
            'task' => $task->fresh()
        ]);
    }

    /**
     * Update daily task status
     */
    public function updateStatus(Request $request, Task $task)
    {
        // Ensure the task belongs to the current workspace and is a daily task
        $workspace = Auth::user()->currentWorkspace;
        
        if ($task->workspace_id !== $workspace->id || $task->project_id !== null) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found or access denied.'
            ], 403);
        }

        $validated = $request->validate([
            'status' => 'required|in:todo,in_progress,done',
        ]);

        $task->update($validated);

        return response()->json([
            'success' => true,
            'task' => $task->fresh()
        ]);
    }

    /**
     * Remove the specified daily task
     */
    public function destroy(Task $task)
    {
        // Ensure the task belongs to the current workspace and is a daily task
        $workspace = Auth::user()->currentWorkspace;
        
        if ($task->workspace_id !== $workspace->id || $task->project_id !== null) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found or access denied.'
            ], 403);
        }

        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Daily task deleted successfully.'
        ]);
    }
}
