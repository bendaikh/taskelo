

<?php $__env->startSection('title', __('app.users')); ?>
<?php $__env->startSection('page-title', __('app.users')); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
    <!-- Search -->
    <form method="GET" action="<?php echo e(route('users.index')); ?>" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 flex-1">
        <input 
            type="text" 
            name="search" 
            placeholder="<?php echo e(__('app.search')); ?>..." 
            value="<?php echo e(request('search')); ?>"
            class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
        <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 whitespace-nowrap">
            <?php echo e(__('app.search')); ?>

        </button>
        <?php if(request('search')): ?>
            <a href="<?php echo e(route('users.index')); ?>" class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 whitespace-nowrap text-center">
                <?php echo e(__('app.cancel')); ?>

            </a>
        <?php endif; ?>
    </form>

    <!-- Add User Button -->
    <a href="<?php echo e(route('users.create')); ?>" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 whitespace-nowrap text-center">
        + <?php echo e(__('app.add_user')); ?>

    </a>
</div>

<!-- Users Table (Desktop) -->
<div class="hidden md:block bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"><?php echo e(__('app.name')); ?></th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"><?php echo e(__('app.email')); ?></th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"><?php echo e(__('app.roles')); ?></th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"><?php echo e(__('app.date')); ?></th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"><?php echo e(__('app.actions')); ?></th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="<?php echo e(route('users.show', $user)); ?>" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 font-medium">
                            <?php echo e($user->name); ?>

                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                        <?php echo e($user->email); ?>

                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                        <?php if($user->roles->count() > 0): ?>
                            <div class="flex flex-wrap gap-1">
                                <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="px-2 py-1 bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300 rounded text-xs">
                                        <?php echo e($role->name); ?>

                                    </span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <span class="text-gray-400"><?php echo e(__('app.no_roles')); ?></span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                        <?php echo e($user->created_at->format('M d, Y')); ?>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="<?php echo e(route('users.edit', $user)); ?>" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 mr-3"><?php echo e(__('app.edit')); ?></a>
                        <?php if($user->id !== Auth::id()): ?>
                            <form action="<?php echo e(route('users.destroy', $user)); ?>" method="POST" class="inline" onsubmit="return confirm('<?php echo e(__('app.confirm_delete')); ?>');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400"><?php echo e(__('app.delete')); ?></button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                        <?php echo e(__('app.no_users')); ?>. <a href="<?php echo e(route('users.create')); ?>" class="text-primary-600 dark:text-primary-400 hover:text-primary-700"><?php echo e(__('app.add_user')); ?></a>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Users Cards (Mobile) -->
<div class="md:hidden space-y-4">
    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <div class="flex items-start justify-between mb-3">
                <a href="<?php echo e(route('users.show', $user)); ?>" class="text-lg font-semibold text-primary-600 dark:text-primary-400 hover:text-primary-700">
                    <?php echo e($user->name); ?>

                </a>
                <div class="flex space-x-2">
                    <a href="<?php echo e(route('users.edit', $user)); ?>" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 text-sm"><?php echo e(__('app.edit')); ?></a>
                    <?php if($user->id !== Auth::id()): ?>
                        <form action="<?php echo e(route('users.destroy', $user)); ?>" method="POST" class="inline" onsubmit="return confirm('<?php echo e(__('app.are_you_sure')); ?>');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 text-sm"><?php echo e(__('app.delete')); ?></button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
            <div class="space-y-2 text-sm">
                <div class="flex items-center">
                    <span class="text-gray-500 dark:text-gray-400 w-24"><?php echo e(__('app.email')); ?>:</span>
                    <span class="text-gray-900 dark:text-gray-100 flex-1 truncate"><?php echo e($user->email); ?></span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-500 dark:text-gray-400 w-24"><?php echo e(__('app.roles')); ?>:</span>
                    <span class="text-gray-900 dark:text-gray-100 flex-1">
                        <?php if($user->roles->count() > 0): ?>
                            <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="px-2 py-1 bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300 rounded text-xs mr-1">
                                    <?php echo e($role->name); ?>

                                </span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <span class="text-gray-400"><?php echo e(__('app.no_roles')); ?></span>
                        <?php endif; ?>
                    </span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-500 dark:text-gray-400 w-24"><?php echo e(__('app.date')); ?>:</span>
                    <span class="text-gray-900 dark:text-gray-100 flex-1"><?php echo e($user->created_at->format('M d, Y')); ?></span>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-8 text-center">
            <p class="text-gray-500 dark:text-gray-400 mb-4"><?php echo e(__('app.no_users')); ?>.</p>
            <a href="<?php echo e(route('users.create')); ?>" class="text-primary-600 dark:text-primary-400 hover:text-primary-700"><?php echo e(__('app.add_user')); ?></a>
        </div>
    <?php endif; ?>
</div>

<!-- Pagination -->
<div class="mt-6">
    <?php echo e($users->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Espacegamers\Documents\bendaikh project\resources\views/users/index.blade.php ENDPATH**/ ?>