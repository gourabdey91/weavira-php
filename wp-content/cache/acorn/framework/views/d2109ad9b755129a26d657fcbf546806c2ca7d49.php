<?php
  // Step 1 only exists to identify a guest (mobile OTP / social) — a
  // logged-in customer is already identified, so checkout starts on
  // Delivery Details instead. billing_email is always collected in Step
  // 2's field grid (pre-filled from the account's stored email when
  // logged in), since Step 1 no longer has its own email field.
  $skipStep1 = is_user_logged_in();

  // Delivery Address is the primary, always-required address — WooCommerce's
  // shipping_* fields. billing_* is only ever its own distinct thing when
  // the customer checks "I need a GST Invoice" below; otherwise it silently
  // mirrors delivery server-side (see the woocommerce_checkout_process hook
  // in app/filters.php) purely so WooCommerce has a valid order record —
  // not shown to the customer as "billing" at all in the common case.
  //
  // Phone/Email stay billing_phone/billing_email regardless — they're the
  // purchaser's own account identity (SMS Alert's checkout-OTP feature is
  // hard-coded to billing_phone specifically), not a delivery-address or
  // billing-address concept, so they're never renamed or duplicated.
  //
  // The store only sells to India (see the woocommerce_allowed_countries/
  // specific_allowed_countries options), so country fields are shown locked
  // rather than editable — disabled fields don't submit, so hidden twins
  // carry the actual values (see #ck-checkout-form below).
  $wcCheckout = WC()->checkout();
  $billingFields = $wcCheckout->get_checkout_fields('billing');
  $shippingFields = $wcCheckout->get_checkout_fields('shipping');

  $billingFields['billing_phone']['label'] = 'Phone Number';
  $billingFields['billing_phone']['required'] = true;
  $billingFields['billing_phone']['class'] = ['form-row-first'];
  $billingFields['billing_email']['label'] = 'Email Address';
  $billingFields['billing_email']['class'] = ['form-row-last'];

  $shippingFields['shipping_address_1']['label'] = 'Address Line 1';
  $shippingFields['shipping_address_2']['label'] = 'Address Line 2'; // WC appends its own "(optional)" suffix
  $shippingFields['shipping_address_2']['label_class'] = []; // WC hides this label (screen-reader-text) by default
  $shippingFields['shipping_city']['class'] = ['form-row-first'];
  $shippingFields['shipping_state']['class'] = ['form-row-last'];
  $shippingFields['shipping_postcode']['class'] = ['form-row-first'];
  $shippingFields['shipping_country']['custom_attributes'] = ['disabled' => 'disabled'];
  $shippingFields['shipping_country']['class'] = ['form-row-last'];

  // Fields for the Delivery Address panel, keyed by the id woocommerce_form_field()
  // needs — phone/email pulled in from $billingFields since they stay billing_*.
  $deliveryFields = $shippingFields;
  $deliveryFields['billing_phone'] = $billingFields['billing_phone'];
  $deliveryFields['billing_email'] = $billingFields['billing_email'];

  // Display order for the Delivery Address panel — matches the mockup's
  // sequence, which differs from WC's own priority-based field order.
  // Postcode + Country pair up on the last row.
  $deliveryFieldOrder = [
      'shipping_first_name', 'shipping_last_name',
      'billing_phone', 'billing_email',
      'shipping_address_1', 'shipping_address_2',
      'shipping_city', 'shipping_state',
      'shipping_postcode', 'shipping_country',
  ];

  // GST billing sub-form — a real, distinct billing_* address, revealed
  // only when "I need a GST Invoice" is checked. required => false at the
  // WC level throughout (the section may be hidden at submit time; JS
  // toggles real requiredness when it's shown — see weavira.js).
  $gstFields = $billingFields;
  foreach ($gstFields as $key => $field) {
      $gstFields[$key]['required'] = false;
  }
  // Fields that become required once the section is actually shown (all
  // but Address Line 2 and the locked Country) — marked with an extra
  // class since none of them carry WC's own "required_field"/"optional"
  // treatment at render time (required is false for all of them here).
  // weavira.js toggles a .ck-gst-fields.is-required class that both sets
  // these inputs' required attribute and, via CSS, swaps each one's label
  // from "(optional)" to a required asterisk — no server-render-time
  // knowledge of the checkbox's state is possible, so this has to be
  // purely client-side.
  $gstFields['billing_company']['label'] = 'Business / Legal Name';
  $gstFields['billing_company']['class'] = ['form-row-wide', 'ck-gst-required-field'];
  $gstFields['billing_first_name']['class'] = ['form-row-first', 'ck-gst-required-field'];
  $gstFields['billing_last_name']['class'] = ['form-row-last', 'ck-gst-required-field'];
  $gstFields['billing_address_1']['label'] = 'Address Line 1';
  $gstFields['billing_address_1']['class'] = ['form-row-wide', 'ck-gst-required-field'];
  $gstFields['billing_address_2']['label'] = 'Address Line 2';
  $gstFields['billing_address_2']['label_class'] = [];
  $gstFields['billing_city']['class'] = ['form-row-first', 'ck-gst-required-field'];
  $gstFields['billing_state']['class'] = ['form-row-last', 'ck-gst-required-field'];
  $gstFields['billing_postcode']['class'] = ['form-row-first', 'ck-gst-required-field'];
  $gstFields['billing_country']['custom_attributes'] = ['disabled' => 'disabled'];
  $gstFields['billing_country']['class'] = ['form-row-last'];

  $gstFieldOrder = [
      'billing_company',
      'billing_first_name', 'billing_last_name',
      'billing_address_1', 'billing_address_2',
      'billing_city', 'billing_state',
      'billing_postcode', 'billing_country',
  ];

  $hasGiftStep = !empty($giftItems);
  $reviewStepNum = $hasGiftStep ? 4 : 3;
?>

<header class="ck-header">
  <a href="<?php echo e(home_url('/')); ?>" class="ck-header-brand">
    <img src="<?php echo get_field('arc_option_logo', 'option'); ?>" alt="<?php echo e($siteName); ?>" class="ck-header-logo" />
  </a>
  <div class="ck-header-secure">
    <i data-lucide="shield-check" aria-hidden="true"></i>
    <span>100% Secure Checkout</span>
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

      <h1 class="ck-panel-title" id="ck-step1-title">How would you like to continue?</h1>
      <p class="ck-panel-sub">Enter your mobile number to receive an OTP and securely continue.</p>

      <div class="ck-auth-grid">

        <div class="ck-auth-col">
          <div class="ck-phone-row">
                <?php echo do_shortcode('[sa_loginwithotp]'); ?>

                <?php echo do_shortcode('[sa_verify phone_selector="#phone" submit_selector= ".btn"]'); ?>

          </div>
        </div>

        <div class="ck-auth-or" aria-hidden="true">OR</div>

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

      </div><!-- /ck-auth-grid -->

      <div class="ck-trust-badges">
        <div class="ck-trust-badge">
          <i data-lucide="shield-check" aria-hidden="true"></i>
          <span>Secure OTP Login</span>
        </div>
        <div class="ck-trust-badge">
          <i data-lucide="lock" aria-hidden="true"></i>
          <span>Your details are never shared</span>
        </div>
      </div>

      <button type="button" class="ck-continue-btn" data-continue-from="1">Continue to Delivery Details</button>

    <?php endif; ?>
    </section><!-- /Step 1 -->

    <?php do_action('woocommerce_before_checkout_form', $wcCheckout); ?>

    <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo e(wc_get_checkout_url()); ?>" enctype="multipart/form-data" id="ck-checkout-form">

      
      <input type="hidden" name="shipping_country" value="IN" />
      <input type="hidden" name="billing_country" value="IN" />

      
      <button class="ck-accordion" type="button" aria-expanded="<?php echo e($skipStep1 ? 'true' : 'false'); ?>" aria-controls="ck-panel-2" data-step-toggle="2">
        <span class="ck-accordion-icon"><i data-lucide="map-pin" aria-hidden="true"></i></span>
        <div class="ck-accordion-text">
          <span class="ck-accordion-title">Delivery Address</span>
          <span class="ck-accordion-sub">Add your delivery details so we can get your order to you.</span>
        </div>
        <i data-lucide="chevron-right" class="ck-accordion-chevron" aria-hidden="true"></i>
      </button>
      <div class="ck-accordion-panel" id="ck-panel-2" data-step="2" <?php if(!$skipStep1): ?> hidden <?php endif; ?>>
        <div class="woocommerce-shipping-fields__field-wrapper">
          <?php
          // Card-list picker (Home / Office / ...) — shown whenever the
          // customer has any saved address at all. JS (weavira.js) reads
          // ajax_object.saved_shipping_addresses (app/setup.php) to fill
          // the (possibly hidden) shipping_* fields below on click; the
          // default entry, if any, starts selected with the field grid
          // hidden, since WC's own get_value() calls below already carry
          // that default's data via weavira_mirror_default_shipping_address().
          $shippingDefault = null;
          foreach (($savedShippingAddresses ?? []) as $saved) {
              if (!empty($saved['is_default'])) {
                  $shippingDefault = $saved;
                  break;
              }
          }
          if (!$shippingDefault && !empty($savedShippingAddresses)) {
              $shippingDefault = $savedShippingAddresses[0];
          }
          $hasShippingCards = !empty($savedShippingAddresses);
          ?>
          <?php if($hasShippingCards): ?>
            <div class="ck-address-cards" id="ck-shipping-address-cards" role="radiogroup" aria-label="Use a saved address">
              <?php $__currentLoopData = $savedShippingAddresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $saved): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                  $cardLabel = $saved['label'] ?? '';
                  $cardIcon = 'map-pin';
                  if (stripos($cardLabel, 'home') !== false) {
                      $cardIcon = 'home';
                  } elseif (stripos($cardLabel, 'office') !== false) {
                      $cardIcon = 'briefcase';
                  }
                ?>
                
                <div class="ck-address-card <?php if($shippingDefault && $shippingDefault['id'] === $saved['id']): ?> is-selected <?php endif; ?>" role="button" tabindex="0" data-address-id="<?php echo e($saved['id']); ?>">
                  <span class="ck-address-card-icon"><i data-lucide="<?php echo e($cardIcon); ?>" aria-hidden="true"></i></span>
                  <div class="ck-address-card-body">
                    <div class="ck-address-card-head">
                      <span class="ck-address-card-label"><?php echo e($cardLabel); ?></span>
                      <?php if(!empty($saved['is_default'])): ?>
                        <span class="ck-address-card-default">DEFAULT</span>
                      <?php endif; ?>
                      <button type="button" class="ck-address-card-edit" data-edit-address-id="<?php echo e($saved['id']); ?>">Edit</button>
                    </div>
                    <span class="ck-address-card-address"><?php echo WC()->countries->get_formatted_address($saved); ?></span>
                    <?php if(!empty($saved['phone'])): ?>
                      <span class="ck-address-card-phone"><strong>Mobile Number:</strong> <?php echo e($saved['phone']); ?></span>
                    <?php endif; ?>
                  </div>
                  <i data-lucide="chevron-right" class="ck-address-card-chevron" aria-hidden="true"></i>
                </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <div class="ck-address-card ck-address-card--add" role="button" tabindex="0" id="ck-shipping-address-add-new">
                <span class="ck-address-card-icon ck-address-card-icon--add" aria-hidden="true">+</span>
                <span class="ck-address-card-add-label">Add New Address</span>
              </div>
            </div>

            
            <div class="ck-addr-modal" id="ck-address-modal" hidden>
              <div class="ck-addr-modal-backdrop" data-modal-close></div>
              <div class="ck-addr-modal-panel" role="dialog" aria-modal="true" aria-labelledby="ck-address-modal-title">
                <div class="ck-addr-modal-header">
                  <h2 class="ck-addr-modal-title" id="ck-address-modal-title">Add New Address</h2>
                  <button type="button" class="ck-addr-modal-close" data-modal-close aria-label="Close">
                    <i data-lucide="x" aria-hidden="true"></i>
                  </button>
                </div>
                <div class="ck-addr-modal-body">
                  <p class="ck-addr-modal-error" id="ck-address-modal-error" hidden></p>

                  <div class="ck-tag-picker" id="ck-address-modal-tag-picker">
                    <span class="ck-tag-picker-label">Save this address as</span>
                    <div class="ck-tag-picker-options">
                      <button type="button" class="ck-tag-pill is-active" data-tag="Home">Home</button>
                      <button type="button" class="ck-tag-pill" data-tag="Office">Office</button>
                      <button type="button" class="ck-tag-pill" data-tag="Other">Other</button>
                    </div>
                    <input type="text" class="ck-tag-other-input" id="ck-address-modal-tag-other" placeholder="Name this address" maxlength="40" hidden />
                  </div>

                  <div class="ck-field-grid">
                    <p class="form-row form-row-first">
                      <label for="ck-am-first_name">First name <span class="required" aria-hidden="true">*</span></label>
                      <input type="text" class="input-text" id="ck-am-first_name" maxlength="60" />
                    </p>
                    <p class="form-row form-row-last">
                      <label for="ck-am-last_name">Last name <span class="required" aria-hidden="true">*</span></label>
                      <input type="text" class="input-text" id="ck-am-last_name" maxlength="60" />
                    </p>
                    <p class="form-row form-row-wide">
                      <label for="ck-am-address_1">Address Line 1 <span class="required" aria-hidden="true">*</span></label>
                      <input type="text" class="input-text" id="ck-am-address_1" placeholder="House number and street name" />
                    </p>
                    <p class="form-row form-row-wide">
                      <label for="ck-am-address_2">Address Line 2 <span class="optional">(optional)</span></label>
                      <input type="text" class="input-text" id="ck-am-address_2" placeholder="Apartment, suite, unit, etc. (optional)" />
                    </p>
                    <p class="form-row form-row-first">
                      <label for="ck-am-city">Town / City <span class="required" aria-hidden="true">*</span></label>
                      <input type="text" class="input-text" id="ck-am-city" />
                    </p>
                    <p class="form-row form-row-last">
                      <label for="ck-am-state">State <span class="required" aria-hidden="true">*</span></label>
                      <select class="input-text" id="ck-am-state">
                        <option value="">Select an option&hellip;</option>
                        <?php foreach ((WC()->countries->get_states('IN') ?: []) as $stateCode => $stateName): ?>
                          <option value="<?php echo e($stateCode); ?>"><?php echo e($stateName); ?></option>
                        <?php endforeach; ?>
                      </select>
                    </p>
                    <p class="form-row form-row-first">
                      <label for="ck-am-postcode">PIN Code <span class="required" aria-hidden="true">*</span></label>
                      <input type="text" class="input-text" id="ck-am-postcode" />
                    </p>
                    <p class="form-row form-row-last">
                      <label for="ck-am-country">Country / Region</label>
                      <input type="text" class="input-text" id="ck-am-country" value="India" disabled="disabled" />
                    </p>
                  </div>
                </div>
                <div class="ck-addr-modal-footer">
                  <button type="button" class="ck-addr-modal-cancel" data-modal-close>Cancel</button>
                  <button type="button" class="ck-addr-modal-save" id="ck-address-modal-save">Save Address</button>
                </div>
              </div>
            </div>
          <?php endif; ?>

          <div class="ck-field-grid" id="ck-shipping-field-grid" <?php if($shippingDefault): ?> hidden <?php endif; ?>>
            <?php
            foreach ($deliveryFieldOrder as $key) {
                if (isset($deliveryFields[$key])) {
                    woocommerce_form_field($key, $deliveryFields[$key], $wcCheckout->get_value($key));
                }
            }
            ?>
          </div>
        </div>

        <div class="ck-gst-block">
          <div class="ck-gst-head">
            <span class="ck-gst-icon"><i data-lucide="file-text" aria-hidden="true"></i></span>
            <div class="ck-gst-text">
              <span class="ck-gst-title">Business Invoice (Optional)</span>
              <span class="ck-gst-sub">Add GST details for a business invoice.</span>
            </div>
          </div>
          <label class="ck-gst-checkbox">
            <input type="checkbox" name="wv_gst_invoice" value="1" id="wv-gst-checkbox" />
            I need a GST Invoice
          </label>
          <div class="ck-gst-note">
            <i data-lucide="info" aria-hidden="true"></i>
            <span>By default, we'll invoice your delivery address. Fill in the details below only if you need a different billing address for GST purposes.</span>
          </div>

          <div class="ck-gst-fields" id="ck-gst-fields" hidden>
            <?php if(count($savedBillingAddresses ?? []) > 1): ?>
              <p class="form-row form-row-wide">
                <label for="wv-billing-address-select">Use a saved address</label>
                <select id="wv-billing-address-select" class="woocommerce-Input woocommerce-Input--select input-select">
                  <option value="">Enter a new address</option>
                  <?php $__currentLoopData = $savedBillingAddresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $saved): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($saved['id']); ?>"><?php echo e($saved['label']); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </p>
            <?php endif; ?>

            <div class="ck-field-grid woocommerce-billing-fields__field-wrapper">
              <p class="form-row form-row-wide ck-gst-required-field">
                <label for="wv_gst_number">GST Number</label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="wv_gst_number" id="wv_gst_number" maxlength="15" placeholder="e.g. 22AAAAA0000A1Z5" />
              </p>
              <?php
              foreach ($gstFieldOrder as $key) {
                  if (isset($gstFields[$key])) {
                      woocommerce_form_field($key, $gstFields[$key], $wcCheckout->get_value($key));
                  }
              }
              ?>
            </div>
          </div>
        </div>

        
        <div class="ck-tag-picker" id="ck-shipping-tag-picker" <?php if($shippingDefault): ?> hidden <?php endif; ?>>
          <span class="ck-tag-picker-label">Save this address as</span>
          <div class="ck-tag-picker-options">
            <button type="button" class="ck-tag-pill is-active" data-tag="Home">Home</button>
            <button type="button" class="ck-tag-pill" data-tag="Office">Office</button>
            <button type="button" class="ck-tag-pill" data-tag="Other">Other</button>
          </div>
          <input type="text" class="ck-tag-other-input" id="ck-shipping-tag-other" placeholder="Name this address" maxlength="40" hidden />
          <input type="hidden" id="ck-shipping-tag-value" value="Home" />
        </div>

        <button type="button" class="ck-continue-btn" data-continue-from="2">Continue to <?php echo e($hasGiftStep ? 'Gift Details' : 'Review & Payment'); ?> <i data-lucide="arrow-right" aria-hidden="true"></i></button>
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

    <div class="ck-summary-perks" role="list">
      <div class="ck-summary-perk" role="listitem">
        <i data-lucide="truck" aria-hidden="true"></i>
        <span>Free Shipping</span>
      </div>
      <div class="ck-summary-perk" role="listitem">
        <i data-lucide="headphones" aria-hidden="true"></i>
        <span>Easy Exchange</span>
      </div>
    </div>

  </aside>

</main><!-- /ck-layout -->

<div class="ck-privacy-note">
  <i data-lucide="shield-check" aria-hidden="true"></i>
  <span>We respect your privacy. Your details are safe and will only be used to process your order.</span>
</div>

<?php do_action('woocommerce_after_checkout_form', $wcCheckout); ?>
<?php /**PATH C:\Users\Admin\Local Sites\weavira\app\public\wp-content\themes\weavira\resources\views/woocommerce/checkout.blade.php ENDPATH**/ ?>