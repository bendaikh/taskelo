@extends('layouts.app')

@section('title', 'Add Expense Category')
@section('page-title', 'Add Expense Category')

@section('content')
<div class="max-w-xl">
  <form action="{{ route('expense-categories.store') }}" method="POST" class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 space-y-4">
    @csrf
    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name</label>
      <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" required />
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
      <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" placeholder="Optional">{{ old('description') }}</textarea>
    </div>
    <div>
      <label class="flex items-center">
        <input type="checkbox" name="is_salary" value="1" {{ old('is_salary') ? 'checked' : '' }} class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">This is a salary category</span>
      </label>
      <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">When adding expenses with this category, you'll be able to select the employee receiving the salary.</p>
    </div>
    <div class="flex items-center justify-end gap-3">
      <a href="{{ route('expense-categories.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded">Cancel</a>
      <button class="px-4 py-2 bg-primary-600 text-white rounded hover:bg-primary-700">Save Category</button>
    </div>
  </form>
</div>
@endsection


