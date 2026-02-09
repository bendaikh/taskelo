@extends('layouts.app')

@section('title', __('app.proposals'))
@section('page-title', __('app.proposals'))

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-start space-y-4 md:space-y-0">
    <!-- Filters -->
    <form method="GET" action="{{ route('proposals.index') }}" class="flex flex-wrap items-center gap-2">
        <input 
            type="text" 
            name="search" 
            placeholder="{{ __('app.search') }}..." 
            value="{{ request('search') }}"
            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
        
        <select 
            name="client_id" 
            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
            <option value="">{{ __('app.all') }} {{ __('app.clients') }}</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                    {{ $client->name }}
                </option>
            @endforeach
        </select>

        <select 
            name="status" 
            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
            <option value="">{{ __('app.all') }} {{ __('app.status') }}</option>
            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>{{ __('app.draft') }}</option>
            <option value="sent" {{ request('status') === 'sent' ? 'selected' : '' }}>{{ __('app.sent') }}</option>
            <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>{{ __('app.accepted') }}</option>
            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>{{ __('app.rejected') }}</option>
        </select>

        <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
            {{ __('app.filter') }}
        </button>
        
        @if(request()->hasAny(['search', 'client_id', 'status']))
            <a href="{{ route('proposals.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500">
                {{ __('app.cancel') }}
            </a>
        @endif
    </form>

    <!-- Add Proposal Button -->
    <a href="{{ route('proposals.create') }}" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 whitespace-nowrap text-center">
        + {{ __('app.add_proposal') }}
    </a>
</div>

<!-- Proposals Table (Desktop) -->
<div class="hidden md:block bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">#</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('app.title') }}</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('app.client') }}</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('app.date') }}</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('app.total') }}</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('app.status') }}</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ __('app.actions') }}</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($proposals as $proposal)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-700 dark:text-gray-300">
                        {{ $proposal->proposal_number }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('proposals.show', $proposal) }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 font-medium">
                            {{ $proposal->title }}
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($proposal->client)
                            <a href="{{ route('clients.show', $proposal->client) }}" class="text-gray-700 dark:text-gray-300 hover:text-primary-600">
                                {{ $proposal->client->name }}
                            </a>
                        @else
                            <span class="text-gray-400 dark:text-gray-500 italic">{{ __('app.no_clients') }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                        {{ $proposal->date->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-gray-100">
                        {{ Auth::user()->currency }} {{ number_format($proposal->total_amount, 2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs rounded-full 
                            @if($proposal->status === 'accepted') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                            @elseif($proposal->status === 'sent') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                            @elseif($proposal->status === 'rejected') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                            @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300
                            @endif">
                            {{ __('app.' . $proposal->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end items-center space-x-2">
                            <a href="{{ route('proposals.view-pdf', $proposal) }}" target="_blank" class="text-blue-600 hover:text-blue-900 dark:text-blue-400" title="{{ __('app.view_pdf') }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                            <a href="{{ route('proposals.pdf', $proposal) }}" class="text-green-600 hover:text-green-900 dark:text-green-400" title="{{ __('app.download_pdf') }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                            </a>
                            <a href="{{ route('proposals.edit', $proposal) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400">{{ __('app.edit') }}</a>
                            <form action="{{ route('proposals.destroy', $proposal) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('app.are_you_sure') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400">{{ __('app.delete') }}</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                        {{ __('app.no_proposals') }}. <a href="{{ route('proposals.create') }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700">{{ __('app.add_proposal') }}</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Proposals Cards (Mobile) -->
<div class="md:hidden space-y-4">
    @forelse($proposals as $proposal)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <div class="flex items-start justify-between mb-3">
                <div class="flex-1 min-w-0">
                    <a href="{{ route('proposals.show', $proposal) }}" class="text-lg font-semibold text-primary-600 dark:text-primary-400 hover:text-primary-700 block mb-2">
                        {{ $proposal->title }}
                    </a>
                    <p class="text-xs font-mono text-gray-500 dark:text-gray-400 mb-1">
                        #{{ $proposal->proposal_number }}
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                        {{ $proposal->date->format('M d, Y') }}
                    </p>
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            {{ Auth::user()->currency }} {{ number_format($proposal->total_amount, 2) }}
                        </span>
                        <span class="px-2 py-1 text-xs rounded-full 
                            @if($proposal->status === 'accepted') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                            @elseif($proposal->status === 'sent') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                            @elseif($proposal->status === 'rejected') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                            @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300
                            @endif">
                            {{ __('app.' . $proposal->status) }}
                        </span>
                    </div>
                </div>
            </div>
            @if($proposal->client)
                <div class="text-sm border-t border-gray-200 dark:border-gray-700 pt-3 mb-3">
                    <span class="text-gray-500 dark:text-gray-400">{{ __('app.client') }}: </span>
                    <a href="{{ route('clients.show', $proposal->client) }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700">
                        {{ $proposal->client->name }}
                    </a>
                </div>
            @endif
            <div class="flex items-center justify-between pt-3 border-t border-gray-200 dark:border-gray-700">
                <div class="flex space-x-3">
                    <a href="{{ route('proposals.view-pdf', $proposal) }}" target="_blank" class="text-blue-600 hover:text-blue-900 dark:text-blue-400" title="{{ __('app.view_pdf') }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </a>
                    <a href="{{ route('proposals.pdf', $proposal) }}" class="text-green-600 hover:text-green-900 dark:text-green-400" title="{{ __('app.download_pdf') }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                    </a>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('proposals.edit', $proposal) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 text-sm">{{ __('app.edit') }}</a>
                    <form action="{{ route('proposals.destroy', $proposal) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('app.are_you_sure') }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 text-sm">{{ __('app.delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-8 text-center">
            <p class="text-gray-500 dark:text-gray-400 mb-4">{{ __('app.no_proposals') }}.</p>
            <a href="{{ route('proposals.create') }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700">{{ __('app.add_proposal') }}</a>
        </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $proposals->links() }}
</div>
@endsection
