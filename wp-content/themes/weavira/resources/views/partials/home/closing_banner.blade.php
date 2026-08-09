@if(!empty($section['banner_image_desktop']))
  <section class="wv-closing-banner">
    <picture class="wv-closing-media">
      @if(!empty($section['banner_image_mobile']))
        <source media="(max-width: 768px)" srcset="{{ $section['banner_image_mobile'] }}">
      @endif
      <img src="{{ $section['banner_image_desktop'] }}" alt="" class="wv-closing-img">
    </picture>
    <div class="wv-closing-overlay">
      <div class="wv-closing-text">
        @if(!empty($section['heading']))
          <h2 class="wv-closing-heading">{{ $section['heading'] }}</h2>
        @endif
        @if(!empty($section['description']))
          <p class="wv-closing-desc">{!! nl2br(e($section['description'])) !!}</p>
        @endif
      </div>
    </div>
  </section>
@endif
