<?php
  $feelScaleValue = get_field('feel_scale_value', $product->get_id());
  $feelBody = get_field('feel_body', $product->get_id());
  $feelKicker = get_field('feel_kicker', $product->get_id()) ?: 'How Will This Saree Feel?';
  $feelImage = get_field('feel_image', $product->get_id()) ?: $galleryImages[0]['url'];
  $feelPoints = ['Featherlight', 'Fine', 'Traditional', 'Heritage'];
?>

<?php if($feelScaleValue): ?>
  <section class="wv-feel-scale">
    <div class="wv-feel-media">
      <img src="<?php echo e($feelImage); ?>" alt="Close-up of the weave" class="wv-feel-img" loading="lazy">
    </div>
    <div class="wv-feel-text">
      <span class="wv-feel-kicker section-kicker"><?php echo e($feelKicker); ?></span>

      <ul class="wv-feel-scale-track">
        <span class="wv-feel-scale-line" aria-hidden="true"></span>
        <?php $__currentLoopData = $feelPoints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li class="wv-feel-point <?php if($point === $feelScaleValue): ?> wv-feel-point--active <?php endif; ?>">
            <span class="wv-feel-label"><?php echo e($point); ?></span>
            <span class="wv-feel-dot"></span>
            <?php if($point === $feelScaleValue): ?>
              <span class="wv-feel-marker">
                <span class="wv-feel-marker-caret" aria-hidden="true">&#9650;</span>
                <span class="wv-feel-marker-text">This Saree</span>
              </span>
            <?php endif; ?>
          </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>

      <?php if($feelBody): ?>
        <p class="wv-feel-body"><?php echo e($feelBody); ?></p>
      <?php endif; ?>
    </div>
  </section>
<?php endif; ?>
<?php /**PATH C:\Users\Admin\Local Sites\weavira\app\public\wp-content\themes\weavira\resources\views/partials/product/feel-scale.blade.php ENDPATH**/ ?>