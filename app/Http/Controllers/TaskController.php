<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Store a newly created task
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'status' => 'required|in:todo,in_progress,done',
            'price' => 'nullable|numeric|min:0',
            'deadline' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        Task::create($validated);

        return back()->with('success', 'Task created successfully.');
    }

    /**
     * Update the specified task
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|in:todo,in_progress,done',
            'price' => 'nullable|numeric|min:0',
            'deadline' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $task->update($validated);

        return back()->with('success', 'Task updated successfully.');
    }

    /**
     * Update task status (for Vue component)
     */
    public function updateStatus(Request $request, Task $task)
    {
        $validated = $request->validate([
            'status' => 'required|in:todo,in_progress,done',
        ]);

        $task->update($validated);

        return response()->json([
            'success' => true,
            'task' => $task,
            'progress' => $task->project->progress
        ]);
    }

    /**
     * Remove the specified task
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return back()->with('success', 'Task deleted successfully.');
    }
}

