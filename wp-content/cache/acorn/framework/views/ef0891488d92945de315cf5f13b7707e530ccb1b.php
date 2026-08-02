
<?php $inWishlist = \App\weavira_wishlist_contains($product->get_id()); ?>
<div class="pdp-gallery-stage">
  <div class="w-pdp-gallery">
    <div class="gallery-main">
      <div class="gallery-main-img">
        <img src="<?php echo e($galleryImages[0]['url']); ?>" alt="<?php echo e($galleryImages[0]['alt']); ?>" class="gallery-main-photo">
        <?php if($galleryVideo): ?>
          <video class="gallery-main-video" playsinline controls hidden></video>
        <?php endif; ?>
      </div>
      <?php if(count($galleryImages) > 1 || $galleryVideo): ?>
        <span class="gallery-slide-counter" aria-live="polite">1 / <?php echo e(count($galleryImages) + ($galleryVideo ? 1 : 0)); ?></span>
      <?php endif; ?>
      <button class="gallery-wishlist <?php if($inWishlist): ?> plp-wish--active <?php endif; ?>" aria-label="<?php echo e($inWishlist ? 'Remove from Wishlist' : 'Add to Wishlist'); ?>" data-product-id="<?php echo e($product->get_id()); ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
          <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
        </svg>
      </button>
      <?php if(count($galleryImages) > 1 || $galleryVideo): ?>
        <button class="gallery-play-toggle" aria-label="Pause slideshow">
          <svg class="icon-pause" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><rect x="6" y="4" width="4" height="16" rx="1"/><rect x="14" y="4" width="4" height="16" rx="1"/></svg>
          <svg class="icon-play" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><polygon points="5,3 19,12 5,21"/></svg>
        </button>
      <?php endif; ?>
      <button class="gallery-expand" aria-label="View fullscreen">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
          <path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"/>
        </svg>
      </button>
    </div>

    <?php if(count($galleryImages) > 1 || $galleryVideo): ?>
      <div class="gallery-thumbs-row">
        <button class="gallery-thumb-arrow" aria-label="Previous image">
          <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M13 4L7 10l6 6"/></svg>
        </button>
        <div class="gallery-thumbs">
          <?php $__currentLoopData = $galleryImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <button class="gallery-thumb <?php if($i === 0): ?> active <?php endif; ?>" aria-label="View image <?php echo e($i + 1); ?>">
              <img src="<?php echo e($image['url']); ?>" alt="<?php echo e($image['alt']); ?>" class="gallery-thumb-img">
            </button>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php if($galleryVideo): ?>
            <button class="gallery-thumb gallery-thumb-video" aria-label="Watch video" data-video-src="<?php echo e($galleryVideo['url']); ?>">
              <img src="<?php echo e($galleryVideo['poster']); ?>" alt="Watch the weaving video" class="gallery-thumb-img">
              <div class="gallery-video-overlay">
                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10" fill="rgba(0,0,0,0.55)"/><polygon points="10,8 17,12 10,16" fill="#fff"/></svg>
              </div>
            </button>
          <?php endif; ?>
        </div>
        <button class="gallery-thumb-arrow" aria-label="Next image">
          <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M7 4l6 6-6 6"/></svg>
        </button>
      </div>
    <?php endif; ?>
  </div>
</div>
<?php /**PATH C:\Users\Admin\Local Sites\weavira\app\public\wp-content\themes\weavira\resources\views/partials/product/gallery.blade.php ENDPATH**/ ?>