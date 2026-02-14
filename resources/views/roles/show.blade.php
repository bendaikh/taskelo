@extends('layouts.app')

@section('title', 'Role Details')
@section('page-title', 'Role Details')

@section('content')
<div class="max-w-4xl">
    <!-- Role Info Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $role->name }}</h2>
            <div class="flex gap-2 mt-4 sm:mt-0">
                <a href="{{ route('roles.edit', $role) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Edit
                </a>
                <form action="{{ route('roles.destroy', $role) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this role?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="space-y-4">
            <div>
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</span>
                <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $role->description ?? 'No description provided.' }}</p>
            </div>
            <div>
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Created</span>
                <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $role->created_at->format('M d, Y \a\t H:i') }}</p>
            </div>
            <div>
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Permissions</span>
                @if($role->permissions && count($role->permissions) > 0)
                    <div class="mt-2 flex flex-wrap gap-2">
                        @foreach($role->permissions as $permission)
                            <span class="px-3 py-1 bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300 rounded-full text-xs font-medium">
                                {{ str_replace('.', ' → ', ucwords(str_replace('.', ' ', $permission))) }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <p class="mt-1 text-gray-500 dark:text-gray-400 italic">No permissions assigned.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Users with this role -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Users with this Role ({{ $role->users->count() }})</h3>
        
        @if($role->users->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($role->users as $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <a href="{{ route('users.show', $user) }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 font-medium">
                                        {{ $user->name }}
                                    </a>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                    {{ $user->email }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('users.edit', $user) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 dark:text-gray-400">No users have been assigned this role yet.</p>
        @endif
    </div>

    <!-- Back Button -->
    <div class="mt-6">
        <a href="{{ route('roles.index') }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700">
            &larr; Back to Roles
        </a>
    </div>
</div>
@endsection
