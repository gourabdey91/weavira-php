@extends('layouts.app')

@section('content')

  <div class="page-shell">
    <div class="section-heading-center heritage-plp-heading">
      @if(get_field('journal_kicker', 'options'))<span class="section-kicker">{{ get_field('journal_kicker', 'options') }} <span aria-hidden="true">&#9670;</span></span>@endif
      <h1>{{ get_field('journal_heading', 'options') ?: 'The Journal' }}</h1>
      @if(get_field('journal_desc', 'options'))<p>{{ get_field('journal_desc', 'options') }}</p>@endif
    </div>
  </div>

  <div class="plp-layout page-shell">

    <aside class="plp-sidebar" id="plp-sidebar">
      <div class="plp-sidebar-inner">

        <div class="plp-filter-header">
          <span class="plp-filter-title">FILTER BY</span>
        </div>

        @if(!empty($categories))
          <div class="filter-group">
            <button class="filter-group-head" type="button" aria-expanded="true">
              CATEGORY <i data-lucide="chevron-up" aria-hidden="true"></i>
            </button>
            <div class="filter-group-body">
              @foreach($categories as $category)
                <label class="filter-option">
                  <input type="checkbox" data-filter-attribute="category" value="{{ $category['slug'] }}" @checked($category['checked'])>
                  <span>{{ $category['name'] }} <em>({{ $category['count'] }})</em></span>
                </label>
              @endforeach
            </div>
          </div>
        @endif

        <button class="plp-clear-all" type="button" data-shop-url="{{ get_post_type_archive_link('journal') }}" @if(!$activeFilterCount) hidden @endif>CLEAR ALL FILTERS</button>

      </div>
    </aside>

    <div class="plp-main">

      <div class="plp-toolbar">
        <div style="display:flex;align-items:center;gap:0.75rem;">
          <button class="plp-mobile-filter-btn" id="plp-filter-toggle" type="button" aria-expanded="false" aria-controls="plp-sidebar">
            <i data-lucide="sliders-horizontal" aria-hidden="true"></i>
            FILTER
            @if($activeFilterCount)<span>({{ $activeFilterCount }})</span>@endif
          </button>
          <span class="plp-count">Showing {{ count($posts) }} of {{ $totalCount }} Stor{{ $totalCount === 1 ? 'y' : 'ies' }}</span>
        </div>
      </div>

      @if(empty($posts))
        <div class="cart-empty">
          <i data-lucide="search-x" aria-hidden="true"></i>
          <p>No stories match this filter.</p>
          <button class="cart-continue-link" type="button" onclick="location.href='{{ get_post_type_archive_link('journal') }}'">Clear filters &rarr;</button>
        </div>
      @else
        <div class="plp-grid journal-listing-grid" id="plp-grid">
          @foreach($posts as $post)
            <a class="plp-card journal-listing-card" href="{{ $post['link'] }}">
              <div class="plp-card-img-wrap">
                <img src="{{ $post['image'] }}" alt="{{ $post['title'] }}" class="plp-card-img" loading="lazy">
              </div>
              <div class="plp-card-body journal-listing-body">
                @if($post['category'])
                  <span class="section-kicker">{{ $post['category'] }}</span>
                @endif
                <h3 class="plp-card-name">{{ $post['title'] }}</h3>
                @if($post['excerpt'])
                  <p class="journal-listing-excerpt">{{ $post['excerpt'] }}</p>
                @endif
                <div class="journal-listing-meta">
                  <span class="journal-listing-readtime"><i data-lucide="clock" aria-hidden="true"></i>{{ $post['readTime'] }}</span>
                  <span class="journal-listing-date">{{ $post['date'] }}</span>
                </div>
              </div>
            </a>
          @endforeach
        </div>

        @if($maxPages > 1)
          <nav class="plp-pagination" aria-label="Page navigation">
            @if($currentPage > 1)
              <a class="plp-page-btn" href="{{ esc_url(add_query_arg('paged', $currentPage - 1)) }}" aria-label="Previous page">&#8249;</a>
            @endif

            @for($p = 1; $p <= $maxPages; $p++)
              @if($p === 1 || $p === $maxPages || abs($p - $currentPage) <= 1)
                <a class="plp-page-btn @if($p === $currentPage) active @endif" href="{{ esc_url(add_query_arg('paged', $p)) }}" @if($p === $currentPage) aria-current="page" @endif>{{ $p }}</a>
              @elseif($p === 2 && $currentPage > 3)
                <span class="plp-page-ellipsis" aria-hidden="true">&hellip;</span>
              @elseif($p === $maxPages - 1 && $currentPage < $maxPages - 2)
                <span class="plp-page-ellipsis" aria-hidden="true">&hellip;</span>
              @endif
            @endfor

            @if($currentPage < $maxPages)
              <a class="plp-page-btn" href="{{ esc_url(add_query_arg('paged', $currentPage + 1)) }}" aria-label="Next page">&#8250;</a>
            @endif
          </nav>
        @endif
      @endif

    </div>

  </div>

  <div class="page-shell">
    <a class="wv-journal-explore-bar heritage-journal-bar" href="{{ wc_get_page_permalink('shop') }}">
      <i data-lucide="shopping-bag" aria-hidden="true"></i>
      <span>Every story ends with a saree. Explore the handwoven pieces behind the traditions you just read about.</span>
      <span class="heritage-journal-bar-cta">SHOP THE COLLECTION &#8594;</span>
    </a>
  </div>

@endsection
