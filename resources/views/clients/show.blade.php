@extends('layouts.app')

@section('title', $client->name)
@section('page-title', $client->name)

@section('content')
<!-- Client Info -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Client Information</h3>
            <dl class="space-y-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                    <dd class="text-gray-900 dark:text-gray-100">{{ $client->email }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</dt>
                    <dd class="text-gray-900 dark:text-gray-100">{{ $client->phone ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Company</dt>
                    <dd class="text-gray-900 dark:text-gray-100">{{ $client->company ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Address</dt>
                    <dd class="text-gray-900 dark:text-gray-100">{{ $client->address ?? 'N/A' }}</dd>
                </div>
            </dl>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Financial Overview</h3>
            <dl class="space-y-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Projects</dt>
                    <dd class="text-gray-900 dark:text-gray-100 font-semibold">{{ $client->projects->count() }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Revenue</dt>
                    <dd class="text-green-600 font-semibold">{{ Auth::user()->currency }} {{ number_format($client->total_revenue, 2) }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Outstanding Balance</dt>
                    <dd class="text-red-600 font-semibold">{{ Auth::user()->currency }} {{ number_format($client->outstanding_balance, 2) }}</dd>
                </div>
            </dl>
        </div>
    </div>

    @if($client->notes)
        <div class="mt-6">
            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Notes</h4>
            <p class="text-gray-900 dark:text-gray-100">{{ $client->notes }}</p>
        </div>
    @endif
</div>

<!-- Projects -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Projects</h3>
    </div>
    <div class="p-6">
        @forelse($client->projects as $project)
            <div class="py-4 border-b border-gray-200 dark:border-gray-700 last:border-0">
                <div class="flex items-center justify-between mb-2">
                    <a href="{{ route('projects.show', $project) }}" class="text-lg font-medium text-primary-600 dark:text-primary-400 hover:text-primary-700">
                        {{ $project->title }}
                    </a>
                    <span class="px-3 py-1 text-sm rounded-full 
                        @if($project->status === 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                        @elseif($project->status === 'completed') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                        @elseif($project->status === 'on_hold') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                        @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                    </span>
                </div>
                <div class="grid grid-cols-4 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">Budget:</span>
                        <span class="text-gray-900 dark:text-gray-100 font-medium">{{ Auth::user()->currency }} {{ number_format($project->budget, 2) }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">Paid:</span>
                        <span class="text-green-600 font-medium">{{ Auth::user()->currency }} {{ number_format($project->amount_paid, 2) }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">Pending:</span>
                        <span class="text-red-600 font-medium">{{ Auth::user()->currency }} {{ number_format($project->pending, 2) }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">Unpaid Tasks Total:</span>
                        <span class="text-orange-600 font-medium">
                            {{ Auth::user()->currency }} 
                            {{ number_format(max(($project->tasks->sum('price') ?? 0) - $project->amount_paid, 0), 2) }}
                        </span>
                    </div>
                </div>
                <div class="mt-2">
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-primary-600 h-2 rounded-full" style="width: {{ $project->progress }}%"></div>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $project->progress }}% complete ({{ $project->tasks->where('status', 'done')->count() }}/{{ $project->tasks->count() }} tasks)</p>
                </div>
            </div>
        @empty
            <p class="text-gray-500 dark:text-gray-400 text-center py-4">No projects yet</p>
        @endforelse
    </div>
</div>

<!-- Payment History -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Payment History</h3>
    </div>
    <div class="p-6">
        @forelse($client->payments as $payment)
            <div class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700 last:border-0">
                <div>
                    <p class="font-medium text-gray-800 dark:text-gray-200">{{ $payment->project->title }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ ucfirst($payment->type) }} • {{ $payment->date->format('M d, Y') }}
                    </p>
                </div>
                <p class="font-semibold text-green-600">{{ Auth::user()->currency }} {{ number_format($payment->amount, 2) }}</p>
            </div>
        @empty
            <p class="text-gray-500 dark:text-gray-400 text-center py-4">No payments yet</p>
        @endforelse
    </div>
</div>
@endsection

