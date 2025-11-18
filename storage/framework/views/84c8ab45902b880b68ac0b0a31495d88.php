

<?php $__env->startSection('title', $proposal->title); ?>
<?php $__env->startSection('page-title', $proposal->title); ?>

<?php $__env->startSection('content'); ?>
<?php
    $language = $language ?? 'en';
    $translations = $translations ?? [];
    $statusLabels = $translations['status_labels'] ?? [];
    $dateFormat = $translations['formats']['date'] ?? 'F d, Y';
?>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Main Info -->
    <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="flex items-start justify-between mb-4">
            <div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-2"><?php echo e($proposal->title); ?></h3>
                <p class="text-gray-500 dark:text-gray-400 mb-1">
                    <span class="font-mono text-sm"><?php echo e($proposal->proposal_number); ?></span>
                </p>
                <p class="text-gray-500 dark:text-gray-400">
                    <?php echo e($translations['client_label'] ?? 'Client'); ?>: <a href="<?php echo e(route('clients.show', $proposal->client)); ?>" class="text-primary-600 dark:text-primary-400 hover:text-primary-700"><?php echo e($proposal->client->name); ?></a>
                </p>
            </div>
            <span class="px-3 py-1 text-sm rounded-full 
                <?php if($proposal->status === 'accepted'): ?> bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                <?php elseif($proposal->status === 'sent'): ?> bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                <?php elseif($proposal->status === 'rejected'): ?> bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                <?php else: ?> bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300
                <?php endif; ?>">
                <?php echo e($statusLabels[$proposal->status] ?? ucfirst($proposal->status)); ?>

            </span>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
            <div>
                <span class="text-gray-500 dark:text-gray-400"><?php echo e($translations['date_label'] ?? 'Date'); ?>:</span>
                <span class="text-gray-900 dark:text-gray-100 font-medium ml-2"><?php echo e($proposal->date->locale($language)->translatedFormat($dateFormat)); ?></span>
            </div>
            <?php if($proposal->valid_until): ?>
                <div>
                    <span class="text-gray-500 dark:text-gray-400"><?php echo e($translations['valid_until_label'] ?? 'Valid Until'); ?>:</span>
                    <span class="text-gray-900 dark:text-gray-100 font-medium ml-2"><?php echo e($proposal->valid_until->locale($language)->translatedFormat($dateFormat)); ?></span>
                </div>
            <?php endif; ?>
        </div>

        <?php if($proposal->notes): ?>
            <div class="mb-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2"><?php echo e($translations['notes_heading'] ?? 'Notes'); ?></h4>
                <p class="text-gray-900 dark:text-gray-100 whitespace-pre-wrap"><?php echo e($proposal->notes); ?></p>
            </div>
        <?php endif; ?>

        <div class="mt-6 flex flex-wrap gap-3">
            <a href="<?php echo e(route('proposals.view-pdf', $proposal)); ?>" target="_blank" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                View PDF (EN)
            </a>
            <a href="<?php echo e(route('proposals.pdf', $proposal)); ?>" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                Download PDF (EN)
            </a>
            <a href="<?php echo e(route('proposals.view-pdf', $proposal)); ?>?lang=fr" target="_blank" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                Voir le PDF (FR)
            </a>
            <a href="<?php echo e(route('proposals.pdf', $proposal)); ?>?lang=fr" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                Télécharger le PDF (FR)
            </a>
            <a href="<?php echo e(route('proposals.edit', $proposal)); ?>" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                Edit Proposal
            </a>
            <form action="<?php echo e(route('proposals.destroy', $proposal)); ?>" method="POST" onsubmit="return confirm('Are you sure?');">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Delete
                </button>
            </form>
        </div>
    </div>

    <!-- Financial Info -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4"><?php echo e($translations['financial_overview_heading'] ?? 'Financial Overview'); ?></h3>
        <dl class="space-y-3">
            <div>
                <dt class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($translations['total_amount_label'] ?? 'Total Amount'); ?></dt>
                <dd class="text-2xl font-bold text-primary-600 dark:text-primary-400"><?php echo e(Auth::user()->currency); ?> <?php echo e(number_format($proposal->total_amount, 2)); ?></dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($translations['services_count_label'] ?? 'Services'); ?></dt>
                <dd class="text-lg font-semibold text-gray-900 dark:text-gray-100"><?php echo e(count($proposal->services)); ?> <?php echo e($translations['services_heading'] ?? 'Services'); ?></dd>
            </div>
        </dl>
    </div>
</div>

<!-- Services Table -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200"><?php echo e($translations['services_heading'] ?? 'Services'); ?></h3>
        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
            <span><?php echo e($translations['language_switch_label'] ?? 'Language'); ?>:</span>
            <div class="inline-flex rounded-lg border border-gray-300 dark:border-gray-600 overflow-hidden">
                <a href="<?php echo e(route('proposals.show', ['proposal' => $proposal, 'lang' => 'en'])); ?>"
                   class="px-3 py-1 <?php echo e($language === 'en' ? 'bg-primary-600 text-white' : 'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200'); ?>">
                    EN
                </a>
                <a href="<?php echo e(route('proposals.show', ['proposal' => $proposal, 'lang' => 'fr'])); ?>"
                   class="px-3 py-1 <?php echo e($language === 'fr' ? 'bg-primary-600 text-white' : 'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200'); ?>">
                    FR
                </a>
            </div>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"><?php echo e($translations['service_label'] ?? 'Service'); ?></th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"><?php echo e($translations['description_label'] ?? 'Description'); ?></th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"><?php echo e($translations['amount_label'] ?? 'Amount'); ?></th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                <?php $__currentLoopData = $proposal->services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                            <?php echo e($service['name']); ?>

                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                            <?php echo e($service['description'] ?? '-'); ?>

                        </td>
                        <?php
                            $lineAmount = $service['total'] ?? ($service['price'] ?? 0);
                        ?>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-gray-100 text-right">
                            <?php echo e(Auth::user()->currency); ?> <?php echo e(number_format($lineAmount, 2)); ?>

                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
            <tfoot class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <td colspan="2" class="px-6 py-4 text-right font-semibold text-gray-800 dark:text-gray-200"><?php echo e($translations['total_amount_label'] ?? 'Total Amount'); ?>:</td>
                    <td class="px-6 py-4 text-right font-bold text-primary-600 dark:text-primary-400 text-lg">
                        <?php echo e(Auth::user()->currency); ?> <?php echo e(number_format($proposal->total_amount, 2)); ?>

                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Espacegamers\Documents\bendaikh project\resources\views/proposals/show.blade.php ENDPATH**/ ?>