@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="relative">
    <div class="absolute inset-0 -z-10 bg-gradient-to-br from-indigo-600 via-purple-600 to-fuchsia-500 opacity-20 blur-2xl rounded-3xl"></div>
    <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-xl p-8 border border-white/40">
        <div class="text-center mb-8">
            <div class="mx-auto mb-4 h-12 w-12 rounded-xl bg-indigo-600 text-white flex items-center justify-center shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path d="M12 2a5 5 0 015 5v1h1a4 4 0 110 8h-1v1a5 5 0 11-10 0v-1H6a4 4 0 110-8h1V7a5 5 0 015-5z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Welcome back</h2>
            <p class="text-gray-600 mt-1">Sign in to Business Manager</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email address</label>
                <div class="relative">
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        value="{{ old('email') }}"
                        required 
                        autofocus
                        autocomplete="email"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('email') border-red-500 @enderror">
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M1.5 8.67l1.885-.943A8.25 8.25 0 0112 3.75c3.05 0 5.768 1.6 7.365 3.977l3.135 1.57-3.135 1.57A8.25 8.25 0 0112 16.5a8.25 8.25 0 01-8.615-5.977L1.5 8.67z"/></svg>
                    </div>
                </div>
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                </div>
                <div class="relative">
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        required
                        autocomplete="current-password"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('password') border-red-500 @enderror">
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 00-5.25 5.25V9A2.25 2.25 0 004.5 11.25v6A2.25 2.25 0 006.75 19.5h10.5A2.25 2.25 0 0019.5 17.25v-6A2.25 2.25 0 0017.25 9V6.75A5.25 5.25 0 0012 1.5zm-3 7.5V6.75a3 3 0 116 0V9h-6z" clip-rule="evenodd"/></svg>
                    </div>
                </div>
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            <button type="submit" class="w-full inline-flex justify-center items-center gap-2 bg-indigo-600 text-white py-2.5 px-4 rounded-xl hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M12 4.5c4.142 0 7.5 3.358 7.5 7.5S16.142 19.5 12 19.5 4.5 16.142 4.5 12 7.858 4.5 12 4.5zm0 3.75a.75.75 0 00-.75.75v3.75H7.5a.75.75 0 000 1.5h3.75v3.75a.75.75 0 001.5 0V14.25H16.5a.75.75 0 000-1.5h-3.75V9A.75.75 0 0012 8.25z"/></svg>
                Sign in
            </button>
        </form>
    </div>
</div>
@endsection

