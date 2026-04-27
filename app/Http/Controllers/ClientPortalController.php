<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientPortalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:client');
    }

    public function dashboard()
    {
        $client = Auth::guard('client')->user();
        $client->load('workspace.owner');
        
        $projects = $client->projects()
            ->with(['tasks', 'payments'])
            ->latest()
            ->get();
        
        $payments = $client->payments()
            ->with('project')
            ->latest()
            ->take(10)
            ->get();
        
        $tasks = $client->projects()
            ->with('tasks')
            ->get()
            ->pluck('tasks')
            ->flatten()
            ->sortByDesc('created_at')
            ->take(20);
        
        $totalPaid = $payments->sum('amount');
        $totalPending = $client->outstanding_balance;
        
        // Get currency from workspace owner
        $currency = $client->workspace->owner->currency ?? '$';
        
        return view('client.dashboard', compact(
            'client',
            'projects',
            'payments',
            'tasks',
            'totalPaid',
            'totalPending',
            'currency'
        ));
    }

    public function projects()
    {
        $client = Auth::guard('client')->user();
        
        $projects = $client->projects()
            ->with(['tasks', 'payments'])
            ->latest()
            ->paginate(10);
        
        // Get currency from workspace owner
        $currency = $client->workspace->owner->currency ?? '$';
        
        return view('client.projects', compact('client', 'projects', 'currency'));
    }

    public function project($id)
    {
        $client = Auth::guard('client')->user();
        
        $project = $client->projects()
            ->with(['tasks', 'payments'])
            ->findOrFail($id);
        
        // Get currency from workspace owner
        $currency = $client->workspace->owner->currency ?? '$';
        
        return view('client.project', compact('client', 'project', 'currency'));
    }

    public function payments()
    {
        $client = Auth::guard('client')->user();
        
        $payments = $client->payments()
            ->with('project')
            ->latest()
            ->paginate(15);
        
        // Get currency from workspace owner
        $currency = $client->workspace->owner->currency ?? '$';
        
        return view('client.payments', compact('client', 'payments', 'currency'));
    }

    public function tasks()
    {
        $client = Auth::guard('client')->user();
        
        $tasks = $client->projects()
            ->with('tasks')
            ->get()
            ->pluck('tasks')
            ->flatten()
            ->sortByDesc('created_at');
        
        // Get currency from workspace owner
        $currency = $client->workspace->owner->currency ?? '$';
        
        return view('client.tasks', compact('client', 'tasks', 'currency'));
    }
}
