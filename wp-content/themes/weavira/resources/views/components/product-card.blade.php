@php
  $cardImageId = $product->get_image_id();
  $cardImage = $cardImageId ? wp_get_attachment_image_url($cardImageId, 'large') : wc_placeholder_img_src('large');
  $inWishlist = \App\weavira_wishlist_contains($product->get_id());
  $fullCard = $fullCard ?? false;

  if ($fullCard) {
    $materialTerms = wp_list_pluck(get_the_terms($product->get_id(), 'pa_material') ?: [], 'name');
    $weaveTerms = wp_list_pluck(get_the_terms($product->get_id(), 'pa_weave') ?: [], 'name');
  }
@endphp

<article class="loom-card fav-card">
  <a href="{{ $product->get_permalink() }}" class="card-link" aria-label="View {{ $product->get_name() }}"></a>
  <div class="fav-image-wrap">
    <img src="{{ $cardImage }}" alt="{{ $product->get_name() }}" class="loom-img" loading="lazy">
    @if($fullCard && !empty($materialTerms))
      <span class="fav-material">{{ $materialTerms[0] }}</span>
    @endif
    <button class="fav-wish @if($inWishlist) plp-wish--active @endif" aria-label="{{ $inWishlist ? 'Remove from wishlist' : 'Add to wishlist' }}" data-product-id="{{ $product->get_id() }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
    </button>
  </div>
  <div class="fav-copy">
    <h3>{{ $product->get_name() }}</h3>
    @if($fullCard)
      @if($product->get_short_description())
        <p class="fav-desc">{{ wp_strip_all_tags($product->get_short_description()) }}</p>
      @endif
      @if(!empty($weaveTerms) || !empty($materialTerms))
        <span class="fav-subtitle">{{ $weaveTerms[0] ?? $materialTerms[0] }}</span>
      @endif
    @endif
    <div class="fav-action">
      <span class="fav-price">{!! $product->get_price_html() !!}</span>
      @if($fullCard)
        @if($product->is_type('variable'))
          <a href="{{ $product->get_permalink() }}" class="fav-add fav-add--link">Choose Options</a>
        @else
          <button class="fav-add" type="button" data-product-id="{{ $product->get_id() }}">Add to Bag</button>
        @endif
      @endif
    </div>
  </div>
</article>
