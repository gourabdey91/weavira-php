@php $products = $section['products'] ?? []; @endphp

@if(!empty($products))
  <div class="page-shell">
    <section class="section fresh-loom">
      <div class="section-heading-center">
        @if(!empty($section['section_heading']))<h2>{{ $section['section_heading'] }}</h2>@endif
        @if(!empty($section['section_subtext']))<p>{{ $section['section_subtext'] }}</p>@endif
      </div>
      <div class="carousel-stage">
        <button class="carousel-arrow carousel-arrow-prev loom-arrow-prev" type="button" aria-label="Previous arrivals">
          <i data-lucide="chevron-left" aria-hidden="true"></i>
        </button>
        <div class="loom-track" id="loom-carousel">
          @foreach($products as $product)
            @include('components.product-card', ['product' => $product, 'fullCard' => true])
          @endforeach
        </div>
        <button class="carousel-arrow carousel-arrow-next loom-arrow-next" type="button" aria-label="Next arrivals">
          <i data-lucide="chevron-right" aria-hidden="true"></i>
        </button>
      </div>
      <div class="fav-cta-wrap">
        <a class="fav-view-all" href="{{ !empty($section['view_all_link']['url']) ? $section['view_all_link']['url'] : wc_get_page_permalink('shop') }}">Explore All New Arrivals &#8594;</a>
      </div>
      <div class="loom-dots" aria-hidden="true"></div>
    </section>
  </div>
@endif
