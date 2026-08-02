<?php
  $storyImage = ($story['image'] ?? null) ?: $galleryImages[0]['url'];
?>

<?php if($story): ?>
  <section class="pdp-inspiration">
    <div class="pdp-inspiration-banner">
      <div class="pdp-inspiration-text">
        <?php if($story['heading']): ?>
          <h2 class="pdp-inspiration-heading"><?php echo e($story['heading']); ?></h2>
        <?php endif; ?>
        <?php if($story['body']): ?>
          <p class="pdp-inspiration-body"><?php echo e($story['body']); ?></p>
        <?php endif; ?>
        <?php if($story['ctaLink']): ?>
          <a href="<?php echo e($story['ctaLink']['url']); ?>" class="pdp-inspiration-cta"><?php echo e($story['ctaLabel'] ?: $story['ctaLink']['title']); ?> &rarr;</a>
        <?php endif; ?>
      </div>
      <div class="pdp-inspiration-media">
        <img src="<?php echo e($storyImage); ?>" alt="<?php echo e($story['heading']); ?>" class="pdp-inspiration-img" loading="lazy">
      </div>
    </div>
  </section>
<?php endif; ?>
<?php /**PATH C:\Users\Admin\Local Sites\weavira\app\public\wp-content\themes\weavira\resources\views/partials/product/story.blade.php ENDPATH**/ ?>