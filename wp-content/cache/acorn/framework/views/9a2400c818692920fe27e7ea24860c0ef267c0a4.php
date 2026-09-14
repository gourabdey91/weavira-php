
<?php
  $categories = get_field('moment_videos_categories', 'option') ?: [];

  $momentsData = [
    'categories' => array_map(function ($cat) {
      return [
        'title' => $cat['category_title'] ?? '',
        'description' => $cat['category_description'] ?? '',
        'thumbnail' => $cat['category_thumbnail'] ?? '',
        'slides' => array_map(function ($slide) {
          return [
            'file' => $slide['slide_file'] ?? '',
            'type' => $slide['slide_type'] ?? 'image',
            'alt' => $slide['slide_alt'] ?? '',
          ];
        }, $cat['category_slides'] ?? []),
      ];
    }, $categories),
  ];
?>

<script type="application/json" id="wv-moments-data"><?php echo wp_json_encode($momentsData); ?></script>

<?php if(empty($categories)): ?>

  <main class="page-shell">
    <div class="myaccount-empty-state">
      <i data-lucide="film" aria-hidden="true"></i>
      <p>No moments have been added yet.</p>
      <a href="<?php echo e(home_url('/')); ?>" class="myaccount-empty-cta">Back to Home</a>
    </div>
  </main>

<?php else: ?>

  <section class="wv-mom-story" id="wv-mom-story" aria-label="Weavira Moments" data-shop-url="<?php echo e(wc_get_page_permalink('shop')); ?>">

    <div class="wv-mom-story-progress">
      <div class="wv-mom-story-progress-fill" id="wv-mom-story-progress-fill"></div>
    </div>

    <div class="wv-mom-story-hd">
      <div class="wv-mom-story-brand">
        <span class="wv-mom-story-logo-wrap">
          <img src="<?php echo get_field('arc_option_logo', 'option'); ?>" alt="<?php echo e(get_bloginfo('name')); ?>" class="wv-mom-story-logo" />
        </span>
        <div>
          <p class="wv-mom-story-brand-name">Weavira</p>
          <p class="wv-mom-story-brand-sub">Heritage Stories</p>
        </div>
      </div>
      <a href="<?php echo e(home_url('/')); ?>" class="wv-mom-story-close" aria-label="Close">
        <i data-lucide="x" aria-hidden="true"></i>
      </a>
    </div>

    <div class="wv-mom-story-track" id="wv-mom-story-track"></div>

    <div class="wv-mom-story-card">
      <span class="wv-mom-story-card-icon" aria-hidden="true">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" width="16" height="16"><polygon points="5 3 19 12 5 21 5 3"/></svg>
      </span>
      <div class="wv-mom-story-card-body">
        <p class="wv-mom-story-card-title" id="wv-mom-story-card-title"></p>
        <p class="wv-mom-story-card-desc" id="wv-mom-story-card-desc"></p>
      </div>
      <a href="<?php echo e(wc_get_page_permalink('shop')); ?>" class="wv-mom-story-card-cta">Discover <i data-lucide="arrow-right" aria-hidden="true"></i></a>
    </div>

  </section>

<?php endif; ?>

<?php echo $__env->make('partials.mobile-bottom-nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home/u908449413/domains/weavira.com/public_html/wp-content/themes/weavira/resources/views/page-moments.blade.php ENDPATH**/ ?>