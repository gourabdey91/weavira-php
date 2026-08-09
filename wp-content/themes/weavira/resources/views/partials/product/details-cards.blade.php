@php
  $designDetails = get_field('design_details', $product->get_id()) ?: [];
@endphp

@if(!empty($designDetails))
  <section class="product-design-details">
    <div class="design-details-grid">
      @foreach($designDetails as $card)
        @continue(empty($card['design_details_title']))
        <div class="design-detail-card">
          <img
            src="{{ $card['design_details_image'] ?: $galleryImages[0]['url'] }}"
            alt="{{ $card['design_details_title'] }}"
            class="design-detail-img"
            loading="lazy"
          >
          <div class="design-detail-overlay"></div>
          <div class="design-detail-content">
            @if(!empty($card['design_details_label']))
              <span class="design-detail-label">{{ strtoupper($card['design_details_label']) }}</span>
            @endif
            <h3 class="design-detail-title">{{ $card['design_details_title'] }}</h3>
            @if(!empty($card['design_details_desc']))
              <p class="design-detail-desc">{{ $card['design_details_desc'] }}</p>
            @endif
          </div>
        </div>
      @endforeach
    </div>
  </section>
@endif
