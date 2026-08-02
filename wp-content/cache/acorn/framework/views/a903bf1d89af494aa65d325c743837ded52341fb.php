<?php
  $featured = $section['featuredPost'] ?? null;
  $posts = $section['posts'] ?? [];
?>

<?php if($featured): ?>
  <div class="page-shell">
    <section class="section wv-journal" id="journal">
      <div class="wv-journal-grid">
        <div class="wv-journal-intro">
          <?php if(!empty($section['journal_kicker'])): ?>
            <span class="section-kicker"><?php echo e($section['journal_kicker']); ?> <span aria-hidden="true">&#9670;</span></span>
          <?php endif; ?>
          <?php if(!empty($section['journal_heading'])): ?><h2><?php echo e($section['journal_heading']); ?></h2><?php endif; ?>
          <?php if(!empty($section['journal_subtext'])): ?><p><?php echo e($section['journal_subtext']); ?></p><?php endif; ?>
        </div>

        <div class="wv-journal-content">
          <a class="wv-journal-featured" href="<?php echo e($featured['link']); ?>">
            <div class="wv-journal-featured-media">
              <span class="wv-journal-featured-badge">Featured</span>
              <img src="<?php echo e($featured['image']); ?>" alt="<?php echo e($featured['title']); ?>" class="wv-journal-featured-img" loading="lazy">
            </div>
            <div class="wv-journal-featured-body">
              <div class="wv-journal-meta-row">
                <?php if($featured['category']): ?><span class="section-kicker wv-journal-category"><?php echo e($featured['category']); ?></span><?php endif; ?>
                <span class="wv-journal-readtime"><?php echo e($featured['readTime']); ?></span>
              </div>
              <h3><?php echo e($featured['title']); ?></h3>
              <?php if($featured['excerpt']): ?><p><?php echo e($featured['excerpt']); ?></p><?php endif; ?>
              <div class="wv-story-meta">
                <span><i data-lucide="clock" aria-hidden="true"></i><?php echo e($featured['readTime']); ?></span>
                <span><?php echo e($featured['date']); ?></span>
              </div>
              <span class="wv-story-read wv-journal-read">Read Story &#8594;</span>
            </div>
          </a>

          <?php if(!empty($posts)): ?>
            <div class="wv-journal-list">
              <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a class="wv-journal-item" href="<?php echo e($post['link']); ?>">
                  <div class="wv-journal-item-media">
                    <img src="<?php echo e($post['image']); ?>" alt="<?php echo e($post['title']); ?>" class="wv-journal-item-img" loading="lazy">
                  </div>
                  <div class="wv-journal-item-body">
                    <div class="wv-journal-meta-row">
                      <?php if($post['category']): ?><span class="section-kicker wv-journal-category"><?php echo e($post['category']); ?></span><?php endif; ?>
                      <span class="wv-journal-readtime"><?php echo e($post['readTime']); ?></span>
                    </div>
                    <h4><?php echo e($post['title']); ?></h4>
                    <?php if($post['excerpt']): ?><p class="wv-journal-item-desc"><?php echo e($post['excerpt']); ?></p><?php endif; ?>
                    <div class="wv-story-meta">
                      <span><i data-lucide="clock" aria-hidden="true"></i><?php echo e($post['readTime']); ?></span>
                      <i data-lucide="arrow-right" class="wv-journal-item-arrow" aria-hidden="true"></i>
                    </div>
                    <span class="wv-story-read wv-journal-read">Read Story &#8594;</span>
                  </div>
                </a>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          <?php endif; ?>

          <div class="fav-cta-wrap">
            <a class="fav-view-all" href="<?php echo e(!empty($section['journal_cta_link']['url']) ? $section['journal_cta_link']['url'] : get_post_type_archive_link('journal')); ?>"><?php echo e($section['journal_cta_label'] ?: 'Explore All Journal Stories'); ?> &#8594;</a>
          </div>
        </div>
      </div>
    </section>
  </div>
<?php endif; ?>
<?php /**PATH /home/u908449413/domains/weavira.com/public_html/wp-content/themes/weavira/resources/views/partials/home/journal_section.blade.php ENDPATH**/ ?>