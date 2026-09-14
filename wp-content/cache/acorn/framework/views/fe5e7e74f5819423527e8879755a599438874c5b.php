<section class="wv-jnl-featured">
  <div class="wv-jnl-featured-text">
    <span class="wv-jnl-featured-kicker"><i data-lucide="sparkles" aria-hidden="true"></i><?php echo $section['kicker_label'] ?: 'Featured Story'; ?></span>
    <h2><?php echo $section['headline']; ?></h2>
    <?php if(!empty($section['excerpt'])): ?>
      <p><?php echo $section['excerpt']; ?></p>
    <?php endif; ?>
    <div class="wv-jnl-featured-meta">
      <?php if(!empty($section['read_time'])): ?>
        <span><i data-lucide="clock" aria-hidden="true"></i><?php echo $section['read_time']; ?></span>
      <?php endif; ?>
      <?php if(!empty($section['category'])): ?>
        <span class="wv-jnl-featured-meta-divider" aria-hidden="true"></span>
        <span><i data-lucide="tag" aria-hidden="true"></i><?php echo $section['category']; ?></span>
      <?php endif; ?>
      <?php if(!empty($section['location'])): ?>
        <span class="wv-jnl-featured-meta-divider" aria-hidden="true"></span>
        <span><?php echo $section['location']; ?></span>
      <?php endif; ?>
    </div>
    <a href="<?php echo $section['cta_link']['url'] ?? '#'; ?>" class="wv-jnl-featured-cta"><?php echo $section['cta_label'] ?: 'Read Story'; ?> <i data-lucide="arrow-right" aria-hidden="true"></i></a>
  </div>
  <?php $images = array_values(array_filter(wp_list_pluck($section['featured_images'] ?? [], 'image'))); ?>
  <?php if(!empty($images)): ?>
    <div class="wv-jnl-featured-media" data-featured-media>
      <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <img src="<?php echo $image; ?>" alt="<?php echo $section['headline']; ?>" loading="lazy" <?php if($i > 0): ?> hidden <?php endif; ?>>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php if(count($images) > 1): ?>
        <div class="wv-jnl-featured-arrows">
          <button class="wv-jnl-featured-arrow" type="button" aria-label="Previous story"><i data-lucide="chevron-left" aria-hidden="true"></i></button>
          <button class="wv-jnl-featured-arrow" type="button" aria-label="Next story"><i data-lucide="chevron-right" aria-hidden="true"></i></button>
        </div>
      <?php endif; ?>
    </div>
  <?php endif; ?>
</section>
<?php /**PATH /home/u908449413/domains/weavira.com/public_html/wp-content/themes/weavira/resources/views/partials/journal/featured_story.blade.php ENDPATH**/ ?>