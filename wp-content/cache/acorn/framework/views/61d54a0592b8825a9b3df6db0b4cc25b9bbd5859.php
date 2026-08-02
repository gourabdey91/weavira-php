<nav class="w-pdp-breadcrumb" aria-label="Breadcrumb">
  <div class="breadcrumb-trail">
    <a href="<?php echo e(home_url('/')); ?>">Home</a>
    <?php if($breadcrumbCategory): ?>
      <span class="bc-sep" aria-hidden="true">&#8250;</span>
      <a href="<?php echo e(get_term_link($breadcrumbCategory)); ?>"><?php echo e($breadcrumbCategory->name); ?></a>
    <?php endif; ?>
    <span class="bc-sep" aria-hidden="true">&#8250;</span>
    <span class="bc-current"><?php echo e($product->get_name()); ?></span>
  </div>
</nav>
<?php /**PATH C:\Users\Admin\Local Sites\weavira\app\public\wp-content\themes\weavira\resources\views/partials/product/breadcrumb.blade.php ENDPATH**/ ?>