<?php $__env->startSection('content'); ?>
<main class="wl-page page-shell">

  <nav class="wl-breadcrumb" aria-label="Breadcrumb">
    <a href="<?php echo e(home_url('/')); ?>">Home</a>
    <span aria-hidden="true">&rsaquo;</span>
    <span aria-current="page"><?php echo e($isSharedView ? 'Shared Collection' : 'My Collection'); ?></span>
  </nav>

  <div class="wl-page-head">
    <?php if($isSharedView): ?>
      <h1 class="wl-page-title">A Shared Collection <span class="wl-title-heart" aria-hidden="true">&#9825;</span></h1>
      <p class="wl-page-sub">Pieces a friend thought <em class="wl-sub-em">you&rsquo;d love</em>.</p>
    <?php else: ?>
      <h1 class="wl-page-title">My Collection <span class="wl-title-heart" aria-hidden="true">&#9825;</span></h1>
      <p class="wl-page-sub">The pieces that <em class="wl-sub-em">stayed with</em> you.</p>
    <?php endif; ?>
    <span class="wl-count">
      <i data-lucide="tag" aria-hidden="true"></i>
      <strong><?php echo e($wishlistCount); ?></strong> Handpicked Treasure<?php echo e($wishlistCount === 1 ? '' : 's'); ?>

    </span>
  </div>

  <div class="wl-trust">
    <div class="wl-trust-item">
      <i data-lucide="truck" aria-hidden="true"></i>
      <div><strong>Free Shipping</strong><span>Across India</span></div>
    </div>
    <div class="wl-trust-item">
      <i data-lucide="shield-check" aria-hidden="true"></i>
      <div><strong>Secure Checkout</strong><span>100% Safe</span></div>
    </div>
    <div class="wl-trust-item">
      <i data-lucide="credit-card" aria-hidden="true"></i>
      <div><strong>All Cards</strong><span>Visa &bull; Mastercard<br>Amex &amp; more</span></div>
    </div>
    <div class="wl-trust-item">
      <i data-lucide="gift" aria-hidden="true"></i>
      <div><strong>Gift Wrapping</strong><span>Beautifully<br>ready to gift</span></div>
    </div>
  </div>

  <?php if (! ($isSharedView)): ?>
    <div class="wl-share">
      <div class="wl-share-copy">
        <i data-lucide="share-2" aria-hidden="true"></i>
        <div>
          <strong>Share Your Collection</strong>
          <span>Send this link to friends &amp; family so they know exactly what you love.</span>
        </div>
      </div>
      <div class="wl-share-action">
        <input type="text" class="wl-share-link" value="<?php echo e($shareUrl); ?>" readonly aria-label="Shareable wishlist link" onclick="this.select()" />
        <button type="button" class="wl-share-btn" data-share-url="<?php echo e($shareUrl); ?>">Copy Link</button>
      </div>
    </div>
  <?php endif; ?>

  <?php if(empty($wishlistItems)): ?>
    <div class="cart-empty">
      <i data-lucide="heart" aria-hidden="true"></i>
      <p><?php echo e($isSharedView ? 'This collection is empty.' : 'Your collection is empty.'); ?></p>
      <?php if (! ($isSharedView)): ?>
        <a href="<?php echo e(wc_get_page_permalink('shop')); ?>" class="cart-continue-link">Browse the collection &rarr;</a>
      <?php endif; ?>
    </div>
  <?php else: ?>
    <div class="wl-grid" id="wl-grid">
      <?php $__currentLoopData = $wishlistItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <article class="plp-card" data-product-id="<?php echo e($item['productId']); ?>">
          <a href="<?php echo e($item['permalink']); ?>" class="card-link" aria-label="View <?php echo e($item['name']); ?>"></a>
          <div class="plp-card-img-wrap">
            <?php if($item['badge']): ?>
              <span class="plp-badge <?php echo e($item['badge']['class']); ?>"><?php echo e($item['badge']['label']); ?></span>
            <?php endif; ?>
            <img src="<?php echo e($item['image']); ?>" alt="<?php echo e($item['name']); ?>" class="plp-card-img" loading="lazy">
            <?php if($item['material']): ?>
              <span class="fav-material"><?php echo e($item['material']); ?></span>
            <?php endif; ?>
            <button class="plp-wish plp-wish--active wl-remove-btn" aria-label="Remove from wishlist" data-product-id="<?php echo e($item['productId']); ?>" <?php if($isSharedView): ?> disabled <?php endif; ?>>
              <i data-lucide="heart" aria-hidden="true"></i>
            </button>
          </div>
          <div class="wl-card-body">
            <h3 class="plp-card-name"><?php echo e($item['name']); ?></h3>
            <?php if($item['variant']): ?>
              <p class="plp-card-variant"><?php echo e($item['variant']); ?></p>
            <?php endif; ?>
            <p class="plp-card-price"><?php echo $item['priceHtml']; ?></p>
            <div class="wl-card-actions">
              <button class="wl-card-bag" data-product-id="<?php echo e($item['productId']); ?>">MOVE TO BAG</button>
              <?php if (! ($isSharedView)): ?>
                <button class="wl-card-delete wl-remove-btn" aria-label="Remove from wishlist" data-product-id="<?php echo e($item['productId']); ?>">
                  <i data-lucide="trash-2" aria-hidden="true"></i>
                </button>
              <?php endif; ?>
            </div>
            <p class="wl-card-saved">Saved <?php echo e($item['savedAgo']); ?></p>
          </div>
        </article>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div><!-- /wl-grid -->

    <p class="wl-empty-hint">
      <span aria-hidden="true">&#9825;</span>
      Can&rsquo;t find something? Some pieces may have sold out.
    </p>
  <?php endif; ?>

  <?php if(!empty($recommendations)): ?>
    <section class="wl-recs" aria-labelledby="wl-recs-heading">
      <div class="wl-recs-head">
        <div>
          <h2 id="wl-recs-heading" class="wl-recs-title">You may also love</h2>
          <p class="wl-recs-sub">Handpicked pieces that go beautifully with your collection.</p>
        </div>
        <a href="<?php echo e(wc_get_page_permalink('shop')); ?>" class="wl-recs-viewall">View All</a>
      </div>
      <div class="carousel-stage">
        <button class="carousel-arrow carousel-arrow-prev wl-recs-prev" aria-label="Previous">
          <i data-lucide="chevron-left" aria-hidden="true"></i>
        </button>
        <div class="loom-track" id="wl-recs-carousel">
          <?php $__currentLoopData = $recommendations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('components.product-card', ['product' => $recProduct], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <button class="carousel-arrow carousel-arrow-next wl-recs-next" aria-label="Next">
          <i data-lucide="chevron-right" aria-hidden="true"></i>
        </button>
      </div>
      <div class="wl-recs-dots" role="tablist" aria-label="Carousel navigation"></div>
    </section>
  <?php endif; ?>

</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Admin\Local Sites\weavira\app\public\wp-content\themes\weavira\resources\views/page-wishlist.blade.php ENDPATH**/ ?>