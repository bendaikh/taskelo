<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Project;
use App\Models\ExpenseCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $workspaceId = Auth::user()->current_workspace_id;
        
        $expenses = Expense::where('workspace_id', $workspaceId)
            ->with(['project', 'user', 'categoryRef'])
            ->latest('date')
            ->paginate(15);

        $total = Expense::where('workspace_id', $workspaceId)->sum('amount');

        return view('expenses.index', compact('expenses', 'total'));
    }

    public function create()
    {
        $workspaceId = Auth::user()->current_workspace_id;
        
        $projects = Project::where('workspace_id', $workspaceId)
            ->orderBy('title')->get(['id', 'title']);
        $categories = ExpenseCategory::where('workspace_id', $workspaceId)
            ->orderBy('name')->get(['id', 'name', 'is_salary']);
        $users = User::orderBy('name')->get(['id', 'name']);
        
        return view('expenses.create', compact('projects', 'categories', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'nullable|exists:projects,id',
            'expense_category_id' => 'nullable|exists:expense_categories,id',
            'user_id' => 'nullable|exists:users,id',
            'category' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // Backfill string category name from selected category if not provided
        if (($validated['category'] ?? null) === null && ($validated['expense_category_id'] ?? null)) {
            $cat = ExpenseCategory::find($validated['expense_category_id']);
            if ($cat) {
                $validated['category'] = $cat->name;
            }
        }

        $validated['workspace_id'] = Auth::user()->current_workspace_id;

        Expense::create($validated);

        return redirect()->route('expenses.index')->with('success', 'Expense added successfully.');
    }

    public function destroy(Expense $expense)
    {
        // Check if expense belongs to current workspace
        if ($expense->workspace_id !== Auth::user()->current_workspace_id) {
            abort(403, 'This expense does not belong to your current workspace.');
        }

        $expense->delete();
        return back()->with('success', 'Expense deleted.');
    }
}


