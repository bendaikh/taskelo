@extends('layouts.app')

@section('title', $business->name)
@section('page-title', $business->name)

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-center space-y-4 md:space-y-0">
    <div class="flex items-center space-x-4">
        <a href="{{ route('businesses.index', ['type' => $business->type]) }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">
            ← Back to {{ $business->type === 'active' ? 'Active Businesses' : 'Business Ideas' }}
        </a>
        <span class="px-3 py-1 text-sm rounded-full
            @if($business->type === 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
            @else bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
            @endif">
            {{ $business->type === 'active' ? 'Active Business' : 'Business Idea' }}
        </span>
    </div>

    <div class="flex items-center space-x-2">
        <a href="{{ route('businesses.edit', $business) }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600">
            Edit Business
        </a>
    </div>
</div>

@if($business->description)
    <div class="mb-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
        <p class="text-gray-700 dark:text-gray-300">{{ $business->description }}</p>
    </div>
@endif

<!-- Flow Builder -->
<flow-builder 
    :business-id="{{ $business->id }}"
    :initial-nodes='@json($business->flowNodes)'
    :initial-edges='@json($business->flowEdges)'>
</flow-builder>
@endsection

