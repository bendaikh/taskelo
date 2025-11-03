<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        $categories = ExpenseCategory::orderBy('name')->paginate(20);
        $totalCategories = ExpenseCategory::count();
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

        ExpenseCategory::create($validated);

        return redirect()->route('expense-categories.index')->with('success', 'Category created.');
    }

    public function destroy(ExpenseCategory $expense_category)
    {
        $expense_category->delete();
        return back()->with('success', 'Category deleted.');
    }
}


