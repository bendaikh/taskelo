<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Project;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $expenses = Expense::with('project')
            ->latest('date')
            ->paginate(15);

        $total = Expense::sum('amount');

        return view('expenses.index', compact('expenses', 'total'));
    }

    public function create()
    {
        $projects = Project::orderBy('title')->get(['id', 'title']);
        $categories = ExpenseCategory::orderBy('name')->get(['id', 'name']);
        return view('expenses.create', compact('projects', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'nullable|exists:projects,id',
            'expense_category_id' => 'nullable|exists:expense_categories,id',
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

        Expense::create($validated);

        return redirect()->route('expenses.index')->with('success', 'Expense added successfully.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return back()->with('success', 'Expense deleted.');
    }
}


