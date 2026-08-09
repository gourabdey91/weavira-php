@php
  $features = $section['gifting_features'] ?? [];
  $occasions = $section['gifting_occasions'] ?? [];
@endphp

@if(!empty($section['gifting_heading']))
  <div class="page-shell">
  <section class="gifting-section" id="gifting">

    <div class="gifting-hero">
      <div class="gifting-hero-text">
        @if(!empty($section['gifting_kicker']))
          <span class="craft-editorial-kicker">{{ $section['gifting_kicker'] }}</span>
        @endif
        <h2>{{ $section['gifting_heading'] }}</h2>
        @if(!empty($section['gifting_body']))
          <p class="gifting-hero-sub">{{ $section['gifting_body'] }}</p>
        @endif
        @if(!empty($section['gifting_cta_label']))
          <a class="gifting-hero-cta" href="{{ $section['gifting_cta_link']['url'] ?? '#' }}">{{ $section['gifting_cta_label'] }} &#8594;</a>
        @endif
      </div>
      @if(!empty($section['gifting_hero_img']))
        <picture class="gifting-hero-picture">
          <img src="{{ $section['gifting_hero_img'] }}" alt="Weavira gift packaging" class="gifting-hero-img-tag">
        </picture>
      @endif
    </div>

    @if(!empty($features))
      <div class="gifting-features-wrap">
        <div class="gifting-features">
          @foreach($features as $feature)
            <div class="gifting-feature">
              <div class="gifting-feature-head">
                @if(!empty($feature['feature_icon']))
                  <i data-lucide="{{ $feature['feature_icon'] }}" class="gifting-feature-icon" aria-hidden="true"></i>
                @endif
                <p class="gifting-feature-title">{{ $feature['feature_title'] }}</p>
              </div>
              @if(!empty($feature['feature_desc']))
                <p class="gifting-feature-desc">{{ $feature['feature_desc'] }}</p>
              @endif
              @if(!empty($feature['feature_image']))
                <img src="{{ $feature['feature_image'] }}" alt="" class="gifting-feature-img" loading="lazy">
              @endif
            </div>
          @endforeach
        </div>
      </div>
    @endif

    @if(!empty($occasions))
      <div class="gifting-occasions-wrap">
        <div class="section-heading-center section-heading-center--plain">
          <h2>Gifting Collection</h2>
        </div>
        <div class="occasions-row">
          @foreach($occasions as $occasion)
            <a class="occasion-card" href="{{ $occasion['occasion_link']['url'] ?? '#' }}">
              @if(!empty($occasion['occasion_badge']))
                <span class="wv-occasion-badge">{{ $occasion['occasion_badge'] }}</span>
              @endif
              <div class="occasion-card-frame">
                <div class="occasion-card-media">
                  <img src="{{ $occasion['occasion_image'] }}" alt="{{ $occasion['occasion_name'] }}" class="occasion-img" loading="lazy">
                </div>
                <div class="occasion-caption">
                  <span class="occasion-name wv-card-title">{{ $occasion['occasion_name'] }}</span>
                  @if(!empty($occasion['occasion_desc']))
                    <p class="occasion-desc">{{ $occasion['occasion_desc'] }}</p>
                  @endif
                </div>
              </div>
            </a>
          @endforeach
        </div>
      </div>
    @endif

  </section>
  </div>
@endif
