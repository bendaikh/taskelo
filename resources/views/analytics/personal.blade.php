@extends('layouts.app')

@section('title', 'Analytics')
@section('page-title', 'Analytics')

@section('content')
<!-- Personal Workspace Analytics -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <!-- Yearly Revenue Comparison -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Yearly Revenue Comparison</h3>
        <div class="space-y-4">
            <div>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600 dark:text-gray-400">Current Year ({{ now()->year }})</span>
                    <span class="font-bold text-gray-900 dark:text-gray-100">{{ Auth::user()->currency }} {{ number_format($currentYearRevenue, 2) }}</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                    <div class="bg-green-600 h-3 rounded-full" style="width: 100%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600 dark:text-gray-400">Last Year ({{ now()->year - 1 }})</span>
                    <span class="font-bold text-gray-900 dark:text-gray-100">{{ Auth::user()->currency }} {{ number_format($lastYearRevenue, 2) }}</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                    @php
                        $percentage = $currentYearRevenue > 0 ? ($lastYearRevenue / $currentYearRevenue) * 100 : 0;
                    @endphp
                    <div class="bg-blue-600 h-3 rounded-full" style="width: {{ $percentage }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Total Revenue</h3>
        <div class="flex items-center justify-center h-32">
            <div class="text-center">
                <div class="text-4xl font-bold text-primary-600">
                    {{ Auth::user()->currency }} {{ number_format($totalRevenue, 2) }}
                </div>
                <p class="text-gray-500 dark:text-gray-400 mt-2">All Time</p>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Revenue Chart -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Monthly Revenue Trend (Last 12 Months)</h3>
    <div id="monthly-revenue-chart">
        <revenue-chart
            :data='@json($monthlyRevenue)'
            :currency="'{{ Auth::user()->currency }}'">
        </revenue-chart>
    </div>
</div>

<!-- Top Categories -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Top 5 Categories by Revenue</h3>
    @if($topCategories->count() === 0)
        <p class="text-gray-500 dark:text-gray-400">No revenue yet in this workspace.</p>
    @else
        <div class="space-y-4">
            @php
                $max = $topCategories->max('total') ?? 0;
            @endphp
            @foreach($topCategories as $index => $row)
                @php
                    $pct = $max > 0 ? ((float) $row->total / (float) $max) * 100 : 0;
                @endphp
                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-700 dark:text-gray-300">{{ $index + 1 }}. {{ $row->category }}</span>
                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ Auth::user()->currency }} {{ number_format($row->total, 2) }}</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-primary-600 h-2 rounded-full" style="width: {{ $pct }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection


