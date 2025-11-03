@extends('layouts.app')

@section('title', 'Add Expense')
@section('page-title', 'Add Expense')

@section('content')
<div class="max-w-2xl">
  <form action="{{ route('expenses.store') }}" method="POST" class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 space-y-4">
    @csrf

    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date</label>
      <input type="date" name="date" value="{{ old('date', now()->toDateString()) }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" required />
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Project (optional)</label>
      <select name="project_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
        <option value="">-- None --</option>
        @foreach($projects as $project)
          <option value="{{ $project->id }}" {{ (string) old('project_id', request('project_id')) === (string) $project->id ? 'selected' : '' }}>{{ $project->title }}</option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <select name="expense_category_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
          <option value="">-- Select Category --</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ (string) old('expense_category_id') === (string) $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
          @endforeach
        </select>
        <input type="text" name="category" value="{{ old('category') }}" placeholder="Or enter custom category" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" />
      </div>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Amount</label>
      <input type="number" step="0.01" min="0" name="amount" value="{{ old('amount') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" required />
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notes</label>
      <textarea name="notes" rows="3" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" placeholder="Details (optional)">{{ old('notes') }}</textarea>
    </div>

    <div class="flex items-center justify-end gap-3">
      <a href="{{ route('expenses.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded">Cancel</a>
      <button class="px-4 py-2 bg-primary-600 text-white rounded hover:bg-primary-700">Save Expense</button>
    </div>
  </form>
</div>
@endsection


