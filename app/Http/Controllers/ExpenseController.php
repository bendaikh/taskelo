<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Project;
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
        return view('expenses.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'nullable|exists:projects,id',
            'category' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        Expense::create($validated);

        return redirect()->route('expenses.index')->with('success', 'Expense added successfully.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return back()->with('success', 'Expense deleted.');
    }
}


