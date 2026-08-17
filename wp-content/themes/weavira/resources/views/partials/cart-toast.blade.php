{{--
  Small AJAX "added to cart" toast — replaces WooCommerce's default
  full-width, page-reload notice. Populated and shown by public/js/weavira.js
  after a successful AJAX add-to-cart on the product page.
--}}
<div id="wv-cart-toast" class="wv-cart-toast" role="status" aria-live="polite" aria-atomic="true" hidden>
  <button class="wv-cart-toast-close" type="button" aria-label="Dismiss">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
  </button>
  <div class="wv-cart-toast-icon">
    <svg class="wv-cart-toast-icon-success" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
    <svg class="wv-cart-toast-icon-error" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 8v5"/><path d="M12 16h.01"/></svg>
  </div>
  <img class="wv-cart-toast-img" id="wv-cart-toast-img" src="" alt="" />
  <div class="wv-cart-toast-body">
    <p class="wv-cart-toast-title" id="wv-cart-toast-title">Added to your bag</p>
    <p class="wv-cart-toast-product" id="wv-cart-toast-product"></p>
  </div>
  {{--
    Deliberately no "Checkout" shortcut here: gifting can only be applied
    per line item, so jumping straight to checkout used to strand anyone
    who wanted gift packaging. Routing through the bag also suits a
    considered, high-value purchase better than a fast-exit CTA.
  --}}
  <div class="wv-cart-toast-actions">
    <a href="{{ wc_get_cart_url() }}" class="wv-cart-toast-cart" id="wv-cart-toast-cart">View Bag</a>
  </div>
</div>
