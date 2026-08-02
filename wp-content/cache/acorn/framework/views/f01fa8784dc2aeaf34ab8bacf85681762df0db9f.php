<?php $products = $section['resolvedProducts'] ?? []; ?>

<?php if(!empty($products)): ?>
  <section class="wv-jnl-collection">
    <div class="carousel-stage">
      <button class="carousel-arrow carousel-arrow-prev jnl-collection-arrow-prev" type="button" aria-label="Previous saree">
        <i data-lucide="chevron-left" aria-hidden="true"></i>
      </button>
      <div class="loom-track" id="jnl-collection-carousel">
        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php echo $__env->make('components.product-card', ['product' => $product], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
      <button class="carousel-arrow carousel-arrow-next jnl-collection-arrow-next" type="button" aria-label="Next saree">
        <i data-lucide="chevron-right" aria-hidden="true"></i>
      </button>
    </div>
    <div class="jnl-collection-dots" aria-hidden="true"></div>
  </section>
<?php endif; ?>
<?php /**PATH /home/u908449413/domains/weavira.com/public_html/wp-content/themes/weavira/resources/views/partials/journal/collection_carousel.blade.php ENDPATH**/ ?>