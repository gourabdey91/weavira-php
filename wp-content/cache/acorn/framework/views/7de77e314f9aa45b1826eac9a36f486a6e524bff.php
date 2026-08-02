<?php
  $designDetails = get_field('design_details', $product->get_id()) ?: [];
?>

<?php if(!empty($designDetails)): ?>
  <section class="product-design-details">
    <div class="design-details-grid">
      <?php $__currentLoopData = $designDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(empty($card['design_details_title'])) continue; ?>
        <div class="design-detail-card">
          <img
            src="<?php echo e($card['design_details_image'] ?: $galleryImages[0]['url']); ?>"
            alt="<?php echo e($card['design_details_title']); ?>"
            class="design-detail-img"
            loading="lazy"
          >
          <div class="design-detail-overlay"></div>
          <div class="design-detail-content">
            <?php if(!empty($card['design_details_label'])): ?>
              <span class="design-detail-label"><?php echo e(strtoupper($card['design_details_label'])); ?></span>
            <?php endif; ?>
            <h3 class="design-detail-title"><?php echo e($card['design_details_title']); ?></h3>
            <?php if(!empty($card['design_details_desc'])): ?>
              <p class="design-detail-desc"><?php echo e($card['design_details_desc']); ?></p>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </section>
<?php endif; ?>
<?php /**PATH C:\Users\Admin\Local Sites\weavira\app\public\wp-content\themes\weavira\resources\views/partials/product/details-cards.blade.php ENDPATH**/ ?>