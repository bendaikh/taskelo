

<?php $__env->startSection('title', 'Add Expense Category'); ?>
<?php $__env->startSection('page-title', 'Add Expense Category'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-xl">
  <form action="<?php echo e(route('expense-categories.store')); ?>" method="POST" class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 space-y-4">
    <?php echo csrf_field(); ?>
    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name</label>
      <input type="text" name="name" value="<?php echo e(old('name')); ?>" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" required />
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
      <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" placeholder="Optional"><?php echo e(old('description')); ?></textarea>
    </div>
    <div class="flex items-center justify-end gap-3">
      <a href="<?php echo e(route('expense-categories.index')); ?>" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded">Cancel</a>
      <button class="px-4 py-2 bg-primary-600 text-white rounded hover:bg-primary-700">Save Category</button>
    </div>
  </form>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Espacegamers\Documents\bendaikh project\resources\views/expense_categories/create.blade.php ENDPATH**/ ?>