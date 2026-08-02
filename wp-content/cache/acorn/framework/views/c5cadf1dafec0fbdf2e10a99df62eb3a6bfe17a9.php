<?php $products = $section['products'] ?? []; ?>

<?php if(!empty($products)): ?>
  <div class="page-shell">
    <section class="section fresh-loom">
      <div class="section-heading-center">
        <?php if(!empty($section['section_heading'])): ?><h2><?php echo e($section['section_heading']); ?></h2><?php endif; ?>
        <?php if(!empty($section['section_subtext'])): ?><p><?php echo e($section['section_subtext']); ?></p><?php endif; ?>
      </div>
      <div class="carousel-stage">
        <button class="carousel-arrow carousel-arrow-prev loom-arrow-prev" type="button" aria-label="Previous arrivals">
          <i data-lucide="chevron-left" aria-hidden="true"></i>
        </button>
        <div class="loom-track" id="loom-carousel">
          <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('components.product-card', ['product' => $product, 'fullCard' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <button class="carousel-arrow carousel-arrow-next loom-arrow-next" type="button" aria-label="Next arrivals">
          <i data-lucide="chevron-right" aria-hidden="true"></i>
        </button>
      </div>
      <div class="fav-cta-wrap">
        <a class="fav-view-all" href="<?php echo e(!empty($section['view_all_link']['url']) ? $section['view_all_link']['url'] : wc_get_page_permalink('shop')); ?>">Explore All New Arrivals &#8594;</a>
      </div>
      <div class="loom-dots" aria-hidden="true"></div>
    </section>
  </div>
<?php endif; ?>
<?php /**PATH /home/u908449413/domains/weavira.com/public_html/wp-content/themes/weavira/resources/views/partials/home/new_arrivals.blade.php ENDPATH**/ ?>