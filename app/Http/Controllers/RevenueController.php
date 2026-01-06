<?php

namespace App\Http\Controllers;

use App\Models\Revenue;
use App\Models\RevenueCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RevenueController extends Controller
{
    public function index(Request $request)
    {
        $workspaceId = Auth::user()->current_workspace_id;
        
        $revenues = Revenue::where('workspace_id', $workspaceId)
            ->with('categoryRef')
            ->latest('date')
            ->paginate(15);

        $total = Revenue::where('workspace_id', $workspaceId)->sum('amount');

        return view('revenues.index', compact('revenues', 'total'));
    }

    public function create()
    {
        $workspaceId = Auth::user()->current_workspace_id;
        
        $categories = RevenueCategory::where('workspace_id', $workspaceId)
            ->orderBy('name')->get(['id', 'name']);
        return view('revenues.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'revenue_category_id' => 'nullable|exists:revenue_categories,id',
            'category' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // Backfill string category name from selected category if not provided
        if (($validated['category'] ?? null) === null && ($validated['revenue_category_id'] ?? null)) {
            $cat = RevenueCategory::find($validated['revenue_category_id']);
            if ($cat) {
                $validated['category'] = $cat->name;
            }
        }

        $validated['workspace_id'] = Auth::user()->current_workspace_id;

        Revenue::create($validated);

        return redirect()->route('revenues.index')->with('success', 'Revenue added successfully.');
    }

    public function destroy(Revenue $revenue)
    {
        // Check if revenue belongs to current workspace
        if ($revenue->workspace_id !== Auth::user()->current_workspace_id) {
            abort(403, 'This revenue does not belong to your current workspace.');
        }

        $revenue->delete();
        return back()->with('success', 'Revenue deleted.');
    }
}

