<?php if(!empty($section['bg_image_desktop'])): ?>
  <div class="page-shell">
  <div class="section-heading-center festive-section-title"></div>
  <section class="festive-edit">
    <a class="festive-bg" href="<?php echo e($section['cta_url']['url'] ?? '#'); ?>" aria-label="Shop the festive collection">
      <picture>
        <?php if(!empty($section['bg_image_mobile'])): ?>
          <source media="(max-width: 768px)" srcset="<?php echo e($section['bg_image_mobile']); ?>">
        <?php endif; ?>
        <img src="<?php echo e($section['bg_image_desktop']); ?>" alt="" class="festive-bg-photo" aria-hidden="true">
      </picture>
    </a>
    <div class="festive-overlay"></div>
    <div class="festive-content">
      <?php if(!empty($section['heading'])): ?>
        <h2 class="festive-heading"><?php echo nl2br(e($section['heading'])); ?></h2>
      <?php endif; ?>
      <div class="festive-ornament">
        <span class="festive-gem" aria-hidden="true">&#9670;</span>
      </div>
      <?php if(!empty($section['description'])): ?>
        <p class="festive-desc"><?php echo nl2br(e($section['description'])); ?></p>
      <?php endif; ?>
      <?php if(!empty($section['cta_label'])): ?>
        <a class="festive-cta" href="<?php echo e($section['cta_url']['url'] ?? '#'); ?>"><?php echo e($section['cta_label']); ?> &#8594;</a>
      <?php endif; ?>
    </div>
  </section>
  </div>
<?php endif; ?>
<?php /**PATH /home/u908449413/domains/weavira.com/public_html/wp-content/themes/weavira/resources/views/partials/home/festive_edit.blade.php ENDPATH**/ ?>