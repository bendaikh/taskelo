

<?php $__env->startSection('title', 'Client Login'); ?>

<?php $__env->startSection('content'); ?>
<div class="relative">
    <div class="absolute inset-0 -z-10 bg-gradient-to-br from-blue-600 via-cyan-600 to-teal-500 opacity-20 blur-2xl rounded-3xl"></div>
    <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-xl p-8 border border-white/40">
        <div class="text-center mb-8">
            <div class="mx-auto mb-4 h-12 w-12 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Client Portal</h2>
            <p class="text-gray-600 mt-1">Sign in to view your projects and payments</p>
        </div>

        <form method="POST" action="<?php echo e(route('client.login')); ?>" class="space-y-5">
            <?php echo csrf_field(); ?>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email address</label>
                <div class="relative">
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        value="<?php echo e(old('email')); ?>"
                        required 
                        autofocus
                        autocomplete="email"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M1.5 8.67l1.885-.943A8.25 8.25 0 0112 3.75c3.05 0 5.768 1.6 7.365 3.977l3.135 1.57-3.135 1.57A8.25 8.25 0 0112 16.5a8.25 8.25 0 01-8.615-5.977L1.5 8.67z"/></svg>
                    </div>
                </div>
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                </div>
                <div class="relative">
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        required
                        autocomplete="current-password"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 00-5.25 5.25V9A2.25 2.25 0 004.5 11.25v6A2.25 2.25 0 006.75 19.5h10.5A2.25 2.25 0 0019.5 17.25v-6A2.25 2.25 0 0017.25 9V6.75A5.25 5.25 0 0012 1.5zm-3 7.5V6.75a3 3 0 116 0V9h-6z" clip-rule="evenodd"/></svg>
                    </div>
                </div>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="flex items-center justify-between">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            <button type="submit" class="w-full inline-flex justify-center items-center gap-2 bg-blue-600 text-white py-2.5 px-4 rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd" d="M7.5 3.75A1.5 1.5 0 006 5.25v13.5a1.5 1.5 0 001.5 1.5h6a1.5 1.5 0 001.5-1.5V15a.75.75 0 011.5 0v3.75a3 3 0 01-3 3h-6a3 3 0 01-3-3V5.25a3 3 0 013-3h6a3 3 0 013 3V9A.75.75 0 0115 9V5.25a1.5 1.5 0 00-1.5-1.5h-6zm10.72 4.72a.75.75 0 011.06 0l3 3a.75.75 0 010 1.06l-3 3a.75.75 0 11-1.06-1.06l1.72-1.72H9a.75.75 0 010-1.5h10.94l-1.72-1.72a.75.75 0 010-1.06z" clip-rule="evenodd" />
                </svg>
                Sign in
            </button>
        </form>
        
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Need help accessing your account? Contact support.
            </p>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Espacegamers\Documents\bendaikh project\resources\views/client/auth/login.blade.php ENDPATH**/ ?>