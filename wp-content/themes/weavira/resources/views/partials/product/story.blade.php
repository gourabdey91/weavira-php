@php
  $storyImage = ($story['image'] ?? null) ?: $galleryImages[0]['url'];
@endphp

@if($story)
  <section class="pdp-inspiration">
    <div class="pdp-inspiration-banner">
      <div class="pdp-inspiration-text">
        @if($story['heading'])
          <h2 class="pdp-inspiration-heading">{{ $story['heading'] }}</h2>
        @endif
        @if($story['body'])
          <p class="pdp-inspiration-body">{{ $story['body'] }}</p>
        @endif
        @if($story['ctaLink'])
          <a href="{{ $story['ctaLink']['url'] }}" class="pdp-inspiration-cta">{{ $story['ctaLabel'] ?: $story['ctaLink']['title'] }} &rarr;</a>
        @endif
      </div>
      <div class="pdp-inspiration-media">
        <img src="{{ $storyImage }}" alt="{{ $story['heading'] }}" class="pdp-inspiration-img" loading="lazy">
      </div>
    </div>
  </section>
@endif
