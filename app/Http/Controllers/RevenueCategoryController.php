<?php

namespace App\Http\Controllers;

use App\Models\RevenueCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RevenueCategoryController extends Controller
{
    public function index()
    {
        $workspaceId = Auth::user()->current_workspace_id;
        
        $categories = RevenueCategory::where('workspace_id', $workspaceId)
            ->orderBy('name')->paginate(20);
        $totalCategories = RevenueCategory::where('workspace_id', $workspaceId)->count();
        return view('revenue_categories.index', compact('categories', 'totalCategories'));
    }

    public function create()
    {
        return view('revenue_categories.create');
    }

    public function store(Request $request)
    {
        $workspaceId = Auth::user()->current_workspace_id;
        
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($workspaceId) {
                    $exists = RevenueCategory::where('workspace_id', $workspaceId)
                        ->where('name', $value)
                        ->exists();
                    if ($exists) {
                        $fail('A category with this name already exists in your workspace.');
                    }
                },
            ],
            'description' => 'nullable|string',
        ]);

        $validated['workspace_id'] = $workspaceId;

        RevenueCategory::create($validated);

        return redirect()->route('revenue-categories.index')->with('success', 'Category created.');
    }

    public function destroy(RevenueCategory $revenue_category)
    {
        // Check if category belongs to current workspace
        if ($revenue_category->workspace_id !== Auth::user()->current_workspace_id) {
            abort(403, 'This category does not belong to your current workspace.');
        }

        $revenue_category->delete();
        return back()->with('success', 'Category deleted.');
    }
}

