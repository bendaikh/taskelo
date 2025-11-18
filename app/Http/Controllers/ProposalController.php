<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\Client;
use App\Models\Business;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ProposalController extends Controller
{
    /**
     * Display a listing of proposals
     */
    public function index(Request $request)
    {
        $query = Proposal::with('client');

        // Filter by client
        if ($request->has('client_id') && $request->client_id !== '') {
            $query->where('client_id', $request->client_id);
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Search by title or proposal number
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('proposal_number', 'like', "%{$search}%");
            });
        }

        $proposals = $query->latest('date')->paginate(15);
        $clients = Client::orderBy('name')->get();

        return view('proposals.index', compact('proposals', 'clients'));
    }

    /**
     * Show the form for creating a new proposal
     */
    public function create()
    {
        $clients = Client::orderBy('name')->get();
        return view('proposals.create', compact('clients'));
    }

    /**
     * Store a newly created proposal
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'valid_until' => 'nullable|date|after_or_equal:date',
            'services' => 'required|array|min:1',
            'services.*.name' => 'required|string|max:255',
            'services.*.description' => 'nullable|string',
            'services.*.price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'status' => 'nullable|in:draft,sent,accepted,rejected',
        ]);

        // Calculate total for each service and overall total
        $services = [];
        $totalAmount = 0;

        foreach ($validated['services'] as $service) {
            $amount = (float) $service['price'];
            $services[] = [
                'name' => $service['name'],
                'description' => $service['description'] ?? '',
                'price' => $amount,
                'total' => $amount,
            ];
            $totalAmount += $amount;
        }

        $validated['services'] = $services;
        $validated['total_amount'] = $totalAmount;
        $validated['proposal_number'] = Proposal::generateProposalNumber();
        $validated['status'] = $validated['status'] ?? 'draft';

        Proposal::create($validated);

        return redirect()->route('proposals.index')
            ->with('success', 'Proposal created successfully.');
    }

    /**
     * Display the specified proposal
     */
    public function show(Request $request, Proposal $proposal)
    {
        $proposal->load('client');
        
        $language = $request->query('lang') === 'fr' ? 'fr' : 'en';
        $translations = $this->getProposalTranslations($language);
        
        return view('proposals.show', compact('proposal', 'language', 'translations'));
    }

    /**
     * Show the form for editing the specified proposal
     */
    public function edit(Proposal $proposal)
    {
        $clients = Client::orderBy('name')->get();
        return view('proposals.edit', compact('proposal', 'clients'));
    }

    /**
     * Update the specified proposal
     */
    public function update(Request $request, Proposal $proposal)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'valid_until' => 'nullable|date|after_or_equal:date',
            'services' => 'required|array|min:1',
            'services.*.name' => 'required|string|max:255',
            'services.*.description' => 'nullable|string',
            'services.*.price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'status' => 'nullable|in:draft,sent,accepted,rejected',
        ]);

        // Calculate total for each service and overall total
        $services = [];
        $totalAmount = 0;

        foreach ($validated['services'] as $service) {
            $amount = (float) $service['price'];
            $services[] = [
                'name' => $service['name'],
                'description' => $service['description'] ?? '',
                'price' => $amount,
                'total' => $amount,
            ];
            $totalAmount += $amount;
        }

        $validated['services'] = $services;
        $validated['total_amount'] = $totalAmount;

        $proposal->update($validated);

        return redirect()->route('proposals.index')
            ->with('success', 'Proposal updated successfully.');
    }

    /**
     * Remove the specified proposal
     */
    public function destroy(Proposal $proposal)
    {
        $proposal->delete();

        return redirect()->route('proposals.index')
            ->with('success', 'Proposal deleted successfully.');
    }

    /**
     * Generate PDF for the proposal
     */
    public function pdf(Proposal $proposal)
    {
        $proposal->load('client');
        
        // Get business info if available
        $business = Business::first();
        $user = auth()->user();
        $language = request('lang') === 'fr' ? 'fr' : 'en';
        $translations = $this->getProposalTranslations($language);
        
        // Get logo - convert to base64 for dompdf compatibility
        $logoBase64 = null;
        if ($user->logo) {
            $logoPath = storage_path('app/public/' . $user->logo);
            if (file_exists($logoPath)) {
                $logoData = file_get_contents($logoPath);
                $logoMime = mime_content_type($logoPath);
                $logoBase64 = 'data:' . $logoMime . ';base64,' . base64_encode($logoData);
            }
        }
        
        // Company display details with sensible fallbacks
        $businessName = $user->company_name ?: ($business->name ?? $user->name);
        $companyWebsite = $user->company_website;
        
        $pdf = Pdf::loadView('proposals.pdf', compact(
            'proposal',
            'business',
            'user',
            'logoBase64',
            'businessName',
            'companyWebsite',
            'language',
            'translations'
        ));
        $pdf->setPaper('a4', 'portrait');
        
        return $pdf->download('proposal_' . $proposal->proposal_number . '.pdf');
    }

    /**
     * View PDF in browser
     */
    public function viewPdf(Proposal $proposal)
    {
        $proposal->load('client');
        
        // Get business info if available
        $business = Business::first();
        $user = auth()->user();
        $language = request('lang') === 'fr' ? 'fr' : 'en';
        $translations = $this->getProposalTranslations($language);
        
        // Get logo - convert to base64 for dompdf compatibility
        $logoBase64 = null;
        if ($user->logo) {
            $logoPath = storage_path('app/public/' . $user->logo);
            if (file_exists($logoPath)) {
                $logoData = file_get_contents($logoPath);
                $logoMime = mime_content_type($logoPath);
                $logoBase64 = 'data:' . $logoMime . ';base64,' . base64_encode($logoData);
            }
        }
        
        // Company display details with sensible fallbacks
        $businessName = $user->company_name ?: ($business->name ?? $user->name);
        $companyWebsite = $user->company_website;
        
        $pdf = Pdf::loadView('proposals.pdf', compact(
            'proposal',
            'business',
            'user',
            'logoBase64',
            'businessName',
            'companyWebsite',
            'language',
            'translations'
        ));
        $pdf->setPaper('a4', 'portrait');
        
        return $pdf->stream('proposal_' . $proposal->proposal_number . '.pdf');
    }

    /**
     * Get translation strings for proposal PDFs
     */
    protected function getProposalTranslations(string $language): array
    {
        $translations = [
            'en' => [
                'document_label' => 'Proposal',
                'proposal_heading' => 'PROPOSAL',
                'number_label' => 'Number',
                'date_label' => 'Date',
                'valid_until_label' => 'Valid Until',
                'status_label' => 'Status',
                'total_amount_label' => 'Total Amount',
                'financial_overview_heading' => 'Financial Overview',
                'services_count_label' => 'Services',
                'client_label' => 'Client',
                'language_switch_label' => 'Language',
                'client_information_heading' => 'Client Information',
                'email_label' => 'Email',
                'phone_label' => 'Phone',
                'service_label' => 'Service',
                'description_label' => 'Description',
                'amount_label' => 'Amount',
                'services_heading' => 'Services',
                'notes_heading' => 'Notes',
                'footer_generated' => 'This proposal was generated on :datetime',
                'footer_contact' => 'For questions or clarifications, please contact us using the information above.',
                'formats' => [
                    'date' => 'F d, Y',
                    'datetime' => 'F d, Y \a\t H:i',
                ],
                'status_labels' => [
                    'draft' => 'Draft',
                    'sent' => 'Sent',
                    'accepted' => 'Accepted',
                    'rejected' => 'Rejected',
                ],
            ],
            'fr' => [
                'document_label' => 'Devis',
                'proposal_heading' => 'DEVIS',
                'number_label' => 'Numéro',
                'date_label' => 'Date',
                'valid_until_label' => 'Valide jusqu\'au',
                'status_label' => 'Statut',
                'total_amount_label' => 'Montant total',
                'financial_overview_heading' => 'Résumé financier',
                'services_count_label' => 'Prestations',
                'client_label' => 'Client',
                'language_switch_label' => 'Langue',
                'client_information_heading' => 'Informations client',
                'email_label' => 'E-mail',
                'phone_label' => 'Téléphone',
                'service_label' => 'Prestation',
                'description_label' => 'Description',
                'amount_label' => 'Montant',
                'services_heading' => 'Prestations',
                'notes_heading' => 'Notes',
                'footer_generated' => 'Ce devis a été généré le :datetime',
                'footer_contact' => 'Pour toute question ou précision, veuillez nous contacter via les informations ci-dessus.',
                'formats' => [
                    'date' => 'd F Y',
                    'datetime' => 'd F Y à H\hi',
                ],
                'status_labels' => [
                    'draft' => 'Brouillon',
                    'sent' => 'Envoyé',
                    'accepted' => 'Accepté',
                    'rejected' => 'Refusé',
                ],
            ],
        ];

        return $translations[$language] ?? $translations['en'];
    }
}
