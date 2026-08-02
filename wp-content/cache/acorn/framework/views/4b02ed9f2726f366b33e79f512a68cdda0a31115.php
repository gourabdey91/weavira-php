<?php
  $imageDesktop = $section['image_desktop'] ?: $section['image_mobile'];
  $imageMobile = $section['image_mobile'] ?: $section['image_desktop'];
?>

<?php if($imageMobile): ?>
  <figure class="wv-jnl-image">
    <picture>
      <?php if($imageDesktop): ?>
        <source media="(min-width: 769px)" srcset="<?php echo $imageDesktop; ?>">
      <?php endif; ?>
      <img src="<?php echo $imageMobile; ?>" alt="<?php echo $section['alt_text']; ?>" loading="lazy">
    </picture>
    <div class="wv-jnl-image-overlay" aria-hidden="true"></div>
    <?php if(!empty($section['caption'])): ?>
      <figcaption><?php echo $section['caption']; ?></figcaption>
    <?php endif; ?>
  </figure>
<?php endif; ?>
<?php /**PATH /home/u908449413/domains/weavira.com/public_html/wp-content/themes/weavira/resources/views/partials/journal/full_width_image.blade.php ENDPATH**/ ?>