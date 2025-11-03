<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\Payment;
use App\Models\Task;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        // Get overview statistics
        $totalProjects = Project::count();
        $activeClients = Client::has('projects')->count();
        $totalRevenue = Payment::sum('amount');

        // Pending payments: if project has a budget use (budget - amount_paid),
        // otherwise use (sum(task.price) - amount_paid). Never below zero.
        $projectsForPending = Project::withSum('tasks as tasks_price_sum', 'price')->get(['id', 'budget', 'amount_paid']);
        $pendingPayments = $projectsForPending->sum(function ($p) {
            $basis = ($p->budget ?? 0) > 0 ? (float) $p->budget : (float) ($p->tasks_price_sum ?? 0);
            $pending = $basis - (float) $p->amount_paid;
            return $pending > 0 ? $pending : 0.0;
        });

        // Recent payments
        $recentPayments = Payment::with(['project', 'client'])
            ->latest()
            ->limit(5)
            ->get();

        // Recent projects
        $recentProjects = Project::with('client')
            ->latest()
            ->limit(5)
            ->get();

        // Monthly revenue for chart (last 12 months)
        $monthlyRevenue = Payment::select(
            DB::raw('DATE_FORMAT(date, "%Y-%m") as month'),
            DB::raw('SUM(amount) as total')
        )
            ->where('date', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Daily revenue for chart (last 14 days)
        $dailyRevenue = Payment::select(
            DB::raw('DATE(date) as day'),
            DB::raw('SUM(amount) as total')
        )
            ->where('date', '>=', now()->subDays(14))
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        // Payment status for pie chart: use budget when available, else sum of task prices
        $projectsForStatus = Project::withSum('tasks as tasks_price_sum', 'price')->get(['id', 'budget', 'amount_paid']);
        $totalPaid = (float) $projectsForStatus->sum('amount_paid');
        $totalBasis = $projectsForStatus->sum(function ($p) {
            return ($p->budget ?? 0) > 0 ? (float) $p->budget : (float) ($p->tasks_price_sum ?? 0);
        });
        $pendingTotal = max($totalBasis - $totalPaid, 0);
        $paymentStatus = [
            'paid' => (float) $totalPaid,
            'pending' => (float) $pendingTotal,
        ];

        // Expenses metrics (guard if table not migrated yet)
        $totalExpenses = 0;
        $monthlyExpenses = collect();
        $dailyExpenses = collect();
        if (Schema::hasTable('expenses')) {
            $totalExpenses = (float) Expense::sum('amount');

            $monthlyExpenses = Expense::select(
                DB::raw('DATE_FORMAT(date, "%Y-%m") as month'),
                DB::raw('SUM(amount) as total')
            )
                ->where('date', '>=', now()->subMonths(12))
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            $dailyExpenses = Expense::select(
                DB::raw('DATE(date) as day'),
                DB::raw('SUM(amount) as total')
            )
                ->where('date', '>=', now()->subDays(14))
                ->groupBy('day')
                ->orderBy('day')
                ->get();
        }

        // Monthly cashflow: revenue - expenses (last 12 months)
        $months = collect(range(0, 11))
            ->map(fn ($i) => now()->subMonths(11 - $i)->format('Y-m'));

        $revenueByMonth = $monthlyRevenue->keyBy('month');
        $expensesByMonth = $monthlyExpenses->keyBy('month');
        $monthlyCashflow = $months->map(function ($m) use ($revenueByMonth, $expensesByMonth) {
            $rev = (float) ($revenueByMonth[$m]->total ?? 0);
            $exp = (float) ($expensesByMonth[$m]->total ?? 0);
            return [
                'month' => $m,
                'revenue' => $rev,
                'expenses' => $exp,
                'cashflow' => $rev - $exp,
            ];
        });

        // Net cashflow (last 30 days)
        $revenue30 = Payment::where('date', '>=', now()->subDays(30))->sum('amount');
        $expenses30 = Schema::hasTable('expenses') ? (float) Expense::where('date', '>=', now()->subDays(30))->sum('amount') : 0.0;
        $netCashflow30 = (float) $revenue30 - (float) $expenses30;

        // Tasks to focus on: To Do and In Progress
        $todoTasks = Task::with(['project.client'])
            ->where('status', 'todo')
            ->latest()
            ->limit(8)
            ->get();

        $inProgressTasks = Task::with(['project.client'])
            ->where('status', 'in_progress')
            ->latest()
            ->limit(8)
            ->get();

        return view('dashboard.index', compact(
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
            'netCashflow30',
            'todoTasks',
            'inProgressTasks'
        ));
    }
}

