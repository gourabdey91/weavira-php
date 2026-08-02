<?php $__env->startSection('content'); ?>

  <div class="page-shell">
    <div class="section-heading-center heritage-plp-heading">
      <?php if(get_field('journal_kicker', 'options')): ?><span class="section-kicker"><?php echo e(get_field('journal_kicker', 'options')); ?> <span aria-hidden="true">&#9670;</span></span><?php endif; ?>
      <h1><?php echo e(get_field('journal_heading', 'options') ?: 'The Journal'); ?></h1>
      <?php if(get_field('journal_desc', 'options')): ?><p><?php echo e(get_field('journal_desc', 'options')); ?></p><?php endif; ?>
    </div>
  </div>

  <div class="plp-layout page-shell">

    <aside class="plp-sidebar" id="plp-sidebar">
      <div class="plp-sidebar-inner">

        <div class="plp-filter-header">
          <span class="plp-filter-title">FILTER BY</span>
        </div>

        <?php if(!empty($categories)): ?>
          <div class="filter-group">
            <button class="filter-group-head" type="button" aria-expanded="true">
              CATEGORY <i data-lucide="chevron-up" aria-hidden="true"></i>
            </button>
            <div class="filter-group-body">
              <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <label class="filter-option">
                  <input type="checkbox" data-filter-attribute="category" value="<?php echo e($category['slug']); ?>" <?php if($category['checked']): echo 'checked'; endif; ?>>
                  <span><?php echo e($category['name']); ?> <em>(<?php echo e($category['count']); ?>)</em></span>
                </label>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          </div>
        <?php endif; ?>

        <button class="plp-clear-all" type="button" data-shop-url="<?php echo e(get_post_type_archive_link('journal')); ?>" <?php if(!$activeFilterCount): ?> hidden <?php endif; ?>>CLEAR ALL FILTERS</button>

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
          <span class="plp-count">Showing <?php echo e(count($posts)); ?> of <?php echo e($totalCount); ?> Stor<?php echo e($totalCount === 1 ? 'y' : 'ies'); ?></span>
        </div>
      </div>

      <?php if(empty($posts)): ?>
        <div class="cart-empty">
          <i data-lucide="search-x" aria-hidden="true"></i>
          <p>No stories match this filter.</p>
          <button class="cart-continue-link" type="button" onclick="location.href='<?php echo e(get_post_type_archive_link('journal')); ?>'">Clear filters &rarr;</button>
        </div>
      <?php else: ?>
        <div class="plp-grid journal-listing-grid" id="plp-grid">
          <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a class="plp-card journal-listing-card" href="<?php echo e($post['link']); ?>">
              <div class="plp-card-img-wrap">
                <img src="<?php echo e($post['image']); ?>" alt="<?php echo e($post['title']); ?>" class="plp-card-img" loading="lazy">
              </div>
              <div class="plp-card-body journal-listing-body">
                <?php if($post['category']): ?>
                  <span class="section-kicker"><?php echo e($post['category']); ?></span>
                <?php endif; ?>
                <h3 class="plp-card-name"><?php echo e($post['title']); ?></h3>
                <?php if($post['excerpt']): ?>
                  <p class="journal-listing-excerpt"><?php echo e($post['excerpt']); ?></p>
                <?php endif; ?>
                <div class="journal-listing-meta">
                  <span class="journal-listing-readtime"><i data-lucide="clock" aria-hidden="true"></i><?php echo e($post['readTime']); ?></span>
                  <span class="journal-listing-date"><?php echo e($post['date']); ?></span>
                </div>
              </div>
            </a>
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

  <div class="page-shell">
    <a class="wv-journal-explore-bar heritage-journal-bar" href="<?php echo e(wc_get_page_permalink('shop')); ?>">
      <i data-lucide="shopping-bag" aria-hidden="true"></i>
      <span>Every story ends with a saree. Explore the handwoven pieces behind the traditions you just read about.</span>
      <span class="heritage-journal-bar-cta">SHOP THE COLLECTION &#8594;</span>
    </a>
  </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u908449413/domains/weavira.com/public_html/wp-content/themes/weavira/resources/views/archive-journal.blade.php ENDPATH**/ ?>