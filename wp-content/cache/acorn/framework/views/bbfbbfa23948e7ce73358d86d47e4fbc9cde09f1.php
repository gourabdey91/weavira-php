<?php $__env->startSection('content'); ?>
<main class="cart-page page-shell">

  <nav class="wl-breadcrumb" aria-label="Breadcrumb">
    <a href="<?php echo e(home_url('/')); ?>">Home</a>
    <span aria-hidden="true">&rsaquo;</span>
    <span aria-current="page">Your Cart</span>
  </nav>

  <div class="cart-page-head">
    <div>
      <h1 class="cart-title">Your Weavira Collection</h1>
      <p class="cart-subtitle"><?php echo e($cartCount); ?> handwoven <?php echo e($cartCount === 1 ? 'saree' : 'sarees'); ?> in your cart</p>
    </div>
    <a href="<?php echo e(wc_get_page_permalink('shop')); ?>" class="cart-continue-link">
      <i data-lucide="arrow-left" aria-hidden="true"></i> Continue Exploring
    </a>
  </div>

  <?php if(empty($cartItems)): ?>
    <div class="cart-empty">
      <i data-lucide="shopping-bag" aria-hidden="true"></i>
      <p>Your cart is empty.</p>
      <a href="<?php echo e(wc_get_page_permalink('shop')); ?>" class="cart-continue-link">Browse the collection &rarr;</a>
    </div>
  <?php else: ?>
    <div class="cart-layout">

      <div class="cart-items">
        <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="cart-item" data-cart-item-key="<?php echo e($item['key']); ?>">
            <div class="cart-item-row">
              <div class="cart-item-img-wrap">
                <a href="<?php echo e($item['permalink']); ?>">
                  <img src="<?php echo e($item['image']); ?>" alt="<?php echo e($item['name']); ?>" class="cart-item-img" />
                </a>
              </div>
              <div class="cart-item-body">
                <div class="cart-item-top">
                  <div>
                    <h2 class="cart-item-name"><a href="<?php echo e($item['permalink']); ?>"><?php echo e($item['name']); ?></a></h2>
                    <?php if($item['collection']): ?>
                      <p class="cart-item-collection"><?php echo e($item['collection']); ?></p>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="cart-amount-badges">
                  <div class="cart-price-qty">
                    <div class="cart-amount">
                      <p class="cart-item-price"><?php echo $item['lineTotalHtml']; ?></p>
                      <?php if(wc_tax_enabled()): ?>
                        <p class="cart-item-gst">Incl. GST</p>
                      <?php endif; ?>
                    </div>
                    <div class="cart-qty">
                      <button class="cart-qty-btn" type="button" aria-label="Decrease quantity">&#8722;</button>
                      <span class="cart-qty-val"><?php echo e($item['quantity']); ?></span>
                      <button class="cart-qty-btn" type="button" aria-label="Increase quantity">&#43;</button>
                    </div>
                  </div>
                  <?php if(!empty($item['badges'])): ?>
                    <div class="cart-item-badges">
                      <?php $__currentLoopData = $item['badges']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $badge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="cart-item-badge"><?php echo e($badge); ?></span>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                  <?php endif; ?>
                </div>
                <div class="cart-item-footer">
                  <label class="cart-gift-label">
                    <input type="checkbox" class="cart-gift-checkbox" data-gift-checkbox <?php if($item['gift']): echo 'checked'; endif; ?>> This will be a Gift
                  </label>
                  <button class="cart-remove-btn" type="button">Remove</button>
                </div>
              </div>
            </div>
            <div class="wv-gift-fields" data-gift-fields <?php if(!$item['gift']): ?> hidden <?php endif; ?>>
              <div class="wv-gift-field">
                <label for="wv-gift-for-<?php echo e($loop->index); ?>">Gift For</label>
                <select id="wv-gift-for-<?php echo e($loop->index); ?>" class="wv-gift-for">
                  <option value="" <?php if(empty($item['gift']['gift_for'])): echo 'selected'; endif; ?> disabled>Select</option>
                  <?php $__currentLoopData = \App\weavira_gift_for_options(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($option); ?>" <?php if(($item['gift']['gift_for'] ?? '') === $option): echo 'selected'; endif; ?>><?php echo e($option); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>
              <div class="wv-gift-field">
                <label for="wv-gift-occasion-<?php echo e($loop->index); ?>">Occasion</label>
                <select id="wv-gift-occasion-<?php echo e($loop->index); ?>" class="wv-gift-occasion">
                  <option value="" <?php if(empty($item['gift']['occasion'])): echo 'selected'; endif; ?> disabled>Select</option>
                  <?php $__currentLoopData = \App\weavira_gift_occasion_options(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($option); ?>" <?php if(($item['gift']['occasion'] ?? '') === $option): echo 'selected'; endif; ?>><?php echo e($option); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>
              <div class="wv-gift-field wv-gift-field--full">
                <label for="wv-gift-recipient-<?php echo e($loop->index); ?>">Gift Recipient Name</label>
                <input type="text" id="wv-gift-recipient-<?php echo e($loop->index); ?>" class="wv-gift-recipient" value="<?php echo e($item['gift']['recipient_name'] ?? ''); ?>" placeholder="Enter recipient&rsquo;s name" maxlength="80" />
              </div>
              <p class="wv-gift-disclaimer">This data is collected only for Customized Packaging.</p>
              <p class="cart-gift-status" aria-live="polite"></p>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div><!-- /cart-items -->

      <aside class="cart-summary">
        <h2 class="cart-summary-title">Order Summary</h2>
        <div class="cart-summary-rows">
          <div class="cart-summary-row">
            <span>Subtotal</span>
            <span class="cart-summary-subtotal"><?php echo $subtotal; ?></span>
          </div>
          <div class="cart-summary-row">
            <span>Shipping</span>
            <span class="cart-summary-shipping <?php if($isFreeShipping): ?> cart-summary-free <?php endif; ?>"><?php echo e($shippingLabel ?: 'Calculated at checkout'); ?></span>
          </div>
          <div class="cart-summary-taxes">
            <?php $__currentLoopData = $taxRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="cart-summary-row">
                <span><?php echo e($tax['label']); ?> (Included)</span>
                <span><?php echo $tax['amount']; ?></span>
              </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        </div>
        <div class="cart-summary-total">
          <span>Total</span>
          <span class="cart-summary-total-price"><?php echo $total; ?></span>
        </div>
        <?php if(wc_tax_enabled()): ?>
          <p class="cart-summary-note">Prices are inclusive of GST. A tax invoice will be provided after purchase.</p>
        <?php endif; ?>
        <a href="<?php echo e(wc_get_checkout_url()); ?>" class="cart-checkout-btn">
          <i data-lucide="lock" aria-hidden="true"></i>
          Proceed to Secure Checkout
        </a>
      </aside>

    </div><!-- /cart-layout -->
  <?php endif; ?>

  <?php $packagingImage = get_field('cart_packaging_image', 'option'); ?>
  <section class="cart-packaging" aria-label="Signature Packaging">
    <div class="cart-packaging-left">
      <?php if($packagingImage): ?>
        <img src="<?php echo e($packagingImage); ?>" alt="Weavira signature gift box" class="cart-packaging-img" loading="lazy">
      <?php endif; ?>
      <div class="cart-packaging-content">
        <h2 class="cart-packaging-title">Signature Packaging</h2>
        <p class="cart-packaging-desc">Every Weavira saree is wrapped in our signature presentation, making it ready for gifting or preserving as a keepsake.</p>
      </div>
    </div>
    <ul class="cart-packaging-features" aria-label="Packaging features">
      <li class="cart-packaging-feature">
        <i data-lucide="package" aria-hidden="true"></i>
        <span>Complementary Name on Box</span>
      </li>
      <li class="cart-packaging-feature">
        <i data-lucide="shield" aria-hidden="true"></i>
        <span>Custom Message</span>
      </li>
      <li class="cart-packaging-feature">
        <i data-lucide="mail" aria-hidden="true"></i>
        <span>Thank-you card</span>
      </li>
      <li class="cart-packaging-feature">
        <i data-lucide="gift" aria-hidden="true"></i>
        <span>Complimentary gift wrapping</span>
      </li>
    </ul>
  </section>

  <div class="cart-promise-strip">
    <img src="<?php echo e(get_field('arc_option_logo', 'option')); ?>" alt="Weavira" class="cart-promise-img" loading="lazy">
    <div>
      <h2 class="cart-promise-title">Weavira Promise</h2>
      <p class="cart-promise-desc">Every saree is hand-inspected before dispatch, carefully folded to preserve the weave, and packed in our signature presentation. An official GST invoice is included with every order.</p>
    </div>
    <div class="cart-help">
      <div>
        <p class="cart-help-title">Need Help?</p>
        <p class="cart-help-sub">We&rsquo;re here to assist you with your selection or order.</p>
      </div>
      <div class="cart-help-actions">
        <?php $whatsapp = get_field('gifting_whatsapp_link', 'option'); ?>
        <a href="<?php echo e($whatsapp['url'] ?? '#'); ?>" class="cart-help-action" aria-label="WhatsApp Us">
          <span class="cart-help-icon"><i data-lucide="message-circle" aria-hidden="true"></i></span>
          <span>WhatsApp</span>
        </a>
        <a href="mailto:hello@weavira.com" class="cart-help-action" aria-label="Email Us">
          <span class="cart-help-icon"><i data-lucide="mail" aria-hidden="true"></i></span>
          <span>Email</span>
        </a>
        <a href="tel:+919123456789" class="cart-help-action" aria-label="Call Us">
          <span class="cart-help-icon"><i data-lucide="headphones" aria-hidden="true"></i></span>
          <span>Call</span>
        </a>
      </div>
    </div>
  </div>

  <?php if(!empty($recommendations)): ?>
    <section class="cart-recs" aria-label="You May Also Love">
      <div class="cart-recs-head">
        <h2 class="cart-recs-title">You May Also Love</h2>
        <a href="<?php echo e(wc_get_page_permalink('shop')); ?>" class="cart-recs-viewall">View all &#8594;</a>
      </div>
      <div class="carousel-stage">
        <button class="carousel-arrow carousel-arrow-prev cart-recs-prev" aria-label="Previous">
          <i data-lucide="chevron-left" aria-hidden="true"></i>
        </button>
        <div class="loom-track" id="cart-recs-carousel">
          <?php $__currentLoopData = $recommendations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('components.product-card', ['product' => $recProduct], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <button class="carousel-arrow carousel-arrow-next cart-recs-next" aria-label="Next">
          <i data-lucide="chevron-right" aria-hidden="true"></i>
        </button>
      </div>
      <div class="cart-recs-dots" role="tablist" aria-label="Carousel navigation"></div>
    </section>
  <?php endif; ?>

  <div class="cart-trust-bar" role="list">
    <div class="cart-trust-bar-item" role="listitem">Handwoven in Odisha</div>
    <div class="cart-trust-bar-item" role="listitem">Secure Payment</div>
    <div class="cart-trust-bar-item" role="listitem">Free Shipping</div>
    <div class="cart-trust-bar-item" role="listitem">Easy Returns</div>
  </div>

</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Admin\Local Sites\weavira\app\public\wp-content\themes\weavira\resources\views/woocommerce\cart.blade.php ENDPATH**/ ?>