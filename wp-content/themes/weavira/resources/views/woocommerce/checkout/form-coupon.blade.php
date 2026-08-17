{{--
  Restyled coupon form — see app/filters.php (moves this out of its default
  position at the top of the checkout page) and
  woocommerce/checkout/form-coupon.php (the template override that renders
  this instead of WooCommerce's own checkout/checkout/form-coupon.php).

  WooCommerce's own checkout.js drives the toggle (.showcoupon click →
  slideToggle .checkout_coupon, also sets aria-expanded on the toggle
  itself) and the AJAX apply/remove — both are keyed on the .showcoupon /
  .checkout_coupon / #coupon_code selectors below, not on markup structure,
  so this can be restyled freely as long as those stay intact.
--}}
<div class="ck-coupon-block">
  <a href="#" role="button" aria-label="Enter your coupon code" aria-controls="woocommerce-checkout-form-coupon" aria-expanded="false" class="showcoupon ck-coupon-toggle">
    <span>Have a coupon?</span>
    <i data-lucide="chevron-down" class="ck-coupon-chevron" aria-hidden="true"></i>
  </a>

  {{-- No `display` styling on the form itself — WooCommerce's checkout.js
       toggles it via jQuery slideToggle()/show()/hide(), which manages its
       own inline `display` (none/block). Overriding that from CSS (even
       with !important, which still beats a plain inline style) fights the
       toggle rather than styling it. The flex row layout lives on the
       inner wrapper instead, which jQuery never touches. --}}
  <form class="checkout_coupon woocommerce-form-coupon ck-coupon-form" method="post" style="display:none" id="woocommerce-checkout-form-coupon">
    <label for="coupon_code" class="screen-reader-text">Coupon:</label>
    {{-- Button comes before the input in DOM order (visual order is set
         via CSS `order` below) so the input stays LAST inside .ck-coupon-row.
         On an invalid coupon, checkout.js appends its error <span> via
         $coupon_field.parent().append(...) — i.e. as the row's last child —
         and its later cleanup (on typing, or after a successful apply) finds
         that span via #coupon_code.next('.coupon-error-notice'), which only
         matches the *immediately following* sibling. Input last in the DOM
         is what makes that match correctly. --}}
    <div class="ck-coupon-row">
      <button type="submit" class="ck-coupon-apply" name="apply_coupon" value="Apply coupon">Apply</button>
      <input type="text" name="coupon_code" class="input-text ck-coupon-input" placeholder="Enter promo code" id="coupon_code" value="" />
    </div>
    <div class="clear"></div>
  </form>
</div>
