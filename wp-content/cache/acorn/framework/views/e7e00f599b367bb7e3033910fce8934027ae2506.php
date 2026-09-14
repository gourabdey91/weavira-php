<?php if(!empty($orders)): ?>
  <div class="myaccount-orders-list">
    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="myaccount-order-card">
        <div class="myaccount-order-card-head">
          <div>
            <span class="myaccount-order-number">Order #<?php echo e($order['number']); ?></span>
            <span class="myaccount-order-date"><?php echo e($order['date']); ?></span>
          </div>
          <span class="myaccount-order-status myaccount-order-status--<?php echo e($order['statusSlug']); ?>"><?php echo e($order['status']); ?></span>
        </div>
        <div class="myaccount-order-card-body">
          <span><?php echo e($order['itemCount']); ?> item<?php echo e($order['itemCount'] === 1 ? '' : 's'); ?></span>
          <span class="myaccount-order-total"><?php echo $order['total']; ?></span>
        </div>
        <div class="myaccount-order-card-actions">
          <?php $__currentLoopData = $order['actions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e($action['url']); ?>" class="myaccount-order-action <?php if($action['key'] === 'view'): ?> myaccount-order-action--primary <?php endif; ?>"><?php echo e($action['name']); ?></a>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>

  <?php if($maxPages > 1): ?>
    <div class="myaccount-orders-pagination">
      <?php if($currentPage > 1): ?>
        <a href="<?php echo e(wc_get_endpoint_url('orders', $currentPage - 1)); ?>" class="myaccount-orders-page-link">&larr; Previous</a>
      <?php endif; ?>
      <?php if($currentPage < $maxPages): ?>
        <a href="<?php echo e(wc_get_endpoint_url('orders', $currentPage + 1)); ?>" class="myaccount-orders-page-link">Next &rarr;</a>
      <?php endif; ?>
    </div>
  <?php endif; ?>
<?php else: ?>
  <div class="myaccount-empty-state">
    <i data-lucide="package" aria-hidden="true"></i>
    <p>You haven&rsquo;t placed any orders yet.</p>
    <a href="<?php echo e(wc_get_page_permalink('shop')); ?>" class="myaccount-empty-cta">Start Shopping &#8594;</a>
  </div>
<?php endif; ?>
<?php /**PATH /home/u908449413/domains/weavira.com/public_html/wp-content/themes/weavira/resources/views/woocommerce/myaccount/orders.blade.php ENDPATH**/ ?>