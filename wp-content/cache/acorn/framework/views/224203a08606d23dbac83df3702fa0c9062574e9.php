<?php
  $washCare = get_field('wash_care', $product->get_id());
  $reviewsEnabled = wc_reviews_enabled() && $product->get_reviews_allowed();
?>

<section class="product-tabs">

  <?php if(!empty($specs)): ?>
    <div class="tab-item">
      <button class="tab-header" aria-expanded="false">
        <span class="tab-icon"><svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><rect x="3" y="3" width="14" height="14" rx="1"/><line x1="3" y1="8" x2="17" y2="8"/><line x1="8" y1="8" x2="8" y2="17"/></svg></span>
        <span class="tab-label">SPECIFICATIONS</span>
        <span class="tab-sub">Size, material &amp; details</span>
        <span class="tab-toggle" aria-hidden="true">+</span>
      </button>
      <div class="tab-body">
        <div class="spec-grid">
          <?php $__currentLoopData = $specs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <span class="spec-label"><?php echo e($row['label']); ?></span>
            <span class="spec-value"><?php echo e($row['value']); ?> <?php if(!empty($row['note'])): ?><span class="spec-note">(<?php echo e($row['note']); ?>)</span><?php endif; ?></span>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <?php if($washCare): ?>
    <div class="tab-item">
      <button class="tab-header" aria-expanded="false">
        <span class="tab-icon"><svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><path d="M4 4h12v9a6 6 0 0 1-12 0V4z"/></svg></span>
        <span class="tab-label">CARE GUIDE</span>
        <span class="tab-sub">How to preserve your saree</span>
        <span class="tab-toggle" aria-hidden="true">+</span>
      </button>
      <div class="tab-body">
        <p><?php echo e($washCare); ?></p>
      </div>
    </div>
  <?php endif; ?>

  <?php if($reviewsEnabled): ?>
    <div class="tab-item">
      <button class="tab-header" aria-expanded="false">
        <span class="tab-icon"><svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><path d="M10 2l2.4 5 5.6.8-4 3.9.9 5.5L10 14.8l-4.9 2.4.9-5.5L2 7.8l5.6-.8z"/></svg></span>
        <span class="tab-label">REVIEWS <span class="tab-count">(<?php echo e($product->get_review_count()); ?>)</span></span>
        <span class="tab-sub">What our customers say</span>
        <span class="tab-toggle" aria-hidden="true">+</span>
      </button>
      <div class="tab-body">
        
        <?php comments_template(); ?>
      </div>
    </div>
  <?php endif; ?>

</section>
<?php /**PATH C:\Users\Admin\Local Sites\weavira\app\public\wp-content\themes\weavira\resources\views/partials/product/tabs.blade.php ENDPATH**/ ?>