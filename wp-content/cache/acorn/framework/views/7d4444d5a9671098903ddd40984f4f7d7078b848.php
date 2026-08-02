
<?php
  $promiseHeading = get_field('promise_heading', 'option');
  $promiseSub = get_field('promise_sub', 'option');
  $promiseCtaLabel = get_field('promise_cta_label', 'option');
  $promiseCtaLink = get_field('promise_cta_link', 'option');
  $promiseImage = get_field('promise_image', 'option');
  $promiseFeatures = get_field('promise_features', 'option') ?: [];
?>

<?php if($promiseHeading || !empty($promiseFeatures)): ?>
  <section class="plp-promise">
    <div class="plp-promise-intro">
      <?php if($promiseHeading): ?>
        <h2 class="plp-promise-heading"><?php echo nl2br(e($promiseHeading)); ?></h2>
      <?php endif; ?>
      <?php if($promiseSub): ?>
        <p class="plp-promise-sub"><?php echo e($promiseSub); ?></p>
      <?php endif; ?>
      <?php if($promiseCtaLink): ?>
        <a href="<?php echo e($promiseCtaLink['url']); ?>" class="plp-promise-cta"><?php echo e(strtoupper($promiseCtaLabel ?: $promiseCtaLink['title'])); ?> &#8594;</a>
      <?php endif; ?>
    </div>

    <?php if(!empty($promiseFeatures)): ?>
      <div class="plp-promise-features">
        <?php $__currentLoopData = $promiseFeatures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="plp-promise-item">
            <div class="plp-promise-icon"><i data-lucide="<?php echo e($feature['promise_features_icon']); ?>" aria-hidden="true"></i></div>
            <strong><?php echo e($feature['promise_features_title']); ?></strong>
            <span><?php echo e($feature['promise_features_text']); ?></span>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    <?php endif; ?>

    <?php if($promiseImage): ?>
      <div class="plp-promise-visual">
        <img src="<?php echo e($promiseImage); ?>" alt="Weavira gift packaging" class="plp-promise-img" loading="lazy">
      </div>
    <?php endif; ?>
  </section>
<?php endif; ?>
<?php /**PATH C:\Users\Admin\Local Sites\weavira\app\public\wp-content\themes\weavira\resources\views/partials/promise-strip.blade.php ENDPATH**/ ?>