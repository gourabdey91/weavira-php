<?php $products = $section['products'] ?? []; ?>

<?php if(!empty($products)): ?>
  <div class="page-shell">
    <section class="section favorites" id="collections">
      <div class="section-heading-center">
        <?php if(!empty($section['section_heading'])): ?><h2><?php echo e($section['section_heading']); ?></h2><?php endif; ?>
        <?php if(!empty($section['section_subtext'])): ?><p><?php echo e($section['section_subtext']); ?></p><?php endif; ?>
      </div>
      <div class="carousel-stage">
        <button class="carousel-arrow carousel-arrow-prev fav-arrow-prev" type="button" aria-label="Previous sarees">
          <i data-lucide="chevron-left" aria-hidden="true"></i>
        </button>
        <div class="fav-carousel-wrap">
          <div class="fav-track" id="fav-carousel">
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php echo $__env->make('components.product-card', ['product' => $product, 'fullCard' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        </div>
        <button class="carousel-arrow carousel-arrow-next fav-arrow-next" type="button" aria-label="Next sarees">
          <i data-lucide="chevron-right" aria-hidden="true"></i>
        </button>
      </div>
      <div class="fav-dots" aria-hidden="true"></div>
      <div class="fav-cta-wrap">
        <a class="fav-view-all" href="<?php echo e(!empty($section['view_all_link']['url']) ? $section['view_all_link']['url'] : wc_get_page_permalink('shop')); ?>">View All Sarees &#8594;</a>
      </div>
    </section>
  </div>
<?php endif; ?>
<?php /**PATH C:\Users\Admin\Local Sites\weavira\app\public\wp-content\themes\weavira\resources\views/partials/home/weavira_favorites.blade.php ENDPATH**/ ?>