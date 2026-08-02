<?php
  $imageDesktop = $section['hero_image_desktop'] ?: get_the_post_thumbnail_url(get_the_ID(), 'large');
  $imageMobile = $section['hero_image_mobile'] ?: $imageDesktop;
  $readTime = $section['hero_readtime'] ?: \App\weavira_journal_read_time(get_post());
?>

<section class="wv-jnl-hero">
  <picture>
    <?php if($imageDesktop): ?>
      <source media="(min-width: 769px)" srcset="<?php echo $imageDesktop; ?>">
    <?php endif; ?>
    <img src="<?php echo $imageMobile ?: wc_placeholder_img_src('large'); ?>" alt="" class="wv-jnl-hero-img" aria-hidden="true">
  </picture>
  <div class="wv-jnl-hero-overlay"></div>
  <div class="wv-jnl-hero-content">
    <?php if(!empty($section['hero_category'])): ?>
      <span class="wv-journal-featured-badge"><?php echo $section['hero_category']; ?></span>
    <?php endif; ?>
    <h1 class="wv-jnl-hero-heading"><?php echo $section['hero_heading'] ?: get_the_title(); ?></h1>
    <?php if(!empty($section['hero_subheading'])): ?>
      <p class="wv-jnl-hero-subheading"><?php echo $section['hero_subheading']; ?></p>
    <?php endif; ?>
    <?php if(!empty($section['hero_excerpt'])): ?>
      <p class="wv-jnl-hero-desc"><?php echo $section['hero_excerpt']; ?></p>
    <?php endif; ?>
    <div class="wv-jnl-hero-meta">
      <span class="wv-jnl-hero-meta-item"><?php echo $readTime; ?></span>
      <span class="wv-jnl-hero-meta-dot" aria-hidden="true">&#183;</span>
      <span class="wv-jnl-hero-meta-item"><?php echo $section['hero_author'] ?: 'Weavira Editorial'; ?></span>
    </div>
  </div>
</section>
<?php /**PATH /home/u908449413/domains/weavira.com/public_html/wp-content/themes/weavira/resources/views/partials/journal/hero.blade.php ENDPATH**/ ?>