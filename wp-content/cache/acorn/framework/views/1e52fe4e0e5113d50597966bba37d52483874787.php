
<?php echo $__env->make('sections.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<main id="main">
    <?php echo $__env->yieldContent('content'); ?>
</main>

<?php if (! empty(trim($__env->yieldContent('sidebar')))): ?>
    <aside class="sidebar">
        <?php echo $__env->yieldContent('sidebar'); ?>
    </aside>
<?php endif; ?>

<?php echo $__env->make('sections.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('partials.search-overlay', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('partials.cart-toast', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH C:\Users\Admin\Local Sites\weavira\app\public\wp-content\themes\weavira\resources\views/layouts/app.blade.php ENDPATH**/ ?>