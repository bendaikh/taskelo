<header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
    <div class="px-4 sm:px-6 py-3 sm:py-4 flex items-center justify-between">
        <!-- Left Side: Mobile Menu Button + Page Title -->
        <div class="flex items-center space-x-3 sm:space-x-4">
            <!-- Mobile Menu Button -->
            <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <!-- Page Title -->
            <div>
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-800 dark:text-gray-200">
                    <?php echo $__env->yieldContent('page-title', 'Dashboard'); ?>
                </h2>
            </div>
        </div>

        <!-- Right Side -->
        <div class="flex items-center space-x-2 sm:space-x-4">
            <!-- Language Switcher -->
            <?php if(Auth::check()): ?>
            <div class="relative" x-data="{ open: false }">
                <button 
                    @click="open = !open" 
                    @click.away="open = false"
                    class="flex items-center space-x-1 px-2 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                    </svg>
                    <span class="hidden sm:inline text-sm text-gray-700 dark:text-gray-300 font-medium uppercase">
                        <?php echo e(Auth::user()->language ?? 'en'); ?>

                    </span>
                    <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Language Dropdown -->
                <div 
                    x-show="open" 
                    x-transition
                    class="absolute right-0 mt-2 w-40 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50">
                    <div class="py-1">
                        <form method="POST" action="<?php echo e(route('settings.language')); ?>">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="language" value="en">
                            <button type="submit" class="w-full px-4 py-2 text-left text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center space-x-2 <?php echo e((Auth::user()->language ?? 'en') === 'en' ? 'bg-blue-50 dark:bg-blue-900/20' : ''); ?>">
                                <span class="text-lg">🇬🇧</span>
                                <span><?php echo e(__('app.english')); ?></span>
                                <?php if((Auth::user()->language ?? 'en') === 'en'): ?>
                                <svg class="w-4 h-4 ml-auto text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <?php endif; ?>
                            </button>
                        </form>
                        <form method="POST" action="<?php echo e(route('settings.language')); ?>">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="language" value="fr">
                            <button type="submit" class="w-full px-4 py-2 text-left text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center space-x-2 <?php echo e((Auth::user()->language ?? 'en') === 'fr' ? 'bg-blue-50 dark:bg-blue-900/20' : ''); ?>">
                                <span class="text-lg">🇫🇷</span>
                                <span><?php echo e(__('app.french')); ?></span>
                                <?php if((Auth::user()->language ?? 'en') === 'fr'): ?>
                                <svg class="w-4 h-4 ml-auto text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <?php endif; ?>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Workspace Selector -->
            <?php if(Auth::check() && Auth::user()->currentWorkspace): ?>
            <div class="relative" x-data="{ open: false }">
                <button 
                    @click="open = !open" 
                    @click.away="open = false"
                    class="flex items-center space-x-2 px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <?php if(Auth::user()->currentWorkspace->type === 'business'): ?>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        <?php else: ?>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        <?php endif; ?>
                    </svg>
                    <span class="hidden sm:inline text-sm text-gray-700 dark:text-gray-300 font-medium">
                        <?php echo e(Str::limit(Auth::user()->currentWorkspace->name, 20)); ?>

                    </span>
                    <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Dropdown -->
                <div 
                    x-show="open" 
                    x-transition
                    class="absolute right-0 mt-2 w-64 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50">
                    <div class="p-2">
                        <!-- Current Workspace -->
                        <div class="px-3 py-2 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">
                            <?php echo e(__('app.current_workspace')); ?>

                        </div>
                        <div class="px-3 py-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg mb-2">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <?php if(Auth::user()->currentWorkspace->type === 'business'): ?>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    <?php else: ?>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    <?php endif; ?>
                                </svg>
                                <div class="flex-1">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        <?php echo e(Auth::user()->currentWorkspace->name); ?>

                                    </div>
                                    <div class="text-xs text-gray-600 dark:text-gray-400">
                                        <?php echo e(ucfirst(Auth::user()->currentWorkspace->type)); ?>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Other Workspaces -->
                        <?php if(Auth::user()->workspaces->where('id', '!=', Auth::user()->current_workspace_id)->count() > 0): ?>
                        <div class="px-3 py-2 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">
                            <?php echo e(__('app.switch_to')); ?>

                        </div>
                        <?php $__currentLoopData = Auth::user()->workspaces->where('id', '!=', Auth::user()->current_workspace_id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $workspace): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <form method="POST" action="<?php echo e(route('workspaces.switch', $workspace)); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="w-full px-3 py-2 text-left rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors flex items-center space-x-2">
                                <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <?php if($workspace->type === 'business'): ?>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    <?php else: ?>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    <?php endif; ?>
                                </svg>
                                <div class="flex-1">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        <?php echo e($workspace->name); ?>

                                    </div>
                                    <div class="text-xs text-gray-600 dark:text-gray-400">
                                        <?php echo e(ucfirst($workspace->type)); ?>

                                    </div>
                                </div>
                            </button>
                        </form>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>

                        <!-- Divider -->
                        <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>

                        <!-- Workspace Management -->
                        <a href="<?php echo e(route('workspaces.create')); ?>" class="block px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                <span><?php echo e(__('app.create_workspace')); ?></span>
                            </div>
                        </a>
                        <a href="<?php echo e(route('workspaces.index')); ?>" class="block px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span><?php echo e(__('app.manage_workspaces')); ?></span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Theme Toggle -->
            <button 
                onclick="toggleTheme()" 
                class="p-2 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <svg class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                </svg>
            </button>

            <!-- Logout -->
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="px-3 sm:px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm sm:text-base">
                    <span class="hidden sm:inline"><?php echo e(__('app.logout')); ?></span>
                    <svg class="w-5 h-5 sm:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</header>

<script>
    function toggleTheme() {
        const html = document.documentElement;
        const currentTheme = html.classList.contains('dark') ? 'dark' : 'light';
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        
        html.classList.remove(currentTheme);
        html.classList.add(newTheme);
        
        // Save preference
        fetch('<?php echo e(route('settings.preferences')); ?>', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({
                theme: newTheme,
                currency: '<?php echo e(Auth::user()->currency); ?>'
            })
        });
    }
</script>

<?php /**PATH C:\Users\Espacegamers\Documents\bendaikh project\resources\views/layouts/navbar.blade.php ENDPATH**/ ?>