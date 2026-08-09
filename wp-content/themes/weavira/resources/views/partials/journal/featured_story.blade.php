<section class="wv-jnl-featured">
  <div class="wv-jnl-featured-text">
    <span class="wv-jnl-featured-kicker"><i data-lucide="sparkles" aria-hidden="true"></i>{!! $section['kicker_label'] ?: 'Featured Story' !!}</span>
    <h2>{!! $section['headline'] !!}</h2>
    @if(!empty($section['excerpt']))
      <p>{!! $section['excerpt'] !!}</p>
    @endif
    <div class="wv-jnl-featured-meta">
      @if(!empty($section['read_time']))
        <span><i data-lucide="clock" aria-hidden="true"></i>{!! $section['read_time'] !!}</span>
      @endif
      @if(!empty($section['category']))
        <span class="wv-jnl-featured-meta-divider" aria-hidden="true"></span>
        <span><i data-lucide="tag" aria-hidden="true"></i>{!! $section['category'] !!}</span>
      @endif
      @if(!empty($section['location']))
        <span class="wv-jnl-featured-meta-divider" aria-hidden="true"></span>
        <span>{!! $section['location'] !!}</span>
      @endif
    </div>
    <a href="{!! $section['cta_link']['url'] ?? '#' !!}" class="wv-jnl-featured-cta">{!! $section['cta_label'] ?: 'Read Story' !!} <i data-lucide="arrow-right" aria-hidden="true"></i></a>
  </div>
  @php $images = array_values(array_filter(wp_list_pluck($section['featured_images'] ?? [], 'image'))); @endphp
  @if(!empty($images))
    <div class="wv-jnl-featured-media" data-featured-media>
      @foreach($images as $i => $image)
        <img src="{!! $image !!}" alt="{!! $section['headline'] !!}" loading="lazy" @if($i > 0) hidden @endif>
      @endforeach
      @if(count($images) > 1)
        <div class="wv-jnl-featured-arrows">
          <button class="wv-jnl-featured-arrow" type="button" aria-label="Previous story"><i data-lucide="chevron-left" aria-hidden="true"></i></button>
          <button class="wv-jnl-featured-arrow" type="button" aria-label="Next story"><i data-lucide="chevron-right" aria-hidden="true"></i></button>
        </div>
      @endif
    </div>
  @endif
</section>
