<?php

namespace App\Http\Controllers;

use App\Models\ProjectSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectSectionController extends Controller
{
    /**
     * Display a listing of the conceptions
     */
    public function index(Request $request)
    {
        $query = ProjectSection::where('user_id', Auth::id())
            ->with('client')
            ->orderBy('created_at', 'desc');

        // Filter by status if provided
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $conceptions = $query->paginate(15);

        return view('conceptions.index', compact('conceptions'));
    }

    /**
     * Show the form for creating a new conception
     */
    public function create()
    {
        $clients = \App\Models\Client::orderBy('name')->get();
        return view('conceptions.create', compact('clients'));
    }

    /**
     * Store a newly created conception in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'nullable|exists:clients,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'valid_until' => 'nullable|date|after:date',
            'notes' => 'nullable|string',
            'sections' => 'required|array|min:1',
            'sections.*.name' => 'required|string|max:255',
            'sections.*.description' => 'nullable|string',
            'sections.*.price' => 'nullable|numeric|min:0',
        ]);

        // Calculate total price (treat null/empty as 0)
        $totalPrice = collect($validated['sections'])->sum(function ($section) {
            return floatval($section['price'] ?? 0);
        });

        $validated['user_id'] = Auth::id();
        $validated['total_price'] = $totalPrice;
        $validated['status'] = 'draft';

        ProjectSection::create($validated);

        return redirect()->route('conceptions.index')
            ->with('success', 'Conception created successfully!');
    }

    /**
     * Display the specified conception
     */
    public function show(ProjectSection $conception)
    {
        // Ensure the conception belongs to the authenticated user
        if ($conception->user_id !== Auth::id()) {
            abort(403);
        }

        $conception->load('client');

        return view('conceptions.show', compact('conception'));
    }

    /**
     * Show the form for editing the specified conception
     */
    public function edit(ProjectSection $conception)
    {
        // Ensure the conception belongs to the authenticated user
        if ($conception->user_id !== Auth::id()) {
            abort(403);
        }

        $clients = \App\Models\Client::orderBy('name')->get();

        return view('conceptions.edit', compact('conception', 'clients'));
    }

    /**
     * Update the specified conception in storage
     */
    public function update(Request $request, ProjectSection $conception)
    {
        // Ensure the conception belongs to the authenticated user
        if ($conception->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'client_id' => 'nullable|exists:clients,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'valid_until' => 'nullable|date|after:date',
            'notes' => 'nullable|string',
            'status' => 'required|in:draft,sent,accepted,rejected',
            'sections' => 'required|array|min:1',
            'sections.*.name' => 'required|string|max:255',
            'sections.*.description' => 'nullable|string',
            'sections.*.price' => 'nullable|numeric|min:0',
        ]);

        // Calculate total price (treat null/empty as 0)
        $totalPrice = collect($validated['sections'])->sum(function ($section) {
            return floatval($section['price'] ?? 0);
        });
        $validated['total_price'] = $totalPrice;

        $conception->update($validated);

        return redirect()->route('conceptions.index')
            ->with('success', 'Conception updated successfully!');
    }

    /**
     * Remove the specified conception from storage
     */
    public function destroy(ProjectSection $conception)
    {
        // Ensure the conception belongs to the authenticated user
        if ($conception->user_id !== Auth::id()) {
            abort(403);
        }

        $conception->delete();

        return redirect()->route('conceptions.index')
            ->with('success', 'Conception deleted successfully!');
    }

    /**
     * Generate PDF for the conception
     */
    public function generatePdf(ProjectSection $conception, $lang = 'en')
    {
        // Ensure the conception belongs to the authenticated user
        if ($conception->user_id !== Auth::id()) {
            abort(403);
        }

        // Validate language parameter
        $lang = in_array($lang, ['en', 'fr']) ? $lang : 'en';

        // Define translations
        $translations = [
            'en' => [
                'title' => 'PROJECT CONCEPTION',
                'client' => 'Client',
                'date' => 'Date',
                'valid_until' => 'Valid Until',
                'status' => 'Status',
                'project_overview' => 'Project Overview',
                'project_sections' => 'Project Sections',
                'total_project_price' => 'TOTAL PROJECT PRICE',
                'additional_notes' => 'ADDITIONAL NOTES',
                'important_scope' => 'IMPORTANT - SCOPE OF WORK',
                'scope_warning' => 'This conception document defines the complete scope of work for this project. The sections listed above represent all the features and functionality that are included in the quoted price.',
                'scope_highlight' => 'Any additional features, modifications, or work outside the scope of these defined sections will require separate pricing and a new agreement.',
                'scope_agreement' => 'By accepting this conception, both parties agree that the work will be limited to the sections described above, and any scope changes must be discussed and agreed upon separately.',
                'generated_on' => 'Generated on',
                'at' => 'at',
                'phone' => 'Phone',
                'email' => 'Email',
                'status_draft' => 'Draft',
                'status_sent' => 'Sent',
                'status_accepted' => 'Accepted',
                'status_rejected' => 'Rejected',
            ],
            'fr' => [
                'title' => 'CONCEPTION DE PROJET',
                'client' => 'Client',
                'date' => 'Date',
                'valid_until' => 'Valable jusqu\'au',
                'status' => 'Statut',
                'project_overview' => 'Aperçu du projet',
                'project_sections' => 'Sections du projet',
                'total_project_price' => 'PRIX TOTAL DU PROJET',
                'additional_notes' => 'NOTES SUPPLÉMENTAIRES',
                'important_scope' => 'IMPORTANT - PORTÉE DES TRAVAUX',
                'scope_warning' => 'Ce document de conception définit la portée complète des travaux pour ce projet. Les sections énumérées ci-dessus représentent toutes les fonctionnalités et caractéristiques incluses dans le prix indiqué.',
                'scope_highlight' => 'Toute fonctionnalité supplémentaire, modification ou travail en dehors de la portée de ces sections définies nécessitera une tarification distincte et un nouvel accord.',
                'scope_agreement' => 'En acceptant cette conception, les deux parties conviennent que le travail sera limité aux sections décrites ci-dessus, et que tout changement de portée doit être discuté et convenu séparément.',
                'generated_on' => 'Généré le',
                'at' => 'à',
                'phone' => 'Téléphone',
                'email' => 'Email',
                'status_draft' => 'Brouillon',
                'status_sent' => 'Envoyé',
                'status_accepted' => 'Accepté',
                'status_rejected' => 'Rejeté',
            ],
        ];

        $conception->load('client', 'user');
        $trans = $translations[$lang];

        $pdf = \PDF::loadView('conceptions.pdf', compact('conception', 'trans', 'lang'));
        
        $filename = 'conception-' . $conception->id . '-' . now()->format('Y-m-d') . '-' . $lang . '.pdf';
        
        return $pdf->download($filename);
    }
}

