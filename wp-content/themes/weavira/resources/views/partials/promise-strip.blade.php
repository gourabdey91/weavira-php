{{--
  "Thoughtful by tradition" strip — editable under Theme Settings > Promise Strip.
  Not product-specific; safe to @include on any page.
--}}
@php
  $promiseHeading = get_field('promise_heading', 'option');
  $promiseSub = get_field('promise_sub', 'option');
  $promiseCtaLabel = get_field('promise_cta_label', 'option');
  $promiseCtaLink = get_field('promise_cta_link', 'option');
  $promiseImage = get_field('promise_image', 'option');
  $promiseFeatures = get_field('promise_features', 'option') ?: [];
@endphp

@if($promiseHeading || !empty($promiseFeatures))
  <section class="plp-promise">
    <div class="plp-promise-intro">
      @if($promiseHeading)
        <h2 class="plp-promise-heading">{!! nl2br(e($promiseHeading)) !!}</h2>
      @endif
      @if($promiseSub)
        <p class="plp-promise-sub">{{ $promiseSub }}</p>
      @endif
      @if($promiseCtaLink)
        <a href="{{ $promiseCtaLink['url'] }}" class="plp-promise-cta">{{ strtoupper($promiseCtaLabel ?: $promiseCtaLink['title']) }} &#8594;</a>
      @endif
    </div>

    @if(!empty($promiseFeatures))
      <div class="plp-promise-features">
        @foreach($promiseFeatures as $feature)
          <div class="plp-promise-item">
            <div class="plp-promise-icon"><i data-lucide="{{ $feature['promise_features_icon'] }}" aria-hidden="true"></i></div>
            <strong>{{ $feature['promise_features_title'] }}</strong>
            <span>{{ $feature['promise_features_text'] }}</span>
          </div>
        @endforeach
      </div>
    @endif

    @if($promiseImage)
      <div class="plp-promise-visual">
        <img src="{{ $promiseImage }}" alt="Weavira gift packaging" class="plp-promise-img" loading="lazy">
      </div>
    @endif
  </section>
@endif
