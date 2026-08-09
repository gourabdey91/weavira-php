@php $products = $section['resolvedProducts'] ?? []; @endphp

@if(!empty($products))
  <section class="wv-jnl-collection">
    <div class="carousel-stage">
      <button class="carousel-arrow carousel-arrow-prev jnl-collection-arrow-prev" type="button" aria-label="Previous saree">
        <i data-lucide="chevron-left" aria-hidden="true"></i>
      </button>
      <div class="loom-track" id="jnl-collection-carousel">
        @foreach($products as $product)
          @include('components.product-card', ['product' => $product])
        @endforeach
      </div>
      <button class="carousel-arrow carousel-arrow-next jnl-collection-arrow-next" type="button" aria-label="Next saree">
        <i data-lucide="chevron-right" aria-hidden="true"></i>
      </button>
    </div>
    <div class="jnl-collection-dots" aria-hidden="true"></div>
  </section>
@endif
