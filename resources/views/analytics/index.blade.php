@extends('layouts.app')

@section('title', 'Analytics')
@section('page-title', 'Analytics')

@section('content')
<!-- Revenue Comparison -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
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

    <!-- Payment Completion Rate -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Payment Completion Rate</h3>
        <div class="flex items-center justify-center h-32">
            <div class="text-center">
                <div class="text-5xl font-bold text-primary-600">{{ number_format($completionRate, 1) }}%</div>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Overall Completion</p>
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

<!-- Top Clients and Project Status -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Top 5 Clients -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Top 5 Clients by Revenue</h3>
        <div class="space-y-4">
            @foreach($topClients as $index => $client)
                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-700 dark:text-gray-300">{{ $index + 1 }}. {{ $client['name'] }}</span>
                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ Auth::user()->currency }} {{ number_format($client['revenue'], 2) }}</span>
                    </div>
                    @php
                        $maxRevenue = $topClients->max('revenue');
                        $percentage = $maxRevenue > 0 ? ($client['revenue'] / $maxRevenue) * 100 : 0;
                    @endphp
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-primary-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Project Status Distribution -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Project Status Distribution</h3>
        <div class="space-y-3">
            @foreach(['planning' => 'Planning', 'active' => 'Active', 'on_hold' => 'On Hold', 'completed' => 'Completed', 'cancelled' => 'Cancelled'] as $key => $label)
                @php
                    $count = $projectsByStatus[$key] ?? 0;
                @endphp
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3 flex-1">
                        <span class="px-3 py-1 text-xs rounded-full
                            @if($key === 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                            @elseif($key === 'completed') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                            @elseif($key === 'on_hold') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                            @elseif($key === 'cancelled') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                            @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300
                            @endif">
                            {{ $label }}
                        </span>
                        <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            @php
                                $total = $projectsByStatus->sum();
                                $percentage = $total > 0 ? ($count / $total) * 100 : 0;
                            @endphp
                            <div class="bg-primary-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                    <span class="ml-3 font-semibold text-gray-900 dark:text-gray-100">{{ $count }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Revenue by Type -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Revenue by Payment Type</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4 border border-green-200 dark:border-green-800">
            <div class="text-sm text-green-700 dark:text-green-300 mb-1">Payments</div>
            <div class="text-2xl font-bold text-green-800 dark:text-green-200">
                {{ Auth::user()->currency }} {{ number_format($revenueByType['payment'] ?? 0, 2) }}
            </div>
        </div>
        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
            <div class="text-sm text-blue-700 dark:text-blue-300 mb-1">Advances</div>
            <div class="text-2xl font-bold text-blue-800 dark:text-blue-200">
                {{ Auth::user()->currency }} {{ number_format($revenueByType['advance'] ?? 0, 2) }}
            </div>
        </div>
    </div>
</div>
@endsection

