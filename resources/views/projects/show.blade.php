@extends('layouts.app')

@section('title', $project->title)
@section('page-title', $project->title)

@section('content')
<!-- Project Info -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Main Info -->
    <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="flex items-start justify-between mb-4">
            <div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-2">{{ $project->title }}</h3>
                <p class="text-gray-500 dark:text-gray-400">
                    Client: <a href="{{ route('clients.show', $project->client) }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700">{{ $project->client->name }}</a>
                </p>
            </div>
            <span class="px-3 py-1 text-sm rounded-full 
                @if($project->status === 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                @elseif($project->status === 'completed') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                @elseif($project->status === 'on_hold') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                @elseif($project->status === 'cancelled') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300
                @endif">
                {{ ucfirst(str_replace('_', ' ', $project->status)) }}
            </span>
        </div>

        @if($project->description)
            <div class="mb-4">
                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Description</h4>
                <p class="text-gray-900 dark:text-gray-100">{{ $project->description }}</p>
            </div>
        @endif

        @if($project->start_date || $project->end_date)
            <div class="flex space-x-6 text-sm">
                @if($project->start_date)
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">Start Date:</span>
                        <span class="text-gray-900 dark:text-gray-100 font-medium">{{ $project->start_date->format('M d, Y') }}</span>
                    </div>
                @endif
                @if($project->end_date)
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">End Date:</span>
                        <span class="text-gray-900 dark:text-gray-100 font-medium">{{ $project->end_date->format('M d, Y') }}</span>
                    </div>
                @endif
            </div>
        @endif

        <div class="mt-6 flex space-x-3">
            <a href="{{ route('projects.edit', $project) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Edit Project
            </a>
            <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Delete Project
                </button>
            </form>
        </div>
    </div>

    <!-- Financial Info -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Financial Overview</h3>
        <dl class="space-y-3">
            <div>
                <dt class="text-sm text-gray-500 dark:text-gray-400">Budget</dt>
                <dd class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ Auth::user()->currency }} {{ number_format($project->budget, 2) }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500 dark:text-gray-400">Amount Paid</dt>
                <dd class="text-xl font-bold text-green-600">{{ Auth::user()->currency }} {{ number_format($project->amount_paid, 2) }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500 dark:text-gray-400">Pending Amount</dt>
                <dd class="text-xl font-bold text-red-600">{{ Auth::user()->currency }} {{ number_format($project->pending, 2) }}</dd>
            </div>
        </dl>

        <!-- Payment Progress Bar -->
        <div class="mt-4">
            <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mb-1">
                <span>Payment Progress</span>
                <span>{{ $project->payment_progress }}%</span>
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                <div class="bg-green-600 h-2 rounded-full" style="width: {{ $project->payment_progress }}%"></div>
            </div>
        </div>

        <!-- Task Progress Bar -->
        <div class="mt-4">
            <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mb-1">
                <span>Task Progress</span>
                <span>{{ $project->progress }}%</span>
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                <div class="bg-primary-600 h-2 rounded-full" style="width: {{ $project->progress }}%"></div>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                {{ $project->tasks->where('status', 'done')->count() }} / {{ $project->tasks->count() }} tasks completed
            </p>
        </div>
    </div>
</div>

<!-- Tasks -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Tasks</h3>
        <button onclick="document.getElementById('add-task-form').classList.toggle('hidden')" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 text-sm">
            + Add Task
        </button>
    </div>

    <!-- Add Task Form -->
    <div id="add-task-form" class="hidden p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
        <form method="POST" action="{{ route('tasks.store') }}">
            @csrf
            <input type="hidden" name="project_id" value="{{ $project->id }}">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <input 
                        type="text" 
                        name="title" 
                        placeholder="Task title"
                        required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
                </div>
                <div>
                    <input 
                        type="date" 
                        name="deadline" 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
                </div>
                <div>
                    <input 
                        type="number" 
                        name="price" 
                        step="0.01" 
                        min="0"
                        placeholder="Price (optional)"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
                </div>
            </div>
            <div class="mt-4">
                <textarea 
                    name="description" 
                    placeholder="Task description (optional)"
                    rows="2"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500"></textarea>
            </div>
            <input type="hidden" name="status" value="todo">
            <div class="mt-4 flex justify-end space-x-2">
                <button type="button" onclick="document.getElementById('add-task-form').classList.add('hidden')" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                    Add Task
                </button>
            </div>
        </form>
    </div>

    <!-- Tasks List -->
    <div id="tasks-container" class="p-6">
        <task-list 
            :project-id="{{ $project->id }}" 
            :initial-tasks='@json($project->tasks)'>
        </task-list>
    </div>
</div>

<!-- Payments -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Payments</h3>
        <a href="{{ route('payments.create', ['project_id' => $project->id]) }}" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 text-sm">
            + Add Payment
        </a>
    </div>
    <div class="p-6">
        @forelse($project->payments as $payment)
            <div class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700 last:border-0">
                <div>
                    <p class="font-medium text-gray-800 dark:text-gray-200">{{ Auth::user()->currency }} {{ number_format($payment->amount, 2) }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ ucfirst($payment->type) }} • {{ $payment->date->format('M d, Y') }}
                    </p>
                    @if($payment->notes)
                        <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">{{ $payment->notes }}</p>
                    @endif
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('payments.edit', $payment) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 text-sm">Edit</a>
                    <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 text-sm">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-gray-500 dark:text-gray-400 text-center py-4">No payments yet</p>
        @endforelse
    </div>
</div>

<!-- Expenses -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow mt-6">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Expenses</h3>
        <a href="{{ route('expenses.create', ['project_id' => $project->id]) }}" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 text-sm">
            + Add Expense
        </a>
    </div>
    <div class="p-6">
        @php($projectTotalExpenses = $project->expenses->sum('amount'))
        <div class="flex items-center justify-between mb-4">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Expenses</p>
            <p class="text-base font-semibold text-red-600 dark:text-red-400">{{ Auth::user()->currency }} {{ number_format($projectTotalExpenses, 2) }}</p>
        </div>

        @forelse($project->expenses->sortByDesc('date') as $expense)
            <div class="flex items-start justify-between py-3 border-b border-gray-200 dark:border-gray-700 last:border-0">
                <div>
                    <p class="font-medium text-gray-800 dark:text-gray-200">{{ $expense->category ?? 'Expense' }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $expense->date->format('M d, Y') }}</p>
                    @if($expense->notes)
                        <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">{{ $expense->notes }}</p>
                    @endif
                </div>
                <div class="text-right">
                    <p class="font-semibold text-red-600 dark:text-red-400">{{ Auth::user()->currency }} {{ number_format($expense->amount, 2) }}</p>
                </div>
            </div>
        @empty
            <p class="text-gray-500 dark:text-gray-400 text-center py-4">No expenses yet</p>
        @endforelse
    </div>
    <div class="p-4 border-t border-gray-200 dark:border-gray-700">
        <a href="{{ route('expenses.index') }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 text-sm font-medium">
            View all expenses →
        </a>
    </div>
</div>
@endsection

