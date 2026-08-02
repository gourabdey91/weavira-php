<?php
  $relatedTabs = [
    'design' => 'Same Design',
    'theme' => 'Same Theme',
    'occasion' => 'Festive Picks',
    'similar' => 'Similar Products',
  ];
  $relatedTabs = array_filter($relatedTabs, fn($label, $key) => !empty($relatedGroups[$key]), ARRAY_FILTER_USE_BOTH);
?>

<?php if(!empty($relatedTabs)): ?>
  <section class="section similar-stories">
    <div class="similar-stories-head">
      <h2 class="similar-stories-title">SIMILAR STORIES</h2>
      <?php if(count($relatedTabs) > 1): ?>
        <div class="similar-stories-filters">
          <?php $__currentLoopData = $relatedTabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <button class="similar-filter <?php if($loop->first): ?> active <?php endif; ?>" data-related-filter="<?php echo e($key); ?>"><?php echo e($label); ?></button>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      <?php endif; ?>
    </div>
    <div class="carousel-stage">
      <button class="carousel-arrow carousel-arrow-prev similar-arrow-prev" aria-label="Previous">
        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M13 4L7 10l6 6"/></svg>
      </button>
      <div class="loom-track" id="similar-carousel">
        <?php $__currentLoopData = $relatedGroups[array_key_first($relatedTabs)]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php echo $__env->make('components.product-card', ['product' => $relatedProduct], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div><!-- /.loom-track -->
      <button class="carousel-arrow carousel-arrow-next similar-arrow-next" aria-label="Next">
        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M7 4l6 6-6 6"/></svg>
      </button>
    </div><!-- /.carousel-stage -->

    <?php $__currentLoopData = $relatedTabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php if(!$loop->first): ?>
        <template data-related-source="<?php echo e($key); ?>">
          <?php $__currentLoopData = $relatedGroups[$key]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('components.product-card', ['product' => $relatedProduct], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </template>
      <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </section>
<?php endif; ?>
<?php /**PATH C:\Users\Admin\Local Sites\weavira\app\public\wp-content\themes\weavira\resources\views/partials/product/related.blade.php ENDPATH**/ ?>