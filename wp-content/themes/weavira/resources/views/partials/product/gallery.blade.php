{{--
  WooCommerce: product gallery (featured image + gallery images), via
  $galleryImages prepared in App\View\Composers\Product.
--}}
@php $inWishlist = \App\weavira_wishlist_contains($product->get_id()); @endphp
<div class="pdp-gallery-stage">
  <div class="w-pdp-gallery">
    <div class="gallery-main">
      <div class="gallery-main-img">
        <img src="{{ $galleryImages[0]['url'] }}" alt="{{ $galleryImages[0]['alt'] }}" class="gallery-main-photo">
        @if($galleryVideo)
          <video class="gallery-main-video" playsinline controls hidden></video>
        @endif
      </div>
      @if(count($galleryImages) > 1 || $galleryVideo)
        <span class="gallery-slide-counter" aria-live="polite">1 / {{ count($galleryImages) + ($galleryVideo ? 1 : 0) }}</span>
      @endif
      <button class="gallery-wishlist @if($inWishlist) plp-wish--active @endif" aria-label="{{ $inWishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}" data-product-id="{{ $product->get_id() }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
          <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
        </svg>
      </button>
      @if(count($galleryImages) > 1 || $galleryVideo)
        <button class="gallery-play-toggle" aria-label="Pause slideshow">
          <svg class="icon-pause" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><rect x="6" y="4" width="4" height="16" rx="1"/><rect x="14" y="4" width="4" height="16" rx="1"/></svg>
          <svg class="icon-play" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><polygon points="5,3 19,12 5,21"/></svg>
        </button>
      @endif
      <button class="gallery-expand" aria-label="View fullscreen">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
          <path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"/>
        </svg>
      </button>
    </div>

    @if(count($galleryImages) > 1 || $galleryVideo)
      <div class="gallery-thumbs-row">
        <button class="gallery-thumb-arrow" aria-label="Previous image">
          <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M13 4L7 10l6 6"/></svg>
        </button>
        <div class="gallery-thumbs">
          @foreach($galleryImages as $i => $image)
            <button class="gallery-thumb @if($i === 0) active @endif" aria-label="View image {{ $i + 1 }}">
              <img src="{{ $image['url'] }}" alt="{{ $image['alt'] }}" class="gallery-thumb-img">
            </button>
          @endforeach
          @if($galleryVideo)
            <button class="gallery-thumb gallery-thumb-video" aria-label="Watch video" data-video-src="{{ $galleryVideo['url'] }}">
              <img src="{{ $galleryVideo['poster'] }}" alt="Watch the weaving video" class="gallery-thumb-img">
              <div class="gallery-video-overlay">
                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10" fill="rgba(0,0,0,0.55)"/><polygon points="10,8 17,12 10,16" fill="#fff"/></svg>
              </div>
            </button>
          @endif
        </div>
        <button class="gallery-thumb-arrow" aria-label="Next image">
          <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M7 4l6 6-6 6"/></svg>
        </button>
      </div>
    @endif
  </div>
</div>
