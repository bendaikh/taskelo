

<?php $__env->startSection('title', 'Projects'); ?>
<?php $__env->startSection('page-title', 'Projects'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-center space-y-4 md:space-y-0">
    <!-- Filters -->
    <form method="GET" action="<?php echo e(route('projects.index')); ?>" class="flex flex-wrap items-center gap-2">
        <input 
            type="text" 
            name="search" 
            placeholder="Search projects..." 
            value="<?php echo e(request('search')); ?>"
            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
        
        <select 
            name="status" 
            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
            <option value="">All Status</option>
            <option value="planning" <?php echo e(request('status') === 'planning' ? 'selected' : ''); ?>>Planning</option>
            <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>Active</option>
            <option value="on_hold" <?php echo e(request('status') === 'on_hold' ? 'selected' : ''); ?>>On Hold</option>
            <option value="completed" <?php echo e(request('status') === 'completed' ? 'selected' : ''); ?>>Completed</option>
            <option value="cancelled" <?php echo e(request('status') === 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
        </select>

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

        <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
            Filter
        </button>
        
        <?php if(request()->hasAny(['search', 'status', 'client_id'])): ?>
            <a href="<?php echo e(route('projects.index')); ?>" class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500">
                Clear
            </a>
        <?php endif; ?>
    </form>

    <!-- Add Project Button -->
    <a href="<?php echo e(route('projects.create')); ?>" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
        + Add Project
    </a>
</div>

<!-- Projects Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php $__empty_1 = true; $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-lg transition-shadow">
            <div class="p-6">
                <!-- Header -->
                <div class="flex items-start justify-between mb-4">
                    <a href="<?php echo e(route('projects.show', $project)); ?>" class="text-lg font-semibold text-gray-800 dark:text-gray-200 hover:text-primary-600">
                        <?php echo e($project->title); ?>

                    </a>
                    <span class="px-2 py-1 text-xs rounded-full whitespace-nowrap
                        <?php if($project->status === 'active'): ?> bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                        <?php elseif($project->status === 'completed'): ?> bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                        <?php elseif($project->status === 'on_hold'): ?> bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                        <?php elseif($project->status === 'cancelled'): ?> bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                        <?php else: ?> bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300
                        <?php endif; ?>">
                        <?php echo e(ucfirst(str_replace('_', ' ', $project->status))); ?>

                    </span>
                </div>

                <!-- Client -->
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                    <a href="<?php echo e(route('clients.show', $project->client)); ?>" class="hover:text-primary-600">
                        <?php echo e($project->client->name); ?>

                    </a>
                </p>

                <!-- Budget Info -->
                <div class="space-y-2 mb-4 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Budget:</span>
                        <span class="text-gray-900 dark:text-gray-100 font-medium"><?php echo e(Auth::user()->currency); ?> <?php echo e(number_format($project->budget, 2)); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Paid:</span>
                        <span class="text-green-600 font-medium"><?php echo e(Auth::user()->currency); ?> <?php echo e(number_format($project->amount_paid, 2)); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Pending:</span>
                        <span class="text-red-600 font-medium"><?php echo e(Auth::user()->currency); ?> <?php echo e(number_format($project->pending, 2)); ?></span>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="mb-4">
                    <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mb-1">
                        <span>Progress</span>
                        <span><?php echo e($project->progress); ?>%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-primary-600 h-2 rounded-full transition-all" style="width: <?php echo e($project->progress); ?>%"></div>
                    </div>
                </div>

                <!-- Dates -->
                <?php if($project->start_date || $project->end_date): ?>
                    <div class="text-xs text-gray-500 dark:text-gray-400 mb-4">
                        <?php if($project->start_date): ?>
                            Start: <?php echo e($project->start_date->format('M d, Y')); ?>

                        <?php endif; ?>
                        <?php if($project->start_date && $project->end_date): ?> | <?php endif; ?>
                        <?php if($project->end_date): ?>
                            End: <?php echo e($project->end_date->format('M d, Y')); ?>

                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Actions -->
                <div class="flex justify-between items-center pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="<?php echo e(route('projects.show', $project)); ?>" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 text-sm font-medium">
                        View Details →
                    </a>
                    <div class="flex space-x-2">
                        <a href="<?php echo e(route('projects.edit', $project)); ?>" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 text-sm">Edit</a>
                        <form action="<?php echo e(route('projects.destroy', $project)); ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 text-sm">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-full text-center py-12 bg-white dark:bg-gray-800 rounded-lg shadow">
            <p class="text-gray-500 dark:text-gray-400 mb-4">No projects found.</p>
            <a href="<?php echo e(route('projects.create')); ?>" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 font-medium">
                Add your first project
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- Pagination -->
<div class="mt-6">
    <?php echo e($projects->links()); ?>

</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Espacegamers\Documents\bendaikh project\resources\views/projects/index.blade.php ENDPATH**/ ?>