@extends('layouts.app')

@section('title', 'Expenses')
@section('page-title', 'Expenses')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
    <div>
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Expenses</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">Total: {{ Auth::user()->currency }} {{ number_format($total, 2) }}</p>
    </div>
    <a href="{{ route('expenses.create') }}" class="px-4 py-2 bg-primary-600 text-white rounded hover:bg-primary-700 whitespace-nowrap text-center">Add Expense</a>
  </div>

  <!-- Expenses Table (Desktop) -->
  <div class="hidden md:block bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
      <thead class="bg-gray-50 dark:bg-gray-700">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Project</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Category</th>
          <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
          <th class="px-6 py-3"/>
        </tr>
      </thead>
      <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
        @forelse($expenses as $expense)
          <tr>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $expense->date->format('M d, Y') }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $expense->project?->title ?? '-' }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $expense->category ?? '-' }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-red-600 dark:text-red-400">{{ Auth::user()->currency }} {{ number_format($expense->amount, 2) }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
              <form action="{{ route('expenses.destroy', $expense) }}" method="POST" onsubmit="return confirm('Delete this expense?')">
                @csrf
                @method('DELETE')
                <button class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">No expenses yet.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
    <div class="p-4">{{ $expenses->links() }}</div>
  </div>

  <!-- Expenses Cards (Mobile) -->
  <div class="md:hidden space-y-4">
    @forelse($expenses as $expense)
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
        <div class="flex items-start justify-between mb-3">
          <div class="flex-1">
            <div class="flex items-center justify-between mb-2">
              <span class="text-lg font-semibold text-red-600 dark:text-red-400">
                {{ Auth::user()->currency }} {{ number_format($expense->amount, 2) }}
              </span>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">
              {{ $expense->date->format('M d, Y') }}
            </p>
          </div>
          <form action="{{ route('expenses.destroy', $expense) }}" method="POST" onsubmit="return confirm('Delete this expense?')" class="ml-2">
            @csrf
            @method('DELETE')
            <button class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 text-sm">Delete</button>
          </form>
        </div>
        <div class="space-y-1 text-sm border-t border-gray-200 dark:border-gray-700 pt-3">
          <div>
            <span class="text-gray-500 dark:text-gray-400">Category: </span>
            <span class="text-gray-900 dark:text-gray-100">{{ $expense->category ?? '-' }}</span>
          </div>
          @if($expense->project)
            <div>
              <span class="text-gray-500 dark:text-gray-400">Project: </span>
              <span class="text-gray-900 dark:text-gray-100">{{ $expense->project->title }}</span>
            </div>
          @endif
        </div>
      </div>
    @empty
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-8 text-center">
        <p class="text-gray-500 dark:text-gray-400">No expenses yet.</p>
      </div>
    @endforelse
    <div class="p-4">{{ $expenses->links() }}</div>
  </div>
@endsection


