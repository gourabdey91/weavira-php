<?php $designs = $section['designs'] ?? []; ?>

<?php if(!empty($designs)): ?>
  <div class="page-shell">
    <section class="section designs" id="designs">
      <div class="section-heading-center">
        <?php if(!empty($section['section_heading'])): ?><h2><?php echo e($section['section_heading']); ?></h2><?php endif; ?>
        <?php if(!empty($section['section_subtext'])): ?><p><?php echo e($section['section_subtext']); ?></p><?php endif; ?>
      </div>
      <div class="carousel-stage">
        <button class="carousel-arrow carousel-arrow-prev design-arrow-prev" type="button" aria-label="Previous designs">
          <i data-lucide="chevron-left" aria-hidden="true"></i>
        </button>
        <div class="design-track" id="design-carousel">
          <?php $__currentLoopData = $designs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $design): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a class="design-card" href="<?php echo e($design['link']); ?>">
              <div class="design-info">
                <span class="design-icon" aria-hidden="true"><i data-lucide="gem"></i></span>
                <h3 class="wv-card-title"><?php echo e($design['name']); ?></h3>
                <span class="design-rule" aria-hidden="true"></span>
                <?php if($design['excerpt']): ?><p><?php echo e($design['excerpt']); ?></p><?php endif; ?>
                <span class="design-explore wv-card-explore">EXPLORE DESIGNS &#8594;</span>
              </div>
              <div class="design-img-wrap">
                <img src="<?php echo e($design['image']); ?>" alt="<?php echo e($design['name']); ?> design" class="design-img" loading="lazy">
              </div>
            </a>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <button class="carousel-arrow carousel-arrow-next design-arrow-next" type="button" aria-label="Next designs">
          <i data-lucide="chevron-right" aria-hidden="true"></i>
        </button>
      </div>
      <div class="fav-cta-wrap">
        <a class="fav-view-all" href="<?php echo e(!empty($section['view_all_link']['url']) ? $section['view_all_link']['url'] : get_post_type_archive_link('heritage_design')); ?>">View All Heritage Designs &#8594;</a>
      </div>
    </section>
  </div>
<?php endif; ?>
<?php /**PATH C:\Users\Admin\Local Sites\weavira\app\public\wp-content\themes\weavira\resources\views/partials/home/discover_designs.blade.php ENDPATH**/ ?>