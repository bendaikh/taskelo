<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Client Portal')</title>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-8 w-8 rounded-lg bg-blue-600 text-white flex items-center justify-center font-bold">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                    <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h1 class="text-lg font-semibold text-gray-900">Client Portal</h1>
                        </div>
                    </div>
                    
                    <div class="hidden md:flex items-center space-x-4">
                        <a href="{{ route('client.dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('client.dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('client.projects') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('client.projects') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                            Projects
                        </a>
                        <a href="{{ route('client.payments') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('client.payments') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                            Payments
                        </a>
                        <a href="{{ route('client.tasks') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('client.tasks') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                            Tasks
                        </a>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="hidden md:block text-sm text-gray-700">
                            <span class="font-medium">{{ Auth::guard('client')->user()->name }}</span>
                        </div>
                        <form method="POST" action="{{ route('client.logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 mr-2">
                                    <path fill-rule="evenodd" d="M7.5 3.75A1.5 1.5 0 006 5.25v13.5a1.5 1.5 0 001.5 1.5h6a1.5 1.5 0 001.5-1.5V15a.75.75 0 011.5 0v3.75a3 3 0 01-3 3h-6a3 3 0 01-3-3V5.25a3 3 0 013-3h6a3 3 0 013 3V9A.75.75 0 0115 9V5.25a1.5 1.5 0 00-1.5-1.5h-6zm10.72 4.72a.75.75 0 011.06 0l3 3a.75.75 0 010 1.06l-3 3a.75.75 0 11-1.06-1.06l1.72-1.72H9a.75.75 0 010-1.5h10.94l-1.72-1.72a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div class="md:hidden border-t border-gray-200" x-data="{ open: false }">
                <button @click="open = !open" class="w-full px-4 py-2 text-left text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <span x-show="!open">Show Menu</span>
                    <span x-show="open">Hide Menu</span>
                </button>
                <div x-show="open" class="px-2 pt-2 pb-3 space-y-1">
                    <a href="{{ route('client.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('client.dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('client.projects') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('client.projects') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        Projects
                    </a>
                    <a href="{{ route('client.payments') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('client.payments') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        Payments
                    </a>
                    <a href="{{ route('client.tasks') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('client.tasks') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        Tasks
                    </a>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
