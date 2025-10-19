

<?php $__env->startSection('title', $project->title); ?>
<?php $__env->startSection('page-title', $project->title); ?>

<?php $__env->startSection('content'); ?>
<!-- Project Info -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Main Info -->
    <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="flex items-start justify-between mb-4">
            <div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-2"><?php echo e($project->title); ?></h3>
                <p class="text-gray-500 dark:text-gray-400">
                    Client: <a href="<?php echo e(route('clients.show', $project->client)); ?>" class="text-primary-600 dark:text-primary-400 hover:text-primary-700"><?php echo e($project->client->name); ?></a>
                </p>
            </div>
            <span class="px-3 py-1 text-sm rounded-full 
                <?php if($project->status === 'active'): ?> bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                <?php elseif($project->status === 'completed'): ?> bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                <?php elseif($project->status === 'on_hold'): ?> bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                <?php elseif($project->status === 'cancelled'): ?> bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                <?php else: ?> bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300
                <?php endif; ?>">
                <?php echo e(ucfirst(str_replace('_', ' ', $project->status))); ?>

            </span>
        </div>

        <?php if($project->description): ?>
            <div class="mb-4">
                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Description</h4>
                <p class="text-gray-900 dark:text-gray-100"><?php echo e($project->description); ?></p>
            </div>
        <?php endif; ?>

        <?php if($project->start_date || $project->end_date): ?>
            <div class="flex space-x-6 text-sm">
                <?php if($project->start_date): ?>
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">Start Date:</span>
                        <span class="text-gray-900 dark:text-gray-100 font-medium"><?php echo e($project->start_date->format('M d, Y')); ?></span>
                    </div>
                <?php endif; ?>
                <?php if($project->end_date): ?>
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">End Date:</span>
                        <span class="text-gray-900 dark:text-gray-100 font-medium"><?php echo e($project->end_date->format('M d, Y')); ?></span>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="mt-6 flex space-x-3">
            <a href="<?php echo e(route('projects.edit', $project)); ?>" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Edit Project
            </a>
            <form action="<?php echo e(route('projects.destroy', $project)); ?>" method="POST" onsubmit="return confirm('Are you sure?');">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Delete Project
                </button>
            </form>
        </div>
    </div>

    <!-- Financial Info -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Financial Overview</h3>
        <dl class="space-y-3">
            <div>
                <dt class="text-sm text-gray-500 dark:text-gray-400">Budget</dt>
                <dd class="text-xl font-bold text-gray-900 dark:text-gray-100"><?php echo e(Auth::user()->currency); ?> <?php echo e(number_format($project->budget, 2)); ?></dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500 dark:text-gray-400">Amount Paid</dt>
                <dd class="text-xl font-bold text-green-600"><?php echo e(Auth::user()->currency); ?> <?php echo e(number_format($project->amount_paid, 2)); ?></dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500 dark:text-gray-400">Pending Amount</dt>
                <dd class="text-xl font-bold text-red-600"><?php echo e(Auth::user()->currency); ?> <?php echo e(number_format($project->pending, 2)); ?></dd>
            </div>
        </dl>

        <!-- Payment Progress Bar -->
        <div class="mt-4">
            <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mb-1">
                <span>Payment Progress</span>
                <span><?php echo e($project->payment_progress); ?>%</span>
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                <div class="bg-green-600 h-2 rounded-full" style="width: <?php echo e($project->payment_progress); ?>%"></div>
            </div>
        </div>

        <!-- Task Progress Bar -->
        <div class="mt-4">
            <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mb-1">
                <span>Task Progress</span>
                <span><?php echo e($project->progress); ?>%</span>
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                <div class="bg-primary-600 h-2 rounded-full" style="width: <?php echo e($project->progress); ?>%"></div>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                <?php echo e($project->tasks->where('status', 'done')->count()); ?> / <?php echo e($project->tasks->count()); ?> tasks completed
            </p>
        </div>
    </div>
</div>

<!-- Tasks -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Tasks</h3>
        <button onclick="document.getElementById('add-task-form').classList.toggle('hidden')" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 text-sm">
            + Add Task
        </button>
    </div>

    <!-- Add Task Form -->
    <div id="add-task-form" class="hidden p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
        <form method="POST" action="<?php echo e(route('tasks.store')); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="project_id" value="<?php echo e($project->id); ?>">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <input 
                        type="text" 
                        name="title" 
                        placeholder="Task title"
                        required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
                </div>
                <div>
                    <input 
                        type="date" 
                        name="deadline" 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
                </div>
                <div>
                    <input 
                        type="number" 
                        name="price" 
                        step="0.01" 
                        min="0"
                        placeholder="Price (optional)"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
                </div>
            </div>
            <div class="mt-4">
                <textarea 
                    name="description" 
                    placeholder="Task description (optional)"
                    rows="2"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500"></textarea>
            </div>
            <input type="hidden" name="status" value="todo">
            <div class="mt-4 flex justify-end space-x-2">
                <button type="button" onclick="document.getElementById('add-task-form').classList.add('hidden')" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                    Add Task
                </button>
            </div>
        </form>
    </div>

    <!-- Tasks List -->
    <div id="tasks-container" class="p-6">
        <task-list 
            :project-id="<?php echo e($project->id); ?>" 
            :initial-tasks='<?php echo json_encode($project->tasks, 15, 512) ?>'>
        </task-list>
    </div>
</div>

<!-- Payments -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Payments</h3>
        <a href="<?php echo e(route('payments.create', ['project_id' => $project->id])); ?>" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 text-sm">
            + Add Payment
        </a>
    </div>
    <div class="p-6">
        <?php $__empty_1 = true; $__currentLoopData = $project->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700 last:border-0">
                <div>
                    <p class="font-medium text-gray-800 dark:text-gray-200"><?php echo e(Auth::user()->currency); ?> <?php echo e(number_format($payment->amount, 2)); ?></p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        <?php echo e(ucfirst($payment->type)); ?> • <?php echo e($payment->date->format('M d, Y')); ?>

                    </p>
                    <?php if($payment->notes): ?>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mt-1"><?php echo e($payment->notes); ?></p>
                    <?php endif; ?>
                </div>
                <div class="flex space-x-2">
                    <a href="<?php echo e(route('payments.edit', $payment)); ?>" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 text-sm">Edit</a>
                    <form action="<?php echo e(route('payments.destroy', $payment)); ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 text-sm">Delete</button>
                    </form>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-gray-500 dark:text-gray-400 text-center py-4">No payments yet</p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Espacegamers\Documents\bendaikh project\resources\views/projects/show.blade.php ENDPATH**/ ?>