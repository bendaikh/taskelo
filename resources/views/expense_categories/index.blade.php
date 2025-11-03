@extends('layouts.app')

@section('title', 'Expense Categories')
@section('page-title', 'Expense Categories')

@section('content')
<div class="mb-6 flex items-center justify-between">
  <div>
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Expense Categories</h2>
    <p class="text-sm text-gray-500 dark:text-gray-400">Total: {{ $totalCategories }}</p>
  </div>
  <a href="{{ route('expense-categories.create') }}" class="px-4 py-2 bg-primary-600 text-white rounded hover:bg-primary-700">Add Category</a>
  </div>

  <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
      <thead class="bg-gray-50 dark:bg-gray-700">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
          <th class="px-6 py-3"/>
        </tr>
      </thead>
      <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
        @forelse($categories as $category)
          <tr>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $category->name }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $category->description }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
              <form action="{{ route('expense-categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete this category?')">
                @csrf
                @method('DELETE')
                <button class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="3" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">No categories yet.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
    <div class="p-4">{{ $categories->links() }}</div>
  </div>
@endsection


