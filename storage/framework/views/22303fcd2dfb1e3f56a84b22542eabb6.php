

<?php $__env->startSection('title', 'My Business'); ?>
<?php $__env->startSection('page-title', 'My Business'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-center space-y-4 md:space-y-0">
    <!-- Tabs -->
    <div class="flex space-x-2 bg-gray-100 dark:bg-gray-800 p-1 rounded-lg">
        <a 
            href="<?php echo e(route('businesses.index', ['type' => 'active'])); ?>" 
            class="px-4 py-2 rounded-lg transition-colors <?php echo e($type === 'active' ? 'bg-primary-600 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700'); ?>">
            Active Businesses
        </a>
        <a 
            href="<?php echo e(route('businesses.index', ['type' => 'idea'])); ?>" 
            class="px-4 py-2 rounded-lg transition-colors <?php echo e($type === 'idea' ? 'bg-primary-600 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700'); ?>">
            Business Ideas
        </a>
    </div>

    <!-- Add Business Button -->
    <a href="<?php echo e(route('businesses.create')); ?>" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
        + Add <?php echo e($type === 'active' ? 'Business' : 'Idea'); ?>

    </a>
</div>

<!-- Businesses Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php $__empty_1 = true; $__currentLoopData = $businesses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $business): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-lg transition-shadow">
            <div class="p-6">
                <!-- Header -->
                <div class="flex items-start justify-between mb-4">
                    <a href="<?php echo e(route('businesses.show', $business)); ?>" class="text-lg font-semibold text-gray-800 dark:text-gray-200 hover:text-primary-600">
                        <?php echo e($business->name); ?>

                    </a>
                    <span class="px-2 py-1 text-xs rounded-full whitespace-nowrap
                        <?php if($business->type === 'active'): ?> bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                        <?php else: ?> bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                        <?php endif; ?>">
                        <?php echo e($business->type === 'active' ? 'Active' : 'Idea'); ?>

                    </span>
                </div>

                <!-- Description -->
                <?php if($business->description): ?>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">
                        <?php echo e($business->description); ?>

                    </p>
                <?php endif; ?>

                <!-- Stats -->
                <div class="space-y-2 mb-4 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Nodes:</span>
                        <span class="text-gray-900 dark:text-gray-100 font-medium"><?php echo e($business->flowNodes->count()); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Connections:</span>
                        <span class="text-gray-900 dark:text-gray-100 font-medium"><?php echo e($business->flowEdges->count()); ?></span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-between items-center pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="<?php echo e(route('businesses.show', $business)); ?>" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 text-sm font-medium">
                        Open Flow →
                    </a>
                    <div class="flex space-x-2">
                        <a href="<?php echo e(route('businesses.edit', $business)); ?>" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 text-sm">Edit</a>
                        <form action="<?php echo e(route('businesses.destroy', $business)); ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 text-sm">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-full text-center py-12 bg-white dark:bg-gray-800 rounded-lg shadow">
            <p class="text-gray-500 dark:text-gray-400 mb-4">No <?php echo e($type === 'active' ? 'businesses' : 'ideas'); ?> found.</p>
            <a href="<?php echo e(route('businesses.create')); ?>" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 font-medium">
                Add your first <?php echo e($type === 'active' ? 'business' : 'idea'); ?>

            </a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Espacegamers\Documents\bendaikh project\resources\views/businesses/index.blade.php ENDPATH**/ ?>