@php
  $imageDesktop = $section['image_desktop'] ?: $section['image_mobile'];
  $imageMobile = $section['image_mobile'] ?: $section['image_desktop'];
@endphp

@if($imageMobile)
  <figure class="wv-jnl-image">
    <picture>
      @if($imageDesktop)
        <source media="(min-width: 769px)" srcset="{!! $imageDesktop !!}">
      @endif
      <img src="{!! $imageMobile !!}" alt="{!! $section['alt_text'] !!}" loading="lazy">
    </picture>
    <div class="wv-jnl-image-overlay" aria-hidden="true"></div>
    @if(!empty($section['caption']))
      <figcaption>{!! $section['caption'] !!}</figcaption>
    @endif
  </figure>
@endif
