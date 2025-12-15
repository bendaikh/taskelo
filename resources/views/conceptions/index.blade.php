@extends('layouts.app')

@section('title', 'Conceptions')
@section('page-title', 'Conceptions')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
    <!-- Filters & Search -->
    <form method="GET" action="{{ route('conceptions.index') }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 flex-1">
        <!-- Search -->
        <input 
            type="text" 
            name="search" 
            placeholder="Search conceptions..." 
            value="{{ request('search') }}"
            class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
        
        <!-- Status Filter -->
        <select name="status" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
            <option value="">All Status</option>
            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
            <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Sent</option>
            <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
        
        <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 whitespace-nowrap">
            Filter
        </button>
        @if(request('search') || request('status'))
            <a href="{{ route('conceptions.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 whitespace-nowrap text-center">
                Clear
            </a>
        @endif
    </form>

    <!-- Add Conception Button -->
    <a href="{{ route('conceptions.create') }}" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 whitespace-nowrap text-center">
        + New Conception
    </a>
</div>

<!-- Conceptions Table (Desktop) -->
<div class="hidden md:block bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Title</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Client</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Sections</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total Price</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($conceptions as $conception)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-4">
                        <a href="{{ route('conceptions.show', $conception) }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 font-medium">
                            {{ $conception->title }}
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                        {{ $conception->client?->name ?? 'No client' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                        {{ $conception->date->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                        {{ count($conception->sections) }} section(s)
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-gray-100">
                        {{ Auth::user()->currency }} {{ number_format($conception->total_price, 2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $statusColors = [
                                'draft' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                'sent' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                'accepted' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                            ];
                        @endphp
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$conception->status] }}">
                            {{ ucfirst($conception->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <a href="{{ route('conceptions.show', $conception) }}" class="text-green-600 hover:text-green-900 dark:text-green-400">View</a>
                        <select onchange="if(this.value) window.location.href=this.value" class="text-purple-600 dark:text-purple-400 bg-transparent border-none cursor-pointer text-sm font-medium focus:outline-none focus:ring-0">
                            <option value="">PDF ▾</option>
                            <option value="{{ route('conceptions.pdf', [$conception, 'en']) }}">🇬🇧 English</option>
                            <option value="{{ route('conceptions.pdf', [$conception, 'fr']) }}">🇫🇷 Français</option>
                        </select>
                        <a href="{{ route('conceptions.edit', $conception) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400">Edit</a>
                        <form action="{{ route('conceptions.destroy', $conception) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this conception?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                        No conceptions found. <a href="{{ route('conceptions.create') }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700">Create your first conception</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Conceptions Cards (Mobile) -->
<div class="md:hidden space-y-4">
    @forelse($conceptions as $conception)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <div class="flex items-start justify-between mb-3">
                <div class="flex-1">
                    <a href="{{ route('conceptions.show', $conception) }}" class="text-lg font-semibold text-primary-600 dark:text-primary-400 hover:text-primary-700 block mb-1">
                        {{ $conception->title }}
                    </a>
                    @php
                        $statusColors = [
                            'draft' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                            'sent' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                            'accepted' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                            'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                        ];
                    @endphp
                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$conception->status] }}">
                        {{ ucfirst($conception->status) }}
                    </span>
                </div>
            </div>
            <div class="space-y-2 text-sm mb-3">
                <div class="flex items-center justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Client:</span>
                    <span class="text-gray-900 dark:text-gray-100">{{ $conception->client?->name ?? 'No client' }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Date:</span>
                    <span class="text-gray-900 dark:text-gray-100">{{ $conception->date->format('M d, Y') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Sections:</span>
                    <span class="text-gray-900 dark:text-gray-100">{{ count($conception->sections) }} section(s)</span>
                </div>
                <div class="flex items-center justify-between pt-2 border-t border-gray-200 dark:border-gray-700">
                    <span class="text-gray-500 dark:text-gray-400">Total:</span>
                    <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        {{ Auth::user()->currency }} {{ number_format($conception->total_price, 2) }}
                    </span>
                </div>
            </div>
            <div class="flex flex-wrap gap-2 text-sm items-center">
                <a href="{{ route('conceptions.show', $conception) }}" class="text-green-600 hover:text-green-900 dark:text-green-400">View</a>
                <select onchange="if(this.value) window.location.href=this.value" class="text-purple-600 dark:text-purple-400 bg-transparent border-none cursor-pointer text-sm font-medium focus:outline-none focus:ring-0">
                    <option value="">PDF ▾</option>
                    <option value="{{ route('conceptions.pdf', [$conception, 'en']) }}">🇬🇧 English</option>
                    <option value="{{ route('conceptions.pdf', [$conception, 'fr']) }}">🇫🇷 Français</option>
                </select>
                <a href="{{ route('conceptions.edit', $conception) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400">Edit</a>
                <form action="{{ route('conceptions.destroy', $conception) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400">Delete</button>
                </form>
            </div>
        </div>
    @empty
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-8 text-center">
            <p class="text-gray-500 dark:text-gray-400 mb-4">No conceptions found.</p>
            <a href="{{ route('conceptions.create') }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700">Create your first conception</a>
        </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $conceptions->links() }}
</div>

@endsection
