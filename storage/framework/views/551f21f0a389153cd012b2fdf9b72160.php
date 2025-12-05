

<?php $__env->startSection('title', 'Expense Categories'); ?>
<?php $__env->startSection('page-title', 'Expense Categories'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
  <div>
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Expense Categories</h2>
    <p class="text-sm text-gray-500 dark:text-gray-400">Total: <?php echo e($totalCategories); ?></p>
  </div>
  <a href="<?php echo e(route('expense-categories.create')); ?>" class="px-4 py-2 bg-primary-600 text-white rounded hover:bg-primary-700 whitespace-nowrap text-center">Add Category</a>
</div>

<!-- Categories Table (Desktop) -->
<div class="hidden md:block bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
      <thead class="bg-gray-50 dark:bg-gray-700">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
          <th class="px-6 py-3"/>
        </tr>
      </thead>
      <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
        <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100"><?php echo e($category->name); ?></td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300"><?php echo e($category->description); ?></td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
              <form action="<?php echo e(route('expense-categories.destroy', $category)); ?>" method="POST" onsubmit="return confirm('Delete this category?')">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">Delete</button>
              </form>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
            <td colspan="3" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">No categories yet.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
    <div class="p-4"><?php echo e($categories->links()); ?></div>
</div>

<!-- Categories Cards (Mobile) -->
<div class="md:hidden space-y-4">
    <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <div class="flex items-start justify-between mb-2">
                <div class="flex-1 min-w-0">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-1"><?php echo e($category->name); ?></h3>
                    <?php if($category->description): ?>
                        <p class="text-sm text-gray-700 dark:text-gray-300"><?php echo e($category->description); ?></p>
                    <?php endif; ?>
                </div>
                <form action="<?php echo e(route('expense-categories.destroy', $category)); ?>" method="POST" onsubmit="return confirm('Delete this category?')" class="ml-2">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 text-sm">Delete</button>
                </form>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-8 text-center">
            <p class="text-gray-500 dark:text-gray-400">No categories yet.</p>
        </div>
    <?php endif; ?>
    <div class="p-4"><?php echo e($categories->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Espacegamers\Documents\bendaikh project\resources\views/expense_categories/index.blade.php ENDPATH**/ ?>