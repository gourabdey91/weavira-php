@php $articles = $section['resolvedArticles'] ?? []; @endphp

@if(!empty($articles))
  <section class="wv-jnl-continue">
    <div class="section-heading-center">
      @if(!empty($section['kicker_label']))
        <span class="section-kicker wv-jnl-continue-kicker">{!! $section['kicker_label'] !!}</span>
      @endif
      <h2>{!! $section['heading'] ?: 'Continue Reading' !!}</h2>
    </div>
    <div class="carousel-stage">
      <button class="carousel-arrow carousel-arrow-prev jnl-continue-arrow-prev" type="button" aria-label="Previous story">
        <i data-lucide="chevron-left" aria-hidden="true"></i>
      </button>
      <div class="loom-track" id="jnl-continue-carousel">
        @foreach($articles as $article)
          <article class="wv-jnl-continue-card">
            <a href="{{ $article['link'] }}" class="card-link" aria-label="Read {{ $article['title'] }}"></a>
            <div class="wv-jnl-continue-image-wrap">
              <img src="{{ $article['image'] }}" alt="" class="wv-jnl-continue-img" loading="lazy">
              <button class="wv-jnl-continue-bookmark" type="button" aria-label="Save story"><i data-lucide="bookmark" aria-hidden="true"></i></button>
            </div>
            <div class="wv-jnl-continue-body">
              @if($article['category'])
                <span class="section-kicker">{!! $article['category'] !!}</span>
              @endif
              <h3>{!! $article['title'] !!}</h3>
              <span class="wv-jnl-continue-readtime"><i data-lucide="clock" aria-hidden="true"></i>{!! $article['readTime'] !!}</span>
            </div>
          </article>
        @endforeach
      </div>
      <button class="carousel-arrow carousel-arrow-next jnl-continue-arrow-next" type="button" aria-label="Next story">
        <i data-lucide="chevron-right" aria-hidden="true"></i>
      </button>
    </div>
    <div class="jnl-continue-dots"></div>
  </section>
@endif
