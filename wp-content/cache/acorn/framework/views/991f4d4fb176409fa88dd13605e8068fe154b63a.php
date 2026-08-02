<?php $slides = $section['hero_slides'] ?? []; ?>

<div class="hero-stage">
  <section class="hero-banner" role="region" aria-label="Featured collection">
    <?php if(!empty($slides)): ?>
      <div class="hero-slider-track" id="hero-slider-track">
        <?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="hero-slide <?php if($i === 0): ?> active <?php endif; ?>">
            <picture>
              <?php if(!empty($slide['image_desktop'])): ?>
                <source media="(min-width: 769px)" srcset="<?php echo e($slide['image_desktop']); ?>">
              <?php endif; ?>
              <img src="<?php echo e($slide['image_mobile'] ?: $slide['image_desktop']); ?>" alt="" class="hero-banner-photo" aria-hidden="true">
            </picture>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    <?php endif; ?>
    <div class="hero-banner-overlay"></div>
    <div class="hero-container">
      <?php if(!empty($section['eyebrow_text'])): ?>
        <div class="hero-label"><?php echo e($section['eyebrow_text']); ?></div>
      <?php endif; ?>
      <div class="hero-copy">
        <?php if(!empty($section['heading'])): ?>
          <h1><?php echo nl2br(e($section['heading'])); ?></h1>
        <?php endif; ?>
        <?php if(!empty($section['subtext'])): ?>
          <p class="hero-subtitle"><?php echo e($section['subtext']); ?></p>
        <?php endif; ?>
        <?php if(!empty($section['cta_label']) && !empty($section['cta_url']['url'])): ?>
          <div class="hero-actions">
            <a class="button button-primary" href="<?php echo e($section['cta_url']['url']); ?>"><?php echo e($section['cta_label']); ?></a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>
</div>
<?php /**PATH C:\Users\Admin\Local Sites\weavira\app\public\wp-content\themes\weavira\resources\views/partials/home/hero_banner.blade.php ENDPATH**/ ?>