

<?php $__env->startSection('title', __('app.conception')); ?>
<?php $__env->startSection('page-title', __('app.conception')); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
    <!-- Filters & Search -->
    <form method="GET" action="<?php echo e(route('conceptions.index')); ?>" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 flex-1">
        <!-- Search -->
        <input 
            type="text" 
            name="search" 
            placeholder="<?php echo e(__('app.search')); ?>..." 
            value="<?php echo e(request('search')); ?>"
            class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
        
        <!-- Status Filter -->
        <select name="status" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
            <option value=""><?php echo e(__('app.all')); ?> <?php echo e(__('app.status')); ?></option>
            <option value="draft" <?php echo e(request('status') == 'draft' ? 'selected' : ''); ?>><?php echo e(__('app.draft')); ?></option>
            <option value="sent" <?php echo e(request('status') == 'sent' ? 'selected' : ''); ?>><?php echo e(__('app.sent')); ?></option>
            <option value="accepted" <?php echo e(request('status') == 'accepted' ? 'selected' : ''); ?>><?php echo e(__('app.accepted')); ?></option>
            <option value="rejected" <?php echo e(request('status') == 'rejected' ? 'selected' : ''); ?>><?php echo e(__('app.rejected')); ?></option>
        </select>
        
        <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 whitespace-nowrap">
            <?php echo e(__('app.filter')); ?>

        </button>
        <?php if(request('search') || request('status')): ?>
            <a href="<?php echo e(route('conceptions.index')); ?>" class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 whitespace-nowrap text-center">
                <?php echo e(__('app.cancel')); ?>

            </a>
        <?php endif; ?>
    </form>

    <!-- Add Conception Button -->
    <a href="<?php echo e(route('conceptions.create')); ?>" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 whitespace-nowrap text-center">
        + <?php echo e(__('app.add_conception')); ?>

    </a>
</div>

<!-- Conceptions Table (Desktop) -->
<div class="hidden md:block bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"><?php echo e(__('app.title')); ?></th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"><?php echo e(__('app.client')); ?></th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"><?php echo e(__('app.date')); ?></th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"><?php echo e(__('app.sections')); ?></th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"><?php echo e(__('app.total')); ?></th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"><?php echo e(__('app.status')); ?></th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"><?php echo e(__('app.actions')); ?></th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            <?php $__empty_1 = true; $__currentLoopData = $conceptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conception): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-4">
                        <a href="<?php echo e(route('conceptions.show', $conception)); ?>" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 font-medium">
                            <?php echo e($conception->title); ?>

                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                        <?php echo e($conception->client?->name ?? __('app.no_clients')); ?>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                        <?php echo e($conception->date->format('M d, Y')); ?>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                        <?php echo e(count($conception->sections)); ?> <?php echo e(__('app.sections')); ?>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-gray-100">
                        <?php echo e($conception->currency); ?> <?php echo e(number_format($conception->total_price, 2)); ?>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <?php
                            $statusColors = [
                                'draft' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                'sent' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                'accepted' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                            ];
                        ?>
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($statusColors[$conception->status]); ?>">
                            <?php echo e(__('app.' . $conception->status)); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <a href="<?php echo e(route('conceptions.show', $conception)); ?>" class="text-green-600 hover:text-green-900 dark:text-green-400"><?php echo e(__('app.view')); ?></a>
                        <select onchange="if(this.value) window.location.href=this.value" class="text-purple-600 dark:text-purple-400 bg-transparent border-none cursor-pointer text-sm font-medium focus:outline-none focus:ring-0">
                            <option value="">PDF ▾</option>
                            <option value="<?php echo e(route('conceptions.pdf', [$conception, 'en'])); ?>">🇬🇧 <?php echo e(__('app.english')); ?></option>
                            <option value="<?php echo e(route('conceptions.pdf', [$conception, 'fr'])); ?>">🇫🇷 <?php echo e(__('app.french')); ?></option>
                        </select>
                        <a href="<?php echo e(route('conceptions.edit', $conception)); ?>" class="text-blue-600 hover:text-blue-900 dark:text-blue-400"><?php echo e(__('app.edit')); ?></a>
                        <form action="<?php echo e(route('conceptions.destroy', $conception)); ?>" method="POST" class="inline" onsubmit="return confirm('<?php echo e(__('app.confirm_delete')); ?>');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400"><?php echo e(__('app.delete')); ?></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                        <?php echo e(__('app.no_conceptions')); ?>. <a href="<?php echo e(route('conceptions.create')); ?>" class="text-primary-600 dark:text-primary-400 hover:text-primary-700"><?php echo e(__('app.add_conception')); ?></a>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Conceptions Cards (Mobile) -->
<div class="md:hidden space-y-4">
    <?php $__empty_1 = true; $__currentLoopData = $conceptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conception): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <div class="flex items-start justify-between mb-3">
                <div class="flex-1">
                    <a href="<?php echo e(route('conceptions.show', $conception)); ?>" class="text-lg font-semibold text-primary-600 dark:text-primary-400 hover:text-primary-700 block mb-1">
                        <?php echo e($conception->title); ?>

                    </a>
                    <?php
                        $statusColors = [
                            'draft' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                            'sent' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                            'accepted' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                            'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                        ];
                    ?>
                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($statusColors[$conception->status]); ?>">
                        <?php echo e(__('app.' . $conception->status)); ?>

                    </span>
                </div>
            </div>
            <div class="space-y-2 text-sm mb-3">
                <div class="flex items-center justify-between">
                    <span class="text-gray-500 dark:text-gray-400"><?php echo e(__('app.client')); ?>:</span>
                    <span class="text-gray-900 dark:text-gray-100"><?php echo e($conception->client?->name ?? __('app.no_clients')); ?></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-500 dark:text-gray-400"><?php echo e(__('app.date')); ?>:</span>
                    <span class="text-gray-900 dark:text-gray-100"><?php echo e($conception->date->format('M d, Y')); ?></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-500 dark:text-gray-400"><?php echo e(__('app.sections')); ?>:</span>
                    <span class="text-gray-900 dark:text-gray-100"><?php echo e(count($conception->sections)); ?></span>
                </div>
                <div class="flex items-center justify-between pt-2 border-t border-gray-200 dark:border-gray-700">
                    <span class="text-gray-500 dark:text-gray-400"><?php echo e(__('app.total')); ?>:</span>
                    <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        <?php echo e($conception->currency); ?> <?php echo e(number_format($conception->total_price, 2)); ?>

                    </span>
                </div>
            </div>
            <div class="flex flex-wrap gap-2 text-sm items-center">
                <a href="<?php echo e(route('conceptions.show', $conception)); ?>" class="text-green-600 hover:text-green-900 dark:text-green-400"><?php echo e(__('app.view')); ?></a>
                <select onchange="if(this.value) window.location.href=this.value" class="text-purple-600 dark:text-purple-400 bg-transparent border-none cursor-pointer text-sm font-medium focus:outline-none focus:ring-0">
                    <option value="">PDF ▾</option>
                    <option value="<?php echo e(route('conceptions.pdf', [$conception, 'en'])); ?>">🇬🇧 <?php echo e(__('app.english')); ?></option>
                    <option value="<?php echo e(route('conceptions.pdf', [$conception, 'fr'])); ?>">🇫🇷 <?php echo e(__('app.french')); ?></option>
                </select>
                <a href="<?php echo e(route('conceptions.edit', $conception)); ?>" class="text-blue-600 hover:text-blue-900 dark:text-blue-400"><?php echo e(__('app.edit')); ?></a>
                <form action="<?php echo e(route('conceptions.destroy', $conception)); ?>" method="POST" class="inline" onsubmit="return confirm('<?php echo e(__('app.are_you_sure')); ?>');">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400"><?php echo e(__('app.delete')); ?></button>
                </form>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-8 text-center">
            <p class="text-gray-500 dark:text-gray-400 mb-4"><?php echo e(__('app.no_conceptions')); ?>.</p>
            <a href="<?php echo e(route('conceptions.create')); ?>" class="text-primary-600 dark:text-primary-400 hover:text-primary-700"><?php echo e(__('app.add_conception')); ?></a>
        </div>
    <?php endif; ?>
</div>

<!-- Pagination -->
<div class="mt-6">
    <?php echo e($conceptions->links()); ?>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Espacegamers\Documents\bendaikh project\resources\views/conceptions/index.blade.php ENDPATH**/ ?>