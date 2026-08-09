{{--
  Recently Viewed: tracked client-side in localStorage (public/js/weavira.js),
  rendered from the WooCommerce Store API (/wp-json/wc/store/v1/products) —
  no custom REST endpoint needed. Hidden until JS has something to show.
--}}
<section class="recently-viewed" data-current-product="{{ $product->get_id() }}" hidden>
  <div class="recently-viewed-head">
    <h2 class="recently-viewed-title">RECENTLY VIEWED</h2>
  </div>
  <div class="recently-viewed-track" id="recently-viewed-track"></div>
</section>
