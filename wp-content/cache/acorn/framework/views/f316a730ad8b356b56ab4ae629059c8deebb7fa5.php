<?php $cards = $section['moment_cards'] ?? []; ?>

<?php if(!empty($cards)): ?>
  <div class="page-shell">
    <section class="section moments" id="moments">
      <div class="section-heading-center">
        <?php if(!empty($section['section_heading'])): ?><h2><?php echo e($section['section_heading']); ?></h2><?php endif; ?>
        <?php if(!empty($section['section_subtext'])): ?><p><?php echo e($section['section_subtext']); ?></p><?php endif; ?>
      </div>
      <div class="moment-stage">
        <button class="moment-arrow-prev" type="button" aria-label="Previous moments">
          <i data-lucide="chevron-left" aria-hidden="true"></i>
        </button>
        <div class="moment-row" id="moment-carousel">
          <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a class="moment-card" href="<?php echo e($card['link_url']['url'] ?? '#'); ?>">
              <picture class="moment-image">
                <img src="<?php echo e($card['image']); ?>" alt="" class="moment-photo" aria-hidden="true">
              </picture>
              <div class="moment-card-content">
                <div class="moment-card-top">
                  <h3 class="wv-card-title"><?php echo e($card['heading']); ?></h3>
                  <div class="moment-divider"></div>
                  <p><?php echo e($card['subtext']); ?></p>
                </div>
                <span class="moment-cta wv-card-explore"><?php echo e($card['cta_label'] ?: 'EXPLORE COLLECTION'); ?> &#8594;</span>
              </div>
            </a>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <button class="moment-arrow-next" type="button" aria-label="Next moments">
          <i data-lucide="chevron-right" aria-hidden="true"></i>
        </button>
      </div>
      <div class="fav-cta-wrap">
        <a class="fav-view-all" href="<?php echo e(!empty($section['view_all_link']['url']) ? $section['view_all_link']['url'] : wc_get_page_permalink('shop')); ?>">Shop All Moments &#8594;</a>
      </div>
      <div class="moment-dots" aria-hidden="true"></div>
    </section>
  </div>
<?php endif; ?>
<?php /**PATH C:\Users\Admin\Local Sites\weavira\app\public\wp-content\themes\weavira\resources\views/partials/home/shop_by_moment.blade.php ENDPATH**/ ?>