<?php $stories = $section['story_items'] ?? []; ?>

<?php if(!empty($section['featured_title'])): ?>
  <div class="page-shell">
    <section class="section wv-stories" id="stories">
      <div class="wv-stories-head">
        <div class="section-heading-center">
          <?php if(!empty($section['stories_kicker'])): ?><div class="section-kicker"><?php echo e($section['stories_kicker']); ?></div><?php endif; ?>
          <?php if(!empty($section['stories_heading'])): ?><h2><?php echo e($section['stories_heading']); ?></h2><?php endif; ?>
        </div>
      </div>

      <article class="wv-story-featured">
        <div class="wv-story-featured-text">
          <span class="section-kicker wv-story-featured-label">Featured Story</span>
          <h3><?php echo e($section['featured_title']); ?></h3>
          <?php if(!empty($section['featured_quote'])): ?>
            <blockquote class="wv-story-quote">&ldquo;<?php echo e($section['featured_quote']); ?>&rdquo;</blockquote>
          <?php endif; ?>
          <div class="wv-story-meta">
            <?php if(!empty($section['featured_location'])): ?><span><i data-lucide="map-pin" aria-hidden="true"></i><?php echo e($section['featured_location']); ?></span><?php endif; ?>
            <?php if(!empty($section['featured_date'])): ?><span><i data-lucide="calendar" aria-hidden="true"></i><?php echo e($section['featured_date']); ?></span><?php endif; ?>
          </div>
          <a class="wv-story-read" href="<?php echo e($section['featured_link']['url'] ?? '#'); ?>">Read Her Story &#8594;</a>
        </div>
        <?php if(!empty($section['featured_image'])): ?>
          <div class="wv-story-featured-media">
            <img src="<?php echo e($section['featured_image']); ?>" alt="<?php echo e($section['featured_title']); ?>" class="wv-story-featured-img" loading="lazy">
          </div>
        <?php endif; ?>
      </article>

      <?php if(!empty($stories)): ?>
        <div class="wv-story-grid">
          <?php $__currentLoopData = $stories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $story): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <article class="wv-story-card">
              <?php if(!empty($story['story_image'])): ?>
                <div class="wv-story-card-media">
                  <img src="<?php echo e($story['story_image']); ?>" alt="<?php echo e($story['story_title']); ?>" class="wv-story-card-img" loading="lazy">
                </div>
              <?php endif; ?>
              <div class="wv-story-card-body">
                <span class="wv-story-card-quote-badge" aria-hidden="true">&#8220;</span>
                <h4><?php echo e($story['story_title']); ?> <i data-lucide="heart" class="wv-story-card-heart" aria-hidden="true"></i></h4>
                <?php if(!empty($story['story_quote'])): ?>
                  <p class="wv-story-card-quote wv-customer-comment">&ldquo;<?php echo e($story['story_quote']); ?>&rdquo;</p>
                <?php endif; ?>
                <div class="wv-story-meta">
                  <?php if(!empty($story['story_location'])): ?><span><i data-lucide="map-pin" aria-hidden="true"></i><?php echo e($story['story_location']); ?></span><?php endif; ?>
                  <?php if(!empty($story['story_date'])): ?><span><i data-lucide="calendar" aria-hidden="true"></i><?php echo e($story['story_date']); ?></span><?php endif; ?>
                </div>
                <a class="wv-story-read" href="<?php echo e($story['story_link']['url'] ?? '#'); ?>">Read Story &#8594;</a>
              </div>
            </article>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      <?php endif; ?>

      <?php if(!empty($section['cta_heading'])): ?>
        <div class="wv-story-cta">
          <div class="wv-story-cta-left">
            <div class="wv-story-cta-seal" aria-hidden="true">&#10070;</div>
            <h3 class="wv-story-cta-heading"><?php echo e($section['cta_heading']); ?></h3>
          </div>
          <div class="wv-story-cta-right">
            <div class="wv-story-cta-row">
              <i data-lucide="book-open" class="wv-story-cta-icon" aria-hidden="true"></i>
              <?php if(!empty($section['cta_desc'])): ?><p class="wv-story-cta-desc"><?php echo e($section['cta_desc']); ?></p><?php endif; ?>
            </div>
            <?php if(!empty($section['cta_label'])): ?>
              <a class="wv-story-cta-btn" href="<?php echo e($section['cta_link']['url'] ?? '#'); ?>"><?php echo e($section['cta_label']); ?> &#8594;</a>
            <?php endif; ?>
          </div>
        </div>
      <?php endif; ?>
    </section>
  </div>
<?php endif; ?>
<?php /**PATH C:\Users\Admin\Local Sites\weavira\app\public\wp-content\themes\weavira\resources\views/partials/home/customer_stories.blade.php ENDPATH**/ ?>