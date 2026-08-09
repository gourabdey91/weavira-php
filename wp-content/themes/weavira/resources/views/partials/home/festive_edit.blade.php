@if(!empty($section['bg_image_desktop']))
  <div class="page-shell">
  <div class="section-heading-center festive-section-title"></div>
  <section class="festive-edit">
    <a class="festive-bg" href="{{ $section['cta_url']['url'] ?? '#' }}" aria-label="Shop the festive collection">
      <picture>
        @if(!empty($section['bg_image_mobile']))
          <source media="(max-width: 768px)" srcset="{{ $section['bg_image_mobile'] }}">
        @endif
        <img src="{{ $section['bg_image_desktop'] }}" alt="" class="festive-bg-photo" aria-hidden="true">
      </picture>
    </a>
    <div class="festive-overlay"></div>
    <div class="festive-content">
      @if(!empty($section['heading']))
        <h2 class="festive-heading">{!! nl2br(e($section['heading'])) !!}</h2>
      @endif
      <div class="festive-ornament">
        <span class="festive-gem" aria-hidden="true">&#9670;</span>
      </div>
      @if(!empty($section['description']))
        <p class="festive-desc">{!! nl2br(e($section['description'])) !!}</p>
      @endif
      @if(!empty($section['cta_label']))
        <a class="festive-cta" href="{{ $section['cta_url']['url'] ?? '#' }}">{{ $section['cta_label'] }} &#8594;</a>
      @endif
    </div>
  </section>
  </div>
@endif
