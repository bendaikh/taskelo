

<?php $__env->startSection('title', 'Create Proposal'); ?>
<?php $__env->startSection('page-title', 'Create Proposal'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <form method="POST" action="<?php echo e(route('proposals.store')); ?>" id="proposalForm">
            <?php echo csrf_field(); ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Client -->
                <div>
                    <label for="client_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Client</label>
                    <select 
                        name="client_id" 
                        id="client_id" 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 <?php $__errorArgs = ['client_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <option value="">Select a client (optional)</option>
                        <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($client->id); ?>" <?php echo e(old('client_id') == $client->id ? 'selected' : ''); ?>>
                                <?php echo e($client->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['client_id'];
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

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Title *</label>
                    <input 
                        type="text" 
                        name="title" 
                        id="title" 
                        value="<?php echo e(old('title')); ?>"
                        required
                        placeholder="e.g., Website Development Proposal"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['title'];
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

                <!-- Date -->
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Date *</label>
                    <input 
                        type="date" 
                        name="date" 
                        id="date" 
                        value="<?php echo e(old('date', date('Y-m-d'))); ?>"
                        required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
                </div>

                <!-- Valid Until -->
                <div>
                    <label for="valid_until" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Valid Until</label>
                    <input 
                        type="date" 
                        name="valid_until" 
                        id="valid_until" 
                        value="<?php echo e(old('valid_until')); ?>"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
                </div>

                <!-- Status -->
                <div class="md:col-span-2">
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                    <select 
                        name="status" 
                        id="status" 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
                        <option value="draft" <?php echo e(old('status', 'draft') === 'draft' ? 'selected' : ''); ?>>Draft</option>
                        <option value="sent" <?php echo e(old('status') === 'sent' ? 'selected' : ''); ?>>Sent</option>
                        <option value="accepted" <?php echo e(old('status') === 'accepted' ? 'selected' : ''); ?>>Accepted</option>
                        <option value="rejected" <?php echo e(old('status') === 'rejected' ? 'selected' : ''); ?>>Rejected</option>
                    </select>
                </div>
            </div>

            <!-- Services Section -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Services *</h3>
                    <button type="button" onclick="addService()" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 text-sm">
                        + Add Service
                    </button>
                </div>

                <div id="services-container" class="space-y-4">
                    <!-- Services will be added here dynamically -->
                </div>

                <?php $__errorArgs = ['services'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <?php $__errorArgs = ['services.*'];
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

            <!-- Total Amount -->
            <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-semibold text-gray-800 dark:text-gray-200">Total Amount:</span>
                    <span class="text-2xl font-bold text-primary-600 dark:text-primary-400" id="total-amount">
                        <?php echo e(Auth::user()->currency); ?> 0.00
                    </span>
                </div>
            </div>

            <!-- Notes -->
            <div class="mb-6">
                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Notes</label>
                <textarea 
                    name="notes" 
                    id="notes" 
                    rows="4"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500"><?php echo e(old('notes')); ?></textarea>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-3">
                <a href="<?php echo e(route('proposals.index')); ?>" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                    Create Proposal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let serviceIndex = 0;

function addService(serviceData = null) {
    const container = document.getElementById('services-container');
    const serviceDiv = document.createElement('div');
    serviceDiv.className = 'p-4 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700';
    serviceDiv.id = `service-${serviceIndex}`;

    const nameValue = serviceData ? (serviceData.name || '') : '';
    const description = serviceData ? (serviceData.description || '') : '';
    const safeDescription = description.replace(/'/g, "\\'");
    const baseAmount = serviceData
        ? (serviceData.total !== undefined
            ? serviceData.total
            : (serviceData.price !== undefined ? serviceData.price : 0))
        : 0;

    serviceDiv.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
            <div class="md:col-span-5">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Service Name *</label>
                <input 
                    type="text" 
                    name="services[${serviceIndex}][name]" 
                    value="${nameValue}"
                    required
                    placeholder="e.g., Website Design"
                    onchange="calculateTotal()"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
            </div>
            <div class="md:col-span-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                <input 
                    type="text" 
                    name="services[${serviceIndex}][description]" 
                    value="${safeDescription}"
                    placeholder="Brief description"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Amount *</label>
                <input 
                    type="number" 
                    name="services[${serviceIndex}][price]" 
                    value="${baseAmount}"
                    step="0.01"
                    min="0"
                    required
                    onchange="calculateTotal()"
                    oninput="calculateTotal()"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
            </div>
            <div class="md:col-span-1 flex items-end">
                <button 
                    type="button" 
                    onclick="removeService(${serviceIndex})" 
                    class="w-full px-3 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    ×
                </button>
            </div>
        </div>
        <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            Amount: <span class="font-semibold service-total" id="service-total-${serviceIndex}"><?php echo e(Auth::user()->currency); ?> 0.00</span>
        </div>
    `;
    
    container.appendChild(serviceDiv);
    serviceIndex++;
    calculateTotal();
}

function removeService(index) {
    const serviceDiv = document.getElementById(`service-${index}`);
    if (serviceDiv) {
        serviceDiv.remove();
        calculateTotal();
    }
}

function calculateTotal() {
    let total = 0;
    const services = document.querySelectorAll('[id^="service-"]');
    
    services.forEach(serviceDiv => {
        const amountInput = serviceDiv.querySelector('input[name*="[price]"]');
        const serviceTotalSpan = serviceDiv.querySelector('.service-total');
        
        if (amountInput) {
            const amount = parseFloat(amountInput.value) || 0;
            total += amount;
            
            if (serviceTotalSpan) {
                serviceTotalSpan.textContent = '<?php echo e(Auth::user()->currency); ?> ' + amount.toFixed(2);
            }
        }
    });
    
    document.getElementById('total-amount').textContent = '<?php echo e(Auth::user()->currency); ?> ' + total.toFixed(2);
}

// Add services on page load (old input or default)
document.addEventListener('DOMContentLoaded', function() {
    const existingServices = <?php echo json_encode(old('services', []), 512) ?>;
    if (existingServices && existingServices.length) {
        existingServices.forEach(service => addService(service));
    } else {
        addService();
    }
});
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Espacegamers\Documents\bendaikh project\resources\views/proposals/create.blade.php ENDPATH**/ ?>