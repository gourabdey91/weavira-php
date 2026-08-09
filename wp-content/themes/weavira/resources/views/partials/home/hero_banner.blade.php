@php $slides = $section['hero_slides'] ?? []; @endphp

<div class="hero-stage">
  <section class="hero-banner" role="region" aria-label="Featured collection">
    @if(!empty($slides))
      <div class="hero-slider-track" id="hero-slider-track">
        @foreach($slides as $i => $slide)
          <div class="hero-slide @if($i === 0) active @endif">
            <picture>
              @if(!empty($slide['image_desktop']))
                <source media="(min-width: 769px)" srcset="{{ $slide['image_desktop'] }}">
              @endif
              <img src="{{ $slide['image_mobile'] ?: $slide['image_desktop'] }}" alt="" class="hero-banner-photo" aria-hidden="true">
            </picture>
          </div>
        @endforeach
      </div>
    @endif
    <div class="hero-banner-overlay"></div>
    <div class="hero-container">
      @if(!empty($section['eyebrow_text']))
        <div class="hero-label">{{ $section['eyebrow_text'] }}</div>
      @endif
      <div class="hero-copy">
        @if(!empty($section['heading']))
          <h1>{!! nl2br(e($section['heading'])) !!}</h1>
        @endif
        @if(!empty($section['subtext']))
          <p class="hero-subtitle">{{ $section['subtext'] }}</p>
        @endif
        @if(!empty($section['cta_label']) && !empty($section['cta_url']['url']))
          <div class="hero-actions">
            <a class="button button-primary" href="{{ $section['cta_url']['url'] }}">{{ $section['cta_label'] }}</a>
          </div>
        @endif
      </div>
    </div>
  </section>
</div>
