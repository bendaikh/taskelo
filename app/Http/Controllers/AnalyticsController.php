<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Monthly revenue for the last 12 months
        $monthlyRevenue = Payment::select(
            DB::raw('DATE_FORMAT(date, "%Y-%m") as month'),
            DB::raw('SUM(amount) as total')
        )
            ->where('date', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Yearly revenue comparison
        $currentYear = now()->year;
        $currentYearRevenue = Payment::whereYear('date', $currentYear)->sum('amount');
        $lastYearRevenue = Payment::whereYear('date', $currentYear - 1)->sum('amount');

        // Top 5 clients by revenue
        $topClients = Client::select('clients.id', 'clients.name', DB::raw('SUM(payments.amount) as revenue'))
            ->join('payments', 'clients.id', '=', 'payments.client_id')
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

        // Payment completion rate
        $totalBudget = Project::sum('budget');
        $totalPaid = Project::sum('amount_paid');
        $completionRate = $totalBudget > 0 ? ($totalPaid / $totalBudget) * 100 : 0;

        // Project status distribution
        $projectsByStatus = Project::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        // Revenue by type (advance vs payment)
        $revenueByType = Payment::select('type', DB::raw('SUM(amount) as total'))
            ->groupBy('type')
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

