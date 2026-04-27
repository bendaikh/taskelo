

<?php $__env->startSection('title', 'Tasks - Client Portal'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900">All Tasks</h2>
    </div>

    <?php if($tasks->isEmpty()): ?>
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mx-auto text-gray-400 mb-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
            </svg>
            <p class="text-lg text-gray-500">No tasks yet</p>
            <p class="text-sm text-gray-400 mt-2">Tasks from your projects will appear here</p>
        </div>
    <?php else: ?>
        <div class="space-y-3">
            <?php
                $groupedTasks = $tasks->groupBy(function($task) {
                    return $task->status;
                });
                $statusOrder = ['pending', 'in_progress', 'done'];
            ?>

            <?php $__currentLoopData = $statusOrder; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(isset($groupedTasks[$status]) && $groupedTasks[$status]->count() > 0): ?>
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    <?php echo e(ucfirst(str_replace('_', ' ', $status))); ?>

                                    <span class="ml-2 text-sm text-gray-500">(<?php echo e($groupedTasks[$status]->count()); ?>)</span>
                                </h3>
                            </div>
                        </div>
                        <div class="p-6 space-y-3">
                            <?php $__currentLoopData = $groupedTasks[$status]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-2">
                                                <h4 class="text-base font-medium text-gray-900"><?php echo e($task->title); ?></h4>
                                            </div>
                                            
                                            <?php if($task->description): ?>
                                                <p class="text-sm text-gray-600 mb-3"><?php echo e($task->description); ?></p>
                                            <?php endif; ?>

                                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                                                <?php if($task->project): ?>
                                                    <a href="<?php echo e(route('client.project', $task->project_id)); ?>" class="inline-flex items-center text-blue-600 hover:text-blue-700">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-1">
                                                            <path fill-rule="evenodd" d="M2.25 6a3 3 0 013-3h13.5a3 3 0 013 3v12a3 3 0 01-3 3H5.25a3 3 0 01-3-3V6zm3.97.97a.75.75 0 011.06 0l2.25 2.25a.75.75 0 010 1.06l-2.25 2.25a.75.75 0 01-1.06-1.06l1.72-1.72-1.72-1.72a.75.75 0 010-1.06zm4.28 4.28a.75.75 0 000 1.5h5.25a.75.75 0 000-1.5H10.5z" clip-rule="evenodd" />
                                                        </svg>
                                                        <?php echo e($task->project->title); ?>

                                                    </a>
                                                <?php endif; ?>

                                                <?php if($task->deadline): ?>
                                                    <span class="inline-flex items-center <?php echo e($task->is_overdue ? 'text-red-600' : ''); ?>">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-1">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" />
                                                        </svg>
                                                        Due: <?php echo e($task->deadline->format('M d, Y')); ?>

                                                        <?php if($task->is_overdue): ?>
                                                            <span class="ml-1 text-xs font-medium">(Overdue)</span>
                                                        <?php endif; ?>
                                                    </span>
                                                <?php endif; ?>

                                                <?php if($task->price): ?>
                                                    <span class="inline-flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-1">
                                                            <path d="M10.75 10.818v2.614A3.13 3.13 0 0011.888 13c.482-.315.612-.648.612-.875 0-.227-.13-.56-.612-.875a3.13 3.13 0 00-1.138-.432zM8.33 8.62c.053.055.115.11.184.164.208.16.46.284.736.363V6.603a2.45 2.45 0 00-.35.13c-.14.065-.27.143-.386.233-.377.292-.514.627-.514.909 0 .184.058.39.202.592.037.051.08.102.128.152z" />
                                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-6a.75.75 0 01.75.75v.316a3.78 3.78 0 011.653.713c.426.33.744.74.925 1.2a.75.75 0 01-1.395.55 1.35 1.35 0 00-.447-.563 2.187 2.187 0 00-.736-.363V9.3c.698.093 1.383.32 1.959.696.787.514 1.29 1.27 1.29 2.13 0 .86-.504 1.616-1.29 2.13-.576.377-1.261.603-1.96.696v.299a.75.75 0 11-1.5 0v-.3c-.697-.092-1.382-.318-1.958-.695-.482-.315-.857-.717-1.078-1.188a.75.75 0 111.359-.636c.08.173.245.376.54.569.313.205.706.353 1.138.432v-2.748a3.782 3.782 0 01-1.653-.713C6.9 9.433 6.5 8.681 6.5 7.875c0-.805.4-1.558 1.097-2.096a3.78 3.78 0 011.653-.713V4.75A.75.75 0 0110 4z" clip-rule="evenodd" />
                                                        </svg>
                                                        <?php echo e($currency); ?><?php echo e(number_format($task->price, 2)); ?>

                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <span class="ml-4 inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                            <?php if($task->status === 'done'): ?> bg-green-100 text-green-800
                                            <?php elseif($task->status === 'in_progress'): ?> bg-blue-100 text-blue-800
                                            <?php else: ?> bg-gray-100 text-gray-800
                                            <?php endif; ?>">
                                            <?php echo e(ucfirst(str_replace('_', ' ', $task->status))); ?>

                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('client.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Espacegamers\Documents\bendaikh project\resources\views/client/tasks.blade.php ENDPATH**/ ?>