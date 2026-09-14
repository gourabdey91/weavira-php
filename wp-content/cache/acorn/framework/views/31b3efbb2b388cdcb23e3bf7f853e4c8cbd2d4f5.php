<section class="wv-jnl-heritage">
  <?php if(!empty($section['heritage_image'])): ?>
    <figure class="wv-jnl-heritage-media">
      <img src="<?php echo $section['heritage_image']; ?>" alt="<?php echo $section['heritage_title']; ?>" loading="lazy">
    </figure>
  <?php endif; ?>
  <div class="wv-jnl-heritage-body">
    <?php if(!empty($section['heritage_title'])): ?>
      <h3><?php echo $section['heritage_title']; ?></h3>
    <?php endif; ?>
    <?php echo $section['heritage_text']; ?>

  </div>
</section>
<?php /**PATH /home/u908449413/domains/weavira.com/public_html/wp-content/themes/weavira/resources/views/partials/journal/heritage_spotlight.blade.php ENDPATH**/ ?>