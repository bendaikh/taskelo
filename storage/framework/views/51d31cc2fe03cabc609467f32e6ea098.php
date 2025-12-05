

<?php $__env->startSection('title', 'Expenses'); ?>
<?php $__env->startSection('page-title', 'Expenses'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
    <div>
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Expenses</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">Total: <?php echo e(Auth::user()->currency); ?> <?php echo e(number_format($total, 2)); ?></p>
    </div>
    <a href="<?php echo e(route('expenses.create')); ?>" class="px-4 py-2 bg-primary-600 text-white rounded hover:bg-primary-700 whitespace-nowrap text-center">Add Expense</a>
  </div>

  <!-- Expenses Table (Desktop) -->
  <div class="hidden md:block bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
      <thead class="bg-gray-50 dark:bg-gray-700">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Project</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Category</th>
          <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
          <th class="px-6 py-3"/>
        </tr>
      </thead>
      <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
        <?php $__empty_1 = true; $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100"><?php echo e($expense->date->format('M d, Y')); ?></td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300"><?php echo e($expense->project?->title ?? '-'); ?></td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300"><?php echo e($expense->category ?? '-'); ?></td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-red-600 dark:text-red-400"><?php echo e(Auth::user()->currency); ?> <?php echo e(number_format($expense->amount, 2)); ?></td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
              <form action="<?php echo e(route('expenses.destroy', $expense)); ?>" method="POST" onsubmit="return confirm('Delete this expense?')">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">Delete</button>
              </form>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
            <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">No expenses yet.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
    <div class="p-4"><?php echo e($expenses->links()); ?></div>
  </div>

  <!-- Expenses Cards (Mobile) -->
  <div class="md:hidden space-y-4">
    <?php $__empty_1 = true; $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
        <div class="flex items-start justify-between mb-3">
          <div class="flex-1">
            <div class="flex items-center justify-between mb-2">
              <span class="text-lg font-semibold text-red-600 dark:text-red-400">
                <?php echo e(Auth::user()->currency); ?> <?php echo e(number_format($expense->amount, 2)); ?>

              </span>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">
              <?php echo e($expense->date->format('M d, Y')); ?>

            </p>
          </div>
          <form action="<?php echo e(route('expenses.destroy', $expense)); ?>" method="POST" onsubmit="return confirm('Delete this expense?')" class="ml-2">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 text-sm">Delete</button>
          </form>
        </div>
        <div class="space-y-1 text-sm border-t border-gray-200 dark:border-gray-700 pt-3">
          <div>
            <span class="text-gray-500 dark:text-gray-400">Category: </span>
            <span class="text-gray-900 dark:text-gray-100"><?php echo e($expense->category ?? '-'); ?></span>
          </div>
          <?php if($expense->project): ?>
            <div>
              <span class="text-gray-500 dark:text-gray-400">Project: </span>
              <span class="text-gray-900 dark:text-gray-100"><?php echo e($expense->project->title); ?></span>
            </div>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-8 text-center">
        <p class="text-gray-500 dark:text-gray-400">No expenses yet.</p>
      </div>
    <?php endif; ?>
    <div class="p-4"><?php echo e($expenses->links()); ?></div>
  </div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Espacegamers\Documents\bendaikh project\resources\views/expenses/index.blade.php ENDPATH**/ ?>