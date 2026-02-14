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

            <!-- Permissions -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Permissions</label>
                <div class="space-y-4 bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
                    
                    @php
                        $rolePermissions = old('permissions', $role->permissions ?? []);
                    @endphp

                    <!-- Dashboard -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                        <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Dashboard</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="dashboard.view" class="mr-2 rounded" {{ in_array('dashboard.view', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">View Dashboard</span>
                            </label>
                        </div>
                    </div>

                    <!-- Projects -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                        <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Projects</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="projects.view" class="mr-2 rounded" {{ in_array('projects.view', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">View Projects</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="projects.create" class="mr-2 rounded" {{ in_array('projects.create', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Create Projects</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="projects.edit" class="mr-2 rounded" {{ in_array('projects.edit', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Edit Projects</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="projects.delete" class="mr-2 rounded" {{ in_array('projects.delete', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Delete Projects</span>
                            </label>
                        </div>
                    </div>

                    <!-- My Business -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                        <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">My Business</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="businesses.view" class="mr-2 rounded" {{ in_array('businesses.view', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">View My Business</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="businesses.create" class="mr-2 rounded" {{ in_array('businesses.create', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Create Business</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="businesses.edit" class="mr-2 rounded" {{ in_array('businesses.edit', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Edit Business</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="businesses.delete" class="mr-2 rounded" {{ in_array('businesses.delete', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Delete Business</span>
                            </label>
                        </div>
                    </div>

                    <!-- Clients -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                        <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Clients</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="clients.view" class="mr-2 rounded" {{ in_array('clients.view', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">View Clients</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="clients.create" class="mr-2 rounded" {{ in_array('clients.create', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Create Clients</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="clients.edit" class="mr-2 rounded" {{ in_array('clients.edit', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Edit Clients</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="clients.delete" class="mr-2 rounded" {{ in_array('clients.delete', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Delete Clients</span>
                            </label>
                        </div>
                    </div>

                    <!-- Payments -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                        <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Payments</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="payments.view" class="mr-2 rounded" {{ in_array('payments.view', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">View Payments</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="payments.create" class="mr-2 rounded" {{ in_array('payments.create', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Create Payments</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="payments.edit" class="mr-2 rounded" {{ in_array('payments.edit', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Edit Payments</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="payments.delete" class="mr-2 rounded" {{ in_array('payments.delete', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Delete Payments</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="payments.export" class="mr-2 rounded" {{ in_array('payments.export', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Export Payments</span>
                            </label>
                        </div>
                    </div>

                    <!-- Proposals -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                        <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Proposals</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="proposals.view" class="mr-2 rounded" {{ in_array('proposals.view', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">View Proposals</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="proposals.create" class="mr-2 rounded" {{ in_array('proposals.create', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Create Proposals</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="proposals.edit" class="mr-2 rounded" {{ in_array('proposals.edit', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Edit Proposals</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="proposals.delete" class="mr-2 rounded" {{ in_array('proposals.delete', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Delete Proposals</span>
                            </label>
                        </div>
                    </div>

                    <!-- Conceptions -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                        <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Conceptions</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="conceptions.view" class="mr-2 rounded" {{ in_array('conceptions.view', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">View Conceptions</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="conceptions.create" class="mr-2 rounded" {{ in_array('conceptions.create', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Create Conceptions</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="conceptions.edit" class="mr-2 rounded" {{ in_array('conceptions.edit', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Edit Conceptions</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="conceptions.delete" class="mr-2 rounded" {{ in_array('conceptions.delete', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Delete Conceptions</span>
                            </label>
                        </div>
                    </div>

                    <!-- Revenue -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                        <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Revenue</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="revenue.view" class="mr-2 rounded" {{ in_array('revenue.view', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">View Revenue</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="revenue.create" class="mr-2 rounded" {{ in_array('revenue.create', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Create Revenue</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="revenue.delete" class="mr-2 rounded" {{ in_array('revenue.delete', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Delete Revenue</span>
                            </label>
                        </div>
                    </div>

                    <!-- Expenses -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                        <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Expenses</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="expenses.view" class="mr-2 rounded" {{ in_array('expenses.view', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">View Expenses</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="expenses.create" class="mr-2 rounded" {{ in_array('expenses.create', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Create Expenses</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="expenses.delete" class="mr-2 rounded" {{ in_array('expenses.delete', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Delete Expenses</span>
                            </label>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                        <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Categories</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="categories.view" class="mr-2 rounded" {{ in_array('categories.view', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">View Categories</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="categories.create" class="mr-2 rounded" {{ in_array('categories.create', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Create Categories</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="categories.delete" class="mr-2 rounded" {{ in_array('categories.delete', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Delete Categories</span>
                            </label>
                        </div>
                    </div>

                    <!-- Daily Tasks -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                        <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Daily Tasks</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="tasks.view" class="mr-2 rounded" {{ in_array('tasks.view', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">View Tasks</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="tasks.create" class="mr-2 rounded" {{ in_array('tasks.create', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Create Tasks</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="tasks.edit" class="mr-2 rounded" {{ in_array('tasks.edit', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Edit Tasks</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="tasks.delete" class="mr-2 rounded" {{ in_array('tasks.delete', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Delete Tasks</span>
                            </label>
                        </div>
                    </div>

                    <!-- Analytics -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                        <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Analytics</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="analytics.view" class="mr-2 rounded" {{ in_array('analytics.view', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">View Analytics</span>
                            </label>
                        </div>
                    </div>

                    <!-- User Management -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                        <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">User Management</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="users.view" class="mr-2 rounded" {{ in_array('users.view', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">View Users</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="users.create" class="mr-2 rounded" {{ in_array('users.create', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Create Users</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="users.edit" class="mr-2 rounded" {{ in_array('users.edit', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Edit Users</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="users.delete" class="mr-2 rounded" {{ in_array('users.delete', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Delete Users</span>
                            </label>
                        </div>
                    </div>

                    <!-- Roles -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                        <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Roles</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="roles.view" class="mr-2 rounded" {{ in_array('roles.view', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">View Roles</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="roles.create" class="mr-2 rounded" {{ in_array('roles.create', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Create Roles</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="roles.edit" class="mr-2 rounded" {{ in_array('roles.edit', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Edit Roles</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="roles.delete" class="mr-2 rounded" {{ in_array('roles.delete', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Delete Roles</span>
                            </label>
                        </div>
                    </div>

                    <!-- Workspaces -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                        <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Workspaces</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="workspaces.view" class="mr-2 rounded" {{ in_array('workspaces.view', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">View Workspaces</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="workspaces.create" class="mr-2 rounded" {{ in_array('workspaces.create', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Create Workspaces</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="workspaces.edit" class="mr-2 rounded" {{ in_array('workspaces.edit', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Edit Workspaces</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="workspaces.delete" class="mr-2 rounded" {{ in_array('workspaces.delete', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Delete Workspaces</span>
                            </label>
                        </div>
                    </div>

                    <!-- Settings -->
                    <div>
                        <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">Settings</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="settings.view" class="mr-2 rounded" {{ in_array('settings.view', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">View Settings</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="settings.edit" class="mr-2 rounded" {{ in_array('settings.edit', $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Edit Settings</span>
                            </label>
                        </div>
                    </div>

                </div>
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
