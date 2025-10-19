@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Overview Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Total Projects -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 dark:text-gray-400 text-sm">Total Projects</p>
                <p class="text-3xl font-bold text-gray-800 dark:text-gray-200 mt-2">{{ $totalProjects }}</p>
            </div>
            <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-lg">
                <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Active Clients -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 dark:text-gray-400 text-sm">Active Clients</p>
                <p class="text-3xl font-bold text-gray-800 dark:text-gray-200 mt-2">{{ $activeClients }}</p>
            </div>
            <div class="bg-green-100 dark:bg-green-900 p-3 rounded-lg">
                <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 dark:text-gray-400 text-sm">Total Revenue</p>
                <p class="text-3xl font-bold text-gray-800 dark:text-gray-200 mt-2">{{ Auth::user()->currency }} {{ number_format($totalRevenue, 2) }}</p>
            </div>
            <div class="bg-yellow-100 dark:bg-yellow-900 p-3 rounded-lg">
                <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Pending Payments -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 dark:text-gray-400 text-sm">Pending Payments</p>
                <p class="text-3xl font-bold text-gray-800 dark:text-gray-200 mt-2">{{ Auth::user()->currency }} {{ number_format($pendingPayments, 2) }}</p>
            </div>
            <div class="bg-red-100 dark:bg-red-900 p-3 rounded-lg">
                <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Monthly Revenue Chart -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Monthly Revenue</h3>
        <div id="monthly-revenue-chart-container">
            <revenue-chart 
                :data='@json($monthlyRevenue)'
                :currency="'{{ Auth::user()->currency }}'">
            </revenue-chart>
        </div>
    </div>

    <!-- Daily Revenue Chart -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Daily Revenue (Last 14 Days)</h3>
        <div>
            <revenue-chart 
                :data='@json($dailyRevenue)'
                :currency="'{{ Auth::user()->currency }}'">
            </revenue-chart>
        </div>
    </div>

    <!-- Payment Status Chart -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Payment Status</h3>
        <div id="payment-status-chart-container">
            <payment-status-chart 
                :data='@json($paymentStatus)'
                :currency="'{{ Auth::user()->currency }}'">
            </payment-status-chart>
        </div>
    </div>
</div>

<!-- Recent Items -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Payments -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Recent Payments</h3>
        </div>
        <div class="p-6">
            @forelse($recentPayments as $payment)
                <div class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700 last:border-0">
                    <div>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $payment->client->name }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $payment->project->title }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-green-600">{{ Auth::user()->currency }} {{ number_format($payment->amount, 2) }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $payment->date->format('M d, Y') }}</p>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">No recent payments</p>
            @endforelse
        </div>
        <div class="p-4 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('payments.index') }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 text-sm font-medium">
                View all payments →
            </a>
        </div>
    </div>

    <!-- Recent Projects -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Recent Projects</h3>
        </div>
        <div class="p-6">
            @forelse($recentProjects as $project)
                <div class="py-3 border-b border-gray-200 dark:border-gray-700 last:border-0">
                    <div class="flex items-center justify-between mb-2">
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $project->title }}</p>
                        <span class="px-2 py-1 text-xs rounded-full 
                            @if($project->status === 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                            @elseif($project->status === 'completed') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                            @elseif($project->status === 'on_hold') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                            @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $project->client->name }}</p>
                    <div class="mt-2">
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-primary-600 h-2 rounded-full" style="width: {{ $project->progress }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $project->progress }}% complete</p>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">No recent projects</p>
            @endforelse
        </div>
        <div class="p-4 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('projects.index') }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 text-sm font-medium">
                View all projects →
            </a>
        </div>
    </div>
</div>
@endsection

