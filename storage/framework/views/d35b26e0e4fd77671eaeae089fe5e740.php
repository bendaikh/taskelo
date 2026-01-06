

<?php $__env->startSection('title', 'Edit Workspace'); ?>
<?php $__env->startSection('page-title', 'Edit Workspace'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Edit Workspace</h2>

        <form method="POST" action="<?php echo e(route('workspaces.update', $workspace)); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <!-- Workspace Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Workspace Name *
                </label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    value="<?php echo e(old('name', $workspace->name)); ?>"
                    required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Workspace Type -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Workspace Type *
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4" x-data="{ selectedType: '<?php echo e(old('type', $workspace->type)); ?>' }">
                    <!-- Personal Option -->
                    <label 
                        @click="selectedType = 'personal'"
                        class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer transition-colors"
                        :class="selectedType === 'personal' ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-gray-300 dark:border-gray-600 hover:border-gray-400 dark:hover:border-gray-500'">
                        <input 
                            type="radio" 
                            name="type" 
                            value="personal" 
                            x-model="selectedType"
                            <?php echo e(old('type', $workspace->type) === 'personal' ? 'checked' : ''); ?>

                            class="sr-only">
                        <div class="flex items-center space-x-3">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <div>
                                <span class="block font-semibold text-gray-900 dark:text-white">Personal</span>
                                <span class="block text-xs text-gray-600 dark:text-gray-400">For personal revenue tracking</span>
                            </div>
                        </div>
                        <svg 
                            x-show="selectedType === 'personal'"
                            class="absolute top-2 right-2 w-5 h-5 text-blue-600 dark:text-blue-400" 
                            fill="currentColor" 
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </label>

                    <!-- Business Option -->
                    <label 
                        @click="selectedType = 'business'"
                        class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer transition-colors"
                        :class="selectedType === 'business' ? 'border-purple-500 bg-purple-50 dark:bg-purple-900/20' : 'border-gray-300 dark:border-gray-600 hover:border-gray-400 dark:hover:border-gray-500'">
                        <input 
                            type="radio" 
                            name="type" 
                            value="business" 
                            x-model="selectedType"
                            <?php echo e(old('type', $workspace->type) === 'business' ? 'checked' : ''); ?>

                            class="sr-only">
                        <div class="flex items-center space-x-3">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <div>
                                <span class="block font-semibold text-gray-900 dark:text-white">Business</span>
                                <span class="block text-xs text-gray-600 dark:text-gray-400">For clients, projects & payments</span>
                            </div>
                        </div>
                        <svg 
                            x-show="selectedType === 'business'"
                            class="absolute top-2 right-2 w-5 h-5 text-purple-600 dark:text-purple-400" 
                            fill="currentColor" 
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </label>
                </div>
                <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                    <strong>Note:</strong> Changing workspace type will affect which features are available. Personal workspaces show Revenue & Revenue Categories, while Business workspaces show Projects, Clients, Payments, Proposals, and Conception.
                </p>
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Description (Optional)
                </label>
                <textarea 
                    name="description" 
                    id="description" 
                    rows="4"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"><?php echo e(old('description', $workspace->description)); ?></textarea>
                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Active Status -->
            <div class="mb-6">
                <label class="flex items-center">
                    <input 
                        type="checkbox" 
                        name="is_active" 
                        value="1"
                        <?php echo e(old('is_active', $workspace->is_active) ? 'checked' : ''); ?>

                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Workspace is active</span>
                </label>
            </div>

            <!-- Actions -->
            <div class="flex items-center space-x-4">
                <button 
                    type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    Update Workspace
                </button>
                <a 
                    href="<?php echo e(route('workspaces.index')); ?>" 
                    class="px-6 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors font-medium">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Espacegamers\Documents\bendaikh project\resources\views/workspaces/edit.blade.php ENDPATH**/ ?>