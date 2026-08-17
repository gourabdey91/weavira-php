<?php $__env->startSection('content'); ?>

  <div class="page-shell">
    <div class="section-heading-center heritage-plp-heading">
      <h1>Heritage Designs</h1>
      <p>Discover the motifs and symbols that give every saree its meaning.</p>
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
                    data-filter-attribute="color"
                    data-filter-value="<?php echo e($swatch['slug']); ?>"
                    aria-pressed="<?php echo e($swatch['checked'] ? 'true' : 'false'); ?>"
                  ></button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            </div>
          </div>
        <?php endif; ?>

        <button class="plp-clear-all" type="button" data-shop-url="<?php echo e(get_post_type_archive_link('heritage_design')); ?>" <?php if(!$activeFilterCount): ?> hidden <?php endif; ?>>CLEAR ALL FILTERS</button>

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
          <span class="plp-count">Showing <?php echo e(count($cards)); ?> of <?php echo e($totalCount); ?> Design<?php echo e($totalCount === 1 ? '' : 's'); ?></span>
        </div>
        <div class="plp-toolbar-right">
          <div class="plp-sort">
            <label for="plp-sort-select">Sort by:</label>
            <select id="plp-sort-select">
              <option value="menu_order" <?php if($currentSort === 'menu_order'): echo 'selected'; endif; ?>>Featured</option>
              <option value="most-designs" <?php if($currentSort === 'most-designs'): echo 'selected'; endif; ?>>Most Designs</option>
              <option value="date" <?php if($currentSort === 'date'): echo 'selected'; endif; ?>>Newest</option>
              <option value="title" <?php if($currentSort === 'title'): echo 'selected'; endif; ?>>A&#8211;Z</option>
            </select>
          </div>
        </div>
      </div>

      <?php if(empty($cards)): ?>
        <div class="cart-empty">
          <i data-lucide="search-x" aria-hidden="true"></i>
          <p>No motifs match these filters.</p>
          <button class="cart-continue-link" type="button" onclick="location.href='<?php echo e(get_post_type_archive_link('heritage_design')); ?>'">Clear filters &rarr;</button>
        </div>
      <?php else: ?>
        <div class="plp-grid heritage-motif-grid" id="plp-grid">
          <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a class="plp-card heritage-motif-card" href="<?php echo e($card['link']); ?>">
              <div class="plp-card-img-wrap">
                <img src="<?php echo e($card['image']); ?>" alt="<?php echo e($card['name']); ?> motif" class="plp-card-img" loading="lazy">
              </div>
              <div class="plp-card-body heritage-motif-body">
                <h3 class="plp-card-name"><?php echo e($card['name']); ?></h3>
                <?php if($card['excerpt']): ?>
                  <p class="heritage-motif-desc"><?php echo e($card['excerpt']); ?></p>
                <?php endif; ?>
                <div class="heritage-motif-meta">
                  <span class="heritage-motif-count"><?php echo e($card['count']); ?> Design<?php echo e($card['count'] === 1 ? '' : 's'); ?></span>
                  <span class="heritage-motif-link">VIEW DESIGNS &#8594;</span>
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
    <a class="wv-journal-explore-bar heritage-journal-bar" href="<?php echo e(get_post_type_archive_link('journal')); ?>">
      <i data-lucide="book-open" aria-hidden="true"></i>
      <span>Each motif carries a meaning. Each weave carries a legacy. Learn more about the stories behind our motifs in the Weavira Journal.</span>
      <span class="heritage-journal-bar-cta">EXPLORE JOURNAL &#8594;</span>
    </a>
  </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Admin\Local Sites\weavira\app\public\wp-content\themes\weavira\resources\views/archive-heritage_design.blade.php ENDPATH**/ ?>