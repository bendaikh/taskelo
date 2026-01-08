@extends('layouts.app')

@section('title', 'Add Expense')
@section('page-title', 'Add Expense')

@section('content')
<div class="max-w-2xl" x-data="expenseForm()">
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
        <select name="expense_category_id" x-model="selectedCategory" @change="checkSalaryCategory()" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
          <option value="">-- Select Category --</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}" data-is-salary="{{ $cat->is_salary ? '1' : '0' }}" {{ (string) old('expense_category_id') === (string) $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
          @endforeach
        </select>
        <input type="text" name="category" value="{{ old('category') }}" placeholder="Or enter custom category" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" />
      </div>
    </div>

    <!-- User Selection (for salary expenses) -->
    <div x-show="isSalaryCategory" x-transition class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
      <label class="block text-sm font-medium text-blue-700 dark:text-blue-300 mb-1">
        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
        </svg>
        Employee (Salary Recipient) *
      </label>
      <select name="user_id" class="w-full px-4 py-2 border border-blue-300 dark:border-blue-700 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500" :required="isSalaryCategory">
        <option value="">-- Select Employee --</option>
        @foreach($users as $user)
          <option value="{{ $user->id }}" {{ (string) old('user_id') === (string) $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
        @endforeach
      </select>
      <p class="mt-1 text-xs text-blue-600 dark:text-blue-400">Select the employee who will receive this salary payment.</p>
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

<script>
function expenseForm() {
    return {
        selectedCategory: '{{ old('expense_category_id', '') }}',
        isSalaryCategory: false,
        categories: @json($categories->keyBy('id')),
        
        init() {
            this.checkSalaryCategory();
        },
        
        checkSalaryCategory() {
            if (this.selectedCategory && this.categories[this.selectedCategory]) {
                this.isSalaryCategory = this.categories[this.selectedCategory].is_salary == true;
            } else {
                this.isSalaryCategory = false;
            }
        }
    }
}
</script>
@endsection
