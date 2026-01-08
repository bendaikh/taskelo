@extends('layouts.app')

@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <form method="POST" action="{{ route('users.update', $user) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Name *</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        value="{{ old('name', $user->name) }}"
                        required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email *</label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        value="{{ old('email', $user->email) }}"
                        required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        placeholder="Leave blank to keep current"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Confirmation -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confirm Password</label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        id="password_confirmation" 
                        placeholder="Leave blank to keep current"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
                </div>
            </div>

            <!-- Roles -->
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Roles</label>
                <div class="space-y-2">
                    @forelse($roles as $role)
                        <label class="flex items-center">
                            <input 
                                type="checkbox" 
                                name="roles[]" 
                                value="{{ $role->id }}"
                                {{ in_array($role->id, old('roles', $user->roles->pluck('id')->toArray())) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $role->name }}</span>
                        </label>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-gray-400">No roles available. <a href="{{ route('roles.create') }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700">Create a role first</a></p>
                    @endforelse
                </div>
                @error('roles')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="mt-6 flex flex-col sm:flex-row justify-end gap-3">
                <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 text-center">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                    Update User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
