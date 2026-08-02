<?php $articles = $section['resolvedArticles'] ?? []; ?>

<?php if(!empty($articles)): ?>
  <section class="wv-jnl-related">
    <div class="wv-jnl-related-grid">
      <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a class="wv-jnl-related-card" href="<?php echo $article['link']; ?>">
          <img src="<?php echo $article['image']; ?>" alt="<?php echo $article['title']; ?>" class="wv-jnl-related-img" loading="lazy">
          <div class="wv-jnl-related-body">
            <?php if($article['category']): ?>
              <span class="section-kicker"><?php echo $article['category']; ?></span>
            <?php endif; ?>
            <h3><?php echo $article['title']; ?></h3>
            <span class="wv-jnl-related-readtime"><i data-lucide="clock" aria-hidden="true"></i><?php echo $article['readTime']; ?></span>
          </div>
        </a>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </section>
<?php endif; ?>
<?php /**PATH /home/u908449413/domains/weavira.com/public_html/wp-content/themes/weavira/resources/views/partials/journal/related_articles.blade.php ENDPATH**/ ?>