<?php if(!$load_address): ?>
  <?php echo $__env->make('woocommerce.myaccount.addresses', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php else: ?>
  <form method="post" novalidate class="myaccount-address-form">
    <h2>
      <?php if($load_address === 'shipping'): ?>
        <?php echo e(!empty($addressId) ? 'Edit shipping address' : 'Add shipping address'); ?>

      <?php else: ?>
        <?php echo e(!empty($addressId) ? 'Edit billing address' : 'Add billing address'); ?>

      <?php endif; ?>
    </h2>

    
    <div class="ck-field-grid myaccount-field-grid">
      <p class="form-row form-row-wide">
        <label for="wv_address_label">Label <span class="required" aria-hidden="true">*</span></label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="wv_address_label" id="wv_address_label" placeholder="<?php echo e($load_address === 'shipping' ? 'e.g. Home, Office' : 'e.g. Head Office, Warehouse GST'); ?>" maxlength="40" value="<?php echo e(wc_get_post_data_by_key('wv_address_label', $addressLabel ?? '')); ?>" required aria-required="true" />
      </p>

      <?php if($load_address === 'billing'): ?>
        <p class="form-row form-row-wide">
          <label for="wv_gst_number">GST Number <span class="required" aria-hidden="true">*</span></label>
          <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="wv_gst_number" id="wv_gst_number" maxlength="15" placeholder="e.g. 22AAAAA0000A1Z5" value="<?php echo e(wc_get_post_data_by_key('wv_gst_number', $addressGstin ?? '')); ?>" required aria-required="true" />
        </p>
      <?php endif; ?>
    </div>

    <div class="ck-field-grid myaccount-field-grid">
      <?php $__currentLoopData = $address; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php woocommerce_form_field($key, $field, wc_get_post_data_by_key($key, $field['value'])); ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <button type="submit" class="myaccount-save-btn" name="save_address" value="Save address">Save Address</button>

    <?php if($load_address === 'shipping'): ?>
      <?php wp_nonce_field('wv_save_shipping_address', 'wv_shipping_address_nonce'); ?>
      <input type="hidden" name="action" value="wv_save_shipping_address" />
      <input type="hidden" name="address_id" value="<?php echo e($addressId ?? ''); ?>" />
    <?php else: ?>
      <?php wp_nonce_field('wv_save_billing_address', 'wv_billing_address_nonce'); ?>
      <input type="hidden" name="action" value="wv_save_billing_address" />
      <input type="hidden" name="address_id" value="<?php echo e($addressId ?? ''); ?>" />
    <?php endif; ?>
  </form>
<?php endif; ?>
<?php /**PATH C:\Users\Admin\Local Sites\weavira\app\public\wp-content\themes\weavira\resources\views/woocommerce/myaccount/edit-address.blade.php ENDPATH**/ ?>