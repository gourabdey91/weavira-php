<?php
  $shopUrl = wc_get_page_permalink('shop');
  $breadcrumbTail = end($breadcrumb);
?>

<?php $__env->startSection('content'); ?>

  <nav class="plp-breadcrumb plp-breadcrumb-below" aria-label="Breadcrumb">
    <a href="<?php echo e(home_url('/')); ?>">Home</a>
    <?php $__currentLoopData = $breadcrumb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $crumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <span>/</span>
      <?php if($i === count($breadcrumb) - 1): ?>
        <span aria-current="page"><?php echo e($crumb); ?></span>
      <?php else: ?>
        <a href="<?php echo e($shopUrl); ?>"><?php echo e($crumb); ?></a>
      <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </nav>

  <section class="plp-hero">
    <picture>
      <?php if($banner['image']): ?>
        <source media="(min-width: 769px)" srcset="<?php echo e($banner['image']); ?>">
        <img src="<?php echo e($banner['image']); ?>" alt="<?php echo e($banner['heading']); ?>" class="plp-hero-img">
      <?php endif; ?>
    </picture>
    <div class="plp-hero-overlay"></div>
    <div class="plp-hero-content">
      <nav class="plp-breadcrumb" aria-label="Breadcrumb">
        <a href="<?php echo e(home_url('/')); ?>">Home</a>
        <?php $__currentLoopData = $breadcrumb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $crumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <span>/</span>
          <?php if($i === count($breadcrumb) - 1): ?>
            <span aria-current="page"><?php echo e($crumb); ?></span>
          <?php else: ?>
            <a href="<?php echo e($shopUrl); ?>"><?php echo e($crumb); ?></a>
          <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </nav>
      <h1 class="plp-hero-heading"><?php echo e($banner['heading']); ?></h1>
      <?php if($banner['sub']): ?>
        <p class="plp-hero-sub"><?php echo e($banner['sub']); ?></p>
      <?php endif; ?>
    </div>
  </section>

  <div class="plp-trust">
    <div class="plp-trust-item">
      <div class="plp-trust-icon"><i data-lucide="truck" aria-hidden="true"></i></div>
      <div class="plp-trust-text">
        <strong>Free Shipping</strong>
        <span>On all orders above &#8377;999</span>
      </div>
    </div>
    <div class="plp-trust-item plp-trust-hide-mobile">
      <div class="plp-trust-icon"><i data-lucide="lock" aria-hidden="true"></i></div>
      <div class="plp-trust-text">
        <strong>Secure Checkout</strong>
        <span>256-bit SSL on every transaction</span>
      </div>
    </div>
    <div class="plp-trust-item">
      <div class="plp-trust-icon"><i data-lucide="credit-card" aria-hidden="true"></i></div>
      <div class="plp-trust-text">
        <strong>All Cards Accepted</strong>
        <span>Visa, Mastercard, RuPay &amp; UPI</span>
      </div>
    </div>
  </div>

  <div class="plp-layout page-shell">

    <aside class="plp-sidebar" id="plp-sidebar">
      <div class="plp-sidebar-inner">

        <div class="plp-filter-header">
          <span class="plp-filter-title">FILTER BY</span>
        </div>

        <?php $__currentLoopData = $filterGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="filter-group">
            <button class="filter-group-head" type="button" aria-expanded="true">
              <?php echo e(strtoupper($group['label'])); ?> <i data-lucide="chevron-up" aria-hidden="true"></i>
            </button>
            <div class="filter-group-body">
              <?php $__currentLoopData = $group['terms']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <label class="filter-option">
                  <input type="checkbox" data-filter-attribute="<?php echo e($group['slug']); ?>" value="<?php echo e($term['slug']); ?>" <?php if($term['checked']): echo 'checked'; endif; ?>>
                  <span><?php echo e($term['name']); ?> <em>(<?php echo e($term['count']); ?>)</em></span>
                </label>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php if(!empty($colourSwatches)): ?>
          <div class="filter-group">
            <button class="filter-group-head" type="button" aria-expanded="true">
              COLOR <i data-lucide="chevron-up" aria-hidden="true"></i>
            </button>
            <div class="filter-group-body">
              <div class="color-swatches">
                <?php $__currentLoopData = $colourSwatches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $swatch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <button
                    class="color-swatch <?php if($swatch['checked']): ?> selected <?php endif; ?>"
                    type="button"
                    style="background:<?php echo e($swatch['hex']); ?>"
                    aria-label="<?php echo e($swatch['name']); ?>"
                    data-filter-attribute="body-primary-colour"
                    data-filter-value="<?php echo e($swatch['slug']); ?>"
                    aria-pressed="<?php echo e($swatch['checked'] ? 'true' : 'false'); ?>"
                  ></button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            </div>
          </div>
        <?php endif; ?>

        <?php if($priceRange['ceil'] > $priceRange['floor']): ?>
          <div class="filter-group">
            <button class="filter-group-head" type="button" aria-expanded="true">
              PRICE <i data-lucide="chevron-up" aria-hidden="true"></i>
            </button>
            <div class="filter-group-body">
              <div class="price-inputs">
                <input type="number" class="price-input" id="plp-price-min" placeholder="Min" value="<?php echo e((int) $priceRange['min']); ?>" min="<?php echo e((int) $priceRange['floor']); ?>" max="<?php echo e((int) $priceRange['ceil']); ?>" aria-label="Minimum price">
                <span>to</span>
                <input type="number" class="price-input" id="plp-price-max" placeholder="Max" value="<?php echo e((int) $priceRange['max']); ?>" min="<?php echo e((int) $priceRange['floor']); ?>" max="<?php echo e((int) $priceRange['ceil']); ?>" aria-label="Maximum price">
              </div>
              <input type="range" class="price-slider" id="plp-price-slider" min="<?php echo e((int) $priceRange['floor']); ?>" max="<?php echo e((int) $priceRange['ceil']); ?>" value="<?php echo e((int) $priceRange['max']); ?>" aria-label="Price range">
              <div class="price-labels">
                <span><?php echo wc_price($priceRange['floor']); ?></span>
                <span><?php echo wc_price($priceRange['ceil']); ?></span>
              </div>
            </div>
          </div>
        <?php endif; ?>

        <button class="plp-clear-all" type="button" data-shop-url="<?php echo e($shopUrl); ?>" <?php if(!$activeFilterCount): ?> hidden <?php endif; ?>>CLEAR ALL</button>

      </div>
    </aside>

    <div class="plp-main">

      <div class="plp-toolbar">
        <div style="display:flex;align-items:center;gap:0.75rem;">
          <button class="plp-mobile-filter-btn" id="plp-filter-toggle" type="button" aria-expanded="false" aria-controls="plp-sidebar">
            <i data-lucide="sliders-horizontal" aria-hidden="true"></i>
            FILTER
            <?php if($activeFilterCount): ?><span>(<?php echo e($activeFilterCount); ?>)</span><?php endif; ?>
          </button>
          <span class="plp-count">Showing <?php echo e(count($products)); ?> of <?php echo e($totalProducts); ?> Product<?php echo e($totalProducts === 1 ? '' : 's'); ?></span>
        </div>
        <div class="plp-toolbar-right">
          <div class="plp-sort">
            <label for="plp-sort-select">Sort by:</label>
            <select id="plp-sort-select">
              <option value="menu_order" <?php if($currentSort === 'menu_order'): echo 'selected'; endif; ?>>Featured</option>
              <option value="price" <?php if($currentSort === 'price'): echo 'selected'; endif; ?>>Price: Low to High</option>
              <option value="price-desc" <?php if($currentSort === 'price-desc'): echo 'selected'; endif; ?>>Price: High to Low</option>
              <option value="date" <?php if($currentSort === 'date'): echo 'selected'; endif; ?>>Newest</option>
              <option value="popularity" <?php if($currentSort === 'popularity'): echo 'selected'; endif; ?>>Best Sellers</option>
            </select>
          </div>
          <div class="plp-view-toggle">
            <button class="plp-view-btn active" type="button" data-view="grid" aria-label="Grid view" aria-pressed="true">
              <i data-lucide="layout-grid" aria-hidden="true"></i>
            </button>
          </div>
        </div>
      </div>

      <?php if(empty($products)): ?>
        <div class="cart-empty">
          <i data-lucide="search-x" aria-hidden="true"></i>
          <p>No products match these filters.</p>
          <button class="cart-continue-link" type="button" data-shop-url="<?php echo e($shopUrl); ?>" onclick="location.href=this.dataset.shopUrl">Clear filters &rarr;</button>
        </div>
      <?php else: ?>
        <div class="plp-grid" id="plp-grid">
          <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('components.plp-card', ['product' => $product], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <?php if($maxPages > 1): ?>
          <nav class="plp-pagination" aria-label="Page navigation">
            <?php if($currentPage > 1): ?>
              <a class="plp-page-btn" href="<?php echo e(esc_url(add_query_arg('paged', $currentPage - 1))); ?>" aria-label="Previous page">&#8249;</a>
            <?php endif; ?>

            <?php for($p = 1; $p <= $maxPages; $p++): ?>
              <?php if($p === 1 || $p === $maxPages || abs($p - $currentPage) <= 1): ?>
                <a class="plp-page-btn <?php if($p === $currentPage): ?> active <?php endif; ?>" href="<?php echo e(esc_url(add_query_arg('paged', $p))); ?>" <?php if($p === $currentPage): ?> aria-current="page" <?php endif; ?>><?php echo e($p); ?></a>
              <?php elseif($p === 2 && $currentPage > 3): ?>
                <span class="plp-page-ellipsis" aria-hidden="true">&hellip;</span>
              <?php elseif($p === $maxPages - 1 && $currentPage < $maxPages - 2): ?>
                <span class="plp-page-ellipsis" aria-hidden="true">&hellip;</span>
              <?php endif; ?>
            <?php endfor; ?>

            <?php if($currentPage < $maxPages): ?>
              <a class="plp-page-btn" href="<?php echo e(esc_url(add_query_arg('paged', $currentPage + 1))); ?>" aria-label="Next page">&#8250;</a>
            <?php endif; ?>
          </nav>
        <?php endif; ?>
      <?php endif; ?>

    </div>

  </div>

  <?php $packagingImage = get_field('cart_packaging_image', 'option'); ?>
  <section class="plp-promise">
    <div class="plp-promise-intro">
      <h2 class="plp-promise-heading">Thoughtful by tradition.<br>Delivered with care.</h2>
      <p class="plp-promise-sub">Every order comes with the Weavira promise.</p>
    </div>
    <div class="plp-promise-features">
      <div class="plp-promise-item">
        <div class="plp-promise-icon"><i data-lucide="truck" aria-hidden="true"></i></div>
        <strong>Free Shipping</strong>
        <span>Across India on all orders</span>
      </div>
      <div class="plp-promise-item">
        <div class="plp-promise-icon"><i data-lucide="credit-card" aria-hidden="true"></i></div>
        <strong>All Cards Accepted</strong>
        <span>Visa, Mastercard, Amex &amp; more</span>
      </div>
      <div class="plp-promise-item">
        <div class="plp-promise-icon"><i data-lucide="gift" aria-hidden="true"></i></div>
        <strong>Complimentary Gift Wrapping</strong>
        <span>Beautifully wrapped, ready to be gifted</span>
      </div>
    </div>
    <?php if($packagingImage): ?>
      <div class="plp-promise-visual">
        <img src="<?php echo e($packagingImage); ?>" alt="Weavira gift packaging" class="plp-promise-img" loading="lazy">
      </div>
    <?php endif; ?>
  </section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Admin\Local Sites\weavira\app\public\wp-content\themes\weavira\resources\views/woocommerce\archive-product.blade.php ENDPATH**/ ?>