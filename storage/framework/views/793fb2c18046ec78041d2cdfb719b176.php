

<?php $__env->startSection('title', 'Analytics'); ?>
<?php $__env->startSection('page-title', 'Analytics'); ?>

<?php $__env->startSection('content'); ?>
<!-- Revenue Comparison -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Yearly Revenue Comparison</h3>
        <div class="space-y-4">
            <div>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600 dark:text-gray-400">Current Year (<?php echo e(now()->year); ?>)</span>
                    <span class="font-bold text-gray-900 dark:text-gray-100"><?php echo e(Auth::user()->currency); ?> <?php echo e(number_format($currentYearRevenue, 2)); ?></span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                    <div class="bg-green-600 h-3 rounded-full" style="width: 100%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600 dark:text-gray-400">Last Year (<?php echo e(now()->year - 1); ?>)</span>
                    <span class="font-bold text-gray-900 dark:text-gray-100"><?php echo e(Auth::user()->currency); ?> <?php echo e(number_format($lastYearRevenue, 2)); ?></span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                    <?php
                        $percentage = $currentYearRevenue > 0 ? ($lastYearRevenue / $currentYearRevenue) * 100 : 0;
                    ?>
                    <div class="bg-blue-600 h-3 rounded-full" style="width: <?php echo e($percentage); ?>%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Completion Rate -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Payment Completion Rate</h3>
        <div class="flex items-center justify-center h-32">
            <div class="text-center">
                <div class="text-5xl font-bold text-primary-600"><?php echo e(number_format($completionRate, 1)); ?>%</div>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Overall Completion</p>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Revenue Chart -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Monthly Revenue Trend (Last 12 Months)</h3>
    <div id="monthly-revenue-chart">
        <revenue-chart 
            :data='<?php echo json_encode($monthlyRevenue, 15, 512) ?>'
            :currency="'<?php echo e(Auth::user()->currency); ?>'">
        </revenue-chart>
    </div>
</div>

<!-- Top Clients and Project Status -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Top 5 Clients -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Top 5 Clients by Revenue</h3>
        <div class="space-y-4">
            <?php $__currentLoopData = $topClients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-700 dark:text-gray-300"><?php echo e($index + 1); ?>. <?php echo e($client['name']); ?></span>
                        <span class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e(Auth::user()->currency); ?> <?php echo e(number_format($client['revenue'], 2)); ?></span>
                    </div>
                    <?php
                        $maxRevenue = $topClients->max('revenue');
                        $percentage = $maxRevenue > 0 ? ($client['revenue'] / $maxRevenue) * 100 : 0;
                    ?>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-primary-600 h-2 rounded-full" style="width: <?php echo e($percentage); ?>%"></div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <!-- Project Status Distribution -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Project Status Distribution</h3>
        <div class="space-y-3">
            <?php $__currentLoopData = ['planning' => 'Planning', 'active' => 'Active', 'on_hold' => 'On Hold', 'completed' => 'Completed', 'cancelled' => 'Cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $count = $projectsByStatus[$key] ?? 0;
                ?>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3 flex-1">
                        <span class="px-3 py-1 text-xs rounded-full
                            <?php if($key === 'active'): ?> bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                            <?php elseif($key === 'completed'): ?> bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                            <?php elseif($key === 'on_hold'): ?> bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                            <?php elseif($key === 'cancelled'): ?> bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                            <?php else: ?> bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300
                            <?php endif; ?>">
                            <?php echo e($label); ?>

                        </span>
                        <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <?php
                                $total = $projectsByStatus->sum();
                                $percentage = $total > 0 ? ($count / $total) * 100 : 0;
                            ?>
                            <div class="bg-primary-600 h-2 rounded-full" style="width: <?php echo e($percentage); ?>%"></div>
                        </div>
                    </div>
                    <span class="ml-3 font-semibold text-gray-900 dark:text-gray-100"><?php echo e($count); ?></span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>

<!-- Revenue by Type -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Revenue by Payment Type</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4 border border-green-200 dark:border-green-800">
            <div class="text-sm text-green-700 dark:text-green-300 mb-1">Payments</div>
            <div class="text-2xl font-bold text-green-800 dark:text-green-200">
                <?php echo e(Auth::user()->currency); ?> <?php echo e(number_format($revenueByType['payment'] ?? 0, 2)); ?>

            </div>
        </div>
        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
            <div class="text-sm text-blue-700 dark:text-blue-300 mb-1">Advances</div>
            <div class="text-2xl font-bold text-blue-800 dark:text-blue-200">
                <?php echo e(Auth::user()->currency); ?> <?php echo e(number_format($revenueByType['advance'] ?? 0, 2)); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Espacegamers\Documents\bendaikh project\resources\views/analytics/index.blade.php ENDPATH**/ ?>