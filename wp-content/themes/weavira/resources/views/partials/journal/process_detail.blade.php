<section class="wv-jnl-process-detail">
  @if(!empty($section['detail_text_left']))
    <p class="wv-jnl-process-detail-text">{!! $section['detail_text_left'] !!}</p>
  @endif
  @if(!empty($section['detail_image']))
    <figure class="wv-jnl-process-detail-media">
      <img src="{!! $section['detail_image'] !!}" alt="{!! $section['detail_caption'] !!}" loading="lazy">
      @if(!empty($section['detail_caption']))
        <figcaption>{!! $section['detail_caption'] !!}</figcaption>
      @endif
    </figure>
  @endif
  @if(!empty($section['detail_text_right']))
    <p class="wv-jnl-process-detail-text">{!! $section['detail_text_right'] !!}</p>
  @endif
</section>
