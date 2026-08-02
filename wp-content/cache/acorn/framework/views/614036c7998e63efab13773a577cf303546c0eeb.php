<?php
  $cardImageId = $product->get_image_id();
  $cardImage = $cardImageId ? wp_get_attachment_image_url($cardImageId, 'large') : wc_placeholder_img_src('large');
  $inWishlist = \App\weavira_wishlist_contains($product->get_id());
  $fullCard = $fullCard ?? false;

  if ($fullCard) {
    $materialTerms = wp_list_pluck(get_the_terms($product->get_id(), 'pa_material') ?: [], 'name');
    $weaveTerms = wp_list_pluck(get_the_terms($product->get_id(), 'pa_weave') ?: [], 'name');
  }
?>

<article class="loom-card fav-card">
  <a href="<?php echo e($product->get_permalink()); ?>" class="card-link" aria-label="View <?php echo e($product->get_name()); ?>"></a>
  <div class="fav-image-wrap">
    <img src="<?php echo e($cardImage); ?>" alt="<?php echo e($product->get_name()); ?>" class="loom-img" loading="lazy">
    <?php if($fullCard && !empty($materialTerms)): ?>
      <span class="fav-material"><?php echo e($materialTerms[0]); ?></span>
    <?php endif; ?>
    <button class="fav-wish <?php if($inWishlist): ?> plp-wish--active <?php endif; ?>" aria-label="<?php echo e($inWishlist ? 'Remove from wishlist' : 'Add to wishlist'); ?>" data-product-id="<?php echo e($product->get_id()); ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
    </button>
  </div>
  <div class="fav-copy">
    <h3><?php echo e($product->get_name()); ?></h3>
    <?php if($fullCard): ?>
      <?php if($product->get_short_description()): ?>
        <p class="fav-desc"><?php echo e(wp_strip_all_tags($product->get_short_description())); ?></p>
      <?php endif; ?>
      <?php if(!empty($weaveTerms) || !empty($materialTerms)): ?>
        <span class="fav-subtitle"><?php echo e($weaveTerms[0] ?? $materialTerms[0]); ?></span>
      <?php endif; ?>
    <?php endif; ?>
    <div class="fav-action">
      <span class="fav-price"><?php echo $product->get_price_html(); ?></span>
      <?php if($fullCard): ?>
        <?php if($product->is_type('variable')): ?>
          <a href="<?php echo e($product->get_permalink()); ?>" class="fav-add fav-add--link">Choose Options</a>
        <?php else: ?>
          <button class="fav-add" type="button" data-product-id="<?php echo e($product->get_id()); ?>">Add to Bag</button>
        <?php endif; ?>
      <?php endif; ?>
    </div>
  </div>
</article>
<?php /**PATH /home/u908449413/domains/weavira.com/public_html/wp-content/themes/weavira/resources/views/components/product-card.blade.php ENDPATH**/ ?>