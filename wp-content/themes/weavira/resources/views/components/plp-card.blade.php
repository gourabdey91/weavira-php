@php
  $cardImageId = $product->get_image_id();
  $cardImage = $cardImageId ? wp_get_attachment_image_url($cardImageId, 'large') : wc_placeholder_img_src('large');
  $inWishlist = \App\weavira_wishlist_contains($product->get_id());
  $badge = \App\weavira_product_badge($product);
  $materialTerms = wp_list_pluck(get_the_terms($product->get_id(), 'pa_material') ?: [], 'name');
  $colourTerms = wp_list_pluck(get_the_terms($product->get_id(), 'pa_body-primary-colour') ?: [], 'name');
  $isVariable = $product->is_type('variable');
@endphp

<article class="plp-card">
  <a href="{{ $product->get_permalink() }}" class="card-link" aria-label="View {{ $product->get_name() }}"></a>
  <div class="plp-card-img-wrap">
    @if($badge)
      <span class="plp-badge {{ $badge['class'] }}">{{ $badge['label'] }}</span>
    @endif
    <img src="{{ $cardImage }}" alt="{{ $product->get_name() }}" class="plp-card-img" loading="lazy">
    @if(!empty($materialTerms))
      <span class="fav-material">{{ $materialTerms[0] }}</span>
    @endif
    <div class="plp-card-atb" aria-hidden="true"><span>{{ $isVariable ? 'CHOOSE OPTIONS' : 'ADD TO BAG' }}</span></div>
    <button class="plp-wish @if($inWishlist) plp-wish--active @endif" aria-label="{{ $inWishlist ? 'Remove from wishlist' : 'Add to wishlist' }}" data-product-id="{{ $product->get_id() }}">
      <i data-lucide="heart" aria-hidden="true"></i>
    </button>
  </div>
  <div class="plp-card-body">
    <h3 class="plp-card-name">{{ $product->get_name() }}</h3>
    @if(!empty($colourTerms))
      <p class="plp-card-variant">{{ $colourTerms[0] }}</p>
    @endif
    <p class="plp-card-price">{!! $product->get_price_html() !!}</p>
    @if($isVariable)
      <a href="{{ $product->get_permalink() }}" class="plp-card-add plp-card-add--link">CHOOSE OPTIONS</a>
    @else
      <button class="plp-card-add" type="button" data-product-id="{{ $product->get_id() }}">ADD TO BAG</button>
    @endif
  </div>
</article>
