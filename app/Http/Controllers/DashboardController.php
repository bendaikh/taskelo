<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\Payment;
use App\Models\Task;
use App\Models\Expense;
use App\Models\Revenue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        $workspaceId = Auth::user()->current_workspace_id;
        $workspace = Auth::user()->currentWorkspace;
        $isPersonal = $workspace && $workspace->type === 'personal';

        if ($isPersonal) {
            // Personal workspace: Use Revenue model instead of Payment
            $totalRevenue = Revenue::where('workspace_id', $workspaceId)->sum('amount');
            
            // Monthly revenue for chart (last 12 months) - from Revenue model
            $monthlyRevenue = Revenue::select(
                DB::raw('DATE_FORMAT(date, "%Y-%m") as month'),
                DB::raw('SUM(amount) as total')
            )
                ->where('workspace_id', $workspaceId)
                ->where('date', '>=', now()->subMonths(12))
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            // Daily revenue for chart (last 14 days) - from Revenue model
            $dailyRevenue = Revenue::select(
                DB::raw('DATE(date) as day'),
                DB::raw('SUM(amount) as total')
            )
                ->where('workspace_id', $workspaceId)
                ->where('date', '>=', now()->subDays(14))
                ->groupBy('day')
                ->orderBy('day')
                ->get();

        } else {
            // Business workspace: Use existing Payment-based logic
            $totalProjects = Project::where('workspace_id', $workspaceId)->count();
            $activeClients = Client::where('workspace_id', $workspaceId)->has('projects')->count();
            $totalRevenue = Payment::whereHas('project', function($q) use ($workspaceId) {
                $q->where('workspace_id', $workspaceId);
            })->sum('amount');

            // Pending payments: if project has a budget use (budget - amount_paid),
            // otherwise use (sum(task.price) - amount_paid). Never below zero.
            $projectsForPending = Project::where('workspace_id', $workspaceId)
                ->withSum('tasks as tasks_price_sum', 'price')->get(['id', 'budget', 'amount_paid']);
            $pendingPayments = $projectsForPending->sum(function ($p) {
                $basis = ($p->budget ?? 0) > 0 ? (float) $p->budget : (float) ($p->tasks_price_sum ?? 0);
                $pending = $basis - (float) $p->amount_paid;
                return $pending > 0 ? $pending : 0.0;
            });

            // Recent payments
            $recentPayments = Payment::with(['project', 'client'])
                ->whereHas('project', function($q) use ($workspaceId) {
                    $q->where('workspace_id', $workspaceId);
                })
                ->latest()
                ->limit(5)
                ->get();

            // Recent projects
            $recentProjects = Project::where('workspace_id', $workspaceId)
                ->with('client')
                ->latest()
                ->limit(5)
                ->get();

            // Monthly revenue for chart (last 12 months)
            $monthlyRevenue = Payment::select(
                DB::raw('DATE_FORMAT(date, "%Y-%m") as month'),
                DB::raw('SUM(amount) as total')
            )
                ->whereHas('project', function($q) use ($workspaceId) {
                    $q->where('workspace_id', $workspaceId);
                })
                ->where('date', '>=', now()->subMonths(12))
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            // Daily revenue for chart (last 14 days)
            $dailyRevenue = Payment::select(
                DB::raw('DATE(date) as day'),
                DB::raw('SUM(amount) as total')
            )
                ->whereHas('project', function($q) use ($workspaceId) {
                    $q->where('workspace_id', $workspaceId);
                })
                ->where('date', '>=', now()->subDays(14))
                ->groupBy('day')
                ->orderBy('day')
                ->get();

            // Payment status for pie chart: use budget when available, else sum of task prices
            $projectsForStatus = Project::where('workspace_id', $workspaceId)
                ->withSum('tasks as tasks_price_sum', 'price')->get(['id', 'budget', 'amount_paid']);
            $totalPaid = (float) $projectsForStatus->sum('amount_paid');
            $totalBasis = $projectsForStatus->sum(function ($p) {
                return ($p->budget ?? 0) > 0 ? (float) $p->budget : (float) ($p->tasks_price_sum ?? 0);
            });
            $pendingTotal = max($totalBasis - $totalPaid, 0);
            $paymentStatus = [
                'paid' => (float) $totalPaid,
                'pending' => (float) $pendingTotal,
            ];

        }

        // Initialize variables that might not be set for personal workspace
        if ($isPersonal) {
            $totalProjects = 0;
            $activeClients = 0;
            $pendingPayments = 0;
            $recentPayments = collect();
            $recentProjects = collect();
            $paymentStatus = ['paid' => 0, 'pending' => 0];
        }

        // Expenses metrics (guard if table not migrated yet)
        $totalExpenses = 0;
        $monthlyExpenses = collect();
        $dailyExpenses = collect();
        if (Schema::hasTable('expenses')) {
            $totalExpenses = (float) Expense::where('workspace_id', $workspaceId)->sum('amount');

            $monthlyExpenses = Expense::select(
                DB::raw('DATE_FORMAT(date, "%Y-%m") as month'),
                DB::raw('SUM(amount) as total')
            )
                ->where('workspace_id', $workspaceId)
                ->where('date', '>=', now()->subMonths(12))
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            $dailyExpenses = Expense::select(
                DB::raw('DATE(date) as day'),
                DB::raw('SUM(amount) as total')
            )
                ->where('workspace_id', $workspaceId)
                ->where('date', '>=', now()->subDays(14))
                ->groupBy('day')
                ->orderBy('day')
                ->get();
        }

        // Expenses by category (for dashboard breakdown)
        $expensesByCategory = collect();
        if (Schema::hasTable('expenses')) {
            $expensesByCategory = DB::table('expenses')
                ->select(DB::raw('COALESCE(category, "Uncategorized") as label'), DB::raw('SUM(amount) as total'))
                ->where('workspace_id', $workspaceId)
                ->groupBy('label')
                ->orderByDesc('total')
                ->limit(8)
                ->get();
        }

        // Monthly cashflow: revenue - expenses (last 12 months)
        $months = collect(range(0, 11))
            ->map(fn ($i) => now()->subMonths(11 - $i)->format('Y-m'));

        $revenueByMonth = $monthlyRevenue->pluck('total', 'month');
        $expensesByMonth = $monthlyExpenses->pluck('total', 'month');
        $monthlyCashflow = $months->map(function ($m) use ($revenueByMonth, $expensesByMonth) {
            $rev = (float) ($revenueByMonth[$m] ?? 0);
            $exp = (float) ($expensesByMonth[$m] ?? 0);
            return [
                'month' => $m,
                'revenue' => $rev,
                'expenses' => $exp,
                'cashflow' => $rev - $exp,
            ];
        });

        // Net cashflow (all time): total revenue - total expenses
        $netCashflow = (float) $totalRevenue - (float) $totalExpenses;

        // Tasks to focus on: To Do and In Progress (only for business workspace)
        $todoTasks = collect();
        $inProgressTasks = collect();
        if (!$isPersonal) {
            $todoTasks = Task::with(['project.client'])
                ->whereHas('project', function($q) use ($workspaceId) {
                    $q->where('workspace_id', $workspaceId);
                })
                ->where('status', 'todo')
                ->latest()
                ->limit(8)
                ->get();

            $inProgressTasks = Task::with(['project.client'])
                ->whereHas('project', function($q) use ($workspaceId) {
                    $q->where('workspace_id', $workspaceId);
                })
                ->where('status', 'in_progress')
                ->latest()
                ->limit(8)
                ->get();
        }

        return view('dashboard.index', compact(
            'isPersonal',
            'totalProjects',
            'activeClients',
            'totalRevenue',
            'pendingPayments',
            'recentPayments',
            'recentProjects',
            'monthlyRevenue',
            'paymentStatus',
            'dailyRevenue',
            'totalExpenses',
            'monthlyExpenses',
            'dailyExpenses',
            'monthlyCashflow',
            'netCashflow',
            'expensesByCategory',
            'todoTasks',
            'inProgressTasks'
        ));
    }
}

