@extends('layouts.app')

@section('title', 'Import Conceptions')
@section('page-title', 'Import Conceptions from Excel')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        
        <!-- Instructions -->
        <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
            <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-2">How to Import Conceptions</h3>
            <ol class="list-decimal list-inside space-y-2 text-blue-800 dark:text-blue-200">
                <li>Download the Excel template using the button below</li>
                <li>Fill in the template with your conception data</li>
                <li>Each row represents one conception</li>
                <li>You can add up to 10 sections per conception</li>
                <li>Make sure dates are in YYYY-MM-DD format</li>
                <li>Upload the completed file using the form below</li>
            </ol>
        </div>

        <!-- Download Template Button -->
        <div class="mb-6">
            <a href="{{ route('conceptions.template') }}" 
               class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Download Excel Template
            </a>
        </div>

        <!-- Import Form -->
        <form method="POST" action="{{ route('conceptions.import') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Select Excel File *
                </label>
                <input 
                    type="file" 
                    name="file" 
                    id="file" 
                    accept=".xlsx,.xls,.csv"
                    required
                    class="block w-full text-sm text-gray-900 dark:text-gray-100 
                           file:mr-4 file:py-2 file:px-4
                           file:rounded-lg file:border-0
                           file:text-sm file:font-semibold
                           file:bg-primary-50 file:text-primary-700
                           hover:file:bg-primary-100
                           dark:file:bg-primary-900 dark:file:text-primary-300
                           border border-gray-300 dark:border-gray-600 rounded-lg
                           bg-white dark:bg-gray-700
                           cursor-pointer">
                @error('file')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- File Format Information -->
            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-2">Supported Formats:</h4>
                <ul class="list-disc list-inside text-sm text-gray-600 dark:text-gray-400 space-y-1">
                    <li>Excel 2007 and later (.xlsx)</li>
                    <li>Excel 97-2003 (.xls)</li>
                    <li>CSV files (.csv)</li>
                </ul>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Maximum file size: 2MB</p>
            </div>

            <!-- Import Errors Display -->
            @if(session('import_errors') && count(session('import_errors')) > 0)
            <div class="p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                <h4 class="text-sm font-semibold text-yellow-900 dark:text-yellow-100 mb-2">Import Warnings:</h4>
                <ul class="list-disc list-inside text-sm text-yellow-800 dark:text-yellow-200 space-y-1 max-h-48 overflow-y-auto">
                    @foreach(session('import_errors') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4">
                <a href="{{ route('conceptions.index') }}" 
                   class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 text-center">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                    Import Conceptions
                </button>
            </div>
        </form>
    </div>

    <!-- Additional Information -->
    <div class="mt-6 bg-gray-50 dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Template Column Guide</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Required Fields:</h4>
                <ul class="list-disc list-inside text-gray-600 dark:text-gray-400 space-y-1">
                    <li>Title</li>
                    <li>At least one section name</li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Optional Fields:</h4>
                <ul class="list-disc list-inside text-gray-600 dark:text-gray-400 space-y-1">
                    <li>Client Name (must exist in your clients list)</li>
                    <li>Description</li>
                    <li>Valid Until Date</li>
                    <li>Currency (defaults to USD)</li>
                    <li>Notes</li>
                    <li>Section Descriptions, Prices, and Time Ranges</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
