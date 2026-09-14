<section class="wv-jnl-process-detail">
  <?php if(!empty($section['detail_text_left'])): ?>
    <p class="wv-jnl-process-detail-text"><?php echo $section['detail_text_left']; ?></p>
  <?php endif; ?>
  <?php if(!empty($section['detail_image'])): ?>
    <figure class="wv-jnl-process-detail-media">
      <img src="<?php echo $section['detail_image']; ?>" alt="<?php echo $section['detail_caption']; ?>" loading="lazy">
      <?php if(!empty($section['detail_caption'])): ?>
        <figcaption><?php echo $section['detail_caption']; ?></figcaption>
      <?php endif; ?>
    </figure>
  <?php endif; ?>
  <?php if(!empty($section['detail_text_right'])): ?>
    <p class="wv-jnl-process-detail-text"><?php echo $section['detail_text_right']; ?></p>
  <?php endif; ?>
</section>
<?php /**PATH /home/u908449413/domains/weavira.com/public_html/wp-content/themes/weavira/resources/views/partials/journal/process_detail.blade.php ENDPATH**/ ?>