<?php
  $shortDescription = $product->get_short_description();
?>

<div class="w-pdp-info">

  <?php if($badgeLabel): ?>
    <span class="product-badge"><?php echo e(strtoupper($badgeLabel)); ?></span>
  <?php endif; ?>

  <h1 class="w-pdp-title"><?php echo e($product->get_name()); ?></h1>

  <?php if($shortDescription): ?>
    <p class="w-pdp-description"><?php echo $shortDescription; ?></p>
  <?php endif; ?>

  <?php if(!empty($attrs['weave']) || !empty($attrs['material']) || !empty($attrs['blouse-piece'])): ?>
    <div class="w-pdp-specs-row">
      <?php if(!empty($attrs['weave'])): ?>
        <div class="w-pdp-specs-item">
          <span class="w-pdp-specs-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><circle cx="12" cy="12" r="3"/><path d="M12 3v2M12 19v2M3 12h2M19 12h2M5.6 5.6l1.5 1.5M16.9 16.9l1.5 1.5M18.4 5.6l-1.5 1.5M7.1 16.9l-1.5 1.5"/></svg>
          </span>
          <span class="w-pdp-specs-text">
            <span class="w-pdp-specs-label">WEAVE</span>
            <span class="w-pdp-specs-value"><?php echo e($attrs['weave']); ?></span>
          </span>
        </div>
      <?php endif; ?>

      <?php if(!empty($attrs['material'])): ?>
        <div class="w-pdp-specs-item">
          <span class="w-pdp-specs-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><path d="M2 7q3-5 5.5 0t5.5 0 5.5 0"/><path d="M2 13q3-5 5.5 0t5.5 0 5.5 0"/><path d="M2 19q3-5 5.5 0t5.5 0 5.5 0"/></svg>
          </span>
          <span class="w-pdp-specs-text">
            <span class="w-pdp-specs-label">MATERIAL</span>
            <span class="w-pdp-specs-value"><?php echo e($attrs['material']); ?></span>
          </span>
        </div>
      <?php endif; ?>

      <?php if(!empty($attrs['blouse-piece'])): ?>
        <div class="w-pdp-specs-item">
          <span class="w-pdp-specs-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><path d="M6 2h12l2 6H4z"/><path d="M4 8h16v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1z"/><line x1="12" y1="8" x2="12" y2="21"/></svg>
          </span>
          <span class="w-pdp-specs-text">
            <span class="w-pdp-specs-label">BLOUSE PIECE</span>
            <span class="w-pdp-specs-value"><?php echo e($attrs['blouse-piece'] === 'Yes' ? 'Included' : 'Not included'); ?></span>
          </span>
        </div>
      <?php endif; ?>
    </div>
  <?php endif; ?>

  <div class="w-pdp-purchase">
    <div class="ppbox-info-row">
      <div class="ppbox-price">
        <p class="w-pdp-price"><?php echo $product->get_price_html(); ?></p>
        <p class="w-pdp-price-note">(Inclusive of all taxes)</p>
      </div>

      <?php if(!empty($craftFacts)): ?>
        <div class="ppbox-divider" aria-hidden="true"></div>

        <div class="ppbox-facts">
          <?php $__currentLoopData = $craftFacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="ppbox-fact">
              <span class="ppbox-fact-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><path d="M12 2c-2 3-4 5-4 8a4 4 0 0 0 8 0c0-3-2-5-4-8z"/><path d="M12 10c-3-2-6-1.5-7 1 2 1 5 1.5 7 0z"/><path d="M12 10c3-2 6-1.5 7 1-2 1-5 1.5-7 0z"/></svg>
              </span>
              <span class="ppbox-fact-text"><?php echo e($fact); ?></span>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      <?php endif; ?>
    </div><!-- /.ppbox-info-row -->

    <div class="w-pdp-cta-row">
      <?php woocommerce_template_single_add_to_cart(); ?>

      <?php if($product->is_purchasable() && $product->is_in_stock()): ?>
        <button type="button" class="btn-buy-now" data-buy-now>BUY IT NOW</button>
      <?php endif; ?>
    </div>

    <div class="ppbox-trust-bar">
      <div class="ppbox-trust-item">
        <svg class="ppbox-trust-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
          <rect x="2" y="8" width="20" height="12" rx="1.5"/>
          <path d="M7 8V6a5 5 0 0 1 10 0v2"/>
          <circle cx="7.5" cy="16" r="1.5"/><circle cx="16.5" cy="16" r="1.5"/>
          <line x1="9" y1="16" x2="15" y2="16"/>
        </svg>
        <div class="ppbox-trust-text">
          <strong>Free Shipping</strong>
          <span>Across India</span>
        </div>
      </div>

      <div class="ppbox-trust-divider" aria-hidden="true"></div>

      <div class="ppbox-trust-item">
        <svg class="ppbox-trust-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
          <rect x="3" y="10" width="18" height="11" rx="1"/>
          <path d="M3 10l2-5h14l2 5"/>
          <path d="M12 10v11"/>
          <path d="M8 10c0-2 1.5-5 4-5s4 3 4 5"/>
        </svg>
        <div class="ppbox-trust-text">
          <strong>Complimentary</strong>
          <span>Gift Wrapping</span>
        </div>
      </div>
    </div><!-- /.ppbox-trust-bar -->

  </div><!-- /.w-pdp-purchase -->

</div><!-- /.w-pdp-info -->
<?php /**PATH C:\Users\Admin\Local Sites\weavira\app\public\wp-content\themes\weavira\resources\views/partials/product/info.blade.php ENDPATH**/ ?>