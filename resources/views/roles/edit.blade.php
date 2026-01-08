@extends('layouts.app')

@section('title', 'Edit Role')
@section('page-title', 'Edit Role')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <form method="POST" action="{{ route('roles.update', $role) }}">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Name *</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    value="{{ old('name', $role->name) }}"
                    required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                <textarea 
                    name="description" 
                    id="description" 
                    rows="4"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">{{ old('description', $role->description) }}</textarea>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row justify-end gap-3">
                <a href="{{ route('roles.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 text-center">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                    Update Role
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
