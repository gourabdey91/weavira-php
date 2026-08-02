<?php
  $features = $section['gifting_features'] ?? [];
  $occasions = $section['gifting_occasions'] ?? [];
?>

<?php if(!empty($section['gifting_heading'])): ?>
  <div class="page-shell">
  <section class="gifting-section" id="gifting">

    <div class="gifting-hero">
      <div class="gifting-hero-text">
        <?php if(!empty($section['gifting_kicker'])): ?>
          <span class="craft-editorial-kicker"><?php echo e($section['gifting_kicker']); ?></span>
        <?php endif; ?>
        <h2><?php echo e($section['gifting_heading']); ?></h2>
        <?php if(!empty($section['gifting_body'])): ?>
          <p class="gifting-hero-sub"><?php echo e($section['gifting_body']); ?></p>
        <?php endif; ?>
        <?php if(!empty($section['gifting_cta_label'])): ?>
          <a class="gifting-hero-cta" href="<?php echo e($section['gifting_cta_link']['url'] ?? '#'); ?>"><?php echo e($section['gifting_cta_label']); ?> &#8594;</a>
        <?php endif; ?>
      </div>
      <?php if(!empty($section['gifting_hero_img'])): ?>
        <picture class="gifting-hero-picture">
          <img src="<?php echo e($section['gifting_hero_img']); ?>" alt="Weavira gift packaging" class="gifting-hero-img-tag">
        </picture>
      <?php endif; ?>
    </div>

    <?php if(!empty($features)): ?>
      <div class="gifting-features-wrap">
        <div class="gifting-features">
          <?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="gifting-feature">
              <div class="gifting-feature-head">
                <?php if(!empty($feature['feature_icon'])): ?>
                  <i data-lucide="<?php echo e($feature['feature_icon']); ?>" class="gifting-feature-icon" aria-hidden="true"></i>
                <?php endif; ?>
                <p class="gifting-feature-title"><?php echo e($feature['feature_title']); ?></p>
              </div>
              <?php if(!empty($feature['feature_desc'])): ?>
                <p class="gifting-feature-desc"><?php echo e($feature['feature_desc']); ?></p>
              <?php endif; ?>
              <?php if(!empty($feature['feature_image'])): ?>
                <img src="<?php echo e($feature['feature_image']); ?>" alt="" class="gifting-feature-img" loading="lazy">
              <?php endif; ?>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>
    <?php endif; ?>

    <?php if(!empty($occasions)): ?>
      <div class="gifting-occasions-wrap">
        <div class="section-heading-center section-heading-center--plain">
          <h2>Gifting Collection</h2>
        </div>
        <div class="occasions-row">
          <?php $__currentLoopData = $occasions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $occasion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a class="occasion-card" href="<?php echo e($occasion['occasion_link']['url'] ?? '#'); ?>">
              <?php if(!empty($occasion['occasion_badge'])): ?>
                <span class="wv-occasion-badge"><?php echo e($occasion['occasion_badge']); ?></span>
              <?php endif; ?>
              <div class="occasion-card-frame">
                <div class="occasion-card-media">
                  <img src="<?php echo e($occasion['occasion_image']); ?>" alt="<?php echo e($occasion['occasion_name']); ?>" class="occasion-img" loading="lazy">
                </div>
                <div class="occasion-caption">
                  <span class="occasion-name wv-card-title"><?php echo e($occasion['occasion_name']); ?></span>
                  <?php if(!empty($occasion['occasion_desc'])): ?>
                    <p class="occasion-desc"><?php echo e($occasion['occasion_desc']); ?></p>
                  <?php endif; ?>
                </div>
              </div>
            </a>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>
    <?php endif; ?>

  </section>
  </div>
<?php endif; ?>
<?php /**PATH C:\Users\Admin\Local Sites\weavira\app\public\wp-content\themes\weavira\resources\views/partials/home/gifting_section.blade.php ENDPATH**/ ?>