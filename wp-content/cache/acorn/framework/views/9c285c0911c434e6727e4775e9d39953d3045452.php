<p class="myaccount-addresses-intro">The following addresses will be used on the checkout page by default.</p>

<?php if($addresses['showShipping']): ?>
  <div class="myaccount-shipping-book">
    <div class="myaccount-shipping-book-head">
      <h2 class="myaccount-shipping-book-title">Shipping Addresses</h2>
      <a href="<?php echo e($addresses['addShippingUrl']); ?>" class="myaccount-address-edit">+ Add new address</a>
    </div>

    <?php if(empty($addresses['shippingAddresses'])): ?>
      <p class="myaccount-address-empty">You have not saved any shipping addresses yet &mdash; add a Home, Office, or any other address for faster checkout.</p>
    <?php else: ?>
      <div class="myaccount-addresses myaccount-addresses--two-col">
        <?php $__currentLoopData = $addresses['shippingAddresses']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="myaccount-address-card">
            <div class="myaccount-address-card-head">
              <h2>
                <?php echo e($address['label']); ?>

                <?php if($address['isDefault']): ?>
                  <span class="myaccount-address-default-badge">Default</span>
                <?php endif; ?>
              </h2>
              <a href="<?php echo e($address['editUrl']); ?>" class="myaccount-address-edit">Edit</a>
            </div>
            <address><?php echo $address['formatted']; ?></address>
            <div class="myaccount-address-actions">
              <?php if (! ($address['isDefault'])): ?>
                <form method="post">
                  <?php wp_nonce_field('wv_set_default_shipping_address_' . $address['id'], 'wv_shipping_address_nonce'); ?>
                  <input type="hidden" name="action" value="wv_set_default_shipping_address" />
                  <input type="hidden" name="address_id" value="<?php echo e($address['id']); ?>" />
                  <button type="submit" class="myaccount-address-set-default">Set as default</button>
                </form>
              <?php endif; ?>
              <form method="post" class="myaccount-address-delete-form">
                <?php wp_nonce_field('wv_delete_shipping_address_' . $address['id'], 'wv_shipping_address_nonce'); ?>
                <input type="hidden" name="action" value="wv_delete_shipping_address" />
                <input type="hidden" name="address_id" value="<?php echo e($address['id']); ?>" />
                <button type="submit" class="myaccount-address-delete">Delete</button>
              </form>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    <?php endif; ?>
  </div>
<?php endif; ?>

<div class="myaccount-shipping-book">
  <div class="myaccount-shipping-book-head">
    <h2 class="myaccount-shipping-book-title">Billing Addresses</h2>
    <a href="<?php echo e($addresses['addBillingUrl']); ?>" class="myaccount-address-edit">+ Add new address</a>
  </div>

  <?php if(empty($addresses['billingAddresses'])): ?>
    <p class="myaccount-address-empty">You have not saved any billing addresses yet &mdash; add one if you need GST invoices addressed to a registered business.</p>
  <?php else: ?>
    <div class="myaccount-addresses myaccount-addresses--two-col">
      <?php $__currentLoopData = $addresses['billingAddresses']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="myaccount-address-card">
          <div class="myaccount-address-card-head">
            <h2>
              <?php echo e($address['label']); ?>

              <?php if($address['isDefault']): ?>
                <span class="myaccount-address-default-badge">Default</span>
              <?php endif; ?>
            </h2>
            <a href="<?php echo e($address['editUrl']); ?>" class="myaccount-address-edit">Edit</a>
          </div>
          <address>
            <?php echo $address['formatted']; ?>

            <?php if($address['gstin']): ?>
              <br />GSTIN: <?php echo e($address['gstin']); ?>

            <?php endif; ?>
          </address>
          <div class="myaccount-address-actions">
            <?php if (! ($address['isDefault'])): ?>
              <form method="post">
                <?php wp_nonce_field('wv_set_default_billing_address_' . $address['id'], 'wv_billing_address_nonce'); ?>
                <input type="hidden" name="action" value="wv_set_default_billing_address" />
                <input type="hidden" name="address_id" value="<?php echo e($address['id']); ?>" />
                <button type="submit" class="myaccount-address-set-default">Set as default</button>
              </form>
            <?php endif; ?>
            <form method="post" class="myaccount-address-delete-form">
              <?php wp_nonce_field('wv_delete_billing_address_' . $address['id'], 'wv_billing_address_nonce'); ?>
              <input type="hidden" name="action" value="wv_delete_billing_address" />
              <input type="hidden" name="address_id" value="<?php echo e($address['id']); ?>" />
              <button type="submit" class="myaccount-address-delete">Delete</button>
            </form>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  <?php endif; ?>
</div>
<?php /**PATH C:\Users\Admin\Local Sites\weavira\app\public\wp-content\themes\weavira\resources\views/woocommerce/myaccount/addresses.blade.php ENDPATH**/ ?>