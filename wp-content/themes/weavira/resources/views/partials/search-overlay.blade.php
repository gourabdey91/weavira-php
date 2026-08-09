{{--
  Search overlay. Markup is server-rendered here (real, randomized "Popular
  Searches" chips + real destination links) instead of being built in JS —
  public/js/weavira.js only handles open/close and the AJAX product search.
--}}
<div id="wv-search-overlay" class="wv-srch-overlay" role="dialog" aria-modal="true" aria-label="Search" aria-hidden="true">
  <div class="wv-srch-backdrop" id="wv-srch-backdrop"></div>
  <div class="wv-srch-panel" role="document">

    <div class="wv-srch-bar">
      <span class="wv-srch-bar-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
      </span>
      <input type="search" id="wv-srch-input" class="wv-srch-input"
        placeholder="Search for a saree, weave, design or colour..."
        autocomplete="off" autocorrect="off" spellcheck="false"
        aria-label="Search products" />
      <button class="wv-srch-clear" id="wv-srch-clear" type="button" aria-label="Clear search" hidden>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
      </button>
    </div>

    <div class="wv-srch-body">

      @if(!empty($popularSearches))
        <aside class="wv-srch-left">
          <p class="wv-srch-label">Popular Searches</p>
          <div class="wv-srch-chips">
            @foreach($popularSearches as $term)
              <button class="wv-srch-chip" type="button">{{ $term }}</button>
            @endforeach
          </div>
        </aside>
      @endif

      <section class="wv-srch-right" aria-live="polite" aria-atomic="true">
        <div class="wv-srch-results-head" id="wv-srch-results-head" hidden>
          <p class="wv-srch-label" style="margin:0">Matching Products</p>
          <a href="#" class="wv-srch-viewall" id="wv-srch-viewall"></a>
        </div>
        <ul class="wv-srch-results" id="wv-srch-results" role="list"></ul>
        <div class="wv-srch-empty" id="wv-srch-empty" hidden>
          <p>No matching sarees found.</p>
          <a href="{{ wc_get_page_permalink('shop') }}" class="wv-srch-browse">Browse all collections &#8594;</a>
        </div>
      </section>

    </div>

    <div class="wv-srch-footer">
      <div class="wv-srch-footer-cell">
        <span class="wv-srch-footer-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        </span>
        <div class="wv-srch-footer-text">
          <p>Can't find what you're looking for?</p>
          <a href="{{ wc_get_page_permalink('shop') }}" class="wv-srch-footer-link">Browse all collections &#8594;</a>
        </div>
      </div>
      <div class="wv-srch-footer-cell">
        <span class="wv-srch-footer-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
        </span>
        <div class="wv-srch-footer-text">
          <p>Every weave has a story.</p>
          <a href="{{ get_post_type_archive_link('journal') }}" class="wv-srch-footer-link">Explore Journal &#8594;</a>
        </div>
      </div>
    </div>

  </div>
</div>
