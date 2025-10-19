

<?php $__env->startSection('title', 'Clients'); ?>
<?php $__env->startSection('page-title', 'Clients'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6 flex justify-between items-center">
    <!-- Search -->
    <form method="GET" action="<?php echo e(route('clients.index')); ?>" class="flex items-center space-x-2">
        <input 
            type="text" 
            name="search" 
            placeholder="Search clients..." 
            value="<?php echo e(request('search')); ?>"
            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
        <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
            Search
        </button>
        <?php if(request('search')): ?>
            <a href="<?php echo e(route('clients.index')); ?>" class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500">
                Clear
            </a>
        <?php endif; ?>
    </form>

    <!-- Add Client Button -->
    <a href="<?php echo e(route('clients.create')); ?>" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
        + Add Client
    </a>
</div>

<!-- Clients Table -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Company</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Projects</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Outstanding</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            <?php $__empty_1 = true; $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="<?php echo e(route('clients.show', $client)); ?>" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 font-medium">
                            <?php echo e($client->name); ?>

                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                        <?php echo e($client->email); ?>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                        <?php echo e($client->company ?? 'N/A'); ?>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                        <?php echo e($client->projects_count); ?>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                        <?php echo e(Auth::user()->currency); ?> <?php echo e(number_format($client->outstanding_balance, 2)); ?>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="<?php echo e(route('clients.edit', $client)); ?>" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 mr-3">Edit</a>
                        <form action="<?php echo e(route('clients.destroy', $client)); ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this client?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                        No clients found. <a href="<?php echo e(route('clients.create')); ?>" class="text-primary-600 dark:text-primary-400 hover:text-primary-700">Add your first client</a>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-6">
    <?php echo e($clients->links()); ?>

</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Espacegamers\Documents\bendaikh project\resources\views/clients/index.blade.php ENDPATH**/ ?>