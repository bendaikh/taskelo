@extends('layouts.app')

@section('title', 'My Business')
@section('page-title', 'My Business')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-center space-y-4 md:space-y-0">
    <!-- Tabs -->
    <div class="flex space-x-2 bg-gray-100 dark:bg-gray-800 p-1 rounded-lg">
        <a 
            href="{{ route('businesses.index', ['type' => 'active']) }}" 
            class="px-4 py-2 rounded-lg transition-colors {{ $type === 'active' ? 'bg-primary-600 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' }}">
            Active Businesses
        </a>
        <a 
            href="{{ route('businesses.index', ['type' => 'idea']) }}" 
            class="px-4 py-2 rounded-lg transition-colors {{ $type === 'idea' ? 'bg-primary-600 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' }}">
            Business Ideas
        </a>
    </div>

    <!-- Add Business Button -->
    <a href="{{ route('businesses.create') }}" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
        + Add {{ $type === 'active' ? 'Business' : 'Idea' }}
    </a>
</div>

<!-- Businesses Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($businesses as $business)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-lg transition-shadow">
            <div class="p-6">
                <!-- Header -->
                <div class="flex items-start justify-between mb-4">
                    <a href="{{ route('businesses.show', $business) }}" class="text-lg font-semibold text-gray-800 dark:text-gray-200 hover:text-primary-600">
                        {{ $business->name }}
                    </a>
                    <span class="px-2 py-1 text-xs rounded-full whitespace-nowrap
                        @if($business->type === 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                        @else bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                        @endif">
                        {{ $business->type === 'active' ? 'Active' : 'Idea' }}
                    </span>
                </div>

                <!-- Description -->
                @if($business->description)
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">
                        {{ $business->description }}
                    </p>
                @endif

                <!-- Stats -->
                <div class="space-y-2 mb-4 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Nodes:</span>
                        <span class="text-gray-900 dark:text-gray-100 font-medium">{{ $business->flowNodes->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Connections:</span>
                        <span class="text-gray-900 dark:text-gray-100 font-medium">{{ $business->flowEdges->count() }}</span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-between items-center pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('businesses.show', $business) }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 text-sm font-medium">
                        Open Flow →
                    </a>
                    <div class="flex space-x-2">
                        <a href="{{ route('businesses.edit', $business) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 text-sm">Edit</a>
                        <form action="{{ route('businesses.destroy', $business) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 text-sm">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-12 bg-white dark:bg-gray-800 rounded-lg shadow">
            <p class="text-gray-500 dark:text-gray-400 mb-4">No {{ $type === 'active' ? 'businesses' : 'ideas' }} found.</p>
            <a href="{{ route('businesses.create') }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 font-medium">
                Add your first {{ $type === 'active' ? 'business' : 'idea' }}
            </a>
        </div>
    @endforelse
</div>
@endsection

