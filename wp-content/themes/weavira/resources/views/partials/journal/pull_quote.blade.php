<section class="wv-jnl-pullquote">
  <p class="wv-jnl-pullquote-text">
    <span class="wv-jnl-pullquote-mark wv-jnl-pullquote-mark--open" aria-hidden="true">&#8220;</span>
    {!! $section['quote_text'] !!}
    <span class="wv-jnl-pullquote-mark wv-jnl-pullquote-mark--close" aria-hidden="true">&#8221;</span>
  </p>
  @if(!empty($section['quote_attribution']))
    <span class="wv-jnl-pullquote-attribution">&#8212; {!! $section['quote_attribution'] !!}</span>
  @endif
</section>
