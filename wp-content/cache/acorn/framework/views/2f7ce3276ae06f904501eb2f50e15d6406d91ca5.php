<section class="wv-jnl-motif">
  <?php if(!empty($section['motif_image'])): ?>
    <div class="wv-jnl-motif-media">
      <img src="<?php echo $section['motif_image']; ?>" alt="<?php echo $section['motif_name']; ?>" loading="lazy">
    </div>
  <?php endif; ?>
  <div class="wv-jnl-motif-body">
    <?php if(!empty($section['motif_name'])): ?>
      <h3><?php echo $section['motif_name']; ?></h3>
    <?php endif; ?>
    <?php if(!empty($section['motif_desc'])): ?>
      <p><?php echo $section['motif_desc']; ?></p>
    <?php endif; ?>
  </div>
</section>
<?php /**PATH /home/u908449413/domains/weavira.com/public_html/wp-content/themes/weavira/resources/views/partials/journal/motif_spotlight.blade.php ENDPATH**/ ?>