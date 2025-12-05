

<?php $__env->startSection('title', 'Payments'); ?>
<?php $__env->startSection('page-title', 'Payments'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-start space-y-4 md:space-y-0">
    <!-- Filters -->
    <form method="GET" action="<?php echo e(route('payments.index')); ?>" class="flex flex-wrap items-center gap-2">
        <select 
            name="client_id" 
            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
            <option value="">All Clients</option>
            <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($client->id); ?>" <?php echo e(request('client_id') == $client->id ? 'selected' : ''); ?>>
                    <?php echo e($client->name); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <select 
            name="type" 
            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
            <option value="">All Types</option>
            <option value="advance" <?php echo e(request('type') === 'advance' ? 'selected' : ''); ?>>Advance</option>
            <option value="payment" <?php echo e(request('type') === 'payment' ? 'selected' : ''); ?>>Payment</option>
        </select>

        <input 
            type="date" 
            name="date_from" 
            placeholder="From"
            value="<?php echo e(request('date_from')); ?>"
            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">

        <input 
            type="date" 
            name="date_to" 
            placeholder="To"
            value="<?php echo e(request('date_to')); ?>"
            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">

        <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
            Filter
        </button>
        
        <?php if(request()->hasAny(['client_id', 'project_id', 'type', 'date_from', 'date_to'])): ?>
            <a href="<?php echo e(route('payments.index')); ?>" class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500">
                Clear
            </a>
        <?php endif; ?>
    </form>

    <!-- Actions -->
    <div class="flex flex-wrap gap-2">
        <a href="<?php echo e(route('payments.export.csv')); ?>?<?php echo e(http_build_query(request()->all())); ?>" class="px-3 sm:px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm whitespace-nowrap">
            Export CSV
        </a>
        <a href="<?php echo e(route('payments.export.pdf')); ?>?<?php echo e(http_build_query(request()->all())); ?>" class="px-3 sm:px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm whitespace-nowrap">
            Export PDF
        </a>
        <a href="<?php echo e(route('payments.create')); ?>" class="px-3 sm:px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 text-sm whitespace-nowrap">
            + Add Payment
        </a>
    </div>
</div>

<!-- Payments Table (Desktop) -->
<div class="hidden md:block bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Client</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Project</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            <?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                        <?php echo e($payment->date->format('M d, Y')); ?>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="<?php echo e(route('clients.show', $payment->client)); ?>" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 font-medium">
                            <?php echo e($payment->client->name); ?>

                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="<?php echo e(route('projects.show', $payment->project)); ?>" class="text-primary-600 dark:text-primary-400 hover:text-primary-700">
                            <?php echo e($payment->project->title); ?>

                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs rounded-full 
                            <?php if($payment->type === 'advance'): ?> bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                            <?php else: ?> bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                            <?php endif; ?>">
                            <?php echo e(ucfirst($payment->type)); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">
                        <?php echo e(Auth::user()->currency); ?> <?php echo e(number_format($payment->amount, 2)); ?>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="<?php echo e(route('payments.edit', $payment)); ?>" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 mr-3">Edit</a>
                        <form action="<?php echo e(route('payments.destroy', $payment)); ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                        No payments found. <a href="<?php echo e(route('payments.create')); ?>" class="text-primary-600 dark:text-primary-400 hover:text-primary-700">Add your first payment</a>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
        <?php if($payments->count() > 0): ?>
            <tfoot class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <td colspan="4" class="px-6 py-4 text-right font-semibold text-gray-800 dark:text-gray-200">Total:</td>
                    <td class="px-6 py-4 font-bold text-green-600">
                        <?php echo e(Auth::user()->currency); ?> <?php echo e(number_format($payments->sum('amount'), 2)); ?>

                    </td>
                    <td></td>
                </tr>
            </tfoot>
        <?php endif; ?>
    </table>
</div>

<!-- Payments Cards (Mobile) -->
<div class="md:hidden space-y-4">
    <?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <div class="flex items-start justify-between mb-3">
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-lg font-semibold text-green-600">
                            <?php echo e(Auth::user()->currency); ?> <?php echo e(number_format($payment->amount, 2)); ?>

                        </span>
                        <span class="px-2 py-1 text-xs rounded-full 
                            <?php if($payment->type === 'advance'): ?> bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                            <?php else: ?> bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                            <?php endif; ?>">
                            <?php echo e(ucfirst($payment->type)); ?>

                        </span>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                        <?php echo e($payment->date->format('M d, Y')); ?>

                    </p>
                </div>
                <div class="flex space-x-2 ml-2">
                    <a href="<?php echo e(route('payments.edit', $payment)); ?>" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 text-sm">Edit</a>
                    <form action="<?php echo e(route('payments.destroy', $payment)); ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 text-sm">Delete</button>
                    </form>
                </div>
            </div>
            <div class="space-y-1 text-sm border-t border-gray-200 dark:border-gray-700 pt-3">
                <div>
                    <span class="text-gray-500 dark:text-gray-400">Client: </span>
                    <a href="<?php echo e(route('clients.show', $payment->client)); ?>" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 font-medium">
                        <?php echo e($payment->client->name); ?>

                    </a>
                </div>
                <div>
                    <span class="text-gray-500 dark:text-gray-400">Project: </span>
                    <a href="<?php echo e(route('projects.show', $payment->project)); ?>" class="text-primary-600 dark:text-primary-400 hover:text-primary-700">
                        <?php echo e($payment->project->title); ?>

                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-8 text-center">
            <p class="text-gray-500 dark:text-gray-400 mb-4">No payments found.</p>
            <a href="<?php echo e(route('payments.create')); ?>" class="text-primary-600 dark:text-primary-400 hover:text-primary-700">Add your first payment</a>
        </div>
    <?php endif; ?>
    <?php if($payments->count() > 0): ?>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 border-t-2 border-primary-600">
            <div class="flex justify-between items-center">
                <span class="font-semibold text-gray-800 dark:text-gray-200">Total:</span>
                <span class="font-bold text-green-600 text-lg">
                    <?php echo e(Auth::user()->currency); ?> <?php echo e(number_format($payments->sum('amount'), 2)); ?>

                </span>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Pagination -->
<div class="mt-6">
    <?php echo e($payments->links()); ?>

</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Espacegamers\Documents\bendaikh project\resources\views/payments/index.blade.php ENDPATH**/ ?>