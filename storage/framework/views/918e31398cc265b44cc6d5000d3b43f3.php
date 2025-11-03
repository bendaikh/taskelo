

<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<!-- Overview Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Total Projects -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 dark:text-gray-400 text-sm">Total Projects</p>
                <p class="text-3xl font-bold text-gray-800 dark:text-gray-200 mt-2"><?php echo e($totalProjects); ?></p>
            </div>
            <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-lg">
                <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Active Clients -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 dark:text-gray-400 text-sm">Active Clients</p>
                <p class="text-3xl font-bold text-gray-800 dark:text-gray-200 mt-2"><?php echo e($activeClients); ?></p>
            </div>
            <div class="bg-green-100 dark:bg-green-900 p-3 rounded-lg">
                <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 dark:text-gray-400 text-sm">Total Revenue</p>
                <p class="text-3xl font-bold text-gray-800 dark:text-gray-200 mt-2"><?php echo e(Auth::user()->currency); ?> <?php echo e(number_format($totalRevenue, 2)); ?></p>
            </div>
            <div class="bg-yellow-100 dark:bg-yellow-900 p-3 rounded-lg">
                <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Pending Payments -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 dark:text-gray-400 text-sm">Pending Payments</p>
                <p class="text-3xl font-bold text-gray-800 dark:text-gray-200 mt-2"><?php echo e(Auth::user()->currency); ?> <?php echo e(number_format($pendingPayments, 2)); ?></p>
            </div>
            <div class="bg-red-100 dark:bg-red-900 p-3 rounded-lg">
                <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Monthly Revenue Chart -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Monthly Revenue</h3>
        <div id="monthly-revenue-chart-container">
            <revenue-chart 
                :data='<?php echo json_encode($monthlyRevenue, 15, 512) ?>'
                :currency="'<?php echo e(Auth::user()->currency); ?>'">
            </revenue-chart>
        </div>
    </div>

    <!-- Daily Revenue Chart -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Daily Revenue (Last 14 Days)</h3>
        <div>
            <revenue-chart 
                :data='<?php echo json_encode($dailyRevenue, 15, 512) ?>'
                :currency="'<?php echo e(Auth::user()->currency); ?>'">
            </revenue-chart>
        </div>
    </div>

    <!-- Payment Status Chart -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Payment Status</h3>
        <div id="payment-status-chart-container">
            <payment-status-chart 
                :data='<?php echo json_encode($paymentStatus, 15, 512) ?>'
                :currency="'<?php echo e(Auth::user()->currency); ?>'">
            </payment-status-chart>
        </div>
    </div>
</div>

<!-- Tasks To Focus -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Tasks In Progress -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Tasks In Progress</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Latest tasks currently being worked on</p>
        </div>
        <div class="p-6">
            <?php $__empty_1 = true; $__currentLoopData = $inProgressTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="py-3 border-b border-gray-200 dark:border-gray-700 last:border-0">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="font-medium text-gray-800 dark:text-gray-200"><?php echo e($task->title); ?></p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                <?php echo e($task->project->title); ?>

                                <?php if($task->project && $task->project->client): ?>
                                    · <?php echo e($task->project->client->name); ?>

                                <?php endif; ?>
                            </p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">In Progress</span>
                    </div>
                    <?php if($task->deadline): ?>
                        <p class="text-xs mt-1 text-gray-500 dark:text-gray-400">Due <?php echo e($task->deadline->format('M d, Y')); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">No tasks in progress</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Tasks To Do -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Tasks To Do</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Latest tasks not started yet</p>
        </div>
        <div class="p-6">
            <?php $__empty_1 = true; $__currentLoopData = $todoTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="py-3 border-b border-gray-200 dark:border-gray-700 last:border-0">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="font-medium text-gray-800 dark:text-gray-200"><?php echo e($task->title); ?></p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                <?php echo e($task->project->title); ?>

                                <?php if($task->project && $task->project->client): ?>
                                    · <?php echo e($task->project->client->name); ?>

                                <?php endif; ?>
                            </p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">To Do</span>
                    </div>
                    <?php if($task->deadline): ?>
                        <p class="text-xs mt-1 text-gray-500 dark:text-gray-400">Due <?php echo e($task->deadline->format('M d, Y')); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">No tasks to do</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Recent Items -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Payments -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Recent Payments</h3>
        </div>
        <div class="p-6">
            <?php $__empty_1 = true; $__currentLoopData = $recentPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700 last:border-0">
                    <div>
                        <p class="font-medium text-gray-800 dark:text-gray-200"><?php echo e($payment->client->name); ?></p>
                        <p class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($payment->project->title); ?></p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-green-600"><?php echo e(Auth::user()->currency); ?> <?php echo e(number_format($payment->amount, 2)); ?></p>
                        <p class="text-xs text-gray-500 dark:text-gray-400"><?php echo e($payment->date->format('M d, Y')); ?></p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">No recent payments</p>
            <?php endif; ?>
        </div>
        <div class="p-4 border-t border-gray-200 dark:border-gray-700">
            <a href="<?php echo e(route('payments.index')); ?>" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 text-sm font-medium">
                View all payments →
            </a>
        </div>
    </div>

    <!-- Recent Projects -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Recent Projects</h3>
        </div>
        <div class="p-6">
            <?php $__empty_1 = true; $__currentLoopData = $recentProjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="py-3 border-b border-gray-200 dark:border-gray-700 last:border-0">
                    <div class="flex items-center justify-between mb-2">
                        <p class="font-medium text-gray-800 dark:text-gray-200"><?php echo e($project->title); ?></p>
                        <span class="px-2 py-1 text-xs rounded-full 
                            <?php if($project->status === 'active'): ?> bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                            <?php elseif($project->status === 'completed'): ?> bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                            <?php elseif($project->status === 'on_hold'): ?> bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                            <?php else: ?> bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300
                            <?php endif; ?>">
                            <?php echo e(ucfirst(str_replace('_', ' ', $project->status))); ?>

                        </span>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($project->client->name); ?></p>
                    <div class="mt-2">
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-primary-600 h-2 rounded-full" style="width: <?php echo e($project->progress); ?>%"></div>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1"><?php echo e($project->progress); ?>% complete</p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">No recent projects</p>
            <?php endif; ?>
        </div>
        <div class="p-4 border-t border-gray-200 dark:border-gray-700">
            <a href="<?php echo e(route('projects.index')); ?>" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 text-sm font-medium">
                View all projects →
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Espacegamers\Documents\bendaikh project\resources\views/dashboard/index.blade.php ENDPATH**/ ?>