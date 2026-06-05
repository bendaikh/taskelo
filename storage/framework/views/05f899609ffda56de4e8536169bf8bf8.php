<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['text' => '', 'forPdf' => false]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['text' => '', 'forPdf' => false]); ?>
<?php foreach (array_filter((['text' => '', 'forPdf' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $isArabic = \App\Support\ArabicText::containsArabic($text);
    $displayText = $forPdf ? \App\Support\ArabicText::forPdf($text) : $text;
?>

<?php if($isArabic): ?>
    <span <?php echo e($attributes->merge(['class' => 'arabic-text', 'dir' => $forPdf ? 'ltr' : 'rtl'])); ?>>
        <?php echo e($displayText); ?>

    </span>
<?php else: ?>
    <span <?php echo e($attributes); ?>>
        <?php echo e($displayText); ?>

    </span>
<?php endif; ?>
<?php /**PATH C:\Users\Espacegamers\Documents\bendaikh project\resources\views/components/arabic-text.blade.php ENDPATH**/ ?>