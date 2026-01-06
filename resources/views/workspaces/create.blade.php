@extends('layouts.app')

@section('title', 'Create Workspace')
@section('page-title', 'Create Workspace')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Create New Workspace</h2>

        <form method="POST" action="{{ route('workspaces.store') }}">
            @csrf

            <!-- Workspace Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Workspace Name *
                </label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    value="{{ old('name') }}"
                    required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                    placeholder="e.g., My Personal Projects, Company Workspace">
                @error('name')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Workspace Type -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                    Workspace Type *
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Personal Option -->
                    <div class="relative">
                        <input 
                            type="radio" 
                            name="type" 
                            id="type_personal" 
                            value="personal" 
                            {{ old('type', 'personal') === 'personal' ? 'checked' : '' }}
                            class="peer sr-only">
                        <label 
                            for="type_personal" 
                            class="flex flex-col items-center p-6 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-600 peer-checked:border-blue-500 peer-checked:ring-2 peer-checked:ring-blue-500 transition-all">
                            <svg class="w-12 h-12 text-blue-600 dark:text-blue-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="text-lg font-semibold text-gray-900 dark:text-white">Personal</span>
                            <span class="text-sm text-gray-600 dark:text-gray-400 text-center mt-2">
                                For individual projects and personal work
                            </span>
                        </label>
                    </div>

                    <!-- Business Option -->
                    <div class="relative">
                        <input 
                            type="radio" 
                            name="type" 
                            id="type_business" 
                            value="business" 
                            {{ old('type') === 'business' ? 'checked' : '' }}
                            class="peer sr-only">
                        <label 
                            for="type_business" 
                            class="flex flex-col items-center p-6 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-600 peer-checked:border-purple-500 peer-checked:ring-2 peer-checked:ring-purple-500 transition-all">
                            <svg class="w-12 h-12 text-purple-600 dark:text-purple-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span class="text-lg font-semibold text-gray-900 dark:text-white">Business</span>
                            <span class="text-sm text-gray-600 dark:text-gray-400 text-center mt-2">
                                For company projects and team collaboration
                            </span>
                        </label>
                    </div>
                </div>
                @error('type')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Description (Optional)
                </label>
                <textarea 
                    name="description" 
                    id="description" 
                    rows="4"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                    placeholder="Brief description of what this workspace is for...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex items-center space-x-4">
                <button 
                    type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    Create Workspace
                </button>
                <a 
                    href="{{ route('workspaces.index') }}" 
                    class="px-6 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors font-medium">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

