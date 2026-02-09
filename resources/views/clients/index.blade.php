@extends('layouts.app')

@section('title', __('app.clients'))
@section('page-title', __('app.clients'))

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
    <!-- Search -->
    <form method="GET" action="{{ route('clients.index') }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 flex-1">
        <input 
            type="text" 
            name="search" 
            placeholder="{{ __('app.search') }}..." 
            value="{{ request('search') }}"
            class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
        <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 whitespace-nowrap">
            {{ __('app.search') }}
        </button>
        @if(request('search'))
            <a href="{{ route('clients.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 whitespace-nowrap text-center">
                {{ __('app.cancel') }}
            </a>
        @endif
    </form>

    <!-- Add Client Button -->
    <a href="{{ route('clients.create') }}" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 whitespace-nowrap text-center">
        + {{ __('app.add_client') }}
    </a>
</div>

<!-- Clients Table (Desktop) -->
<div class="hidden md:block bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('app.name') }}</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('app.email') }}</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('app.company_name') }}</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('app.projects') }}</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('app.pending') }}</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('app.actions') }}</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($clients as $client)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('clients.show', $client) }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 font-medium">
                            {{ $client->name }}
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                        {{ $client->email }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                        {{ $client->company ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                        {{ $client->projects_count }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                        {{ Auth::user()->currency }} {{ number_format($client->outstanding_balance, 2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('clients.edit', $client) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 mr-3">{{ __('app.edit') }}</a>
                        <form action="{{ route('clients.destroy', $client) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('app.confirm_delete') }}');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400">{{ __('app.delete') }}</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                        {{ __('app.no_clients') }}. <a href="{{ route('clients.create') }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700">{{ __('app.add_client') }}</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Clients Cards (Mobile) -->
<div class="md:hidden space-y-4">
    @forelse($clients as $client)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <div class="flex items-start justify-between mb-3">
                <a href="{{ route('clients.show', $client) }}" class="text-lg font-semibold text-primary-600 dark:text-primary-400 hover:text-primary-700">
                    {{ $client->name }}
                </a>
                <div class="flex space-x-2">
                    <a href="{{ route('clients.edit', $client) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 text-sm">{{ __('app.edit') }}</a>
                    <form action="{{ route('clients.destroy', $client) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('app.are_you_sure') }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 text-sm">{{ __('app.delete') }}</button>
                    </form>
                </div>
            </div>
            <div class="space-y-2 text-sm">
                <div class="flex items-center">
                    <span class="text-gray-500 dark:text-gray-400 w-24">{{ __('app.email') }}:</span>
                    <span class="text-gray-900 dark:text-gray-100 flex-1 truncate">{{ $client->email }}</span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-500 dark:text-gray-400 w-24">{{ __('app.company_name') }}:</span>
                    <span class="text-gray-900 dark:text-gray-100 flex-1">{{ $client->company ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-500 dark:text-gray-400 w-24">{{ __('app.projects') }}:</span>
                    <span class="text-gray-900 dark:text-gray-100 flex-1">{{ $client->projects_count }}</span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-500 dark:text-gray-400 w-24">{{ __('app.pending') }}:</span>
                    <span class="text-gray-900 dark:text-gray-100 flex-1 font-semibold">{{ Auth::user()->currency }} {{ number_format($client->outstanding_balance, 2) }}</span>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-8 text-center">
            <p class="text-gray-500 dark:text-gray-400 mb-4">{{ __('app.no_clients') }}.</p>
            <a href="{{ route('clients.create') }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700">{{ __('app.add_client') }}</a>
        </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $clients->links() }}
</div>
@endsection
