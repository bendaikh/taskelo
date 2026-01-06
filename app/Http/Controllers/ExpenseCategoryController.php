<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        $workspaceId = Auth::user()->current_workspace_id;
        
        $categories = ExpenseCategory::where('workspace_id', $workspaceId)
            ->orderBy('name')->paginate(20);
        $totalCategories = ExpenseCategory::where('workspace_id', $workspaceId)->count();
        return view('expense_categories.index', compact('categories', 'totalCategories'));
    }

    public function create()
    {
        return view('expense_categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:expense_categories,name',
            'description' => 'nullable|string',
        ]);

        $validated['workspace_id'] = Auth::user()->current_workspace_id;

        ExpenseCategory::create($validated);

        return redirect()->route('expense-categories.index')->with('success', 'Category created.');
    }

    public function destroy(ExpenseCategory $expense_category)
    {
        // Check if category belongs to current workspace
        if ($expense_category->workspace_id !== Auth::user()->current_workspace_id) {
            abort(403, 'This category does not belong to your current workspace.');
        }

        $expense_category->delete();
        return back()->with('success', 'Category deleted.');
    }
}


