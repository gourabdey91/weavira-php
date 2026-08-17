<?php $__env->startSection('content'); ?>
  <?php while(have_posts()): ?> <?php (the_post()); ?>
    <main class="page-shell thankyou-page">

      <nav class="wl-breadcrumb" aria-label="Breadcrumb">
        <a href="<?php echo e(home_url('/')); ?>">Home</a>
        <span aria-hidden="true">&rsaquo;</span>
        <span aria-current="page"><?php echo e(function_exists('is_order_received_page') && is_order_received_page() ? 'Order Confirmation' : 'Checkout'); ?></span>
      </nav>

      <?php echo $__env->first(['partials.content-page', 'partials.content'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </main>
  <?php endwhile; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Admin\Local Sites\weavira\app\public\wp-content\themes\weavira\resources\views/page-checkout.blade.php ENDPATH**/ ?>