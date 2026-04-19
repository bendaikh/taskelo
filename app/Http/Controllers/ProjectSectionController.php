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
        $query = ProjectSection::with(['client', 'user'])
            ->orderBy('created_at', 'desc');

        if (!Auth::user()->isSuperAdmin()) {
            $query->where('user_id', Auth::id());
        }

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

        $conceptions = $query->paginate(8);

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
            'currency' => 'required|string|max:10',
            'notes' => 'nullable|string',
            'sections' => 'required|array|min:1',
            'sections.*.name' => 'required|string|max:255',
            'sections.*.description' => 'nullable|string',
            'sections.*.price' => 'nullable|numeric|min:0',
            'sections.*.time_range' => 'nullable|string|max:255',
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
        if (!Auth::user()->isSuperAdmin() && $conception->user_id !== Auth::id()) {
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
        if (!Auth::user()->isSuperAdmin() && $conception->user_id !== Auth::id()) {
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
        if (!Auth::user()->isSuperAdmin() && $conception->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'client_id' => 'nullable|exists:clients,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'valid_until' => 'nullable|date|after:date',
            'currency' => 'required|string|max:10',
            'notes' => 'nullable|string',
            'status' => 'required|in:draft,sent,accepted,rejected',
            'sections' => 'required|array|min:1',
            'sections.*.name' => 'required|string|max:255',
            'sections.*.description' => 'nullable|string',
            'sections.*.price' => 'nullable|numeric|min:0',
            'sections.*.time_range' => 'nullable|string|max:255',
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
        if (!Auth::user()->isSuperAdmin() && $conception->user_id !== Auth::id()) {
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
        if (!Auth::user()->isSuperAdmin() && $conception->user_id !== Auth::id()) {
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
                'time_range' => 'Time Range',
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
                'time_range' => 'Durée',
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

    /**
     * Show the import form
     */
    public function showImportForm()
    {
        return view('conceptions.import');
    }

    /**
     * Download Excel template for importing conceptions
     */
    public function downloadTemplate()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $headers = [
            'A1' => 'Title',
            'B1' => 'Client Name (optional)',
            'C1' => 'Description',
            'D1' => 'Date (YYYY-MM-DD)',
            'E1' => 'Valid Until (YYYY-MM-DD, optional)',
            'F1' => 'Currency',
            'G1' => 'Notes',
            'H1' => 'Section 1 Name',
            'I1' => 'Section 1 Description',
            'J1' => 'Section 1 Price',
            'K1' => 'Section 1 Time Range',
            'L1' => 'Section 2 Name',
            'M1' => 'Section 2 Description',
            'N1' => 'Section 2 Price',
            'O1' => 'Section 2 Time Range',
            'P1' => 'Section 3 Name',
            'Q1' => 'Section 3 Description',
            'R1' => 'Section 3 Price',
            'S1' => 'Section 3 Time Range',
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
            $sheet->getStyle($cell)->getFont()->setBold(true);
        }

        // Add example row
        $sheet->setCellValue('A2', 'E-commerce Website Development');
        $sheet->setCellValue('B2', 'Example Client');
        $sheet->setCellValue('C2', 'A modern e-commerce platform');
        $sheet->setCellValue('D2', now()->format('Y-m-d'));
        $sheet->setCellValue('E2', now()->addDays(30)->format('Y-m-d'));
        $sheet->setCellValue('F2', 'USD');
        $sheet->setCellValue('G2', 'Payment terms: 50% upfront, 50% on completion');
        $sheet->setCellValue('H2', 'User Authentication System');
        $sheet->setCellValue('I2', 'Login, registration, password reset functionality');
        $sheet->setCellValue('J2', '500.00');
        $sheet->setCellValue('K2', '1 week');
        $sheet->setCellValue('L2', 'Product Catalog');
        $sheet->setCellValue('M2', 'Product listing, filtering, and search');
        $sheet->setCellValue('N2', '1200.00');
        $sheet->setCellValue('O2', '2 weeks');
        $sheet->setCellValue('P2', 'Shopping Cart & Checkout');
        $sheet->setCellValue('Q2', 'Cart functionality and payment integration');
        $sheet->setCellValue('R2', '800.00');
        $sheet->setCellValue('S2', '1.5 weeks');

        // Auto-size columns
        foreach (range('A', 'S') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        
        $filename = 'conception_import_template.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), $filename);
        $writer->save($tempFile);

        return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
    }

    /**
     * Import conceptions from Excel file
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            $file = $request->file('file');
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            // Remove header row
            $header = array_shift($rows);

            $imported = 0;
            $errors = [];

            foreach ($rows as $index => $row) {
                $rowNumber = $index + 2; // +2 because we removed header and Excel is 1-indexed

                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }

                try {
                    // Get client ID if client name is provided
                    $clientId = null;
                    if (!empty($row[1])) {
                        $client = \App\Models\Client::where('name', $row[1])->first();
                        if ($client) {
                            $clientId = $client->id;
                        }
                    }

                    // Build sections array (supporting up to 10 sections)
                    $sections = [];
                    for ($i = 0; $i < 10; $i++) {
                        $baseIndex = 7 + ($i * 4); // Starting from column H (index 7)
                        
                        if (!empty($row[$baseIndex])) {
                            $sections[] = [
                                'name' => $row[$baseIndex],
                                'description' => $row[$baseIndex + 1] ?? '',
                                'price' => !empty($row[$baseIndex + 2]) ? floatval($row[$baseIndex + 2]) : 0,
                                'time_range' => $row[$baseIndex + 3] ?? '',
                            ];
                        }
                    }

                    if (empty($sections)) {
                        $errors[] = "Row {$rowNumber}: No sections provided";
                        continue;
                    }

                    // Calculate total price
                    $totalPrice = collect($sections)->sum('price');

                    // Create the conception
                    ProjectSection::create([
                        'user_id' => Auth::id(),
                        'client_id' => $clientId,
                        'title' => $row[0],
                        'description' => $row[2] ?? null,
                        'date' => !empty($row[3]) ? $row[3] : now()->format('Y-m-d'),
                        'valid_until' => !empty($row[4]) ? $row[4] : null,
                        'currency' => !empty($row[5]) ? $row[5] : 'USD',
                        'notes' => $row[6] ?? null,
                        'sections' => $sections,
                        'total_price' => $totalPrice,
                        'status' => 'draft',
                    ]);

                    $imported++;

                } catch (\Exception $e) {
                    $errors[] = "Row {$rowNumber}: " . $e->getMessage();
                }
            }

            $message = "Successfully imported {$imported} conception(s).";
            if (!empty($errors)) {
                $message .= " " . count($errors) . " row(s) had errors.";
            }

            return redirect()->route('conceptions.index')
                ->with('success', $message)
                ->with('import_errors', $errors);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error importing file: ' . $e->getMessage());
        }
    }
}

