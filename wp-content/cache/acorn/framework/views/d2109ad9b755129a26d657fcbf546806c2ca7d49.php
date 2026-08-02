<?php
  // Step 1 only exists to identify a guest (mobile OTP / social / guest
  // email) — a logged-in customer is already identified, so checkout
  // starts on Delivery Details instead. billing_email is normally captured
  // by Step 1's own "Continue as Guest" field and kept out of Step 2's
  // field grid (see unset() below); when Step 1 is skipped that field
  // would never render at all, so it stays in Step 2's grid instead,
  // pre-filled from the account's stored email.
  $skipStep1 = is_user_logged_in();

  $wcCheckout = WC()->checkout();
  $billingFields = $wcCheckout->get_checkout_fields('billing');
  $shippingFields = $wcCheckout->get_checkout_fields('shipping');
  $emailField = $billingFields['billing_email'] ?? null;
  if (!$skipStep1) {
      unset($billingFields['billing_email']);
  }
  $shipToDifferentAddress = apply_filters('woocommerce_ship_to_different_address_checked', 'shipping' === get_option('woocommerce_ship_to_destination') ? 1 : 0);
  $hasGiftStep = !empty($giftItems);
  $reviewStepNum = $hasGiftStep ? 4 : 3;
?>

<header class="ck-header">
  <a href="<?php echo e(home_url('/')); ?>" class="ck-header-brand">
    <img src="<?php echo get_field('arc_option_logo', 'option'); ?>" alt="<?php echo e($siteName); ?>" class="ck-header-logo" />
  </a>
  <div class="ck-header-secure">
    <i data-lucide="lock" aria-hidden="true"></i>
    <span>Secure Checkout</span>
  </div>
</header>

<div class="ck-progress" role="list" aria-label="Checkout steps">
  <div class="ck-step <?php if(!$skipStep1): ?> ck-step--active <?php endif; ?>" data-step="1" role="listitem">
    <div class="ck-step-num" <?php if(!$skipStep1): ?> aria-current="step" <?php endif; ?>>1</div>
    <span class="ck-step-label">Continue</span>
  </div>
  <div class="ck-step-line" aria-hidden="true"></div>
  <div class="ck-step <?php if($skipStep1): ?> ck-step--active <?php endif; ?>" data-step="2" role="listitem">
    <div class="ck-step-num" <?php if($skipStep1): ?> aria-current="step" <?php endif; ?>>2</div>
    <span class="ck-step-label">Delivery Details</span>
  </div>
  <div class="ck-step-line" aria-hidden="true"></div>
  <?php if($hasGiftStep): ?>
    <div class="ck-step" data-step="3" role="listitem">
      <div class="ck-step-num">3</div>
      <span class="ck-step-label">Gift Details (<?php echo e(count($giftItems)); ?>)</span>
    </div>
    <div class="ck-step-line" aria-hidden="true"></div>
  <?php endif; ?>
  <div class="ck-step" data-step="<?php echo e($reviewStepNum); ?>" role="listitem">
    <div class="ck-step-num"><?php echo e($reviewStepNum); ?></div>
    <span class="ck-step-label">Review &amp; Payment</span>
  </div>
</div>

<main class="ck-layout">

  <div class="ck-main">

    
    <section class="ck-panel ck-step-panel" id="ck-panel-1" data-step="1" aria-labelledby="ck-step1-title" <?php if($skipStep1): ?> hidden <?php endif; ?>>
    <?php if (! ($skipStep1)): ?>

      <h1 class="ck-panel-title" id="ck-step1-title">1. How would you like to continue?</h1>
      <p class="ck-panel-sub">We need a few details to prepare your order and keep you updated.</p>

      <div class="ck-auth-grid">

        <div class="ck-social-col">
          
          <button class="ck-social-btn" type="button" disabled title="Coming soon">
            <svg class="ck-social-icon" viewBox="0 0 24 24" aria-label="Google" role="img">
              <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
              <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
              <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/>
              <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
            Continue with Google
          </button>
          <button class="ck-social-btn" type="button" disabled title="Coming soon">
            <svg class="ck-social-icon" viewBox="0 0 24 24" fill="currentColor" aria-label="Apple" role="img">
              <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
            </svg>
            Continue with Apple
          </button>
        </div>

        <div class="ck-auth-or" aria-hidden="true">OR</div>

        <div class="ck-auth-col">

          <div class="ck-method-card">
            <div class="ck-method-head">
              <i data-lucide="smartphone" aria-hidden="true"></i>
              <span>Continue with Mobile Number</span>
            </div>
            <div class="ck-phone-row">
              


                  <?php echo do_shortcode('[sa_loginwithotp]'); ?>

                  <?php echo do_shortcode('[sa_verify phone_selector="#phone" submit_selector= ".btn"]'); ?>


            </div>
          </div>

          <div class="ck-method-card ck-method-card--guest">
            <div class="ck-method-head">
              <i data-lucide="mail" aria-hidden="true"></i>
              <span>Continue as Guest</span>
            </div>
            <p class="ck-method-sub">Enter your email address</p>
            <?php
            if ($emailField) {
                woocommerce_form_field('billing_email', array_merge($emailField, [
                    'id' => 'ck_guest_email',
                    'label' => false,
                    'placeholder' => 'you@example.com',
                ]), $wcCheckout->get_value('billing_email'));
            }
            ?>
          </div>

        </div>

      </div><!-- /ck-auth-grid -->

      <div class="ck-privacy-note">
        <i data-lucide="shield-check" aria-hidden="true"></i>
        <span>We respect your privacy. Your details are safe and will only be used to process your order.</span>
      </div>

      <button type="button" class="ck-continue-btn" data-continue-from="1">Continue to Delivery Details</button>

    <?php endif; ?>
    </section><!-- /Step 1 -->

    <?php do_action('woocommerce_before_checkout_form', $wcCheckout); ?>

    <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo e(wc_get_checkout_url()); ?>" enctype="multipart/form-data" id="ck-checkout-form">

      <?php if (! ($skipStep1)): ?>
        <input type="hidden" name="billing_email" id="billing_email" value="<?php echo e($wcCheckout->get_value('billing_email')); ?>" />
      <?php endif; ?>

      
      <button class="ck-accordion" type="button" aria-expanded="<?php echo e($skipStep1 ? 'true' : 'false'); ?>" aria-controls="ck-panel-2" data-step-toggle="2">
        <span class="ck-accordion-icon"><i data-lucide="map-pin" aria-hidden="true"></i></span>
        <div class="ck-accordion-text">
          <span class="ck-accordion-title">2. Delivery Details</span>
          <span class="ck-accordion-sub">Add delivery address and contact number</span>
        </div>
        <i data-lucide="chevron-right" class="ck-accordion-chevron" aria-hidden="true"></i>
      </button>
      <div class="ck-accordion-panel" id="ck-panel-2" data-step="2" <?php if(!$skipStep1): ?> hidden <?php endif; ?>>
        <div class="ck-field-grid woocommerce-billing-fields__field-wrapper">
          <?php
          foreach ($billingFields as $key => $field) {
              woocommerce_form_field($key, $field, $wcCheckout->get_value($key));
          }
          ?>
        </div>

        <?php if(WC()->cart->needs_shipping_address()): ?>
          <div class="woocommerce-shipping-fields">
            <h3 id="ship-to-different-address">
              <label class="cart-gift-label woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                <input id="ship-to-different-address-checkbox" class="cart-gift-checkbox woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" type="checkbox" name="ship_to_different_address" value="1" <?php if($shipToDifferentAddress): echo 'checked'; endif; ?> />
                Ship to a different address?
              </label>
            </h3>
            <div class="shipping_address" <?php if(!$shipToDifferentAddress): ?> style="display:none;" <?php endif; ?>>
              <?php do_action('woocommerce_before_checkout_shipping_form', $wcCheckout); ?>

              <?php if(count($savedShippingAddresses ?? []) > 1): ?>
                
                <p class="form-row form-row-wide">
                  <label for="wv-shipping-address-select">Use a saved address</label>
                  <select id="wv-shipping-address-select" class="woocommerce-Input woocommerce-Input--select input-select">
                    <option value="">Enter a new address</option>
                    <?php $__currentLoopData = $savedShippingAddresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $saved): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($saved['id']); ?>"><?php echo e($saved['label']); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                </p>
              <?php endif; ?>

              <div class="ck-field-grid woocommerce-shipping-fields__field-wrapper">
                <?php
                foreach ($shippingFields as $key => $field) {
                    woocommerce_form_field($key, $field, $wcCheckout->get_value($key));
                }
                ?>
              </div>
              <?php do_action('woocommerce_after_checkout_shipping_form', $wcCheckout); ?>
            </div>
          </div>
        <?php endif; ?>

        <button type="button" class="ck-continue-btn" data-continue-from="2">Continue to <?php echo e($hasGiftStep ? 'Gift Details' : 'Review & Payment'); ?></button>
      </div>

      <?php if($hasGiftStep): ?>
        
        <button class="ck-accordion" type="button" aria-expanded="false" aria-controls="ck-panel-3" data-step-toggle="3">
          <span class="ck-accordion-icon"><i data-lucide="gift" aria-hidden="true"></i></span>
          <div class="ck-accordion-text">
            <span class="ck-accordion-title">3. Gift Details (<?php echo e(count($giftItems)); ?> Item<?php echo e(count($giftItems) === 1 ? '' : 's'); ?>)</span>
            <span class="ck-accordion-sub">Confirm recipient information for items marked as gift</span>
          </div>
          <i data-lucide="chevron-right" class="ck-accordion-chevron" aria-hidden="true"></i>
        </button>
        <div class="ck-accordion-panel" id="ck-panel-3" data-step="3" hidden>
          <?php $__currentLoopData = $giftItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="ck-gift-item" data-cart-item-key="<?php echo e($item['key']); ?>">
              <div class="ck-gift-item-head">
                <img src="<?php echo e($item['image']); ?>" alt="<?php echo e($item['name']); ?>" class="ck-gift-item-img" loading="lazy" />
                <p class="ck-gift-item-name"><?php echo e($item['name']); ?></p>
              </div>
              <div class="wv-gift-fields ck-gift-form" data-gift-fields>
                <div class="wv-gift-field">
                  <label for="ck-gift-for-<?php echo e($loop->index); ?>">Gift For</label>
                  <select id="ck-gift-for-<?php echo e($loop->index); ?>" class="wv-gift-for">
                    <option value="" <?php if(empty($item['gift']['gift_for'])): echo 'selected'; endif; ?> disabled>Select</option>
                    <?php $__currentLoopData = \App\weavira_gift_for_options(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($option); ?>" <?php if(($item['gift']['gift_for'] ?? '') === $option): echo 'selected'; endif; ?>><?php echo e($option); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                </div>
                <div class="wv-gift-field">
                  <label for="ck-gift-occasion-<?php echo e($loop->index); ?>">Occasion</label>
                  <select id="ck-gift-occasion-<?php echo e($loop->index); ?>" class="wv-gift-occasion">
                    <option value="" <?php if(empty($item['gift']['occasion'])): echo 'selected'; endif; ?> disabled>Select</option>
                    <?php $__currentLoopData = \App\weavira_gift_occasion_options(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($option); ?>" <?php if(($item['gift']['occasion'] ?? '') === $option): echo 'selected'; endif; ?>><?php echo e($option); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                </div>
                <div class="wv-gift-field wv-gift-field--full">
                  <label for="ck-gift-recipient-<?php echo e($loop->index); ?>">Gift Recipient Name</label>
                  <input type="text" id="ck-gift-recipient-<?php echo e($loop->index); ?>" class="wv-gift-recipient" value="<?php echo e($item['gift']['recipient_name'] ?? ''); ?>" placeholder="Enter recipient&rsquo;s name" maxlength="80" />
                </div>
                <p class="wv-gift-disclaimer">This data is collected only for Customized Packaging.</p>
                <p class="cart-gift-status" aria-live="polite"></p>
              </div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <button type="button" class="ck-continue-btn" data-continue-from="3">Continue to Review &amp; Payment</button>
        </div>
      <?php endif; ?>

      
      <button class="ck-accordion" type="button" aria-expanded="false" aria-controls="ck-panel-<?php echo e($reviewStepNum); ?>" data-step-toggle="<?php echo e($reviewStepNum); ?>">
        <span class="ck-accordion-icon"><i data-lucide="credit-card" aria-hidden="true"></i></span>
        <div class="ck-accordion-text">
          <span class="ck-accordion-title"><?php echo e($reviewStepNum); ?>. Review &amp; Payment</span>
          <span class="ck-accordion-sub">Confirm your order and choose a payment method</span>
        </div>
        <i data-lucide="chevron-right" class="ck-accordion-chevron" aria-hidden="true"></i>
      </button>
      <div class="ck-accordion-panel" id="ck-panel-<?php echo e($reviewStepNum); ?>" data-step="<?php echo e($reviewStepNum); ?>" hidden>
        <div id="order_review" class="woocommerce-checkout-review-order">
          <?php do_action('woocommerce_checkout_order_review'); ?>
        </div>
      </div>

    </form>

  </div><!-- /ck-main -->

  <aside class="ck-summary" aria-label="Order Summary">

    <div class="ck-summary-head">
      <div>
        <h2 class="ck-summary-title">Your Order</h2>
        <p class="ck-summary-count"><?php echo e($cartCount); ?> Item<?php echo e($cartCount === 1 ? '' : 's'); ?></p>
      </div>
      <a href="<?php echo e(wc_get_cart_url()); ?>" class="ck-edit-cart">Edit Cart</a>
    </div>

    <div class="ck-order-items">
      <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="ck-order-item">
          <img src="<?php echo e($item['image']); ?>" alt="<?php echo e($item['name']); ?>" class="ck-order-img" loading="lazy" />
          <div class="ck-order-info">
            <p class="ck-order-name"><?php echo e($item['name']); ?></p>
            <p class="ck-order-meta">Qty: <?php echo e($item['quantity']); ?> <?php if($item['gift']): ?><span class="ck-dot" aria-hidden="true">&bull;</span> Gift <?php endif; ?></p>
          </div>
          <span class="ck-order-price"><?php echo $item['lineTotalHtml']; ?></span>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div><!-- /ck-order-items -->

    <div class="ck-summary-rows">
      <div class="ck-summary-row">
        <span>Subtotal (<?php echo e($cartCount); ?> item<?php echo e($cartCount === 1 ? '' : 's'); ?>)</span>
        <span><?php echo $subtotal; ?></span>
      </div>
      <div class="ck-summary-row">
        <span>Shipping</span>
        <span class="<?php if($isFreeShipping): ?> ck-free <?php endif; ?>"><?php echo e($shippingLabel ?: 'Calculated at next step'); ?></span>
      </div>
    </div>

    <div class="ck-summary-total">
      <span class="ck-total-label">Total <?php if(wc_tax_enabled()): ?><em class="ck-gst-note">(Incl. GST)</em><?php endif; ?></span>
      <span class="ck-total-price"><?php echo $total; ?></span>
    </div>

  </aside>

</main><!-- /ck-layout -->

<?php do_action('woocommerce_after_checkout_form', $wcCheckout); ?>
<?php /**PATH C:\Users\Admin\Local Sites\weavira\app\public\wp-content\themes\weavira\resources\views/woocommerce/checkout.blade.php ENDPATH**/ ?>