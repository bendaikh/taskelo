<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\Payment;
use App\Models\Revenue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        $workspaceId = Auth::user()->current_workspace_id;
        $workspace = Auth::user()->currentWorkspace;

        // Personal workspace analytics (Revenue-based)
        if ($workspace && $workspace->type === 'personal') {
            $driver = DB::getDriverName();
            $monthExpr = match ($driver) {
                'sqlite' => "strftime('%Y-%m', revenues.date)",
                'pgsql' => "to_char(revenues.date, 'YYYY-MM')",
                default => "DATE_FORMAT(revenues.date, '%Y-%m')",
            };

            $currentYear = now()->year;

            $totalRevenue = Revenue::where('workspace_id', $workspaceId)->sum('amount');

            $monthlyRevenue = Revenue::select(
                DB::raw($monthExpr . ' as month'),
                DB::raw('SUM(revenues.amount) as total')
            )
                ->where('revenues.workspace_id', $workspaceId)
                ->where('revenues.date', '>=', now()->subMonths(12))
                ->groupBy(DB::raw($monthExpr))
                ->orderBy(DB::raw($monthExpr))
                ->get();

            $currentYearRevenue = Revenue::where('workspace_id', $workspaceId)
                ->whereYear('date', $currentYear)
                ->sum('amount');

            $lastYearRevenue = Revenue::where('workspace_id', $workspaceId)
                ->whereYear('date', $currentYear - 1)
                ->sum('amount');

            // Top categories (use revenue_categories.name when available, fallback to revenues.category)
            $topCategories = Revenue::select(
                DB::raw("COALESCE(revenue_categories.name, revenues.category, 'Uncategorized') as category"),
                DB::raw('SUM(revenues.amount) as total')
            )
                ->leftJoin('revenue_categories', 'revenues.revenue_category_id', '=', 'revenue_categories.id')
                ->where('revenues.workspace_id', $workspaceId)
                ->groupBy(DB::raw("COALESCE(revenue_categories.name, revenues.category, 'Uncategorized')"))
                ->orderByDesc(DB::raw('SUM(revenues.amount)'))
                ->limit(5)
                ->get();

            return view('analytics.personal', compact(
                'totalRevenue',
                'monthlyRevenue',
                'currentYearRevenue',
                'lastYearRevenue',
                'topCategories'
            ));
        }

        // Monthly revenue for the last 12 months (filtered by workspace through projects)
        // Use a DB-driver-specific month formatter for better portability (mysql/sqlite/pgsql).
        $driver = DB::getDriverName();
        $monthExpr = match ($driver) {
            'sqlite' => "strftime('%Y-%m', payments.date)",
            'pgsql' => "to_char(payments.date, 'YYYY-MM')",
            default => "DATE_FORMAT(payments.date, '%Y-%m')",
        };

        $monthlyRevenue = Payment::select(
            DB::raw($monthExpr . ' as month'),
            DB::raw('SUM(payments.amount) as total')
        )
            ->join('projects', 'payments.project_id', '=', 'projects.id')
            ->where('projects.workspace_id', $workspaceId)
            ->where('payments.date', '>=', now()->subMonths(12))
            ->groupBy(DB::raw($monthExpr))
            ->orderBy(DB::raw($monthExpr))
            ->get();

        // Yearly revenue comparison (filtered by workspace through projects)
        $currentYear = now()->year;
        $currentYearRevenue = Payment::join('projects', 'payments.project_id', '=', 'projects.id')
            ->where('projects.workspace_id', $workspaceId)
            ->whereYear('payments.date', $currentYear)
            ->sum('payments.amount');
        
        $lastYearRevenue = Payment::join('projects', 'payments.project_id', '=', 'projects.id')
            ->where('projects.workspace_id', $workspaceId)
            ->whereYear('payments.date', $currentYear - 1)
            ->sum('payments.amount');

        // Top 5 clients by revenue (filtered by workspace through projects)
        // Note: use the project's client_id as the source of truth to avoid mismatches if legacy payments have wrong client_id.
        $topClients = Client::select('clients.id', 'clients.name', DB::raw('SUM(payments.amount) as revenue'))
            ->join('projects', 'clients.id', '=', 'projects.client_id')
            ->join('payments', 'projects.id', '=', 'payments.project_id')
            ->where('projects.workspace_id', $workspaceId)
            ->groupBy('clients.id', 'clients.name')
            ->orderByRaw('SUM(payments.amount) DESC')
            ->limit(5)
            ->get()
            ->map(function ($client) {
                return [
                    'name' => $client->name,
                    'revenue' => $client->revenue
                ];
            });

        // Payment completion rate (filtered by workspace)
        $totalBudget = Project::where('workspace_id', $workspaceId)->sum('budget');
        $totalPaid = Project::where('workspace_id', $workspaceId)->sum('amount_paid');
        $completionRate = $totalBudget > 0 ? ($totalPaid / $totalBudget) * 100 : 0;

        // Project status distribution (filtered by workspace)
        $projectsByStatus = Project::select('status', DB::raw('count(*) as count'))
            ->where('workspace_id', $workspaceId)
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        // Revenue by type (advance vs payment) (filtered by workspace through projects)
        $revenueByType = Payment::select('payments.type', DB::raw('SUM(payments.amount) as total'))
            ->join('projects', 'payments.project_id', '=', 'projects.id')
            ->where('projects.workspace_id', $workspaceId)
            ->groupBy('payments.type')
            ->get()
            ->pluck('total', 'type');

        return view('analytics.index', compact(
            'monthlyRevenue',
            'currentYearRevenue',
            'lastYearRevenue',
            'topClients',
            'completionRate',
            'projectsByStatus',
            'revenueByType'
        ));
    }
}

