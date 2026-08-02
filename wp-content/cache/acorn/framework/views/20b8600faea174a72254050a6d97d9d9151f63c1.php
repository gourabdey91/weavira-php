
<header class="site-header">
    <div class="header-grid">

      <!-- Left nav: Shop (mega trigger) + Gifting + Journal + About Us -->
      <nav class="site-nav" aria-label="Main navigation">
        <div class="nav-item has-mega" id="nav-shop">
          <button class="nav-trigger" id="shop-trigger"
                  aria-expanded="false" aria-haspopup="true" aria-controls="mega-shop">
            SHOP
          </button>
        </div>
        <div class="nav-item has-mega" id="nav-gifting">
          <button class="nav-trigger" id="gifting-trigger"
                  aria-expanded="false" aria-haspopup="true" aria-controls="mega-gifting">
            GIFTING
          </button>
        </div>
        <div class="nav-item has-mega" id="nav-journal">
          <button class="nav-trigger" id="journal-trigger"
                  aria-expanded="false" aria-haspopup="true" aria-controls="mega-journal-menu">
            JOURNAL
          </button>
        </div>
        <div class="nav-item has-mega" id="nav-about">
          <button class="nav-trigger" id="about-trigger"
                  aria-expanded="false" aria-haspopup="true" aria-controls="mega-about">
            ABOUT US
          </button>
        </div>
      </nav>

      <!-- Centre logo -->
      <div class="brand-wrap">
        <a class="brand" href="<?php echo e(home_url('/')); ?>"><img src="<?php echo get_field('arc_option_logo', 'option'); ?>" alt="<?php echo $siteName; ?>" class="brand-logo" /></a>
      </div>

      <!-- Right: icon buttons -->
      <div class="nav-actions">
        <button class="icon-button" aria-label="Search">
          <i data-lucide="search" aria-hidden="true"></i>
        </button>
        <a href="<?php echo e(wc_get_page_permalink('myaccount')); ?>" class="icon-button" aria-label="My Account">
          <i data-lucide="user" aria-hidden="true"></i>
        </a>
        <a href="<?php echo e($wishlistUrl); ?>" class="icon-button nav-btn-badge" aria-label="Wishlist">
          <i data-lucide="heart" aria-hidden="true"></i>
          <span class="nav-badge wv-wishlist-badge" aria-label="<?php echo e($wishlistCount); ?> item<?php echo e($wishlistCount === 1 ? '' : 's'); ?>" <?php if($wishlistCount < 1): ?> hidden <?php endif; ?>><?php echo e($wishlistCount); ?></span>
        </a>
        <a href="<?php echo e(wc_get_cart_url()); ?>" class="icon-button nav-btn-badge cart-button" aria-label="Cart">
          <i data-lucide="shopping-cart" aria-hidden="true"></i>
          <span class="nav-badge wv-cart-badge" aria-label="<?php echo e($cartCount); ?> item<?php echo e($cartCount === 1 ? '' : 's'); ?>" <?php if($cartCount < 1): ?> hidden <?php endif; ?>><?php echo e($cartCount); ?></span>
        </a>
      </div>

    </div>

    <!-- ─── SHOP MEGA MENU ─────────────────────────────────────────────── -->
    <div class="mega-menu" id="mega-shop" aria-hidden="true">
      <div class="mega-inner">
        <div class="mega-content-grid">

          <!-- ── Left: 4 browse columns ───────────────────────────────── -->
          <div class="mega-browse">
            <div class="mega-browse-cols">

              <!-- Editorial image -->
              <?php if($shopMega['feature']['image']): ?>
                <div class="mega-col mega-col--img">
                  <img src="<?php echo e($shopMega['feature']['image']); ?>" class="mega-col-img" alt="<?php echo e($shopMega['feature']['label']); ?>" loading="lazy">
                  <div class="mega-col-img-overlay">
                    <p class="mega-col-img-label"><?php echo e($shopMega['feature']['label']); ?></p>
                    <?php if(!empty($shopMega['feature']['link']['url'])): ?>
                      <a href="<?php echo e($shopMega['feature']['link']['url']); ?>" class="mega-col-img-btn"><?php echo e($shopMega['feature']['link']['title'] ?: 'VIEW'); ?></a>
                    <?php endif; ?>
                  </div>
                </div>
              <?php endif; ?>

              <!-- Material -->
              <?php if(!empty($shopMega['materials'])): ?>
                <div class="mega-col">
                  <div class="mega-col-head">
                    <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.3" aria-hidden="true"><path d="M10 2c-2 3-4 5-4 8a4 4 0 008 0c0-3-2-5-4-8z"/></svg>
                    <span>BY MATERIAL</span>
                  </div>
                  <span class="mega-col-rule" aria-hidden="true"></span>
                  <ul class="mega-col-list">
                    <?php $__currentLoopData = $shopMega['materials']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <li><a href="<?php echo e($item['link']); ?>" class="mega-col-item">
                        <?php if($item['thumbnail']): ?><img src="<?php echo e($item['thumbnail']); ?>" class="mega-item-thumb" alt="" loading="lazy" aria-hidden="true"><?php endif; ?>
                        <?php echo e($item['name']); ?>

                      </a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </ul>
                  <a href="<?php echo e(wc_get_page_permalink('shop')); ?>" class="mega-col-viewall">View all materials →</a>
                </div>
              <?php endif; ?>

              <!-- Design -->
              <?php if(!empty($shopMega['designs'])): ?>
                <div class="mega-col">
                  <div class="mega-col-head">
                    <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.3" aria-hidden="true"><rect x="3" y="3" width="6" height="6"/><rect x="11" y="3" width="6" height="6"/><rect x="3" y="11" width="6" height="6"/><rect x="11" y="11" width="6" height="6"/></svg>
                    <span>BY DESIGN</span>
                  </div>
                  <span class="mega-col-rule" aria-hidden="true"></span>
                  <ul class="mega-col-list">
                    <?php $__currentLoopData = $shopMega['designs']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <li><a href="<?php echo e($item['link']); ?>" class="mega-col-item">
                        <?php if($item['thumbnail']): ?><img src="<?php echo e($item['thumbnail']); ?>" class="mega-item-thumb" alt="" loading="lazy" aria-hidden="true"><?php endif; ?>
                        <?php echo e($item['name']); ?>

                      </a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </ul>
                  <a href="<?php echo e(wc_get_page_permalink('shop')); ?>" class="mega-col-viewall">View all designs →</a>
                </div>
              <?php endif; ?>

              <!-- Occasion -->
              <?php if(!empty($shopMega['occasions'])): ?>
                <div class="mega-col">
                  <div class="mega-col-head">
                    <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.3" aria-hidden="true"><circle cx="10" cy="7" r="3"/><path d="M4 17c0-3.3 2.7-6 6-6s6 2.7 6 6"/></svg>
                    <span>BY OCCASION</span>
                  </div>
                  <span class="mega-col-rule" aria-hidden="true"></span>
                  <ul class="mega-col-list">
                    <?php $__currentLoopData = $shopMega['occasions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <li><a href="<?php echo e($item['link']); ?>" class="mega-col-item"><i data-lucide="<?php echo e($item['icon']); ?>" class="mega-item-icon" aria-hidden="true"></i><?php echo e($item['name']); ?></a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </ul>
                  <a href="<?php echo e(wc_get_page_permalink('shop')); ?>" class="mega-col-viewall">View all occasions →</a>
                </div>
              <?php endif; ?>

              <!-- Weave -->
              <?php if(!empty($shopMega['weaves'])): ?>
                <div class="mega-col">
                  <div class="mega-col-head">
                    <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.3" aria-hidden="true"><path d="M2 5q3-4 4 0t4 0 4 0"/><path d="M2 10q3-4 4 0t4 0 4 0"/><path d="M2 15q3-4 4 0t4 0 4 0"/></svg>
                    <span>BY WEAVE</span>
                  </div>
                  <span class="mega-col-rule" aria-hidden="true"></span>
                  <ul class="mega-col-list">
                    <?php $__currentLoopData = $shopMega['weaves']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <li><a href="<?php echo e($item['link']); ?>" class="mega-col-item">
                        <?php if($item['thumbnail']): ?><img src="<?php echo e($item['thumbnail']); ?>" class="mega-item-thumb" alt="" loading="lazy" aria-hidden="true"><?php endif; ?>
                        <?php echo e($item['name']); ?>

                      </a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </ul>
                  <a href="<?php echo e(wc_get_page_permalink('shop')); ?>" class="mega-col-viewall">View all weaves →</a>
                </div>
              <?php endif; ?>

            </div><!-- /mega-browse-cols -->

          </div><!-- /mega-browse -->

          <!-- ── Right panel: Browse by Collection only ─────────────── -->
          <?php if(!empty($shopMega['collections'])): ?>
            <div class="mega-right-panel">
              <div class="mega-right-section mega-right-section--last">
                <div class="mega-right-head">
                  <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.3" aria-hidden="true"><path d="M10 2l2.4 5 5.6.8-4 3.9.9 5.5L10 14.8l-4.9 2.4.9-5.5L2 7.8l5.6-.8z"/></svg>
                  <span>BY COLLECTION</span>
                </div>
                <ul class="mega-collection-list">
                  <?php $__currentLoopData = $shopMega['collections']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $collection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><a href="<?php echo e($collection['link']['url'] ?? '#'); ?>" class="mega-collection-item">
                      <?php if($collection['image']): ?><img src="<?php echo e($collection['image']); ?>" class="mega-collection-thumb" alt="" loading="lazy" aria-hidden="true"><?php endif; ?>
                      <div class="mega-collection-text">
                        <span class="mega-collection-title"><?php echo e($collection['title']); ?></span>
                        <span class="mega-collection-sub"><?php echo e($collection['subtitle']); ?></span>
                      </div>
                      <svg class="mega-chevron" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M6 4l4 4-4 4"/></svg>
                    </a></li>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
              </div>
            </div><!-- /mega-right-panel -->
          <?php endif; ?>

        </div><!-- /mega-content-grid -->

        <!-- ── Budget + Colour row (full width, below dividing line) ── -->
        <div class="mega-split-row">

          <!-- Shop by Budget (left) -->
          <?php if(!empty($shopMega['budgets'])): ?>
            <div class="mega-split-budget">
              <div class="mega-right-head">
                <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.3" aria-hidden="true"><rect x="2" y="5" width="16" height="11" rx="1"/><path d="M2 9h16"/><circle cx="6" cy="13" r="1" fill="currentColor" stroke="none"/></svg>
                <span>SHOP BY BUDGET</span>
              </div>
              <div class="mega-budget-grid">
                <?php $__currentLoopData = $shopMega['budgets']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <a href="<?php echo e($tier['link']); ?>" class="mega-budget-btn"><?php echo e($tier['label']); ?></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            </div>
          <?php endif; ?>

          <!-- Shop by Colour (right) -->
          <?php if(!empty($shopMega['colours'])): ?>
            <div class="mega-split-colour">
              <div class="mega-right-head">
                <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.3" aria-hidden="true"><circle cx="10" cy="10" r="8"/><circle cx="7" cy="8" r="1.5" fill="currentColor" stroke="none"/><circle cx="13" cy="8" r="1.5" fill="currentColor" stroke="none"/><circle cx="10" cy="13" r="1.5" fill="currentColor" stroke="none"/></svg>
                <span>SHOP BY COLOUR</span>
              </div>
              <div class="mega-split-colour-body">
                <div class="mega-colour-grid">
                  <?php $__currentLoopData = $shopMega['colours']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $colour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e($colour['link']); ?>" class="mega-colour-swatch"><span class="mega-colour-dot" style="background:<?php echo e($colour['hex']); ?>"></span><span class="mega-colour-label"><?php echo e($colour['name']); ?></span></a>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <a href="<?php echo e(wc_get_page_permalink('shop')); ?>" class="mega-col-viewall">View all colours →</a>
              </div>
            </div>
          <?php endif; ?>

        </div><!-- /mega-split-row -->

        <!-- ── Editorial footer banner ───────────────────────────────── -->
        <?php if($shopMega['bannerHeading'] || $shopMega['bannerSub']): ?>
          <div class="mega-footer-banner">
            <div class="mega-footer-body">
              <?php if($shopMega['bannerHeading']): ?><p class="mega-footer-heading"><?php echo e($shopMega['bannerHeading']); ?></p><?php endif; ?>
              <?php if($shopMega['bannerSub']): ?><p class="mega-footer-sub"><?php echo e($shopMega['bannerSub']); ?></p><?php endif; ?>
            </div>
          </div><!-- /mega-footer-banner -->
        <?php endif; ?>

      </div><!-- /mega-inner -->
    </div><!-- /mega-menu #mega-shop -->

    <!-- ─── JOURNAL MEGA MENU ─────────────────────────────────────────────── -->
    <div class="mega-menu" id="mega-journal-menu" aria-hidden="true">
      <div class="mega-inner mega-inner--journal">

        <!-- ── Top: journal intro + featured editorial ──────────── -->
        <div class="mjn-top">

          <!-- Left: journal intro -->
          <div class="mjn-intro">
            <?php if($journalMega['kicker']): ?><p class="mjn-kicker"><?php echo e($journalMega['kicker']); ?></p><?php endif; ?>
            <span class="mega-col-rule" aria-hidden="true"></span>
            <?php if($journalMega['heading']): ?><h3 class="mjn-intro-heading"><?php echo e($journalMega['heading']); ?></h3><?php endif; ?>
            <?php if($journalMega['desc']): ?><p class="mjn-intro-desc"><?php echo e($journalMega['desc']); ?></p><?php endif; ?>
          </div>

          <!-- Right: featured editorial -->
          <?php if($journalMega['featured']['image']): ?>
            <div class="mjn-hero">
              <div class="mjn-hero-img-wrap">
                <img src="<?php echo e($journalMega['featured']['image']); ?>" class="mjn-hero-img" alt="<?php echo e($journalMega['featured']['heading']); ?>" loading="lazy">
              </div>
              <div class="mjn-hero-overlay">
                <?php if($journalMega['featured']['kicker']): ?><p class="mjn-kicker"><?php echo e($journalMega['featured']['kicker']); ?></p><?php endif; ?>
                <span class="mega-col-rule" aria-hidden="true"></span>
                <?php if($journalMega['featured']['heading']): ?><h3 class="mjn-hero-heading"><?php echo e($journalMega['featured']['heading']); ?></h3><?php endif; ?>
                <?php if($journalMega['featured']['desc']): ?><p class="mjn-hero-desc"><?php echo e($journalMega['featured']['desc']); ?></p><?php endif; ?>
                <?php if($journalMega['featured']['readtime']): ?>
                  <span class="mjn-readtime">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <?php echo e($journalMega['featured']['readtime']); ?>

                  </span>
                <?php endif; ?>
                <?php if(!empty($journalMega['featured']['link']['url'])): ?>
                  <a href="<?php echo e($journalMega['featured']['link']['url']); ?>" class="mjn-cta">READ STORY &rarr;</a>
                <?php endif; ?>
              </div>
            </div>
          <?php endif; ?>

        </div><!-- /mjn-top -->

        <!-- ── Category tiles ──────────────────────────────────────── -->
        <?php if(!empty($journalMega['categories'])): ?>
          <div class="mjn-cat-row">
            <?php $__currentLoopData = $journalMega['categories']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <a href="<?php echo e($category['link']['url'] ?? '#'); ?>" class="mjn-cat-card">
                <?php if($category['image']): ?>
                  <picture class="mjn-cat-media">
                    <img src="<?php echo e($category['image']); ?>" alt="" loading="lazy">
                  </picture>
                <?php endif; ?>
                <h4 class="mjn-cat-title"><?php echo e($category['title']); ?></h4>
                <p class="mjn-cat-desc"><?php echo e($category['desc']); ?></p>
                <span class="mjn-cat-link">EXPLORE &rarr;</span>
              </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div><!-- /mjn-cat-row -->
        <?php endif; ?>

        <?php if(!empty($journalMega['exploreLink']['url'])): ?>
          <a href="<?php echo e($journalMega['exploreLink']['url']); ?>" class="mjn-explore-all">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M2 3h6a4 4 0 014 4v14a3 3 0 00-3-3H2z"/><path d="M22 3h-6a4 4 0 00-4 4v14a3 3 0 013-3h7z"/></svg>
            <?php echo e($journalMega['exploreLink']['title'] ?: 'EXPLORE ALL STORIES'); ?>

          </a>
        <?php endif; ?>

      </div><!-- /mega-inner -->
    </div><!-- /mega-menu #mega-journal-menu -->

    <!-- ─── GIFTING MEGA MENU ─────────────────────────────────────────────── -->
    <div class="mega-menu" id="mega-gifting" aria-hidden="true">
      <div class="mega-inner mega-inner--gifting">

        <!-- ── Main 4-col grid ──────────────────────────────────────────── -->
        <div class="mgft-main">

          <!-- Col 1: Brand pitch + features -->
          <div class="mgft-left">
            <?php if($giftingMega['kicker']): ?><p class="mgft-kicker"><?php echo e($giftingMega['kicker']); ?></p><?php endif; ?>
            <?php if($giftingMega['heading']): ?><h3 class="mgft-heading"><?php echo e($giftingMega['heading']); ?></h3><?php endif; ?>
            <?php if($giftingMega['sub']): ?><p class="mgft-sub"><?php echo e($giftingMega['sub']); ?></p><?php endif; ?>
            <?php if(!empty($giftingMega['features'])): ?>
              <ul class="mgft-features">
                <?php $__currentLoopData = $giftingMega['features']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li class="mgft-feature">
                    <i data-lucide="<?php echo e($feature['icon'] ?: 'star'); ?>" class="mgft-feature-icon" aria-hidden="true"></i>
                    <span><?php echo e($feature['text']); ?></span>
                  </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
            <?php endif; ?>
          </div>

          <!-- Col 2: Gift image -->
          <?php if($giftingMega['image']): ?>
            <div class="mgft-img-wrap">
              <img src="<?php echo e($giftingMega['image']); ?>" alt="Weavira gift packaging" class="mgft-img" loading="lazy">
            </div>
          <?php endif; ?>

          <!-- Col 3: Gift by Occasion -->
          <?php if(!empty($giftingMega['occasions'])): ?>
            <div class="mgft-col">
              <p class="mgft-col-head">GIFT BY OCCASION</p>
              <ul class="mgft-list">
                <?php $__currentLoopData = $giftingMega['occasions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $occasion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li>
                    <a href="<?php echo e($occasion['link']['url'] ?? '#'); ?>" class="mgft-list-item">
                      <span class="mgft-item-icon">
                        <i data-lucide="<?php echo e($occasion['icon'] ?: 'heart'); ?>" aria-hidden="true"></i>
                      </span>
                      <span class="mgft-item-text">
                        <span class="mgft-item-title"><?php echo e($occasion['title']); ?></span>
                        <span class="mgft-item-sub"><?php echo e($occasion['subtitle']); ?></span>
                      </span>
                      <i data-lucide="chevron-right" class="mgft-chevron" aria-hidden="true"></i>
                    </a>
                  </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
              <?php if(!empty($giftingMega['occasionsViewAll']['url'])): ?>
                <a href="<?php echo e($giftingMega['occasionsViewAll']['url']); ?>" class="mgft-view-all">VIEW ALL OCCASIONS →</a>
              <?php endif; ?>
            </div>
          <?php endif; ?>

          <!-- Col 4: Gift by Relation -->
          <?php if(!empty($giftingMega['relations'])): ?>
            <div class="mgft-col">
              <p class="mgft-col-head">GIFT BY RELATION</p>
              <ul class="mgft-list">
                <?php $__currentLoopData = $giftingMega['relations']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li>
                    <a href="<?php echo e($relation['link']['url'] ?? '#'); ?>" class="mgft-list-item">
                      <span class="mgft-item-icon mgft-item-icon--circle">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                      </span>
                      <span class="mgft-item-text">
                        <span class="mgft-item-title"><?php echo e($relation['title']); ?></span>
                        <span class="mgft-item-sub"><?php echo e($relation['subtitle']); ?></span>
                      </span>
                    </a>
                  </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
              <?php if(!empty($giftingMega['relationsViewAll']['url'])): ?>
                <a href="<?php echo e($giftingMega['relationsViewAll']['url']); ?>" class="mgft-view-all">VIEW ALL RELATIONS →</a>
              <?php endif; ?>
            </div>
          <?php endif; ?>

        </div><!-- /mgft-main -->

        <!-- ── Bottom service bar ─────────────────────────────────────────── -->
        <div class="mgft-footer">
          <p class="mgft-footer-kicker">MAKE IT EXTRA SPECIAL</p>
          <?php if(!empty($giftingMega['services'])): ?>
            <div class="mgft-services">
              <?php $__currentLoopData = $giftingMega['services']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="mgft-service">
                  <i data-lucide="<?php echo e($service['icon'] ?: 'star'); ?>" class="mgft-service-icon" aria-hidden="true"></i>
                  <div>
                    <p class="mgft-service-title"><?php echo e($service['title']); ?></p>
                    <p class="mgft-service-sub"><?php echo e($service['subtitle']); ?></p>
                  </div>
                </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          <?php endif; ?>
          <?php if(!empty($giftingMega['whatsappLink']['url'])): ?>
            <a href="<?php echo e($giftingMega['whatsappLink']['url']); ?>" class="mgft-whatsapp">
              <div class="mgft-wa-icons" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 10.8 19.79 19.79 0 01.5 2.18 2 2 0 012.48 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 7.91a16 16 0 006.18 6.18l1.28-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
              </div>
              <?php if($giftingMega['whatsappHeading']): ?><p class="mgft-wa-heading"><?php echo e($giftingMega['whatsappHeading']); ?></p><?php endif; ?>
              <span class="mgft-wa-link">Chat with us on WhatsApp →</span>
            </a>
          <?php endif; ?>
        </div><!-- /mgft-footer -->

      </div><!-- /mega-inner--gifting -->
    </div><!-- /mega-menu #mega-gifting -->

    <!-- ─── ABOUT US MEGA MENU ────────────────────────────────────────────── -->
    <div class="mega-menu" id="mega-about" aria-hidden="true">
      <div class="mega-inner mega-inner--about">

        <!-- Two-column content grid -->
        <div class="mau-grid">

        <!-- Left: image panel with text overlay -->
        <?php if($aboutMega['hero']['image']): ?>
          <div class="mau-hero">
            <img src="<?php echo e($aboutMega['hero']['image']); ?>" alt="Weavira atelier" class="mau-hero-img" loading="lazy">
            <div class="mau-hero-overlay">
              <?php if($aboutMega['hero']['heading']): ?><h3 class="mau-hero-heading"><?php echo e($aboutMega['hero']['heading']); ?></h3><?php endif; ?>
              <?php if($aboutMega['hero']['tagline']): ?><p class="mau-hero-tagline"><em><?php echo e($aboutMega['hero']['tagline']); ?></em></p><?php endif; ?>
              <div class="mau-hero-rule" aria-hidden="true">
                <span class="mau-hero-rule-line"></span>
                <span class="mau-hero-rule-gem">◆</span>
                <span class="mau-hero-rule-line"></span>
              </div>
              <?php if($aboutMega['hero']['body']): ?><p class="mau-hero-body"><?php echo e($aboutMega['hero']['body']); ?></p><?php endif; ?>
              <?php if(!empty($aboutMega['hero']['ctaLink']['url'])): ?>
                <a href="<?php echo e($aboutMega['hero']['ctaLink']['url']); ?>" class="mau-hero-cta"><?php echo e($aboutMega['hero']['ctaLabel'] ?: 'READ OUR STORY'); ?> →</a>
              <?php endif; ?>
            </div>
          </div>
        <?php endif; ?>

        <!-- Right: two info columns + contact bar -->
        <div class="mau-right">

          <div class="mau-cols">

            <!-- Col 1: Why Weavira -->
            <div class="mau-col">
              <div class="mau-col-head">
                <div class="mau-col-icon-wrap">
                  <svg viewBox="0 0 36 36" fill="none" stroke="currentColor" stroke-width="1.3" aria-hidden="true">
                    <circle cx="18" cy="18" r="4.5"/>
                    <path d="M18 13.5C18 8 15 3 15 3S11 8 18 13.5Z"/>
                    <path d="M18 13.5C18 8 21 3 21 3S25 8 18 13.5Z"/>
                    <path d="M18 22.5C18 28 15 33 15 33S11 28 18 22.5Z"/>
                    <path d="M18 22.5C18 28 21 33 21 33S25 28 18 22.5Z"/>
                    <path d="M13.5 18C8 18 3 15 3 15S8 11 13.5 18Z"/>
                    <path d="M13.5 18C8 18 3 21 3 21S8 25 13.5 18Z"/>
                    <path d="M22.5 18C28 18 33 15 33 15S28 11 22.5 18Z"/>
                    <path d="M22.5 18C28 18 33 21 33 21S28 25 22.5 18Z"/>
                  </svg>
                </div>
                <div>
                  <p class="mau-col-title"><?php echo e($aboutMega['col1']['title'] ?: 'WHY WEAVIRA?'); ?></p>
                  <span class="mau-col-accent-line"></span>
                </div>
              </div>
              <?php if($aboutMega['col1']['desc']): ?><p class="mau-col-desc"><?php echo e($aboutMega['col1']['desc']); ?></p><?php endif; ?>
              <?php if(!empty($aboutMega['col1']['points'])): ?>
                <ul class="mau-list">
                  <?php $__currentLoopData = $aboutMega['col1']['points']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="mau-list-item">
                      <i data-lucide="<?php echo e($point['icon'] ?: 'star'); ?>" class="mau-item-icon" aria-hidden="true"></i>
                      <span><?php echo e($point['text']); ?></span>
                    </li>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
              <?php endif; ?>
              <?php if(!empty($aboutMega['col1']['ctaLink']['url'])): ?>
                <a href="<?php echo e($aboutMega['col1']['ctaLink']['url']); ?>" class="mau-cta-link"><?php echo e($aboutMega['col1']['ctaLabel'] ?: 'Read Our Story'); ?> →</a>
              <?php endif; ?>
            </div>

            <!-- Col 2: Why Handwoven -->
            <div class="mau-col mau-col--right">
              <div class="mau-col-head">
                <div class="mau-col-icon-wrap">
                  <svg viewBox="0 0 36 36" fill="none" stroke="currentColor" stroke-width="1.3" aria-hidden="true">
                    <path d="M18 2L34 18L18 34L2 18Z"/>
                    <path d="M18 9L27 18L18 27L9 18Z"/>
                    <circle cx="18" cy="18" r="3.5"/>
                  </svg>
                </div>
                <div>
                  <p class="mau-col-title"><?php echo e($aboutMega['col2']['title'] ?: 'WHY HANDWOVEN?'); ?></p>
                  <span class="mau-col-accent-line"></span>
                </div>
              </div>
              <?php if($aboutMega['col2']['desc']): ?><p class="mau-col-desc"><?php echo e($aboutMega['col2']['desc']); ?></p><?php endif; ?>
              <?php if(!empty($aboutMega['col2']['points'])): ?>
                <ul class="mau-list">
                  <?php $__currentLoopData = $aboutMega['col2']['points']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="mau-list-item">
                      <i data-lucide="<?php echo e($point['icon'] ?: 'star'); ?>" class="mau-item-icon" aria-hidden="true"></i>
                      <span><?php echo e($point['text']); ?></span>
                    </li>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
              <?php endif; ?>
              <?php if(!empty($aboutMega['col2']['ctaLink']['url'])): ?>
                <a href="<?php echo e($aboutMega['col2']['ctaLink']['url']); ?>" class="mau-cta-link"><?php echo e($aboutMega['col2']['ctaLabel'] ?: 'Discover the Craft'); ?> →</a>
              <?php endif; ?>
            </div>

          </div><!-- /mau-cols -->

          <!-- Bottom: Talk to Us bar -->
          <div class="mau-contact">
            <div class="mau-contact-head">
              <div>
                <p class="mau-contact-title"><?php echo e($aboutMega['contact']['title'] ?: 'TALK TO US'); ?></p>
                <?php if($aboutMega['contact']['sub']): ?><p class="mau-contact-sub"><?php echo e($aboutMega['contact']['sub']); ?></p><?php endif; ?>
              </div>
            </div>
            <?php if(!empty($aboutMega['contact']['actions'])): ?>
              <div class="mau-contact-actions">
                <?php $__currentLoopData = $aboutMega['contact']['actions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <a href="<?php echo e($action['link']['url'] ?? '#'); ?>" class="mau-contact-action">
                    <i data-lucide="<?php echo e($action['icon'] ?: 'mail'); ?>" class="mau-action-icon" aria-hidden="true"></i>
                    <span><?php echo e($action['label']); ?></span>
                  </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            <?php endif; ?>
          </div><!-- /mau-contact -->

        </div><!-- /mau-right -->

        </div><!-- /mau-grid -->

        <!-- Quote strip — full-bleed block, matches gifting menu pattern -->
        <?php if($aboutMega['quote']): ?>
          <div class="mau-quote-strip" aria-label="Brand quote">
            <span class="mau-quote-mark mau-quote-mark--open" aria-hidden="true">&ldquo;</span>
            <div class="mau-quote-body">
              <p class="mau-quote-text"><?php echo e($aboutMega['quote']); ?></p>
            </div>
            <span class="mau-quote-mark mau-quote-mark--close" aria-hidden="true">&rdquo;</span>
          </div>
        <?php endif; ?>

      </div><!-- /mega-inner--about -->
    </div><!-- /mega-menu #mega-about -->

  </header>

  <!-- Mobile topbar (hidden on desktop, page-wide sticky) -->
  <div class="mobile-topbar">
    <button class="icon-button mobile-menu-button" aria-label="Open menu" aria-expanded="false" aria-controls="mobile-drawer">
      <i data-lucide="menu" aria-hidden="true"></i>
    </button>
    <a href="<?php echo e(home_url('/')); ?>"><img src="<?php echo e(get_field('arc_option_logo', 'option')); ?>" alt="<?php echo e($siteName); ?>" class="mobile-logo-img" /></a>
    <a href="<?php echo e(wc_get_cart_url()); ?>" class="icon-button cart-button" aria-label="Cart">
      <i data-lucide="shopping-cart" aria-hidden="true"></i>
      <span class="nav-badge wv-cart-badge" aria-label="<?php echo e($cartCount); ?> item<?php echo e($cartCount === 1 ? '' : 's'); ?>" <?php if($cartCount < 1): ?> hidden <?php endif; ?>><?php echo e($cartCount); ?></span>
    </a>
  </div>

  <!-- ─── MOBILE DRAWER ─────────────────────────────────────────────────── -->
  <div class="mobile-drawer" id="mobile-drawer" aria-hidden="true">
    <div class="drawer-overlay" data-drawer-close></div>
    <div class="drawer-panel" role="dialog" aria-label="Mobile navigation">

      <!-- Header: X left · Logo centre -->
      <div class="drawer-header">
        <button class="drawer-close" type="button" aria-label="Close menu" data-drawer-close>
          <i data-lucide="x" aria-hidden="true"></i>
        </button>
        <img src="<?php echo e(get_field('arc_option_logo', 'option')); ?>" alt="<?php echo e($siteName); ?>" class="drawer-logo" />
        <span class="drawer-header-spacer"></span>
      </div>

      <!-- Main nav -->
      <nav class="drawer-nav">
        <div class="drawer-nav-row" data-target="drawer-sub-shop" role="button" tabindex="0" aria-label="Open Shop submenu">
          <span class="drawer-nav-icon"><i data-lucide="shopping-bag" aria-hidden="true"></i></span>
          <span class="drawer-nav-label">SHOP</span>
          <span class="drawer-nav-arrow">&#8250;</span>
        </div>
        <div class="drawer-nav-row" data-target="drawer-sub-gifting" role="button" tabindex="0" aria-label="Open Gifting submenu">
          <span class="drawer-nav-icon"><i data-lucide="gift" aria-hidden="true"></i></span>
          <span class="drawer-nav-label">GIFTING</span>
          <span class="drawer-nav-arrow">&#8250;</span>
        </div>
        <div class="drawer-nav-row" data-target="drawer-sub-journal" role="button" tabindex="0" aria-label="Open Journal submenu">
          <span class="drawer-nav-icon"><i data-lucide="book-open" aria-hidden="true"></i></span>
          <span class="drawer-nav-label">JOURNAL</span>
          <span class="drawer-nav-arrow">&#8250;</span>
        </div>
        <div class="drawer-nav-row" data-target="drawer-sub-about" role="button" tabindex="0" aria-label="Open About submenu">
          <span class="drawer-nav-icon"><i data-lucide="leaf" aria-hidden="true"></i></span>
          <span class="drawer-nav-label">ABOUT US</span>
          <span class="drawer-nav-arrow">&#8250;</span>
        </div>
      </nav>

      <!-- Utility links -->
      <div class="drawer-utility">
        <a href="<?php echo e($wishlistUrl); ?>"><i data-lucide="heart" aria-hidden="true"></i> Wishlist</a>
        <a href="#"><i data-lucide="package" aria-hidden="true"></i> Track Order</a>
        <a href="<?php echo e(wc_get_page_permalink('myaccount')); ?>"><i data-lucide="user" aria-hidden="true"></i> Login / Register</a>
      </div>

      <!-- Footer strip -->
      <?php if($shopMega['bannerHeading']): ?>
        <div class="drawer-footer-strip">
          <span class="drawer-footer-ornament">&#9670;</span>
          <p><?php echo e($shopMega['bannerHeading']); ?></p>
        </div>
      <?php endif; ?>

      <!-- ─── SUB-PANEL: SHOP ──────────────────────────────────────────── -->
      <div class="drawer-sub-panel" id="drawer-sub-shop">
        <div class="dsp-header">
          <button class="dsp-back" aria-label="Back"><i data-lucide="arrow-left" aria-hidden="true"></i></button>
          <span class="dsp-title">SHOP</span>
          <a href="<?php echo e(wc_get_cart_url()); ?>" class="dsp-cart" aria-label="Cart"><i data-lucide="shopping-cart" aria-hidden="true"></i></a>
        </div>

        <div class="dsp-body">
          <?php if($shopMega['feature']['image']): ?>
            <div class="dsp-hero">
              <img src="<?php echo e($shopMega['feature']['image']); ?>" alt="" class="dsp-hero-img" aria-hidden="true">
              <div class="dsp-hero-overlay">
                <?php if($shopMega['feature']['label']): ?><h3 class="dsp-hero-heading"><?php echo e($shopMega['feature']['label']); ?></h3><?php endif; ?>
                <?php if(!empty($shopMega['feature']['link']['url'])): ?>
                  <a href="<?php echo e($shopMega['feature']['link']['url']); ?>" class="dsp-hero-cta"><?php echo e($shopMega['feature']['link']['title'] ?: 'EXPLORE COLLECTION'); ?></a>
                <?php endif; ?>
              </div>
            </div>
          <?php endif; ?>

          <!-- Browse by Material accordion -->
          <?php if(!empty($shopMega['materials'])): ?>
            <div class="dsp-acc-wrap">
              <div class="dsp-row dsp-row--expandable" data-accordion="acc-material" role="button" tabindex="0" aria-expanded="false" aria-controls="acc-material">
                <span class="dsp-row-icon"><i data-lucide="droplets" aria-hidden="true"></i></span>
                <span class="dsp-row-text">
                  <span class="dsp-row-title">Browse by Material</span>
                  <span class="dsp-row-sub">Silk, Cotton, Tussar &amp; more</span>
                </span>
                <span class="dsp-row-arrow">&#8250;</span>
              </div>
              <div class="dsp-acc-body" id="acc-material" aria-hidden="true">
                <?php $__currentLoopData = $shopMega['materials']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <a href="<?php echo e($item['link']); ?>" class="dsp-acc-item"><?php echo e($item['name']); ?></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(wc_get_page_permalink('shop')); ?>" class="dsp-acc-viewall">View all materials &#8594;</a>
              </div>
            </div>
          <?php endif; ?>

          <!-- Browse by Design accordion -->
          <?php if(!empty($shopMega['designs'])): ?>
            <div class="dsp-acc-wrap">
              <div class="dsp-row dsp-row--expandable" data-accordion="acc-design" role="button" tabindex="0" aria-expanded="false" aria-controls="acc-design">
                <span class="dsp-row-icon"><i data-lucide="layout-grid" aria-hidden="true"></i></span>
                <span class="dsp-row-text">
                  <span class="dsp-row-title">Browse by Design</span>
                  <span class="dsp-row-sub">Pasapalli, Nabakothi &amp; more</span>
                </span>
                <span class="dsp-row-arrow">&#8250;</span>
              </div>
              <div class="dsp-acc-body" id="acc-design" aria-hidden="true">
                <?php $__currentLoopData = $shopMega['designs']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <a href="<?php echo e($item['link']); ?>" class="dsp-acc-item"><?php echo e($item['name']); ?></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(wc_get_page_permalink('shop')); ?>" class="dsp-acc-viewall">View all designs &#8594;</a>
              </div>
            </div>
          <?php endif; ?>

          <!-- Browse by Occasion accordion -->
          <?php if(!empty($shopMega['occasions'])): ?>
            <div class="dsp-acc-wrap">
              <div class="dsp-row dsp-row--expandable" data-accordion="acc-occasion" role="button" tabindex="0" aria-expanded="false" aria-controls="acc-occasion">
                <span class="dsp-row-icon"><i data-lucide="sparkles" aria-hidden="true"></i></span>
                <span class="dsp-row-text">
                  <span class="dsp-row-title">Browse by Occasion</span>
                  <span class="dsp-row-sub">Wedding, Festive &amp; more</span>
                </span>
                <span class="dsp-row-arrow">&#8250;</span>
              </div>
              <div class="dsp-acc-body" id="acc-occasion" aria-hidden="true">
                <?php $__currentLoopData = $shopMega['occasions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <a href="<?php echo e($item['link']); ?>" class="dsp-acc-item"><?php echo e($item['name']); ?></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(wc_get_page_permalink('shop')); ?>" class="dsp-acc-viewall">View all occasions &#8594;</a>
              </div>
            </div>
          <?php endif; ?>

          <!-- Browse by Weave accordion -->
          <?php if(!empty($shopMega['weaves'])): ?>
            <div class="dsp-acc-wrap">
              <div class="dsp-row dsp-row--expandable" data-accordion="acc-weave" role="button" tabindex="0" aria-expanded="false" aria-controls="acc-weave">
                <span class="dsp-row-icon"><i data-lucide="waves" aria-hidden="true"></i></span>
                <span class="dsp-row-text">
                  <span class="dsp-row-title">Browse by Weave</span>
                  <span class="dsp-row-sub">Sambalpuri, Bomkai &amp; more</span>
                </span>
                <span class="dsp-row-arrow">&#8250;</span>
              </div>
              <div class="dsp-acc-body" id="acc-weave" aria-hidden="true">
                <?php $__currentLoopData = $shopMega['weaves']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <a href="<?php echo e($item['link']); ?>" class="dsp-acc-item"><?php echo e($item['name']); ?></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(wc_get_page_permalink('shop')); ?>" class="dsp-acc-viewall">View all weaves &#8594;</a>
              </div>
            </div>
          <?php endif; ?>

          <!-- Browse by Collection accordion -->
          <?php if(!empty($shopMega['collections'])): ?>
            <div class="dsp-acc-wrap">
              <div class="dsp-row dsp-row--expandable" data-accordion="acc-collection" role="button" tabindex="0" aria-expanded="false" aria-controls="acc-collection">
                <span class="dsp-row-icon"><i data-lucide="star" aria-hidden="true"></i></span>
                <span class="dsp-row-text">
                  <span class="dsp-row-title">Browse by Collection</span>
                  <span class="dsp-row-sub">New Arrivals, Best Sellers &amp; more</span>
                </span>
                <span class="dsp-row-arrow">&#8250;</span>
              </div>
              <div class="dsp-acc-body" id="acc-collection" aria-hidden="true">
                <?php $__currentLoopData = $shopMega['collections']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $collection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <a href="<?php echo e($collection['link']['url'] ?? '#'); ?>" class="dsp-acc-item dsp-acc-item--with-sub">
                    <span class="dsp-acc-item-title"><?php echo e($collection['title']); ?></span>
                    <span class="dsp-acc-item-sub"><?php echo e($collection['subtitle']); ?></span>
                  </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            </div>
          <?php endif; ?>

          <?php if(!empty($shopMega['budgets'])): ?>
            <p class="dsp-section-label">Shop by Budget</p>
            <div class="dsp-budget-row">
              <?php $__currentLoopData = $shopMega['budgets']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e($tier['link']); ?>" class="dsp-budget-tag"><?php echo e($tier['label']); ?></a>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          <?php endif; ?>

          <?php if(!empty($shopMega['colours'])): ?>
            <p class="dsp-section-label">Shop by Colour</p>
            <div class="dsp-colour-row">
              <?php $__currentLoopData = $shopMega['colours']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $colour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e($colour['link']); ?>" class="dsp-colour-swatch" style="background:<?php echo e($colour['hex']); ?>;" title="<?php echo e($colour['name']); ?>" aria-label="<?php echo e($colour['name']); ?>"></a>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          <?php endif; ?>
        </div>

        <?php if($shopMega['bannerHeading']): ?>
          <div class="dsp-footer">
            <span class="dsp-footer-ornament">&#9670;</span>
            <p><?php echo e($shopMega['bannerHeading']); ?></p>
          </div>
        <?php endif; ?>
      </div>

      <!-- ─── SUB-PANEL: GIFTING ────────────────────────────────────────── -->
      <div class="drawer-sub-panel" id="drawer-sub-gifting">
        <div class="dsp-header">
          <button class="dsp-back" aria-label="Back"><i data-lucide="arrow-left" aria-hidden="true"></i></button>
          <span class="dsp-title">GIFTING</span>
          <a href="<?php echo e(wc_get_cart_url()); ?>" class="dsp-cart" aria-label="Cart"><i data-lucide="shopping-cart" aria-hidden="true"></i></a>
        </div>

        <div class="dsp-body">
          <?php if($giftingMega['image']): ?>
            <div class="dsp-hero">
              <img src="<?php echo e($giftingMega['image']); ?>" alt="" class="dsp-hero-img" aria-hidden="true">
              <div class="dsp-hero-overlay">
                <?php if($giftingMega['heading']): ?><h3 class="dsp-hero-heading"><?php echo e($giftingMega['heading']); ?></h3><?php endif; ?>
                <?php if($giftingMega['sub']): ?><p class="dsp-hero-sub"><?php echo e($giftingMega['sub']); ?></p><?php endif; ?>
              </div>
            </div>
          <?php endif; ?>

          <!-- Gift by Occasion accordion -->
          <?php if(!empty($giftingMega['occasions'])): ?>
            <div class="dsp-section-toggle" data-accordion="acc-gift-occasion" role="button" tabindex="0" aria-expanded="false" aria-controls="acc-gift-occasion">
              <span class="dsp-section-toggle-label">GIFT BY OCCASION</span>
              <span class="dsp-row-arrow">&#8250;</span>
            </div>
            <div class="dsp-acc-body dsp-acc-body--flat" id="acc-gift-occasion" aria-hidden="true">
              <?php $__currentLoopData = $giftingMega['occasions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $occasion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e($occasion['link']['url'] ?? '#'); ?>" class="dsp-acc-item dsp-acc-item--with-sub">
                  <span class="dsp-acc-item-title"><?php echo e($occasion['title']); ?></span>
                  <span class="dsp-acc-item-sub"><?php echo e($occasion['subtitle']); ?></span>
                </a>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php if(!empty($giftingMega['occasionsViewAll']['url'])): ?>
                <a href="<?php echo e($giftingMega['occasionsViewAll']['url']); ?>" class="dsp-acc-viewall dsp-acc-viewall--flat">View all occasions &#8594;</a>
              <?php endif; ?>
            </div>
          <?php endif; ?>

          <!-- Gift by Relation accordion -->
          <?php if(!empty($giftingMega['relations'])): ?>
            <div class="dsp-section-toggle" data-accordion="acc-gift-relation" role="button" tabindex="0" aria-expanded="false" aria-controls="acc-gift-relation">
              <span class="dsp-section-toggle-label">GIFT BY RELATION</span>
              <span class="dsp-row-arrow">&#8250;</span>
            </div>
            <div class="dsp-acc-body dsp-acc-body--flat" id="acc-gift-relation" aria-hidden="true">
              <?php $__currentLoopData = $giftingMega['relations']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e($relation['link']['url'] ?? '#'); ?>" class="dsp-acc-item dsp-acc-item--with-sub">
                  <span class="dsp-acc-item-title"><?php echo e($relation['title']); ?></span>
                  <span class="dsp-acc-item-sub"><?php echo e($relation['subtitle']); ?></span>
                </a>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php if(!empty($giftingMega['relationsViewAll']['url'])): ?>
                <a href="<?php echo e($giftingMega['relationsViewAll']['url']); ?>" class="dsp-acc-viewall dsp-acc-viewall--flat">View all &#8594;</a>
              <?php endif; ?>
            </div>
          <?php endif; ?>

          <?php if(!empty($giftingMega['services'])): ?>
            <div class="dsp-service-bar">
              <?php $__currentLoopData = $giftingMega['services']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="dsp-service-item">
                  <i data-lucide="<?php echo e($service['icon'] ?: 'star'); ?>" aria-hidden="true"></i>
                  <span><?php echo e($service['title']); ?></span>
                </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          <?php endif; ?>
        </div>

        <?php if(!empty($giftingMega['whatsappLink']['url'])): ?>
          <a href="<?php echo e($giftingMega['whatsappLink']['url']); ?>" class="dsp-whatsapp-bar">
            <i data-lucide="message-circle" aria-hidden="true"></i>
            <span><?php echo e($giftingMega['whatsappHeading']); ?><strong>Chat with us on WhatsApp &#8594;</strong></span>
          </a>
        <?php endif; ?>
      </div>

      <!-- ─── SUB-PANEL: JOURNAL ───────────────────────────────────────── -->
      <div class="drawer-sub-panel" id="drawer-sub-journal">
        <div class="dsp-header">
          <button class="dsp-back" aria-label="Back"><i data-lucide="arrow-left" aria-hidden="true"></i></button>
          <span class="dsp-title">JOURNAL</span>
          <a href="<?php echo e(wc_get_cart_url()); ?>" class="dsp-cart" aria-label="Cart"><i data-lucide="shopping-cart" aria-hidden="true"></i></a>
        </div>

        <div class="dsp-body">
          <?php if($journalMega['featured']['image']): ?>
            <div class="dsp-featured">
              <img src="<?php echo e($journalMega['featured']['image']); ?>" alt="" class="dsp-featured-img" aria-hidden="true">
              <div class="dsp-featured-overlay">
                <?php if($journalMega['featured']['kicker']): ?><span class="dsp-featured-kicker"><?php echo e($journalMega['featured']['kicker']); ?></span><?php endif; ?>
                <?php if($journalMega['featured']['heading']): ?><h3 class="dsp-featured-heading"><?php echo e($journalMega['featured']['heading']); ?></h3><?php endif; ?>
                <?php if($journalMega['featured']['desc']): ?><p class="dsp-featured-sub"><?php echo e($journalMega['featured']['desc']); ?></p><?php endif; ?>
                <?php if(!empty($journalMega['featured']['link']['url'])): ?>
                  <a href="<?php echo e($journalMega['featured']['link']['url']); ?>" class="dsp-featured-read"><i data-lucide="clock" aria-hidden="true"></i> <?php echo e($journalMega['featured']['readtime']); ?> &nbsp;&bull;&nbsp; Read Story &#8594;</a>
                <?php endif; ?>
              </div>
            </div>
          <?php endif; ?>

          <?php if($journalMega['kicker']): ?><p class="dsp-section-label"><?php echo e($journalMega['kicker']); ?></p><?php endif; ?>

          <?php if(!empty($journalMega['categories'])): ?>
            <div class="dsp-acc-wrap">
              <?php $__currentLoopData = $journalMega['categories']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e($category['link']['url'] ?? '#'); ?>" class="dsp-row">
                  <span class="dsp-row-text"><span class="dsp-row-title"><?php echo e($category['title']); ?></span><span class="dsp-row-sub"><?php echo e($category['desc']); ?></span></span>
                  <span class="dsp-row-arrow">&#8250;</span>
                </a>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          <?php endif; ?>

          <?php if(!empty($journalMega['exploreLink']['url'])): ?>
            <a href="<?php echo e($journalMega['exploreLink']['url']); ?>" class="dsp-explore-btn"><i data-lucide="book-open" aria-hidden="true"></i> <?php echo e($journalMega['exploreLink']['title'] ?: 'EXPLORE ALL STORIES'); ?> &#8594;</a>
          <?php endif; ?>
        </div>

        <?php if($journalMega['heading']): ?>
          <div class="dsp-footer">
            <p><?php echo e($journalMega['heading']); ?></p>
            <span class="dsp-footer-ornament">&#9670;</span>
          </div>
        <?php endif; ?>
      </div>

      <!-- ─── SUB-PANEL: ABOUT ─────────────────────────────────────────── -->
      <div class="drawer-sub-panel" id="drawer-sub-about">
        <div class="dsp-header">
          <button class="dsp-back" aria-label="Back"><i data-lucide="arrow-left" aria-hidden="true"></i></button>
          <span class="dsp-title">ABOUT</span>
          <a href="<?php echo e(wc_get_cart_url()); ?>" class="dsp-cart" aria-label="Cart"><i data-lucide="shopping-cart" aria-hidden="true"></i></a>
        </div>

        <div class="dsp-body">
          <?php if($aboutMega['hero']['image']): ?>
            <div class="dsp-hero">
              <img src="<?php echo e($aboutMega['hero']['image']); ?>" alt="" class="dsp-hero-img" aria-hidden="true">
              <div class="dsp-hero-overlay">
                <?php if($aboutMega['hero']['heading']): ?><h3 class="dsp-hero-heading"><?php echo e($aboutMega['hero']['heading']); ?></h3><?php endif; ?>
                <?php if($aboutMega['hero']['tagline']): ?><p class="dsp-hero-sub"><em><?php echo e($aboutMega['hero']['tagline']); ?></em></p><?php endif; ?>
                <?php if(!empty($aboutMega['hero']['ctaLink']['url'])): ?>
                  <a href="<?php echo e($aboutMega['hero']['ctaLink']['url']); ?>" class="dsp-hero-cta"><?php echo e($aboutMega['hero']['ctaLabel'] ?: 'READ OUR STORY'); ?></a>
                <?php endif; ?>
              </div>
            </div>
          <?php endif; ?>

          <!-- Why Weavira accordion -->
          <div class="dsp-about-toggle" data-accordion="acc-why-weavira" role="button" tabindex="0" aria-expanded="false" aria-controls="acc-why-weavira">
            <div class="dsp-about-icon"><i data-lucide="gem" aria-hidden="true"></i></div>
            <p class="dsp-about-title"><?php echo e($aboutMega['col1']['title'] ?: 'WHY WEAVIRA?'); ?></p>
            <span class="dsp-row-arrow">&#8250;</span>
          </div>
          <div class="dsp-acc-body" id="acc-why-weavira" aria-hidden="true">
            <?php if($aboutMega['col1']['desc']): ?><p class="dsp-about-body-desc"><?php echo e($aboutMega['col1']['desc']); ?></p><?php endif; ?>
            <?php if(!empty($aboutMega['col1']['points'])): ?>
              <ul class="dsp-about-points">
                <?php $__currentLoopData = $aboutMega['col1']['points']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li><?php echo e($point['text']); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
            <?php endif; ?>
            <?php if(!empty($aboutMega['col1']['ctaLink']['url'])): ?>
              <a href="<?php echo e($aboutMega['col1']['ctaLink']['url']); ?>" class="dsp-acc-viewall dsp-acc-viewall--flat"><?php echo e($aboutMega['col1']['ctaLabel'] ?: 'Read Our Story'); ?> &#8594;</a>
            <?php endif; ?>
          </div>

          <!-- Why Handwoven accordion -->
          <div class="dsp-about-toggle" data-accordion="acc-why-handwoven" role="button" tabindex="0" aria-expanded="false" aria-controls="acc-why-handwoven">
            <div class="dsp-about-icon"><i data-lucide="layers" aria-hidden="true"></i></div>
            <p class="dsp-about-title"><?php echo e($aboutMega['col2']['title'] ?: 'WHY HANDWOVEN?'); ?></p>
            <span class="dsp-row-arrow">&#8250;</span>
          </div>
          <div class="dsp-acc-body" id="acc-why-handwoven" aria-hidden="true">
            <?php if($aboutMega['col2']['desc']): ?><p class="dsp-about-body-desc"><?php echo e($aboutMega['col2']['desc']); ?></p><?php endif; ?>
            <?php if(!empty($aboutMega['col2']['points'])): ?>
              <ul class="dsp-about-points">
                <?php $__currentLoopData = $aboutMega['col2']['points']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li><?php echo e($point['text']); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
            <?php endif; ?>
            <?php if(!empty($aboutMega['col2']['ctaLink']['url'])): ?>
              <a href="<?php echo e($aboutMega['col2']['ctaLink']['url']); ?>" class="dsp-acc-viewall dsp-acc-viewall--flat"><?php echo e($aboutMega['col2']['ctaLabel'] ?: 'Discover the Craft'); ?> &#8594;</a>
            <?php endif; ?>
          </div>

          <!-- Need Help — kept as static block with contact row below -->
          <div class="dsp-about-block">
            <div class="dsp-about-icon"><i data-lucide="headphones" aria-hidden="true"></i></div>
            <div>
              <p class="dsp-about-title"><?php echo e($aboutMega['contact']['title'] ?: 'NEED HELP?'); ?></p>
              <?php if($aboutMega['contact']['sub']): ?><p class="dsp-about-text"><?php echo e($aboutMega['contact']['sub']); ?></p><?php endif; ?>
            </div>
          </div>

          <?php if(!empty($aboutMega['contact']['actions'])): ?>
            <div class="dsp-contact-row">
              <?php $__currentLoopData = $aboutMega['contact']['actions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e($action['link']['url'] ?? '#'); ?>" class="dsp-contact-item">
                  <i data-lucide="<?php echo e($action['icon'] ?: 'mail'); ?>" aria-hidden="true"></i>
                  <span><?php echo e($action['label']); ?></span>
                </a>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          <?php endif; ?>
        </div>

        <?php if($aboutMega['quote']): ?>
          <div class="dsp-footer">
            <p><?php echo e($aboutMega['quote']); ?></p>
            <span class="dsp-footer-ornament">&#9670;</span>
          </div>
        <?php endif; ?>
      </div>

    </div>
  </div><?php /**PATH C:\Users\Admin\Local Sites\weavira\app\public\wp-content\themes\weavira\resources\views/sections/header.blade.php ENDPATH**/ ?>