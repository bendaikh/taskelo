@extends('layouts.app')

@section('title', 'Users')
@section('page-title', 'Users')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
    <!-- Search -->
    <form method="GET" action="{{ route('users.index') }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 flex-1">
        <input 
            type="text" 
            name="search" 
            placeholder="Search users..." 
            value="{{ request('search') }}"
            class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
        <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 whitespace-nowrap">
            Search
        </button>
        @if(request('search'))
            <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 whitespace-nowrap text-center">
                Clear
            </a>
        @endif
    </form>

    <!-- Add User Button -->
    <a href="{{ route('users.create') }}" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 whitespace-nowrap text-center">
        + Add User
    </a>
</div>

<!-- Users Table (Desktop) -->
<div class="hidden md:block bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Roles</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Created</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($users as $user)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('users.show', $user) }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 font-medium">
                            {{ $user->name }}
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                        {{ $user->email }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                        @if($user->roles->count() > 0)
                            <div class="flex flex-wrap gap-1">
                                @foreach($user->roles as $role)
                                    <span class="px-2 py-1 bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300 rounded text-xs">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <span class="text-gray-400">No roles</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                        {{ $user->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('users.edit', $user) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 mr-3">Edit</a>
                        @if($user->id !== Auth::id())
                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                        No users found. <a href="{{ route('users.create') }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700">Add your first user</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Users Cards (Mobile) -->
<div class="md:hidden space-y-4">
    @forelse($users as $user)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <div class="flex items-start justify-between mb-3">
                <a href="{{ route('users.show', $user) }}" class="text-lg font-semibold text-primary-600 dark:text-primary-400 hover:text-primary-700">
                    {{ $user->name }}
                </a>
                <div class="flex space-x-2">
                    <a href="{{ route('users.edit', $user) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 text-sm">Edit</a>
                    @if($user->id !== Auth::id())
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 text-sm">Delete</button>
                        </form>
                    @endif
                </div>
            </div>
            <div class="space-y-2 text-sm">
                <div class="flex items-center">
                    <span class="text-gray-500 dark:text-gray-400 w-24">Email:</span>
                    <span class="text-gray-900 dark:text-gray-100 flex-1 truncate">{{ $user->email }}</span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-500 dark:text-gray-400 w-24">Roles:</span>
                    <span class="text-gray-900 dark:text-gray-100 flex-1">
                        @if($user->roles->count() > 0)
                            @foreach($user->roles as $role)
                                <span class="px-2 py-1 bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300 rounded text-xs mr-1">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        @else
                            <span class="text-gray-400">No roles</span>
                        @endif
                    </span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-500 dark:text-gray-400 w-24">Created:</span>
                    <span class="text-gray-900 dark:text-gray-100 flex-1">{{ $user->created_at->format('M d, Y') }}</span>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-8 text-center">
            <p class="text-gray-500 dark:text-gray-400 mb-4">No users found.</p>
            <a href="{{ route('users.create') }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700">Add your first user</a>
        </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $users->links() }}
</div>
@endsection
