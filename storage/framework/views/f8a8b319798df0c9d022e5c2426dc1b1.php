

<?php $__env->startSection('title', 'Create Conception'); ?>
<?php $__env->startSection('page-title', 'Create Conception'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <form method="POST" action="<?php echo e(route('conceptions.store')); ?>" id="conception-form">
            <?php echo csrf_field(); ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Title -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Conception Title *</label>
                    <input 
                        type="text" 
                        name="title" 
                        id="title" 
                        value="<?php echo e(old('title')); ?>"
                        required
                        placeholder="e.g., E-commerce Website Development"
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

                <!-- Client -->
                <div>
                    <label for="client_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Client</label>
                    <select 
                        name="client_id" 
                        id="client_id"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
                        <option value="">No client (General conception)</option>
                        <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($client->id); ?>" <?php echo e(old('client_id') == $client->id ? 'selected' : ''); ?>>
                                <?php echo e($client->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- Date -->
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Date *</label>
                    <input 
                        type="date" 
                        name="date" 
                        id="date" 
                        value="<?php echo e(old('date', now()->format('Y-m-d'))); ?>"
                        required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['date'];
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

                <!-- Currency -->
                <div>
                    <label for="currency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Currency *</label>
                    <select 
                        name="currency" 
                        id="currency" 
                        required
                        onchange="updateCurrencyDisplay()"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 <?php $__errorArgs = ['currency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <option value="USD" <?php echo e(old('currency', 'USD') === 'USD' ? 'selected' : ''); ?>>USD ($)</option>
                        <option value="EUR" <?php echo e(old('currency') === 'EUR' ? 'selected' : ''); ?>>EUR (€)</option>
                        <option value="GBP" <?php echo e(old('currency') === 'GBP' ? 'selected' : ''); ?>>GBP (£)</option>
                        <option value="JPY" <?php echo e(old('currency') === 'JPY' ? 'selected' : ''); ?>>JPY (¥)</option>
                        <option value="INR" <?php echo e(old('currency') === 'INR' ? 'selected' : ''); ?>>INR (₹)</option>
                        <option value="AUD" <?php echo e(old('currency') === 'AUD' ? 'selected' : ''); ?>>AUD (A$)</option>
                        <option value="CAD" <?php echo e(old('currency') === 'CAD' ? 'selected' : ''); ?>>CAD (C$)</option>
                        <option value="MAD" <?php echo e(old('currency') === 'MAD' ? 'selected' : ''); ?>>MAD (Dhs)</option>
                        <option value="PHP" <?php echo e(old('currency') === 'PHP' ? 'selected' : ''); ?>>PHP (₱)</option>
                        <option value="NGN" <?php echo e(old('currency') === 'NGN' ? 'selected' : ''); ?>>NGN (₦)</option>
                        <option value="PKR" <?php echo e(old('currency') === 'PKR' ? 'selected' : ''); ?>>PKR (₨)</option>
                        <option value="BDT" <?php echo e(old('currency') === 'BDT' ? 'selected' : ''); ?>>BDT (৳)</option>
                        <option value="XOF" <?php echo e(old('currency') === 'XOF' ? 'selected' : ''); ?>>CFA (FCFA)</option>
                        <option value="XAF" <?php echo e(old('currency') === 'XAF' ? 'selected' : ''); ?>>CFA Central (FCFA)</option>
                    </select>
                    <?php $__errorArgs = ['currency'];
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

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                    <textarea 
                        name="description" 
                        id="description" 
                        rows="3"
                        placeholder="Brief description of the project..."
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500"><?php echo e(old('description')); ?></textarea>
                </div>
            </div>

            <!-- Sections -->
            <div class="mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Project Sections *</h3>
                    <button type="button" onclick="addSection()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm">
                        + Add Section
                    </button>
                </div>

                <div id="sections-container" class="space-y-4">
                    <!-- Sections will be added here dynamically -->
                </div>

                <!-- Remise -->
                <div class="mt-4 p-4 border border-gray-200 dark:border-gray-600 rounded-lg">
                    <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-3">Remise (optional)</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="remise_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Type</label>
                            <select
                                name="remise_type"
                                id="remise_type"
                                onchange="updateTotal()"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
                                <option value="fixed" <?php echo e(old('remise_type', 'fixed') === 'fixed' ? 'selected' : ''); ?>>Fixed amount</option>
                                <option value="percent" <?php echo e(old('remise_type') === 'percent' ? 'selected' : ''); ?>>Percentage (%)</option>
                            </select>
                        </div>
                        <div>
                            <label for="remise" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Value</label>
                            <input
                                type="number"
                                name="remise"
                                id="remise"
                                value="<?php echo e(old('remise', 0)); ?>"
                                min="0"
                                step="0.01"
                                onchange="updateTotal()"
                                oninput="updateTotal()"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 <?php $__errorArgs = ['remise'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['remise'];
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
                    </div>
                </div>

                <div id="total-price-container" class="mt-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg space-y-2">
                    <div class="flex items-center justify-between text-gray-700 dark:text-gray-300">
                        <span>Subtotal:</span>
                        <span id="subtotal-price"><span class="currency-symbol">USD</span> 0.00</span>
                    </div>
                    <div id="remise-row" class="flex items-center justify-between text-red-600 dark:text-red-400 hidden">
                        <span>Remise:</span>
                        <span id="remise-amount">-<span class="currency-symbol">USD</span> 0.00</span>
                    </div>
                    <div class="flex items-center justify-between pt-2 border-t border-gray-300 dark:border-gray-600">
                        <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">Total Price:</span>
                        <span id="total-price" class="text-2xl font-bold text-primary-600 dark:text-primary-400">
                            <span class="currency-symbol">USD</span> 0.00
                        </span>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="mb-6">
                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Notes</label>
                <textarea 
                    name="notes" 
                    id="notes" 
                    rows="3"
                    placeholder="Any additional notes or terms..."
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500"><?php echo e(old('notes')); ?></textarea>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row justify-end gap-3">
                <a href="<?php echo e(route('conceptions.index')); ?>" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 text-center">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                    Create Conception
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let sectionCount = 0;

function getCurrentCurrency() {
    return document.getElementById('currency').value;
}

function updateCurrencyDisplay() {
    const currency = getCurrentCurrency();
    document.querySelectorAll('.currency-symbol').forEach(el => {
        el.textContent = currency;
    });

    const currencyLabels = document.querySelectorAll('.currency-label');
    currencyLabels.forEach(label => {
        label.textContent = currency;
    });

    updateTotal();
}

function getRemiseAmount(subtotal) {
    const remise = parseFloat(document.getElementById('remise').value) || 0;
    const remiseType = document.getElementById('remise_type').value;

    if (remise <= 0 || subtotal <= 0) {
        return 0;
    }

    if (remiseType === 'percent') {
        return Math.min(subtotal, subtotal * Math.min(remise, 100) / 100);
    }

    return Math.min(remise, subtotal);
}

function addSection() {
    sectionCount++;
    const container = document.getElementById('sections-container');
    const currency = getCurrentCurrency();
    const sectionHtml = `
        <div class="section-item p-4 border-2 border-gray-300 dark:border-gray-600 rounded-lg relative" id="section-${sectionCount}">
            <button type="button" onclick="removeSection(${sectionCount})" class="absolute top-2 right-2 text-red-600 hover:text-red-800 dark:text-red-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Section Name *</label>
                    <input 
                        type="text" 
                        name="sections[${sectionCount}][name]" 
                        required
                        placeholder="e.g., User Authentication System"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                    <textarea 
                        name="sections[${sectionCount}][description]" 
                        rows="2"
                        placeholder="What's included in this section..."
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500"></textarea>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Price (optional)</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-500 dark:text-gray-400 currency-label">${currency}</span>
                            <input 
                                type="number" 
                                name="sections[${sectionCount}][price]" 
                                min="0"
                                step="0.01"
                                placeholder="0.00"
                                onchange="updateTotal()"
                                oninput="updateTotal()"
                                class="section-price w-full pl-16 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Time Range (optional)</label>
                        <input 
                            type="text" 
                            name="sections[${sectionCount}][time_range]" 
                            placeholder="e.g., 2-3 weeks, 5 days, 10 hours"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500">
                    </div>
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', sectionHtml);
}

function removeSection(id) {
    const section = document.getElementById(`section-${id}`);
    if (section) {
        section.remove();
        updateTotal();
    }
}

function updateTotal() {
    const prices = document.querySelectorAll('.section-price');
    let subtotal = 0;

    prices.forEach(priceInput => {
        subtotal += parseFloat(priceInput.value) || 0;
    });

    const currency = getCurrentCurrency();
    const remiseAmount = getRemiseAmount(subtotal);
    const total = Math.max(0, subtotal - remiseAmount);

    document.getElementById('subtotal-price').innerHTML = `<span class="currency-symbol">${currency}</span> ${subtotal.toFixed(2)}`;
    document.getElementById('total-price').innerHTML = `<span class="currency-symbol">${currency}</span> ${total.toFixed(2)}`;

    const remiseRow = document.getElementById('remise-row');
    if (remiseAmount > 0) {
        remiseRow.classList.remove('hidden');
        document.getElementById('remise-amount').innerHTML = `-<span class="currency-symbol">${currency}</span> ${remiseAmount.toFixed(2)}`;
    } else {
        remiseRow.classList.add('hidden');
    }
}

// Add initial section on page load
window.addEventListener('DOMContentLoaded', function() {
    addSection();
    updateCurrencyDisplay();
});

// Validate form before submission
document.getElementById('conception-form').addEventListener('submit', function(e) {
    const sectionsContainer = document.getElementById('sections-container');
    if (sectionsContainer.children.length === 0) {
        e.preventDefault();
        alert('Please add at least one section to the conception.');
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Espacegamers\Documents\bendaikh project\resources\views/conceptions/create.blade.php ENDPATH**/ ?>