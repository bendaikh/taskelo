

<?php $__env->startSection('title', 'Manage Workspaces'); ?>
<?php $__env->startSection('page-title', 'Manage Workspaces'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Your Workspaces</h1>
        <a href="<?php echo e(route('workspaces.create')); ?>" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>Create Workspace</span>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__empty_1 = true; $__currentLoopData = $workspaces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $workspace): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 <?php echo e(Auth::user()->current_workspace_id === $workspace->id ? 'ring-2 ring-blue-500' : ''); ?>">
            <!-- Workspace Icon and Type -->
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <div class="p-3 <?php echo e($workspace->type === 'business' ? 'bg-purple-100 dark:bg-purple-900/20' : 'bg-blue-100 dark:bg-blue-900/20'); ?> rounded-lg">
                        <svg class="w-6 h-6 <?php echo e($workspace->type === 'business' ? 'text-purple-600 dark:text-purple-400' : 'text-blue-600 dark:text-blue-400'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <?php if($workspace->type === 'business'): ?>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            <?php else: ?>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            <?php endif; ?>
                        </svg>
                    </div>
                    <?php if(Auth::user()->current_workspace_id === $workspace->id): ?>
                    <span class="px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 rounded-full">
                        Current
                    </span>
                    <?php endif; ?>
                </div>
                <?php if($workspace->owner_id === Auth::id()): ?>
                <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 rounded-full">
                    Owner
                </span>
                <?php endif; ?>
            </div>

            <!-- Workspace Info -->
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">
                <?php echo e($workspace->name); ?>

            </h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                <span class="font-semibold">Type:</span> <?php echo e(ucfirst($workspace->type)); ?>

            </p>
            <?php if($workspace->description): ?>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">
                <?php echo e($workspace->description); ?>

            </p>
            <?php endif; ?>

            <!-- Stats -->
            <div class="grid grid-cols-2 gap-4 mb-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Clients</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-white"><?php echo e($workspace->clients()->count()); ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Projects</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-white"><?php echo e($workspace->projects()->count()); ?></p>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center space-x-2">
                <?php if(Auth::user()->current_workspace_id !== $workspace->id): ?>
                <form method="POST" action="<?php echo e(route('workspaces.switch', $workspace)); ?>" class="flex-1">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">
                        Switch
                    </button>
                </form>
                <?php endif; ?>

                <?php if($workspace->owner_id === Auth::id()): ?>
                <a href="<?php echo e(route('workspaces.edit', $workspace)); ?>" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors text-sm">
                    Edit
                </a>
                
                <?php if(Auth::user()->workspaces()->count() > 1): ?>
                <form method="POST" action="<?php echo e(route('workspaces.destroy', $workspace)); ?>" onsubmit="return confirm('Are you sure you want to delete this workspace? All data will be permanently deleted.')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm">
                        Delete
                    </button>
                </form>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-full text-center py-12">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No workspaces found</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">Get started by creating your first workspace</p>
            <a href="<?php echo e(route('workspaces.create')); ?>" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Create Workspace
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Espacegamers\Documents\bendaikh project\resources\views/workspaces/index.blade.php ENDPATH**/ ?>