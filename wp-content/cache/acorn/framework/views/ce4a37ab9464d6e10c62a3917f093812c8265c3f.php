<div class="myaccount-welcome">
  <p>Hello, <strong><?php echo e($current_user->display_name); ?></strong> <span class="myaccount-welcome-sub">(not you? <a href="<?php echo e(wc_logout_url()); ?>">Log out</a>)</span></p>
  <p class="myaccount-welcome-desc">From your account dashboard you can view your <a href="<?php echo e(wc_get_endpoint_url('orders')); ?>">recent orders</a>, manage your <a href="<?php echo e(wc_get_endpoint_url('edit-address')); ?>">billing address</a>, and <a href="<?php echo e(wc_get_endpoint_url('edit-account')); ?>">edit your password and account details</a>.</p>
</div>

<div class="myaccount-quick-links">
  <a href="<?php echo e(wc_get_endpoint_url('orders')); ?>" class="myaccount-quick-link">
    <span class="myaccount-quick-link-icon" aria-hidden="true"><i data-lucide="package"></i></span>
    <span class="myaccount-quick-link-title">Orders</span>
    <span class="myaccount-quick-link-desc">Track and review your past orders</span>
  </a>
  <a href="<?php echo e(wc_get_endpoint_url('edit-address')); ?>" class="myaccount-quick-link">
    <span class="myaccount-quick-link-icon" aria-hidden="true"><i data-lucide="map-pin"></i></span>
    <span class="myaccount-quick-link-title">Address</span>
    <span class="myaccount-quick-link-desc">Update your billing address</span>
  </a>
  <a href="<?php echo e(wc_get_endpoint_url('edit-account')); ?>" class="myaccount-quick-link">
    <span class="myaccount-quick-link-icon" aria-hidden="true"><i data-lucide="user"></i></span>
    <span class="myaccount-quick-link-title">Account Details</span>
    <span class="myaccount-quick-link-desc">Edit your name, email and password</span>
  </a>
  <a href="<?php echo e(wc_get_page_permalink('shop')); ?>" class="myaccount-quick-link">
    <span class="myaccount-quick-link-icon" aria-hidden="true"><i data-lucide="shopping-bag"></i></span>
    <span class="myaccount-quick-link-title">Continue Shopping</span>
    <span class="myaccount-quick-link-desc">Explore the Weavira collection</span>
  </a>
</div>

<?php if(!empty($recentOrder)): ?>
  <div class="myaccount-recent-order">
    <div class="myaccount-recent-order-head">
      <h2>Your Most Recent Order</h2>
      <a href="<?php echo e($recentOrder['viewUrl']); ?>" class="myaccount-recent-order-view">View Order &#8594;</a>
    </div>
    <div class="myaccount-recent-order-row">
      <span>Order</span>
      <strong><?php echo e($recentOrder['number']); ?></strong>
    </div>
    <div class="myaccount-recent-order-row">
      <span>Date</span>
      <strong><?php echo e($recentOrder['date']); ?></strong>
    </div>
    <div class="myaccount-recent-order-row">
      <span>Status</span>
      <strong class="myaccount-order-status myaccount-order-status--<?php echo e($recentOrder['statusSlug']); ?>"><?php echo e($recentOrder['status']); ?></strong>
    </div>
    <div class="myaccount-recent-order-row">
      <span>Total</span>
      <strong><?php echo $recentOrder['total']; ?></strong>
    </div>
  </div>
<?php endif; ?>
<?php /**PATH C:\Users\Admin\Local Sites\weavira\app\public\wp-content\themes\weavira\resources\views/woocommerce/myaccount/dashboard.blade.php ENDPATH**/ ?>