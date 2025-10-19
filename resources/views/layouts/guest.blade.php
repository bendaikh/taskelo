<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Business Manager')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Decorative subtle grid background */
        .bg-grid {
            background-image: linear-gradient(to right, rgba(255,255,255,0.06) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(255,255,255,0.06) 1px, transparent 1px);
            background-size: 24px 24px;
        }
    </style>
    </head>
<body class="relative min-h-screen overflow-hidden">
    <!-- Gradient base background -->
    <div class="pointer-events-none absolute inset-0 bg-gradient-to-br from-indigo-700 via-purple-700 to-fuchsia-600"></div>
    <!-- Subtle grid overlay -->
    <div class="pointer-events-none absolute inset-0 bg-grid opacity-20"></div>
    <!-- Decorative blobs -->
    <div class="pointer-events-none absolute -top-24 -left-24 h-72 w-72 rounded-full bg-white/10 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-20 -right-20 h-80 w-80 rounded-full bg-fuchsia-300/20 blur-3xl"></div>

    <!-- Content -->
    <div class="relative min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            @yield('content')
        </div>
    </div>
</body>
</html>

