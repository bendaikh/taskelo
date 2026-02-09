<aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-800 shadow-md flex-shrink-0 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
    <div class="h-full flex flex-col">
        <!-- Logo -->
        <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
            <h1 class="text-xl sm:text-2xl font-bold text-primary-600 dark:text-primary-400">
                {{ Auth::user()->app_name ?? __('app.business_manager') }}
            </h1>
            <!-- Close button for mobile -->
            <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto p-4">
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('dashboard') }}" 
                       onclick="if(window.innerWidth < 1024) toggleSidebar();"
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        {{ __('app.dashboard') }}
                    </a>
                </li>

                @php
                    $isPersonal = Auth::check() && Auth::user()->currentWorkspace && Auth::user()->currentWorkspace->type === 'personal';
                @endphp

                @if(!$isPersonal)
                <li>
                    <a href="{{ route('projects.index') }}" 
                       onclick="if(window.innerWidth < 1024) toggleSidebar();"
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('projects.*') ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        {{ __('app.projects') }}
                    </a>
                </li>
                @endif

                <li>
                    <a href="{{ route('businesses.index') }}" 
                       onclick="if(window.innerWidth < 1024) toggleSidebar();"
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('businesses.*') ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        {{ __('app.my_business') }}
                    </a>
                </li>

                @if(!$isPersonal)
                <li>
                    <a href="{{ route('daily-tasks.index') }}" 
                       onclick="if(window.innerWidth < 1024) toggleSidebar();"
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('daily-tasks.*') ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                        {{ __('app.daily_tasks') }}
                    </a>
                </li>
                @endif

                @if(!$isPersonal)
                <li>
                    <a href="{{ route('clients.index') }}" 
                       onclick="if(window.innerWidth < 1024) toggleSidebar();"
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('clients.*') ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        {{ __('app.clients') }}
                    </a>
                </li>

                <li>
                    <a href="{{ route('payments.index') }}" 
                       onclick="if(window.innerWidth < 1024) toggleSidebar();"
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('payments.*') ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ __('app.payments') }}
                    </a>
                </li>

                <li>
                    <a href="{{ route('proposals.index') }}" 
                       onclick="if(window.innerWidth < 1024) toggleSidebar();"
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('proposals.*') ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        {{ __('app.proposals') }}
                    </a>
                </li>

                <li>
                    <a href="{{ route('conceptions.index') }}" 
                       onclick="if(window.innerWidth < 1024) toggleSidebar();"
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('conceptions.*') ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        {{ __('app.conception') }}
                    </a>
                </li>
                @endif

                @if($isPersonal)
                <li>
                    <a href="{{ route('revenues.index') }}" 
                       onclick="if(window.innerWidth < 1024) toggleSidebar();"
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('revenues.*') ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ __('app.revenue') }}
                    </a>
                </li>

                <li>
                    <a href="{{ route('revenue-categories.index') }}" 
                       onclick="if(window.innerWidth < 1024) toggleSidebar();"
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('revenue-categories.*') ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        {{ __('app.revenue_categories') }}
                    </a>
                </li>
                @endif

                <!-- Expenses -->
                <li x-data="{ open: {{ request()->routeIs('expenses.*') || request()->routeIs('expense-categories.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="w-full flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('expenses.*') || request()->routeIs('expense-categories.*') ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="flex-1 text-left">{{ __('app.expenses') }}</span>
                        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-90': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                    <ul x-show="open" x-collapse class="ml-4 mt-2 space-y-1">
                        <li>
                            <a href="{{ route('expenses.index') }}" 
                               onclick="if(window.innerWidth < 1024) toggleSidebar();"
                               class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('expenses.*') ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l2-2 4 4m0 0l-4-4m4 4V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2z" />
                                </svg>
                                {{ __('app.expenses') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('expense-categories.index') }}" 
                               onclick="if(window.innerWidth < 1024) toggleSidebar();"
                               class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('expense-categories.*') ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                                {{ __('app.categories') }}
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- User Management -->
                <li x-data="{ open: {{ request()->routeIs('roles.*') || request()->routeIs('users.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="w-full flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('roles.*') || request()->routeIs('users.*') ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span class="flex-1 text-left">{{ __('app.user_management') }}</span>
                        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-90': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                    <ul x-show="open" x-collapse class="ml-4 mt-2 space-y-1">
                        <li>
                            <a href="{{ route('roles.index') }}" 
                               onclick="if(window.innerWidth < 1024) toggleSidebar();"
                               class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('roles.*') ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                {{ __('app.roles') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('users.index') }}" 
                               onclick="if(window.innerWidth < 1024) toggleSidebar();"
                               class="flex items-center px-4 py-2 rounded-lg transition-colors {{ request()->routeIs('users.*') ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ __('app.users') }}
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('analytics') }}" 
                       onclick="if(window.innerWidth < 1024) toggleSidebar();"
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('analytics') ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        {{ __('app.analytics') }}
                    </a>
                </li>

                <li>
                    <a href="{{ route('settings') }}" 
                       onclick="if(window.innerWidth < 1024) toggleSidebar();"
                       class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('settings') ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{ __('app.settings') }}
                    </a>
                </li>
            </ul>
        </nav>

        <!-- User Info -->
        <div class="p-4 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-full bg-primary-600 flex items-center justify-center text-white font-semibold flex-shrink-0">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="ml-3 flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300 truncate">
                        {{ Auth::user()->name }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                        {{ Auth::user()->email }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</aside>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('mobile-sidebar-overlay');
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('mobile-sidebar-overlay');
        const isClickInsideSidebar = sidebar.contains(event.target);
        const isClickOnOverlay = event.target === overlay;
        
        if (!isClickInsideSidebar && !sidebar.classList.contains('-translate-x-full') && window.innerWidth < 1024) {
            if (isClickOnOverlay) {
                toggleSidebar();
            }
        }
    });

    // Close sidebar on window resize if switching to desktop
    window.addEventListener('resize', function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('mobile-sidebar-overlay');
        if (window.innerWidth >= 1024) {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.add('hidden');
        }
    });
</script>

