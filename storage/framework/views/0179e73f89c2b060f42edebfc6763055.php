

<?php $__env->startSection('title', 'Dashboard - Client Portal'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-blue-600 to-cyan-600 rounded-lg shadow-lg p-6 text-white">
        <h2 class="text-2xl font-bold">Welcome back, <?php echo e($client->name); ?>!</h2>
        <p class="mt-2 text-blue-100">Here's an overview of your projects and payments</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Projects</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900"><?php echo e($projects->count()); ?></p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-blue-600">
                        <path fill-rule="evenodd" d="M2.25 6a3 3 0 013-3h13.5a3 3 0 013 3v12a3 3 0 01-3 3H5.25a3 3 0 01-3-3V6zm3.97.97a.75.75 0 011.06 0l2.25 2.25a.75.75 0 010 1.06l-2.25 2.25a.75.75 0 01-1.06-1.06l1.72-1.72-1.72-1.72a.75.75 0 010-1.06zm4.28 4.28a.75.75 0 000 1.5h5.25a.75.75 0 000-1.5H10.5z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Paid</p>
                    <p class="mt-2 text-3xl font-bold text-green-600"><?php echo e($currency); ?><?php echo e(number_format($totalPaid, 2)); ?></p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-green-600">
                        <path d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 01-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004zM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 01-.921.42z" />
                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v.816a3.836 3.836 0 00-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 01-.921-.421l-.879-.66a.75.75 0 00-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 001.5 0v-.81a4.124 4.124 0 001.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 00-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 00.933-1.175l-.415-.33a3.836 3.836 0 00-1.719-.755V6z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Pending Amount</p>
                    <p class="mt-2 text-3xl font-bold text-orange-600"><?php echo e($currency); ?><?php echo e(number_format($totalPending, 2)); ?></p>
                </div>
                <div class="p-3 bg-orange-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-orange-600">
                        <path d="M12 7.5a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z" />
                        <path fill-rule="evenodd" d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v9.75c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 14.625v-9.75zM8.25 9.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM18.75 9a.75.75 0 00-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 00.75-.75V9.75a.75.75 0 00-.75-.75h-.008zM4.5 9.75A.75.75 0 015.25 9h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75H5.25a.75.75 0 01-.75-.75V9.75z" clip-rule="evenodd" />
                        <path d="M2.25 18a.75.75 0 000 1.5c5.4 0 10.63.722 15.6 2.075 1.19.324 2.4-.558 2.4-1.82V18.75a.75.75 0 00-.75-.75H2.25z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Projects -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Your Projects</h3>
                <a href="<?php echo e(route('client.projects')); ?>" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View All</a>
            </div>
        </div>
        <div class="p-6">
            <?php if($projects->isEmpty()): ?>
                <p class="text-gray-500 text-center py-4">No projects yet</p>
            <?php else: ?>
                <div class="space-y-4">
                    <?php $__currentLoopData = $projects->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h4 class="text-lg font-medium text-gray-900"><?php echo e($project->title); ?></h4>
                                    <p class="text-sm text-gray-600 mt-1"><?php echo e(Str::limit($project->description, 100)); ?></p>
                                    
                                    <div class="flex items-center gap-4 mt-3">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            <?php if($project->status === 'completed'): ?> bg-green-100 text-green-800
                                            <?php elseif($project->status === 'in_progress'): ?> bg-blue-100 text-blue-800
                                            <?php elseif($project->status === 'on_hold'): ?> bg-yellow-100 text-yellow-800
                                            <?php else: ?> bg-gray-100 text-gray-800
                                            <?php endif; ?>">
                                            <?php echo e(ucfirst(str_replace('_', ' ', $project->status))); ?>

                                        </span>
                                        
                                        <span class="text-sm text-gray-600">
                                            <?php echo e($project->tasks->count()); ?> tasks
                                        </span>
                                        
                                        <span class="text-sm text-gray-600">
                                            <?php echo e($project->progress); ?>% complete
                                        </span>
                                    </div>

                                    <div class="mt-3">
                                        <div class="flex items-center justify-between text-sm text-gray-600 mb-1">
                                            <span>Payment Progress</span>
                                            <span class="font-medium"><?php echo e($currency); ?><?php echo e(number_format($project->amount_paid, 2)); ?> / <?php echo e($currency); ?><?php echo e(number_format($project->budget ?? $project->tasks->sum('price'), 2)); ?></span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-green-600 h-2 rounded-full" style="width: <?php echo e($project->payment_progress); ?>%"></div>
                                        </div>
                                    </div>
                                </div>
                                <a href="<?php echo e(route('client.project', $project->id)); ?>" class="ml-4 inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                    View Details
                                </a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Recent Payments & Tasks Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Payments -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Payments</h3>
                    <a href="<?php echo e(route('client.payments')); ?>" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View All</a>
                </div>
            </div>
            <div class="p-6">
                <?php if($payments->isEmpty()): ?>
                    <p class="text-gray-500 text-center py-4">No payments yet</p>
                <?php else: ?>
                    <div class="space-y-3">
                        <?php $__currentLoopData = $payments->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="text-sm font-medium text-gray-900"><?php echo e($payment->project->title); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo e($payment->date->format('M d, Y')); ?></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-semibold text-green-600"><?php echo e($currency); ?><?php echo e(number_format($payment->amount, 2)); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo e(ucfirst($payment->type)); ?></p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Recent Tasks -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Tasks</h3>
                    <a href="<?php echo e(route('client.tasks')); ?>" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View All</a>
                </div>
            </div>
            <div class="p-6">
                <?php if($tasks->isEmpty()): ?>
                    <p class="text-gray-500 text-center py-4">No tasks yet</p>
                <?php else: ?>
                    <div class="space-y-3">
                        <?php $__currentLoopData = $tasks->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900"><?php echo e($task->title); ?></p>
                                    <?php if($task->deadline): ?>
                                        <p class="text-xs text-gray-500">Due: <?php echo e($task->deadline->format('M d, Y')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    <?php if($task->status === 'done'): ?> bg-green-100 text-green-800
                                    <?php elseif($task->status === 'in_progress'): ?> bg-blue-100 text-blue-800
                                    <?php else: ?> bg-gray-100 text-gray-800
                                    <?php endif; ?>">
                                    <?php echo e(ucfirst(str_replace('_', ' ', $task->status))); ?>

                                </span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('client.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Espacegamers\Documents\bendaikh project\resources\views/client/dashboard.blade.php ENDPATH**/ ?>