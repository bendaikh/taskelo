@extends('layouts.app')

@section('title', 'Edit Conception')
@section('page-title', 'Edit Conception')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <form method="POST" action="{{ route('conceptions.update', $conception) }}" id="conception-form">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Title -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Conception Title *</label>
                    <input 
                        type="text" 
                        name="title" 
                        id="title" 
                        value="{{ old('title', $conception->title) }}"
                        required
                        placeholder="e.g., E-commerce Website Development"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Client -->
                <div>
                    <label for="client_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Client</label>
                    <select 
                        name="client_id" 
                        id="client_id"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
                        <option value="">No client (General conception)</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ old('client_id', $conception->client_id) == $client->id ? 'selected' : '' }}>
                                {{ $client->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Date -->
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Date *</label>
                    <input 
                        type="date" 
                        name="date" 
                        id="date" 
                        value="{{ old('date', $conception->date->format('Y-m-d')) }}"
                        required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 @error('date') border-red-500 @enderror">
                    @error('date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Currency -->
                <div>
                    <label for="currency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Currency *</label>
                    <select 
                        name="currency" 
                        id="currency" 
                        required
                        onchange="updateCurrencyDisplay()"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 @error('currency') border-red-500 @enderror">
                        <option value="USD" {{ old('currency', $conception->currency ?? 'USD') === 'USD' ? 'selected' : '' }}>USD ($)</option>
                        <option value="EUR" {{ old('currency', $conception->currency) === 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                        <option value="GBP" {{ old('currency', $conception->currency) === 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                        <option value="JPY" {{ old('currency', $conception->currency) === 'JPY' ? 'selected' : '' }}>JPY (¥)</option>
                        <option value="INR" {{ old('currency', $conception->currency) === 'INR' ? 'selected' : '' }}>INR (₹)</option>
                        <option value="AUD" {{ old('currency', $conception->currency) === 'AUD' ? 'selected' : '' }}>AUD (A$)</option>
                        <option value="CAD" {{ old('currency', $conception->currency) === 'CAD' ? 'selected' : '' }}>CAD (C$)</option>
                        <option value="MAD" {{ old('currency', $conception->currency) === 'MAD' ? 'selected' : '' }}>MAD (Dhs)</option>
                        <option value="PHP" {{ old('currency', $conception->currency) === 'PHP' ? 'selected' : '' }}>PHP (₱)</option>
                        <option value="NGN" {{ old('currency', $conception->currency) === 'NGN' ? 'selected' : '' }}>NGN (₦)</option>
                        <option value="PKR" {{ old('currency', $conception->currency) === 'PKR' ? 'selected' : '' }}>PKR (₨)</option>
                        <option value="BDT" {{ old('currency', $conception->currency) === 'BDT' ? 'selected' : '' }}>BDT (৳)</option>
                        <option value="XOF" {{ old('currency', $conception->currency) === 'XOF' ? 'selected' : '' }}>CFA (FCFA)</option>
                        <option value="XAF" {{ old('currency', $conception->currency) === 'XAF' ? 'selected' : '' }}>CFA Central (FCFA)</option>
                    </select>
                    @error('currency')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Valid Until -->
                <div>
                    <label for="valid_until" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Valid Until</label>
                    <input 
                        type="date" 
                        name="valid_until" 
                        id="valid_until" 
                        value="{{ old('valid_until', $conception->valid_until?->format('Y-m-d')) }}"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status *</label>
                    <select 
                        name="status" 
                        id="status"
                        required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
                        <option value="draft" {{ old('status', $conception->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="sent" {{ old('status', $conception->status) == 'sent' ? 'selected' : '' }}>Sent</option>
                        <option value="accepted" {{ old('status', $conception->status) == 'accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="rejected" {{ old('status', $conception->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                    <textarea 
                        name="description" 
                        id="description" 
                        rows="3"
                        placeholder="Brief description of the project..."
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">{{ old('description', $conception->description) }}</textarea>
                </div>
            </div>

            <!-- Sections -->
            <div class="mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Project Sections *</h3>
                    <button type="button" onclick="addSection()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm">
                        + Add Section
                    </button>
                </div>

                <div id="sections-container" class="space-y-4">
                    <!-- Existing sections will be loaded here -->
                </div>

                <!-- Remise -->
                <div class="mt-4 p-4 border border-gray-200 dark:border-gray-600 rounded-lg">
                    <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-3">Remise (optional)</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="remise_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Type</label>
                            <select
                                name="remise_type"
                                id="remise_type"
                                onchange="updateTotal()"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
                                <option value="fixed" {{ old('remise_type', $conception->remise_type ?? 'fixed') === 'fixed' ? 'selected' : '' }}>Fixed amount</option>
                                <option value="percent" {{ old('remise_type', $conception->remise_type ?? 'fixed') === 'percent' ? 'selected' : '' }}>Percentage (%)</option>
                            </select>
                        </div>
                        <div>
                            <label for="remise" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Value</label>
                            <input
                                type="number"
                                name="remise"
                                id="remise"
                                value="{{ old('remise', $conception->remise ?? 0) }}"
                                min="0"
                                step="0.01"
                                onchange="updateTotal()"
                                oninput="updateTotal()"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 @error('remise') border-red-500 @enderror">
                            @error('remise')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div id="total-price-container" class="mt-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg space-y-2">
                    <div class="flex items-center justify-between text-gray-700 dark:text-gray-300">
                        <span>Subtotal:</span>
                        <span id="subtotal-price"><span class="currency-symbol">{{ $conception->currency ?? 'USD' }}</span> 0.00</span>
                    </div>
                    <div id="remise-row" class="flex items-center justify-between text-red-600 dark:text-red-400 hidden">
                        <span>Remise:</span>
                        <span id="remise-amount">-<span class="currency-symbol">{{ $conception->currency ?? 'USD' }}</span> 0.00</span>
                    </div>
                    <div class="flex items-center justify-between pt-2 border-t border-gray-300 dark:border-gray-600">
                        <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">Total Price:</span>
                        <span id="total-price" class="text-2xl font-bold text-primary-600 dark:text-primary-400">
                            <span class="currency-symbol">{{ $conception->currency ?? 'USD' }}</span> 0.00
                        </span>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="mb-6">
                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Notes</label>
                <textarea 
                    name="notes" 
                    id="notes" 
                    rows="3"
                    placeholder="Any additional notes or terms..."
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">{{ old('notes', $conception->notes) }}</textarea>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row justify-end gap-3">
                <a href="{{ route('conceptions.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 text-center">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                    Update Conception
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let sectionCount = 0;
let existingSections = @json(old('sections', $conception->sections ?? [])) || [];

// Convert object to array if needed (sections may be stored as {"1": {...}, "2": {...}})
if (existingSections && typeof existingSections === 'object' && !Array.isArray(existingSections)) {
    existingSections = Object.values(existingSections);
}

function getCurrentCurrency() {
    return document.getElementById('currency').value;
}

function updateCurrencyDisplay() {
    const currency = getCurrentCurrency();
    document.querySelectorAll('.currency-symbol').forEach(el => {
        el.textContent = currency;
    });

    const currencyLabels = document.querySelectorAll('.currency-label');
    currencyLabels.forEach(label => {
        label.textContent = currency;
    });

    updateTotal();
}

function getRemiseAmount(subtotal) {
    const remise = parseFloat(document.getElementById('remise').value) || 0;
    const remiseType = document.getElementById('remise_type').value;

    if (remise <= 0 || subtotal <= 0) {
        return 0;
    }

    if (remiseType === 'percent') {
        return Math.min(subtotal, subtotal * Math.min(remise, 100) / 100);
    }

    return Math.min(remise, subtotal);
}

function addSection(name = '', description = '', price = '', timeRange = '') {
    sectionCount++;
    const container = document.getElementById('sections-container');
    const currency = getCurrentCurrency();
    const sectionHtml = `
        <div class="section-item p-4 border-2 border-gray-300 dark:border-gray-600 rounded-lg relative" id="section-${sectionCount}">
            <button type="button" onclick="removeSection(${sectionCount})" class="absolute top-2 right-2 text-red-600 hover:text-red-800 dark:text-red-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Section Name *</label>
                    <input 
                        type="text" 
                        name="sections[${sectionCount}][name]" 
                        value="${name}"
                        required
                        placeholder="e.g., User Authentication System"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                    <textarea 
                        name="sections[${sectionCount}][description]" 
                        rows="2"
                        placeholder="What's included in this section..."
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">${description}</textarea>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Price (optional)</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-500 dark:text-gray-400 currency-label">${currency}</span>
                            <input 
                                type="number" 
                                name="sections[${sectionCount}][price]" 
                                value="${price}"
                                min="0"
                                step="0.01"
                                placeholder="0.00"
                                onchange="updateTotal()"
                                oninput="updateTotal()"
                                class="section-price w-full pl-16 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Time Range (optional)</label>
                        <input 
                            type="text" 
                            name="sections[${sectionCount}][time_range]" 
                            value="${timeRange}"
                            placeholder="e.g., 2-3 weeks, 5 days, 10 hours"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
                    </div>
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', sectionHtml);
    updateTotal();
}

function removeSection(id) {
    const section = document.getElementById(`section-${id}`);
    if (section) {
        section.remove();
        updateTotal();
    }
}

function updateTotal() {
    const prices = document.querySelectorAll('.section-price');
    let subtotal = 0;

    prices.forEach(priceInput => {
        subtotal += parseFloat(priceInput.value) || 0;
    });

    const currency = getCurrentCurrency();
    const remiseAmount = getRemiseAmount(subtotal);
    const total = Math.max(0, subtotal - remiseAmount);

    document.getElementById('subtotal-price').innerHTML = `<span class="currency-symbol">${currency}</span> ${subtotal.toFixed(2)}`;
    document.getElementById('total-price').innerHTML = `<span class="currency-symbol">${currency}</span> ${total.toFixed(2)}`;

    const remiseRow = document.getElementById('remise-row');
    if (remiseAmount > 0) {
        remiseRow.classList.remove('hidden');
        document.getElementById('remise-amount').innerHTML = `-<span class="currency-symbol">${currency}</span> ${remiseAmount.toFixed(2)}`;
    } else {
        remiseRow.classList.add('hidden');
    }
}

// Load existing sections on page load
window.addEventListener('DOMContentLoaded', function() {
    if (Array.isArray(existingSections) && existingSections.length > 0) {
        existingSections.forEach(section => {
            addSection(section.name || '', section.description || '', section.price || '', section.time_range || '');
        });
    } else {
        addSection();
    }
    updateCurrencyDisplay();
});

// Validate form before submission
document.getElementById('conception-form').addEventListener('submit', function(e) {
    const sectionsContainer = document.getElementById('sections-container');
    if (sectionsContainer.children.length === 0) {
        e.preventDefault();
        alert('Please add at least one section to the conception.');
    }
});
</script>
@endsection
