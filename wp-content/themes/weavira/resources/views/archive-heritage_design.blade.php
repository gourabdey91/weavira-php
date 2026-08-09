@extends('layouts.app')

@section('content')

  <div class="page-shell">
    <div class="section-heading-center heritage-plp-heading">
      <h1>Heritage Designs</h1>
      <p>Discover the motifs and symbols that give every saree its meaning.</p>
    </div>
  </div>

  <div class="plp-layout page-shell">

    <aside class="plp-sidebar" id="plp-sidebar">
      <div class="plp-sidebar-inner">

        <div class="plp-filter-header">
          <span class="plp-filter-title">FILTER BY</span>
        </div>

        @foreach($filterGroups as $group)
          <div class="filter-group">
            <button class="filter-group-head" type="button" aria-expanded="true">
              {{ strtoupper($group['label']) }} <i data-lucide="chevron-up" aria-hidden="true"></i>
            </button>
            <div class="filter-group-body">
              @foreach($group['terms'] as $term)
                <label class="filter-option">
                  <input type="checkbox" data-filter-attribute="{{ $group['slug'] }}" value="{{ $term['slug'] }}" @checked($term['checked'])>
                  <span>{{ $term['name'] }} <em>({{ $term['count'] }})</em></span>
                </label>
              @endforeach
            </div>
          </div>
        @endforeach

        @if(!empty($colourSwatches))
          <div class="filter-group">
            <button class="filter-group-head" type="button" aria-expanded="true">
              COLOR <i data-lucide="chevron-up" aria-hidden="true"></i>
            </button>
            <div class="filter-group-body">
              <div class="color-swatches">
                @foreach($colourSwatches as $swatch)
                  <button
                    class="color-swatch @if($swatch['checked']) selected @endif"
                    type="button"
                    style="background:{{ $swatch['hex'] }}"
                    aria-label="{{ $swatch['name'] }}"
                    data-filter-attribute="color"
                    data-filter-value="{{ $swatch['slug'] }}"
                    aria-pressed="{{ $swatch['checked'] ? 'true' : 'false' }}"
                  ></button>
                @endforeach
              </div>
            </div>
          </div>
        @endif

        <button class="plp-clear-all" type="button" data-shop-url="{{ get_post_type_archive_link('heritage_design') }}" @if(!$activeFilterCount) hidden @endif>CLEAR ALL FILTERS</button>

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
          <span class="plp-count">Showing {{ count($cards) }} of {{ $totalCount }} Design{{ $totalCount === 1 ? '' : 's' }}</span>
        </div>
        <div class="plp-toolbar-right">
          <div class="plp-sort">
            <label for="plp-sort-select">Sort by:</label>
            <select id="plp-sort-select">
              <option value="menu_order" @selected($currentSort === 'menu_order')>Featured</option>
              <option value="most-designs" @selected($currentSort === 'most-designs')>Most Designs</option>
              <option value="date" @selected($currentSort === 'date')>Newest</option>
              <option value="title" @selected($currentSort === 'title')>A&#8211;Z</option>
            </select>
          </div>
        </div>
      </div>

      @if(empty($cards))
        <div class="cart-empty">
          <i data-lucide="search-x" aria-hidden="true"></i>
          <p>No motifs match these filters.</p>
          <button class="cart-continue-link" type="button" onclick="location.href='{{ get_post_type_archive_link('heritage_design') }}'">Clear filters &rarr;</button>
        </div>
      @else
        <div class="plp-grid heritage-motif-grid" id="plp-grid">
          @foreach($cards as $card)
            <a class="plp-card heritage-motif-card" href="{{ $card['link'] }}">
              <div class="plp-card-img-wrap">
                <img src="{{ $card['image'] }}" alt="{{ $card['name'] }} motif" class="plp-card-img" loading="lazy">
              </div>
              <div class="plp-card-body heritage-motif-body">
                <h3 class="plp-card-name">{{ $card['name'] }}</h3>
                @if($card['excerpt'])
                  <p class="heritage-motif-desc">{{ $card['excerpt'] }}</p>
                @endif
                <div class="heritage-motif-meta">
                  <span class="heritage-motif-count">{{ $card['count'] }} Design{{ $card['count'] === 1 ? '' : 's' }}</span>
                  <span class="heritage-motif-link">VIEW DESIGNS &#8594;</span>
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
    <a class="wv-journal-explore-bar heritage-journal-bar" href="{{ get_post_type_archive_link('journal') }}">
      <i data-lucide="book-open" aria-hidden="true"></i>
      <span>Each motif carries a meaning. Each weave carries a legacy. Learn more about the stories behind our motifs in the Weavira Journal.</span>
      <span class="heritage-journal-bar-cta">EXPLORE JOURNAL &#8594;</span>
    </a>
  </div>

@endsection
