@extends('layouts.app')

@section('title', 'User Details')
@section('page-title', 'User Details')

@section('content')
<div class="max-w-4xl">
    <!-- User Info Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
            <div class="flex items-center">
                <div class="w-16 h-16 rounded-full bg-primary-600 flex items-center justify-center text-white text-2xl font-bold flex-shrink-0">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div class="ml-4">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $user->name }}</h2>
                    <p class="text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                </div>
            </div>
            <div class="flex gap-2 mt-4 sm:mt-0">
                <a href="{{ route('users.edit', $user) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Edit
                </a>
                @if($user->id !== Auth::id())
                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            Delete
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Created</span>
                <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $user->created_at->format('M d, Y \a\t H:i') }}</p>
            </div>
            <div>
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</span>
                <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $user->updated_at->format('M d, Y \a\t H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- User Roles -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Assigned Roles ({{ $user->roles->count() }})</h3>
        
        @if($user->roles->count() > 0)
            <div class="flex flex-wrap gap-2">
                @foreach($user->roles as $role)
                    <a href="{{ route('roles.show', $role) }}" class="px-4 py-2 bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300 rounded-lg hover:bg-primary-200 dark:hover:bg-primary-800 transition-colors">
                        {{ $role->name }}
                    </a>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 dark:text-gray-400">No roles have been assigned to this user.</p>
        @endif
    </div>

    <!-- Back Button -->
    <div class="mt-6">
        <a href="{{ route('users.index') }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700">
            &larr; Back to Users
        </a>
    </div>
</div>
@endsection
