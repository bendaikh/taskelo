

<?php $__env->startSection('title', 'Add Expense'); ?>
<?php $__env->startSection('page-title', 'Add Expense'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl">
  <form action="<?php echo e(route('expenses.store')); ?>" method="POST" class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 space-y-4">
    <?php echo csrf_field(); ?>

    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date</label>
      <input type="date" name="date" value="<?php echo e(old('date', now()->toDateString())); ?>" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" required />
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Project (optional)</label>
      <select name="project_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
        <option value="">-- None --</option>
        <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($project->id); ?>" <?php echo e((string) old('project_id', request('project_id')) === (string) $project->id ? 'selected' : ''); ?>><?php echo e($project->title); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <select name="expense_category_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
          <option value="">-- Select Category --</option>
          <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($cat->id); ?>" <?php echo e((string) old('expense_category_id') === (string) $cat->id ? 'selected' : ''); ?>><?php echo e($cat->name); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <input type="text" name="category" value="<?php echo e(old('category')); ?>" placeholder="Or enter custom category" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" />
      </div>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Amount</label>
      <input type="number" step="0.01" min="0" name="amount" value="<?php echo e(old('amount')); ?>" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" required />
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notes</label>
      <textarea name="notes" rows="3" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" placeholder="Details (optional)"><?php echo e(old('notes')); ?></textarea>
    </div>

    <div class="flex items-center justify-end gap-3">
      <a href="<?php echo e(route('expenses.index')); ?>" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded">Cancel</a>
      <button class="px-4 py-2 bg-primary-600 text-white rounded hover:bg-primary-700">Save Expense</button>
    </div>
  </form>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Espacegamers\Documents\bendaikh project\resources\views/expenses/create.blade.php ENDPATH**/ ?>