<section class="wv-jnl-richtext">
  <div class="wv-jnl-richtext-text">
    @if(!empty($section['block_heading']))
      <h2>{{ $section['block_heading'] }}</h2>
    @endif
    {!! $section['block_body'] !!}
  </div>
  @if(!empty($section['block_illustration']))
    <figure class="wv-jnl-richtext-media">
      <img src="{{ $section['block_illustration'] }}" alt="" loading="lazy">
    </figure>
  @endif
</section>
