<section class="wv-jnl-quote">
  <span class="wv-jnl-quote-portrait">
    @if(!empty($section['portrait_image']))
      <img src="{!! $section['portrait_image'] !!}" alt="{!! $section['quote_name'] !!}">
    @else
      <i data-lucide="user" aria-hidden="true"></i>
    @endif
  </span>
  <div class="wv-jnl-quote-body">
    <p class="wv-jnl-quote-text"><span class="wv-jnl-quote-mark" aria-hidden="true">&#8220;</span>{!! $section['quote_text'] !!}</p>
    <cite class="wv-jnl-quote-cite">
      <span class="wv-jnl-quote-name">{!! $section['quote_name'] !!}</span>
      <span class="wv-jnl-quote-role">{!! $section['quote_role'] !!}</span>
    </cite>
  </div>
</section>
