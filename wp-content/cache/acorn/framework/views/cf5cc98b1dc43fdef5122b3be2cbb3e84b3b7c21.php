<?php if(!empty($section['banner_image_desktop'])): ?>
  <section class="wv-closing-banner">
    <picture class="wv-closing-media">
      <?php if(!empty($section['banner_image_mobile'])): ?>
        <source media="(max-width: 768px)" srcset="<?php echo e($section['banner_image_mobile']); ?>">
      <?php endif; ?>
      <img src="<?php echo e($section['banner_image_desktop']); ?>" alt="" class="wv-closing-img">
    </picture>
    <div class="wv-closing-overlay">
      <div class="wv-closing-text">
        <?php if(!empty($section['heading'])): ?>
          <h2 class="wv-closing-heading"><?php echo e($section['heading']); ?></h2>
        <?php endif; ?>
        <?php if(!empty($section['description'])): ?>
          <p class="wv-closing-desc"><?php echo nl2br(e($section['description'])); ?></p>
        <?php endif; ?>
      </div>
    </div>
  </section>
<?php endif; ?>
<?php /**PATH C:\Users\Admin\Local Sites\weavira\app\public\wp-content\themes\weavira\resources\views/partials/home/closing_banner.blade.php ENDPATH**/ ?>