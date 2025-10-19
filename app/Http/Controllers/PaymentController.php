<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    /**
     * Display a listing of payments
     */
    public function index(Request $request)
    {
        $query = Payment::with(['project', 'client']);

        // Filter by client
        if ($request->has('client_id') && $request->client_id !== '') {
            $query->where('client_id', $request->client_id);
        }

        // Filter by project
        if ($request->has('project_id') && $request->project_id !== '') {
            $query->where('project_id', $request->project_id);
        }

        // Filter by type
        if ($request->has('type') && $request->type !== '') {
            $query->where('type', $request->type);
        }

        // Date range filter
        if ($request->has('date_from') && $request->date_from !== '') {
            $query->where('date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to !== '') {
            $query->where('date', '<=', $request->date_to);
        }

        $payments = $query->latest('date')->paginate(15);
        $clients = Client::orderBy('name')->get();
        $projects = Project::orderBy('title')->get();

        return view('payments.index', compact('payments', 'clients', 'projects'));
    }

    /**
     * Show the form for creating a new payment
     */
    public function create()
    {
        $clients = Client::orderBy('name')->get();
        $projects = Project::with('client')->orderBy('title')->get();
        
        return view('payments.create', compact('clients', 'projects'));
    }

    /**
     * Store a newly created payment
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'client_id' => 'required|exists:clients,id',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:advance,payment',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        Payment::create($validated);

        return redirect()->route('payments.index')
            ->with('success', 'Payment recorded successfully.');
    }

    /**
     * Display the specified payment
     */
    public function show(Payment $payment)
    {
        $payment->load(['project', 'client']);
        return view('payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified payment
     */
    public function edit(Payment $payment)
    {
        $clients = Client::orderBy('name')->get();
        $projects = Project::with('client')->orderBy('title')->get();
        
        return view('payments.edit', compact('payment', 'clients', 'projects'));
    }

    /**
     * Update the specified payment
     */
    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'client_id' => 'required|exists:clients,id',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:advance,payment',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $payment->update($validated);

        return redirect()->route('payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    /**
     * Remove the specified payment
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('payments.index')
            ->with('success', 'Payment deleted successfully.');
    }

    /**
     * Export payments to CSV
     */
    public function exportCsv(Request $request)
    {
        $query = Payment::with(['project', 'client']);

        // Apply same filters as index
        if ($request->has('client_id') && $request->client_id !== '') {
            $query->where('client_id', $request->client_id);
        }

        if ($request->has('project_id') && $request->project_id !== '') {
            $query->where('project_id', $request->project_id);
        }

        $payments = $query->latest('date')->get();

        $filename = 'payments_' . now()->format('Y-m-d') . '.csv';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        
        fputcsv($output, ['Date', 'Client', 'Project', 'Amount', 'Type', 'Notes']);

        foreach ($payments as $payment) {
            fputcsv($output, [
                $payment->date->format('Y-m-d'),
                $payment->client->name,
                $payment->project->title,
                $payment->amount,
                ucfirst($payment->type),
                $payment->notes,
            ]);
        }

        fclose($output);
        exit;
    }

    /**
     * Export payments to PDF
     */
    public function exportPdf(Request $request)
    {
        $query = Payment::with(['project', 'client']);

        // Apply same filters as index
        if ($request->has('client_id') && $request->client_id !== '') {
            $query->where('client_id', $request->client_id);
        }

        if ($request->has('project_id') && $request->project_id !== '') {
            $query->where('project_id', $request->project_id);
        }

        $payments = $query->latest('date')->get();
        $total = $payments->sum('amount');

        $pdf = Pdf::loadView('payments.pdf', compact('payments', 'total'));
        
        return $pdf->download('payments_' . now()->format('Y-m-d') . '.pdf');
    }
}

