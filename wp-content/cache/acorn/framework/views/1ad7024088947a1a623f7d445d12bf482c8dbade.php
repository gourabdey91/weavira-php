<section class="wv-jnl-richtext">
  <div class="wv-jnl-richtext-text">
    <?php if(!empty($section['block_heading'])): ?>
      <h2><?php echo e($section['block_heading']); ?></h2>
    <?php endif; ?>
    <?php echo $section['block_body']; ?>

  </div>
  <?php if(!empty($section['block_illustration'])): ?>
    <figure class="wv-jnl-richtext-media">
      <img src="<?php echo e($section['block_illustration']); ?>" alt="" loading="lazy">
    </figure>
  <?php endif; ?>
</section>
<?php /**PATH /home/u908449413/domains/weavira.com/public_html/wp-content/themes/weavira/resources/views/partials/journal/rich_text.blade.php ENDPATH**/ ?>