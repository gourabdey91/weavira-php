@extends('layouts.app')

@php
  $shopUrl = wc_get_page_permalink('shop');
  $breadcrumbTail = end($breadcrumb);
@endphp

@section('content')

  <nav class="plp-breadcrumb plp-breadcrumb-below" aria-label="Breadcrumb">
    <a href="{{ home_url('/') }}">Home</a>
    @foreach($breadcrumb as $i => $crumb)
      <span>/</span>
      @if($i === count($breadcrumb) - 1)
        <span aria-current="page">{{ $crumb }}</span>
      @else
        <a href="{{ $shopUrl }}">{{ $crumb }}</a>
      @endif
    @endforeach
  </nav>

  <section class="plp-hero">
    <picture>
      @if($banner['image'])
        <source media="(min-width: 769px)" srcset="{{ $banner['image'] }}">
        <img src="{{ $banner['image'] }}" alt="{{ $banner['heading'] }}" class="plp-hero-img">
      @endif
    </picture>
    <div class="plp-hero-overlay"></div>
    <div class="plp-hero-content">
      <nav class="plp-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ home_url('/') }}">Home</a>
        @foreach($breadcrumb as $i => $crumb)
          <span>/</span>
          @if($i === count($breadcrumb) - 1)
            <span aria-current="page">{{ $crumb }}</span>
          @else
            <a href="{{ $shopUrl }}">{{ $crumb }}</a>
          @endif
        @endforeach
      </nav>
      <h1 class="plp-hero-heading">{{ $banner['heading'] }}</h1>
      @if($banner['sub'])
        <p class="plp-hero-sub">{{ $banner['sub'] }}</p>
      @endif
    </div>
  </section>

  <div class="plp-trust">
    <div class="plp-trust-item">
      <div class="plp-trust-icon"><i data-lucide="truck" aria-hidden="true"></i></div>
      <div class="plp-trust-text">
        <strong>Free Shipping</strong>
        <span>On all orders above &#8377;999</span>
      </div>
    </div>
    <div class="plp-trust-item plp-trust-hide-mobile">
      <div class="plp-trust-icon"><i data-lucide="lock" aria-hidden="true"></i></div>
      <div class="plp-trust-text">
        <strong>Secure Checkout</strong>
        <span>256-bit SSL on every transaction</span>
      </div>
    </div>
    <div class="plp-trust-item">
      <div class="plp-trust-icon"><i data-lucide="credit-card" aria-hidden="true"></i></div>
      <div class="plp-trust-text">
        <strong>All Cards Accepted</strong>
        <span>Visa, Mastercard, RuPay &amp; UPI</span>
      </div>
    </div>
  </div>

  <div class="plp-layout page-shell">

    <aside class="plp-sidebar" id="plp-sidebar">
      <div class="plp-sidebar-inner">

        <div class="plp-filter-header">
          <span class="plp-filter-title">FILTER BY</span>
        </div>

        @foreach($filterGroups as $group)
          <div class="filter-group">
            <button class="filter-group-head" type="button" aria-expanded="true">
              {{ strtoupper($group['label']) }} <i data-lucide="chevron-up" aria-hidden="true"></i>
            </button>
            <div class="filter-group-body">
              @foreach($group['terms'] as $term)
                <label class="filter-option">
                  <input type="checkbox" data-filter-attribute="{{ $group['slug'] }}" value="{{ $term['slug'] }}" @checked($term['checked'])>
                  <span>{{ $term['name'] }} <em>({{ $term['count'] }})</em></span>
                </label>
              @endforeach
            </div>
          </div>
        @endforeach

        @if(!empty($colourSwatches))
          <div class="filter-group">
            <button class="filter-group-head" type="button" aria-expanded="true">
              COLOR <i data-lucide="chevron-up" aria-hidden="true"></i>
            </button>
            <div class="filter-group-body">
              <div class="color-swatches">
                @foreach($colourSwatches as $swatch)
                  <button
                    class="color-swatch @if($swatch['checked']) selected @endif"
                    type="button"
                    style="background:{{ $swatch['hex'] }}"
                    aria-label="{{ $swatch['name'] }}"
                    data-filter-attribute="body-primary-colour"
                    data-filter-value="{{ $swatch['slug'] }}"
                    aria-pressed="{{ $swatch['checked'] ? 'true' : 'false' }}"
                  ></button>
                @endforeach
              </div>
            </div>
          </div>
        @endif

        @if($priceRange['ceil'] > $priceRange['floor'])
          <div class="filter-group">
            <button class="filter-group-head" type="button" aria-expanded="true">
              PRICE <i data-lucide="chevron-up" aria-hidden="true"></i>
            </button>
            <div class="filter-group-body">
              <div class="price-inputs">
                <input type="number" class="price-input" id="plp-price-min" placeholder="Min" value="{{ (int) $priceRange['min'] }}" min="{{ (int) $priceRange['floor'] }}" max="{{ (int) $priceRange['ceil'] }}" aria-label="Minimum price">
                <span>to</span>
                <input type="number" class="price-input" id="plp-price-max" placeholder="Max" value="{{ (int) $priceRange['max'] }}" min="{{ (int) $priceRange['floor'] }}" max="{{ (int) $priceRange['ceil'] }}" aria-label="Maximum price">
              </div>
              <input type="range" class="price-slider" id="plp-price-slider" min="{{ (int) $priceRange['floor'] }}" max="{{ (int) $priceRange['ceil'] }}" value="{{ (int) $priceRange['max'] }}" aria-label="Price range">
              <div class="price-labels">
                <span>{!! wc_price($priceRange['floor']) !!}</span>
                <span>{!! wc_price($priceRange['ceil']) !!}</span>
              </div>
            </div>
          </div>
        @endif

        <button class="plp-clear-all" type="button" data-shop-url="{{ $shopUrl }}" @if(!$activeFilterCount) hidden @endif>CLEAR ALL</button>

      </div>
    </aside>

    <div class="plp-main">

      <div class="plp-toolbar">
        <div style="display:flex;align-items:center;gap:0.75rem;">
          <button class="plp-mobile-filter-btn" id="plp-filter-toggle" type="button" aria-expanded="false" aria-controls="plp-sidebar">
            <i data-lucide="sliders-horizontal" aria-hidden="true"></i>
            FILTER
            @if($activeFilterCount)<span>({{ $activeFilterCount }})</span>@endif
          </button>
          <span class="plp-count">Showing {{ count($products) }} of {{ $totalProducts }} Product{{ $totalProducts === 1 ? '' : 's' }}</span>
        </div>
        <div class="plp-toolbar-right">
          <div class="plp-sort">
            <label for="plp-sort-select">Sort by:</label>
            <select id="plp-sort-select">
              <option value="menu_order" @selected($currentSort === 'menu_order')>Featured</option>
              <option value="price" @selected($currentSort === 'price')>Price: Low to High</option>
              <option value="price-desc" @selected($currentSort === 'price-desc')>Price: High to Low</option>
              <option value="date" @selected($currentSort === 'date')>Newest</option>
              <option value="popularity" @selected($currentSort === 'popularity')>Best Sellers</option>
            </select>
          </div>
          <div class="plp-view-toggle">
            <button class="plp-view-btn active" type="button" data-view="grid" aria-label="Grid view" aria-pressed="true">
              <i data-lucide="layout-grid" aria-hidden="true"></i>
            </button>
          </div>
        </div>
      </div>

      @if(empty($products))
        <div class="cart-empty">
          <i data-lucide="search-x" aria-hidden="true"></i>
          <p>No products match these filters.</p>
          <button class="cart-continue-link" type="button" data-shop-url="{{ $shopUrl }}" onclick="location.href=this.dataset.shopUrl">Clear filters &rarr;</button>
        </div>
      @else
        <div class="plp-grid" id="plp-grid">
          @foreach($products as $product)
            @include('components.plp-card', ['product' => $product])
          @endforeach
        </div>

        @if($maxPages > 1)
          <nav class="plp-pagination" aria-label="Page navigation">
            @if($currentPage > 1)
              <a class="plp-page-btn" href="{{ esc_url(add_query_arg('paged', $currentPage - 1)) }}" aria-label="Previous page">&#8249;</a>
            @endif

            @for($p = 1; $p <= $maxPages; $p++)
              @if($p === 1 || $p === $maxPages || abs($p - $currentPage) <= 1)
                <a class="plp-page-btn @if($p === $currentPage) active @endif" href="{{ esc_url(add_query_arg('paged', $p)) }}" @if($p === $currentPage) aria-current="page" @endif>{{ $p }}</a>
              @elseif($p === 2 && $currentPage > 3)
                <span class="plp-page-ellipsis" aria-hidden="true">&hellip;</span>
              @elseif($p === $maxPages - 1 && $currentPage < $maxPages - 2)
                <span class="plp-page-ellipsis" aria-hidden="true">&hellip;</span>
              @endif
            @endfor

            @if($currentPage < $maxPages)
              <a class="plp-page-btn" href="{{ esc_url(add_query_arg('paged', $currentPage + 1)) }}" aria-label="Next page">&#8250;</a>
            @endif
          </nav>
        @endif
      @endif

    </div>

  </div>

  @php $packagingImage = get_field('cart_packaging_image', 'option'); @endphp
  <section class="plp-promise">
    <div class="plp-promise-intro">
      <h2 class="plp-promise-heading">Thoughtful by tradition.<br>Delivered with care.</h2>
      <p class="plp-promise-sub">Every order comes with the Weavira promise.</p>
    </div>
    <div class="plp-promise-features">
      <div class="plp-promise-item">
        <div class="plp-promise-icon"><i data-lucide="truck" aria-hidden="true"></i></div>
        <strong>Free Shipping</strong>
        <span>Across India on all orders</span>
      </div>
      <div class="plp-promise-item">
        <div class="plp-promise-icon"><i data-lucide="credit-card" aria-hidden="true"></i></div>
        <strong>All Cards Accepted</strong>
        <span>Visa, Mastercard, Amex &amp; more</span>
      </div>
      <div class="plp-promise-item">
        <div class="plp-promise-icon"><i data-lucide="gift" aria-hidden="true"></i></div>
        <strong>Complimentary Gift Wrapping</strong>
        <span>Beautifully wrapped, ready to be gifted</span>
      </div>
    </div>
    @if($packagingImage)
      <div class="plp-promise-visual">
        <img src="{{ $packagingImage }}" alt="Weavira gift packaging" class="plp-promise-img" loading="lazy">
      </div>
    @endif
  </section>

@endsection
