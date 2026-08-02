<?php
  $cardImageId = $product->get_image_id();
  $cardImage = $cardImageId ? wp_get_attachment_image_url($cardImageId, 'large') : wc_placeholder_img_src('large');
  $inWishlist = \App\weavira_wishlist_contains($product->get_id());
  $badge = \App\weavira_product_badge($product);
  $materialTerms = wp_list_pluck(get_the_terms($product->get_id(), 'pa_material') ?: [], 'name');
  $colourTerms = wp_list_pluck(get_the_terms($product->get_id(), 'pa_body-primary-colour') ?: [], 'name');
  $isVariable = $product->is_type('variable');
?>

<article class="plp-card">
  <a href="<?php echo e($product->get_permalink()); ?>" class="card-link" aria-label="View <?php echo e($product->get_name()); ?>"></a>
  <div class="plp-card-img-wrap">
    <?php if($badge): ?>
      <span class="plp-badge <?php echo e($badge['class']); ?>"><?php echo e($badge['label']); ?></span>
    <?php endif; ?>
    <img src="<?php echo e($cardImage); ?>" alt="<?php echo e($product->get_name()); ?>" class="plp-card-img" loading="lazy">
    <?php if(!empty($materialTerms)): ?>
      <span class="fav-material"><?php echo e($materialTerms[0]); ?></span>
    <?php endif; ?>
    <div class="plp-card-atb" aria-hidden="true"><span><?php echo e($isVariable ? 'CHOOSE OPTIONS' : 'ADD TO BAG'); ?></span></div>
    <button class="plp-wish <?php if($inWishlist): ?> plp-wish--active <?php endif; ?>" aria-label="<?php echo e($inWishlist ? 'Remove from wishlist' : 'Add to wishlist'); ?>" data-product-id="<?php echo e($product->get_id()); ?>">
      <i data-lucide="heart" aria-hidden="true"></i>
    </button>
  </div>
  <div class="plp-card-body">
    <h3 class="plp-card-name"><?php echo e($product->get_name()); ?></h3>
    <?php if(!empty($colourTerms)): ?>
      <p class="plp-card-variant"><?php echo e($colourTerms[0]); ?></p>
    <?php endif; ?>
    <p class="plp-card-price"><?php echo $product->get_price_html(); ?></p>
    <?php if($isVariable): ?>
      <a href="<?php echo e($product->get_permalink()); ?>" class="plp-card-add plp-card-add--link">CHOOSE OPTIONS</a>
    <?php else: ?>
      <button class="plp-card-add" type="button" data-product-id="<?php echo e($product->get_id()); ?>">ADD TO BAG</button>
    <?php endif; ?>
  </div>
</article>
<?php /**PATH C:\Users\Admin\Local Sites\weavira\app\public\wp-content\themes\weavira\resources\views/components/plp-card.blade.php ENDPATH**/ ?>