

<?php $__env->startSection('title', $business->name); ?>
<?php $__env->startSection('page-title', $business->name); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-center space-y-4 md:space-y-0">
    <div class="flex items-center space-x-4">
        <a href="<?php echo e(route('businesses.index', ['type' => $business->type])); ?>" class="text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">
            ← Back to <?php echo e($business->type === 'active' ? 'Active Businesses' : 'Business Ideas'); ?>

        </a>
        <span class="px-3 py-1 text-sm rounded-full
            <?php if($business->type === 'active'): ?> bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
            <?php else: ?> bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
            <?php endif; ?>">
            <?php echo e($business->type === 'active' ? 'Active Business' : 'Business Idea'); ?>

        </span>
    </div>

    <div class="flex items-center space-x-2">
        <a href="<?php echo e(route('businesses.edit', $business)); ?>" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600">
            Edit Business
        </a>
    </div>
</div>

<?php if($business->description): ?>
    <div class="mb-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
        <p class="text-gray-700 dark:text-gray-300"><?php echo e($business->description); ?></p>
    </div>
<?php endif; ?>

<!-- Flow Builder -->
<flow-builder 
    :business-id="<?php echo e($business->id); ?>"
    :initial-nodes='<?php echo json_encode($business->flowNodes, 15, 512) ?>'
    :initial-edges='<?php echo json_encode($business->flowEdges, 15, 512) ?>'>
</flow-builder>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Espacegamers\Documents\bendaikh project\resources\views/businesses/show.blade.php ENDPATH**/ ?>