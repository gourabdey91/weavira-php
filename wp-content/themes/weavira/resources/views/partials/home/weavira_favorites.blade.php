@php $products = $section['products'] ?? []; @endphp

@if(!empty($products))
  <div class="page-shell">
    <section class="section favorites" id="collections">
      <div class="section-heading-center">
        @if(!empty($section['section_heading']))<h2>{{ $section['section_heading'] }}</h2>@endif
        @if(!empty($section['section_subtext']))<p>{{ $section['section_subtext'] }}</p>@endif
      </div>
      <div class="carousel-stage">
        <button class="carousel-arrow carousel-arrow-prev fav-arrow-prev" type="button" aria-label="Previous sarees">
          <i data-lucide="chevron-left" aria-hidden="true"></i>
        </button>
        <div class="fav-carousel-wrap">
          <div class="fav-track" id="fav-carousel">
            @foreach($products as $product)
              @include('components.product-card', ['product' => $product, 'fullCard' => true])
            @endforeach
          </div>
        </div>
        <button class="carousel-arrow carousel-arrow-next fav-arrow-next" type="button" aria-label="Next sarees">
          <i data-lucide="chevron-right" aria-hidden="true"></i>
        </button>
      </div>
      <div class="fav-dots" aria-hidden="true"></div>
      <div class="fav-cta-wrap">
        <a class="fav-view-all" href="{{ !empty($section['view_all_link']['url']) ? $section['view_all_link']['url'] : wc_get_page_permalink('shop') }}">View All Sarees &#8594;</a>
      </div>
    </section>
  </div>
@endif
