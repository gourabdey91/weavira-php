<nav class="myaccount-nav-card" aria-label="Account pages">
  <ul>
    <?php $__currentLoopData = wc_get_account_menu_items(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $endpoint => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <li class="myaccount-nav-item <?php if(wc_is_current_account_menu_item($endpoint)): ?> is-active <?php endif; ?>">
        <a href="<?php echo e(wc_get_account_endpoint_url($endpoint)); ?>" <?php if(wc_is_current_account_menu_item($endpoint)): ?> aria-current="page" <?php endif; ?>>
          <?php echo e($label); ?>

        </a>
      </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </ul>
</nav>
<?php /**PATH C:\Users\Admin\Local Sites\weavira\app\public\wp-content\themes\weavira\resources\views/woocommerce/myaccount/navigation.blade.php ENDPATH**/ ?>