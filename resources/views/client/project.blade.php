@extends('client.layouts.app')

@section('title', $project->title . ' - Client Portal')

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <div>
        <a href="{{ route('client.projects') }}" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-700">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-1">
                <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
            </svg>
            Back to Projects
        </a>
    </div>

    <!-- Project Header -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-start justify-between mb-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $project->title }}</h2>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium mt-2
                    @if($project->status === 'completed') bg-green-100 text-green-800
                    @elseif($project->status === 'in_progress') bg-blue-100 text-blue-800
                    @elseif($project->status === 'on_hold') bg-yellow-100 text-yellow-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                </span>
            </div>
        </div>

        @if($project->description)
            <p class="text-gray-600 mb-6">{{ $project->description }}</p>
        @endif

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-6 pb-6 border-b border-gray-200">
            <div>
                <p class="text-sm text-gray-500 mb-1">Start Date</p>
                <p class="text-base font-medium text-gray-900">{{ $project->start_date ? $project->start_date->format('M d, Y') : 'Not set' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">End Date</p>
                <p class="text-base font-medium text-gray-900">{{ $project->end_date ? $project->end_date->format('M d, Y') : 'Not set' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Budget</p>
                <p class="text-base font-medium text-gray-900">{{ $currency }}{{ number_format($project->budget ?? $project->tasks->sum('price'), 2) }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Amount Paid</p>
                <p class="text-base font-medium text-green-600">{{ $currency }}{{ number_format($project->amount_paid, 2) }}</p>
            </div>
        </div>

        <div class="space-y-4">
            <div>
                <div class="flex items-center justify-between text-sm mb-2">
                    <span class="text-gray-700 font-medium">Task Completion</span>
                    <span class="text-gray-900">{{ $project->tasks->where('status', 'done')->count() }} / {{ $project->tasks->count() }} tasks ({{ $project->progress }}%)</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-blue-600 h-3 rounded-full transition-all" style="width: {{ $project->progress }}%"></div>
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between text-sm mb-2">
                    <span class="text-gray-700 font-medium">Payment Progress</span>
                    <span class="text-gray-900">{{ $currency }}{{ number_format($project->amount_paid, 2) }} / {{ $currency }}{{ number_format($project->budget ?? $project->tasks->sum('price'), 2) }} ({{ $project->payment_progress }}%)</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-green-600 h-3 rounded-full transition-all" style="width: {{ $project->payment_progress }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tasks -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Tasks</h3>
        </div>
        <div class="p-6">
            @if($project->tasks->isEmpty())
                <p class="text-gray-500 text-center py-8">No tasks for this project</p>
            @else
                <div class="space-y-3">
                    @foreach($project->tasks as $task)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h4 class="text-base font-medium text-gray-900">{{ $task->title }}</h4>
                                    @if($task->description)
                                        <p class="text-sm text-gray-600 mt-1">{{ $task->description }}</p>
                                    @endif
                                    <div class="flex items-center gap-4 mt-2">
                                        @if($task->deadline)
                                            <span class="text-xs text-gray-500">
                                                Due: {{ $task->deadline->format('M d, Y') }}
                                            </span>
                                        @endif
                                        @if($task->price)
                                            <span class="text-xs text-gray-500">
                                                Price: {{ $currency }}{{ number_format($task->price, 2) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ml-4
                                    @if($task->status === 'done') bg-green-100 text-green-800
                                    @elseif($task->status === 'in_progress') bg-blue-100 text-blue-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Payments -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Payments</h3>
        </div>
        <div class="p-6">
            @if($project->payments->isEmpty())
                <p class="text-gray-500 text-center py-8">No payments recorded yet</p>
            @else
                <div class="space-y-3">
                    @foreach($project->payments as $payment)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <p class="text-sm font-medium text-gray-900">Payment</p>
                                <p class="text-xs text-gray-500">{{ $payment->date->format('M d, Y') }} • {{ ucfirst($payment->type) }}</p>
                                @if($payment->notes)
                                    <p class="text-xs text-gray-600 mt-1">{{ $payment->notes }}</p>
                                @endif
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-semibold text-green-600">{{ $currency }}{{ number_format($payment->amount, 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
