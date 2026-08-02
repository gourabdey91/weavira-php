<?php $articles = $section['resolvedArticles'] ?? []; ?>

<?php if(!empty($articles)): ?>
  <section class="wv-jnl-continue">
    <div class="section-heading-center">
      <?php if(!empty($section['kicker_label'])): ?>
        <span class="section-kicker wv-jnl-continue-kicker"><?php echo $section['kicker_label']; ?></span>
      <?php endif; ?>
      <h2><?php echo $section['heading'] ?: 'Continue Reading'; ?></h2>
    </div>
    <div class="carousel-stage">
      <button class="carousel-arrow carousel-arrow-prev jnl-continue-arrow-prev" type="button" aria-label="Previous story">
        <i data-lucide="chevron-left" aria-hidden="true"></i>
      </button>
      <div class="loom-track" id="jnl-continue-carousel">
        <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <article class="wv-jnl-continue-card">
            <a href="<?php echo e($article['link']); ?>" class="card-link" aria-label="Read <?php echo e($article['title']); ?>"></a>
            <div class="wv-jnl-continue-image-wrap">
              <img src="<?php echo e($article['image']); ?>" alt="" class="wv-jnl-continue-img" loading="lazy">
              <button class="wv-jnl-continue-bookmark" type="button" aria-label="Save story"><i data-lucide="bookmark" aria-hidden="true"></i></button>
            </div>
            <div class="wv-jnl-continue-body">
              <?php if($article['category']): ?>
                <span class="section-kicker"><?php echo $article['category']; ?></span>
              <?php endif; ?>
              <h3><?php echo $article['title']; ?></h3>
              <span class="wv-jnl-continue-readtime"><i data-lucide="clock" aria-hidden="true"></i><?php echo $article['readTime']; ?></span>
            </div>
          </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
      <button class="carousel-arrow carousel-arrow-next jnl-continue-arrow-next" type="button" aria-label="Next story">
        <i data-lucide="chevron-right" aria-hidden="true"></i>
      </button>
    </div>
    <div class="jnl-continue-dots"></div>
  </section>
<?php endif; ?>
<?php /**PATH /home/u908449413/domains/weavira.com/public_html/wp-content/themes/weavira/resources/views/partials/journal/continue_reading.blade.php ENDPATH**/ ?>