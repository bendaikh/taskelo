@extends('layouts.app')

@section('title', 'Revenue')
@section('page-title', 'Revenue')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
    <div>
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Revenue</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">Total: {{ Auth::user()->currency }} {{ number_format($total, 2) }}</p>
    </div>
    <a href="{{ route('revenues.create') }}" class="px-4 py-2 bg-primary-600 text-white rounded hover:bg-primary-700 whitespace-nowrap text-center">Add Revenue</a>
  </div>

  <!-- Revenue Table (Desktop) -->
  <div class="hidden md:block bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
      <thead class="bg-gray-50 dark:bg-gray-700">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Category</th>
          <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
          <th class="px-6 py-3"/>
        </tr>
      </thead>
      <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
        @forelse($revenues as $revenue)
          <tr>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $revenue->date->format('M d, Y') }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $revenue->category ?? '-' }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-green-600 dark:text-green-400">{{ Auth::user()->currency }} {{ number_format($revenue->amount, 2) }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
              <form action="{{ route('revenues.destroy', $revenue) }}" method="POST" onsubmit="return confirm('Delete this revenue?')">
                @csrf
                @method('DELETE')
                <button class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">No revenue yet.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
    <div class="p-4">{{ $revenues->links() }}</div>
  </div>

  <!-- Revenue Cards (Mobile) -->
  <div class="md:hidden space-y-4">
    @forelse($revenues as $revenue)
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
        <div class="flex items-start justify-between mb-3">
          <div class="flex-1">
            <div class="flex items-center justify-between mb-2">
              <span class="text-lg font-semibold text-green-600 dark:text-green-400">
                {{ Auth::user()->currency }} {{ number_format($revenue->amount, 2) }}
              </span>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">
              {{ $revenue->date->format('M d, Y') }}
            </p>
          </div>
          <form action="{{ route('revenues.destroy', $revenue) }}" method="POST" onsubmit="return confirm('Delete this revenue?')" class="ml-2">
            @csrf
            @method('DELETE')
            <button class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 text-sm">Delete</button>
          </form>
        </div>
        <div class="space-y-1 text-sm border-t border-gray-200 dark:border-gray-700 pt-3">
          <div>
            <span class="text-gray-500 dark:text-gray-400">Category: </span>
            <span class="text-gray-900 dark:text-gray-100">{{ $revenue->category ?? '-' }}</span>
          </div>
          @if($revenue->notes)
            <div>
              <span class="text-gray-500 dark:text-gray-400">Notes: </span>
              <span class="text-gray-900 dark:text-gray-100">{{ $revenue->notes }}</span>
            </div>
          @endif
        </div>
      </div>
    @empty
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-8 text-center">
        <p class="text-gray-500 dark:text-gray-400">No revenue yet.</p>
      </div>
    @endforelse
    <div class="p-4">{{ $revenues->links() }}</div>
  </div>
@endsection

