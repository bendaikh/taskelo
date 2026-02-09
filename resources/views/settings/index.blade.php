@extends('layouts.app')

@section('title', __('app.settings'))
@section('page-title', __('app.settings'))

@section('content')
<div class="max-w-4xl">
    <!-- Profile Settings -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">{{ __('app.profile_settings') }}</h3>
        <form method="POST" action="{{ route('settings.profile') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('app.name') }} *</label>
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
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('app.email') }} *</label>
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

                <!-- Company Name -->
                <div>
                    <label for="company_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('app.company_name') }}</label>
                    <input
                        type="text"
                        name="company_name"
                        id="company_name"
                        value="{{ old('company_name', $user->company_name) }}"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 @error('company_name') border-red-500 @enderror">
                    @error('company_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Company Website -->
                <div>
                    <label for="company_website" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('app.company_website') }}</label>
                    <input
                        type="url"
                        name="company_website"
                        id="company_website"
                        placeholder="https://example.com"
                        value="{{ old('company_website', $user->company_website) }}"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 @error('company_website') border-red-500 @enderror">
                    @error('company_website')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Logo -->
            <div class="mt-6">
                <label for="logo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('app.logo') }}</label>
                @if($user->logo)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $user->logo) }}" alt="Logo" class="h-20 w-20 object-cover rounded">
                    </div>
                @endif
                <input 
                    type="file" 
                    name="logo" 
                    id="logo" 
                    accept="image/*"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ __('app.max_size') }}</p>
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                    {{ __('app.update_profile') }}
                </button>
            </div>
        </form>
    </div>

    <!-- Password Settings -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">{{ __('app.change_password') }}</h3>
        <form method="POST" action="{{ route('settings.password') }}">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <!-- Current Password -->
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('app.current_password') }} *</label>
                    <input 
                        type="password" 
                        name="current_password" 
                        id="current_password" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 @error('current_password') border-red-500 @enderror">
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('app.new_password') }} *</label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('app.confirm_new_password') }} *</label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        id="password_confirmation" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                    {{ __('app.update_password') }}
                </button>
            </div>
        </form>
    </div>

    <!-- Preferences Settings -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">{{ __('app.preferences') }}</h3>
        <form method="POST" action="{{ route('settings.preferences') }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Currency -->
                <div>
                    <label for="currency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('app.currency') }} *</label>
                    <select 
                        name="currency" 
                        id="currency" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
                        <option value="USD" {{ $user->currency === 'USD' ? 'selected' : '' }}>USD ($)</option>
                        <option value="EUR" {{ $user->currency === 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                        <option value="GBP" {{ $user->currency === 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                        <option value="JPY" {{ $user->currency === 'JPY' ? 'selected' : '' }}>JPY (¥)</option>
                        <option value="INR" {{ $user->currency === 'INR' ? 'selected' : '' }}>INR (₹)</option>
                        <option value="AUD" {{ $user->currency === 'AUD' ? 'selected' : '' }}>AUD (A$)</option>
                        <option value="CAD" {{ $user->currency === 'CAD' ? 'selected' : '' }}>CAD (C$)</option>
                        <option value="MAD" {{ $user->currency === 'MAD' ? 'selected' : '' }}>MAD (Dhs)</option>
                        <option value="PHP" {{ $user->currency === 'PHP' ? 'selected' : '' }}>PHP (₱)</option>
                        <option value="NGN" {{ $user->currency === 'NGN' ? 'selected' : '' }}>NGN (₦)</option>
                        <option value="PKR" {{ $user->currency === 'PKR' ? 'selected' : '' }}>PKR (₨)</option>
                        <option value="BDT" {{ $user->currency === 'BDT' ? 'selected' : '' }}>BDT (৳)</option>
                        <option value="XOF" {{ $user->currency === 'XOF' ? 'selected' : '' }}>CFA (FCFA)</option>
                        <option value="XAF" {{ $user->currency === 'XAF' ? 'selected' : '' }}>CFA Central (FCFA)</option>
                    </select>
                </div>

                <!-- Theme -->
                <div>
                    <label for="theme" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('app.theme') }} *</label>
                    <select 
                        name="theme" 
                        id="theme" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
                        <option value="light" {{ $user->theme === 'light' ? 'selected' : '' }}>{{ __('app.light') }}</option>
                        <option value="dark" {{ $user->theme === 'dark' ? 'selected' : '' }}>{{ __('app.dark') }}</option>
                    </select>
                </div>

                <!-- Language -->
                <div>
                    <label for="language" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('app.language') }} *</label>
                    <select 
                        name="language" 
                        id="language" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
                        <option value="en" {{ ($user->language ?? 'en') === 'en' ? 'selected' : '' }}>{{ __('app.english') }}</option>
                        <option value="fr" {{ ($user->language ?? 'en') === 'fr' ? 'selected' : '' }}>{{ __('app.french') }}</option>
                    </select>
                </div>

                <!-- App Name -->
                <div>
                    <label for="app_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('app.app_name') }}</label>
                    <input 
                        type="text" 
                        name="app_name" 
                        id="app_name" 
                        value="{{ old('app_name', $user->app_name) }}"
                        placeholder="{{ __('app.business_manager') }}"
                        maxlength="50"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 @error('app_name') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ __('app.app_name_help') }}</p>
                    @error('app_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                    {{ __('app.update_preferences') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

