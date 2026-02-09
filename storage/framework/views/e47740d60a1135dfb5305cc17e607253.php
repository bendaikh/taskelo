

<?php $__env->startSection('title', __('app.daily_tasks')); ?>
<?php $__env->startSection('page-title', __('app.daily_tasks')); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6">
    <div>
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200"><?php echo e(__('app.daily_tasks')); ?></h2>
        <p class="text-sm text-gray-500 dark:text-gray-400"><?php echo e(__('app.tasks_to_do_desc')); ?></p>
    </div>
</div>

<!-- Daily Tasks Container -->
<div id="daily-tasks-container" class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
    <daily-tasks-list :initial-tasks='<?php echo json_encode($tasks, 15, 512) ?>'></daily-tasks-list>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Espacegamers\Documents\bendaikh project\resources\views/daily-tasks/index.blade.php ENDPATH**/ ?>