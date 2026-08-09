@php
  $imageDesktop = $section['hero_image_desktop'] ?: get_the_post_thumbnail_url(get_the_ID(), 'large');
  $imageMobile = $section['hero_image_mobile'] ?: $imageDesktop;
  $readTime = $section['hero_readtime'] ?: \App\weavira_journal_read_time(get_post());
@endphp

<section class="wv-jnl-hero">
  <picture>
    @if($imageDesktop)
      <source media="(min-width: 769px)" srcset="{!! $imageDesktop !!}">
    @endif
    <img src="{!! $imageMobile ?: wc_placeholder_img_src('large') !!}" alt="" class="wv-jnl-hero-img" aria-hidden="true">
  </picture>
  <div class="wv-jnl-hero-overlay"></div>
  <div class="wv-jnl-hero-content">
    @if(!empty($section['hero_category']))
      <span class="wv-journal-featured-badge">{!! $section['hero_category'] !!}</span>
    @endif
    <h1 class="wv-jnl-hero-heading">{!! $section['hero_heading'] ?: get_the_title() !!}</h1>
    @if(!empty($section['hero_subheading']))
      <p class="wv-jnl-hero-subheading">{!! $section['hero_subheading'] !!}</p>
    @endif
    @if(!empty($section['hero_excerpt']))
      <p class="wv-jnl-hero-desc">{!! $section['hero_excerpt'] !!}</p>
    @endif
    <div class="wv-jnl-hero-meta">
      <span class="wv-jnl-hero-meta-item">{!! $readTime !!}</span>
      <span class="wv-jnl-hero-meta-dot" aria-hidden="true">&#183;</span>
      <span class="wv-jnl-hero-meta-item">{!! $section['hero_author'] ?: 'Weavira Editorial' !!}</span>
    </div>
  </div>
</section>
