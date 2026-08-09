@extends('layouts.app')

@section('content')
<main class="wl-page page-shell">

  <nav class="wl-breadcrumb" aria-label="Breadcrumb">
    <a href="{{ home_url('/') }}">Home</a>
    <span aria-hidden="true">&rsaquo;</span>
    <span aria-current="page">{{ $isSharedView ? 'Shared Collection' : 'My Collection' }}</span>
  </nav>

  <div class="wl-page-head">
    @if($isSharedView)
      <h1 class="wl-page-title">A Shared Collection <span class="wl-title-heart" aria-hidden="true">&#9825;</span></h1>
      <p class="wl-page-sub">Pieces a friend thought <em class="wl-sub-em">you&rsquo;d love</em>.</p>
    @else
      <h1 class="wl-page-title">My Collection <span class="wl-title-heart" aria-hidden="true">&#9825;</span></h1>
      <p class="wl-page-sub">The pieces that <em class="wl-sub-em">stayed with</em> you.</p>
    @endif
    <span class="wl-count">
      <i data-lucide="tag" aria-hidden="true"></i>
      <strong>{{ $wishlistCount }}</strong> Handpicked Treasure{{ $wishlistCount === 1 ? '' : 's' }}
    </span>
  </div>

  <div class="wl-trust">
    <div class="wl-trust-item">
      <i data-lucide="truck" aria-hidden="true"></i>
      <div><strong>Free Shipping</strong><span>Across India</span></div>
    </div>
    <div class="wl-trust-item">
      <i data-lucide="shield-check" aria-hidden="true"></i>
      <div><strong>Secure Checkout</strong><span>100% Safe</span></div>
    </div>
    <div class="wl-trust-item">
      <i data-lucide="credit-card" aria-hidden="true"></i>
      <div><strong>All Cards</strong><span>Visa &bull; Mastercard<br>Amex &amp; more</span></div>
    </div>
    <div class="wl-trust-item">
      <i data-lucide="gift" aria-hidden="true"></i>
      <div><strong>Gift Wrapping</strong><span>Beautifully<br>ready to gift</span></div>
    </div>
  </div>

  @unless($isSharedView)
    <div class="wl-share">
      <div class="wl-share-copy">
        <i data-lucide="share-2" aria-hidden="true"></i>
        <div>
          <strong>Share Your Collection</strong>
          <span>Send this link to friends &amp; family so they know exactly what you love.</span>
        </div>
      </div>
      <div class="wl-share-action">
        <input type="text" class="wl-share-link" value="{{ $shareUrl }}" readonly aria-label="Shareable wishlist link" onclick="this.select()" />
        <button type="button" class="wl-share-btn" data-share-url="{{ $shareUrl }}">Copy Link</button>
      </div>
    </div>
  @endunless

  @if(empty($wishlistItems))
    <div class="cart-empty">
      <i data-lucide="heart" aria-hidden="true"></i>
      <p>{{ $isSharedView ? 'This collection is empty.' : 'Your collection is empty.' }}</p>
      @unless($isSharedView)
        <a href="{{ wc_get_page_permalink('shop') }}" class="cart-continue-link">Browse the collection &rarr;</a>
      @endunless
    </div>
  @else
    <div class="wl-grid" id="wl-grid">
      @foreach($wishlistItems as $item)
        <article class="plp-card" data-product-id="{{ $item['productId'] }}">
          <a href="{{ $item['permalink'] }}" class="card-link" aria-label="View {{ $item['name'] }}"></a>
          <div class="plp-card-img-wrap">
            @if($item['badge'])
              <span class="plp-badge {{ $item['badge']['class'] }}">{{ $item['badge']['label'] }}</span>
            @endif
            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="plp-card-img" loading="lazy">
            @if($item['material'])
              <span class="fav-material">{{ $item['material'] }}</span>
            @endif
            <button class="plp-wish plp-wish--active wl-remove-btn" aria-label="Remove from wishlist" data-product-id="{{ $item['productId'] }}" @if($isSharedView) disabled @endif>
              <i data-lucide="heart" aria-hidden="true"></i>
            </button>
          </div>
          <div class="wl-card-body">
            <h3 class="plp-card-name">{{ $item['name'] }}</h3>
            @if($item['variant'])
              <p class="plp-card-variant">{{ $item['variant'] }}</p>
            @endif
            <p class="plp-card-price">{!! $item['priceHtml'] !!}</p>
            <div class="wl-card-actions">
              <button class="wl-card-bag" data-product-id="{{ $item['productId'] }}">MOVE TO BAG</button>
              @unless($isSharedView)
                <button class="wl-card-delete wl-remove-btn" aria-label="Remove from wishlist" data-product-id="{{ $item['productId'] }}">
                  <i data-lucide="trash-2" aria-hidden="true"></i>
                </button>
              @endunless
            </div>
            <p class="wl-card-saved">Saved {{ $item['savedAgo'] }}</p>
          </div>
        </article>
      @endforeach
    </div><!-- /wl-grid -->

    <p class="wl-empty-hint">
      <span aria-hidden="true">&#9825;</span>
      Can&rsquo;t find something? Some pieces may have sold out.
    </p>
  @endif

  @if(!empty($recommendations))
    <section class="wl-recs" aria-labelledby="wl-recs-heading">
      <div class="wl-recs-head">
        <div>
          <h2 id="wl-recs-heading" class="wl-recs-title">You may also love</h2>
          <p class="wl-recs-sub">Handpicked pieces that go beautifully with your collection.</p>
        </div>
        <a href="{{ wc_get_page_permalink('shop') }}" class="wl-recs-viewall">View All</a>
      </div>
      <div class="carousel-stage">
        <button class="carousel-arrow carousel-arrow-prev wl-recs-prev" aria-label="Previous">
          <i data-lucide="chevron-left" aria-hidden="true"></i>
        </button>
        <div class="loom-track" id="wl-recs-carousel">
          @foreach($recommendations as $recProduct)
            @include('components.product-card', ['product' => $recProduct])
          @endforeach
        </div>
        <button class="carousel-arrow carousel-arrow-next wl-recs-next" aria-label="Next">
          <i data-lucide="chevron-right" aria-hidden="true"></i>
        </button>
      </div>
      <div class="wl-recs-dots" role="tablist" aria-label="Carousel navigation"></div>
    </section>
  @endif

</main>
@endsection
