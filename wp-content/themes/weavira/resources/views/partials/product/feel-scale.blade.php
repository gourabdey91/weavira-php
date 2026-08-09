@php
  $feelScaleValue = get_field('feel_scale_value', $product->get_id());
  $feelBody = get_field('feel_body', $product->get_id());
  $feelKicker = get_field('feel_kicker', $product->get_id()) ?: 'How Will This Saree Feel?';
  $feelImage = get_field('feel_image', $product->get_id()) ?: $galleryImages[0]['url'];
  $feelPoints = ['Featherlight', 'Fine', 'Traditional', 'Heritage'];
@endphp

@if($feelScaleValue)
  <section class="wv-feel-scale">
    <div class="wv-feel-media">
      <img src="{{ $feelImage }}" alt="Close-up of the weave" class="wv-feel-img" loading="lazy">
    </div>
    <div class="wv-feel-text">
      <span class="wv-feel-kicker section-kicker">{{ $feelKicker }}</span>

      <ul class="wv-feel-scale-track">
        <span class="wv-feel-scale-line" aria-hidden="true"></span>
        @foreach($feelPoints as $point)
          <li class="wv-feel-point @if($point === $feelScaleValue) wv-feel-point--active @endif">
            <span class="wv-feel-label">{{ $point }}</span>
            <span class="wv-feel-dot"></span>
            @if($point === $feelScaleValue)
              <span class="wv-feel-marker">
                <span class="wv-feel-marker-caret" aria-hidden="true">&#9650;</span>
                <span class="wv-feel-marker-text">This Saree</span>
              </span>
            @endif
          </li>
        @endforeach
      </ul>

      @if($feelBody)
        <p class="wv-feel-body">{{ $feelBody }}</p>
      @endif
    </div>
  </section>
@endif
