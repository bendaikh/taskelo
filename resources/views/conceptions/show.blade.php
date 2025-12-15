@extends('layouts.app')

@section('title', 'View Conception')
@section('page-title', 'Conception Details')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Action Buttons -->
    <div class="mb-6 flex flex-wrap gap-3 justify-end">
        <a href="{{ route('conceptions.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
            ← Back to List
        </a>
        
        <!-- PDF Download Select -->
        <select onchange="if(this.value) window.location.href=this.value" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 cursor-pointer font-medium focus:outline-none focus:ring-2 focus:ring-purple-500">
            <option value="" class="bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200">📄 Download PDF</option>
            <option value="{{ route('conceptions.pdf', [$conception, 'en']) }}" class="bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200">🇬🇧 English</option>
            <option value="{{ route('conceptions.pdf', [$conception, 'fr']) }}" class="bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200">🇫🇷 Français</option>
        </select>
        
        <a href="{{ route('conceptions.edit', $conception) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            ✏️ Edit
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 md:p-8">
        <!-- Header -->
        <div class="border-b border-gray-200 dark:border-gray-700 pb-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                        {{ $conception->title }}
                    </h1>
                    @if($conception->description)
                        <p class="text-gray-600 dark:text-gray-400">
                            {{ $conception->description }}
                        </p>
                    @endif
                </div>
                <div>
                    @php
                        $statusColors = [
                            'draft' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                            'sent' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                            'accepted' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                            'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                        ];
                    @endphp
                    <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full {{ $statusColors[$conception->status] }}">
                        {{ ucfirst($conception->status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Info Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Client</h3>
                <p class="text-lg text-gray-900 dark:text-gray-100">
                    {{ $conception->client?->name ?? 'No client assigned' }}
                </p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Date</h3>
                <p class="text-lg text-gray-900 dark:text-gray-100">
                    {{ $conception->date->format('M d, Y') }}
                </p>
            </div>
            @if($conception->valid_until)
            <div>
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Valid Until</h3>
                <p class="text-lg text-gray-900 dark:text-gray-100">
                    {{ $conception->valid_until->format('M d, Y') }}
                </p>
            </div>
            @endif
        </div>

        <!-- Sections -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">Project Sections</h2>
            <div class="space-y-4">
                @foreach($conception->sections as $index => $section)
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300 font-semibold text-sm">
                                        {{ $index + 1 }}
                                    </span>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $section['name'] }}
                                    </h3>
                                </div>
                                @if(!empty($section['description']))
                                    <p class="text-gray-600 dark:text-gray-400 ml-10">
                                        {{ $section['description'] }}
                                    </p>
                                @endif
                            </div>
                            <div class="ml-4 text-right">
                                @if(!empty($section['price']) && $section['price'] > 0)
                                <p class="text-xl font-bold text-primary-600 dark:text-primary-400">
                                    {{ Auth::user()->currency }} {{ number_format($section['price'], 2) }}
                                </p>
                                @else
                                <p class="text-sm text-gray-400 dark:text-gray-500 italic">
                                    No price set
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Total Price -->
        <div class="border-t-2 border-gray-300 dark:border-gray-600 pt-6 mb-6">
            <div class="flex items-center justify-between">
                <span class="text-2xl font-bold text-gray-900 dark:text-gray-100">Total Price:</span>
                <span class="text-3xl font-bold text-primary-600 dark:text-primary-400">
                    {{ Auth::user()->currency }} {{ number_format($conception->total_price, 2) }}
                </span>
            </div>
        </div>

        <!-- Notes -->
        @if($conception->notes)
        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Notes</h3>
            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">
                {{ $conception->notes }}
            </p>
        </div>
        @endif

        <!-- Important Notice -->
        <div class="mt-8 border-l-4 border-yellow-500 bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded">
            <p class="text-sm text-yellow-800 dark:text-yellow-200">
                <strong>⚠️ Important:</strong> This conception defines the scope of work. Any additional features or modifications outside these sections will require separate pricing and agreement.
            </p>
        </div>
    </div>
</div>
@endsection

