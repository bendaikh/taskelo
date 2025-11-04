<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\FlowNode;
use App\Models\FlowEdge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessController extends Controller
{
    /**
     * Display a listing of businesses
     */
    public function index(Request $request)
    {
        $type = $request->get('type', 'active'); // Default to 'active'
        
        $businesses = Business::where('user_id', Auth::id())
            ->where('type', $type)
            ->with(['flowNodes', 'flowEdges'])
            ->latest()
            ->get();

        return view('businesses.index', compact('businesses', 'type'));
    }

    /**
     * Show the form for creating a new business
     */
    public function create()
    {
        return view('businesses.create');
    }

    /**
     * Store a newly created business
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:active,idea',
        ]);

        $validated['user_id'] = Auth::id();

        $business = Business::create($validated);

        return redirect()->route('businesses.show', $business)
            ->with('success', 'Business created successfully.');
    }

    /**
     * Display the specified business (flow builder)
     */
    public function show(Business $business)
    {
        // Ensure user owns this business
        if ($business->user_id !== Auth::id()) {
            abort(403);
        }

        $business->load(['flowNodes', 'flowEdges']);
        
        return view('businesses.show', compact('business'));
    }

    /**
     * Show the form for editing the specified business
     */
    public function edit(Business $business)
    {
        if ($business->user_id !== Auth::id()) {
            abort(403);
        }

        return view('businesses.edit', compact('business'));
    }

    /**
     * Update the specified business
     */
    public function update(Request $request, Business $business)
    {
        if ($business->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:active,idea',
        ]);

        $business->update($validated);

        return redirect()->route('businesses.show', $business)
            ->with('success', 'Business updated successfully.');
    }

    /**
     * Remove the specified business
     */
    public function destroy(Business $business)
    {
        if ($business->user_id !== Auth::id()) {
            abort(403);
        }

        $business->delete();

        return redirect()->route('businesses.index')
            ->with('success', 'Business deleted successfully.');
    }

    // API endpoints for flow builder

    /**
     * Create a new flow node
     */
    public function createNode(Request $request, Business $business)
    {
        if ($business->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:planning,in_progress,completed',
            'color' => 'nullable|string',
            'icon' => 'nullable|string',
            'position_x' => 'required|numeric',
            'position_y' => 'required|numeric',
        ]);

        $validated['business_id'] = $business->id;
        $validated['color'] = $validated['color'] ?? '#3B82F6';

        $node = FlowNode::create($validated);

        return response()->json(['success' => true, 'node' => $node]);
    }

    /**
     * Update a flow node
     */
    public function updateNode(Request $request, Business $business, FlowNode $node)
    {
        if ($business->user_id !== Auth::id() || $node->business_id !== $business->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|required|in:planning,in_progress,completed',
            'color' => 'nullable|string',
            'icon' => 'nullable|string',
            'position_x' => 'sometimes|required|numeric',
            'position_y' => 'sometimes|required|numeric',
        ]);

        $node->update($validated);

        return response()->json(['success' => true, 'node' => $node]);
    }

    /**
     * Delete a flow node
     */
    public function deleteNode(Business $business, FlowNode $node)
    {
        if ($business->user_id !== Auth::id() || $node->business_id !== $business->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $node->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Create a flow edge (connection)
     */
    public function createEdge(Request $request, Business $business)
    {
        if ($business->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'from_node_id' => 'required|exists:flow_nodes,id',
            'to_node_id' => 'required|exists:flow_nodes,id|different:from_node_id',
        ]);

        // Ensure both nodes belong to this business
        $fromNode = FlowNode::findOrFail($validated['from_node_id']);
        $toNode = FlowNode::findOrFail($validated['to_node_id']);

        if ($fromNode->business_id !== $business->id || $toNode->business_id !== $business->id) {
            return response()->json(['error' => 'Nodes must belong to this business'], 400);
        }

        $validated['business_id'] = $business->id;

        try {
            $edge = FlowEdge::create($validated);
            return response()->json(['success' => true, 'edge' => $edge]);
        } catch (\Illuminate\Database\QueryException $e) {
            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                return response()->json(['error' => 'Connection already exists'], 400);
            }
            throw $e;
        }
    }

    /**
     * Delete a flow edge
     */
    public function deleteEdge(Business $business, FlowEdge $edge)
    {
        if ($business->user_id !== Auth::id() || $edge->business_id !== $business->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $edge->delete();

        return response()->json(['success' => true]);
    }
}
