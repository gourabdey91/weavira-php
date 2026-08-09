@php $articles = $section['resolvedArticles'] ?? []; @endphp

@if(!empty($articles))
  <section class="wv-jnl-related">
    <div class="wv-jnl-related-grid">
      @foreach($articles as $article)
        <a class="wv-jnl-related-card" href="{!! $article['link'] !!}">
          <img src="{!! $article['image'] !!}" alt="{!! $article['title'] !!}" class="wv-jnl-related-img" loading="lazy">
          <div class="wv-jnl-related-body">
            @if($article['category'])
              <span class="section-kicker">{!! $article['category'] !!}</span>
            @endif
            <h3>{!! $article['title'] !!}</h3>
            <span class="wv-jnl-related-readtime"><i data-lucide="clock" aria-hidden="true"></i>{!! $article['readTime'] !!}</span>
          </div>
        </a>
      @endforeach
    </div>
  </section>
@endif
