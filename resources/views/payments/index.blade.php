@extends('layouts.app')

@section('title', 'Payments')
@section('page-title', 'Payments')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-start space-y-4 md:space-y-0">
    <!-- Filters -->
    <form method="GET" action="{{ route('payments.index') }}" class="flex flex-wrap items-center gap-2">
        <select 
            name="client_id" 
            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
            <option value="">All Clients</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                    {{ $client->name }}
                </option>
            @endforeach
        </select>

        <select 
            name="type" 
            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
            <option value="">All Types</option>
            <option value="advance" {{ request('type') === 'advance' ? 'selected' : '' }}>Advance</option>
            <option value="payment" {{ request('type') === 'payment' ? 'selected' : '' }}>Payment</option>
        </select>

        <input 
            type="date" 
            name="date_from" 
            placeholder="From"
            value="{{ request('date_from') }}"
            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">

        <input 
            type="date" 
            name="date_to" 
            placeholder="To"
            value="{{ request('date_to') }}"
            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">

        <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
            Filter
        </button>
        
        @if(request()->hasAny(['client_id', 'project_id', 'type', 'date_from', 'date_to']))
            <a href="{{ route('payments.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500">
                Clear
            </a>
        @endif
    </form>

    <!-- Actions -->
    <div class="flex space-x-2">
        <a href="{{ route('payments.export.csv') }}?{{ http_build_query(request()->all()) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm">
            Export CSV
        </a>
        <a href="{{ route('payments.export.pdf') }}?{{ http_build_query(request()->all()) }}" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">
            Export PDF
        </a>
        <a href="{{ route('payments.create') }}" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 text-sm">
            + Add Payment
        </a>
    </div>
</div>

<!-- Payments Table -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Client</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Project</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($payments as $payment)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                        {{ $payment->date->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('clients.show', $payment->client) }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 font-medium">
                            {{ $payment->client->name }}
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('projects.show', $payment->project) }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700">
                            {{ $payment->project->title }}
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs rounded-full 
                            @if($payment->type === 'advance') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                            @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                            @endif">
                            {{ ucfirst($payment->type) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">
                        {{ Auth::user()->currency }} {{ number_format($payment->amount, 2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('payments.edit', $payment) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 mr-3">Edit</a>
                        <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                        No payments found. <a href="{{ route('payments.create') }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700">Add your first payment</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
        @if($payments->count() > 0)
            <tfoot class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <td colspan="4" class="px-6 py-4 text-right font-semibold text-gray-800 dark:text-gray-200">Total:</td>
                    <td class="px-6 py-4 font-bold text-green-600">
                        {{ Auth::user()->currency }} {{ number_format($payments->sum('amount'), 2) }}
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        @endif
    </table>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $payments->links() }}
</div>
@endsection

