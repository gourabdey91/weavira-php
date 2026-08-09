<section class="wv-jnl-heritage">
  @if(!empty($section['heritage_image']))
    <figure class="wv-jnl-heritage-media">
      <img src="{!! $section['heritage_image'] !!}" alt="{!! $section['heritage_title'] !!}" loading="lazy">
    </figure>
  @endif
  <div class="wv-jnl-heritage-body">
    @if(!empty($section['heritage_title']))
      <h3>{!! $section['heritage_title'] !!}</h3>
    @endif
    {!! $section['heritage_text'] !!}
  </div>
</section>
