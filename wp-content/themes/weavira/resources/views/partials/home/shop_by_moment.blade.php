@php $cards = $section['moment_cards'] ?? []; @endphp

@if(!empty($cards))
  <div class="page-shell">
    <section class="section moments" id="moments">
      <div class="section-heading-center">
        @if(!empty($section['section_heading']))<h2>{{ $section['section_heading'] }}</h2>@endif
        @if(!empty($section['section_subtext']))<p>{{ $section['section_subtext'] }}</p>@endif
      </div>
      <div class="moment-stage">
        <button class="moment-arrow-prev" type="button" aria-label="Previous moments">
          <i data-lucide="chevron-left" aria-hidden="true"></i>
        </button>
        <div class="moment-row" id="moment-carousel">
          @foreach($cards as $card)
            <a class="moment-card" href="{{ $card['link_url']['url'] ?? '#' }}">
              <picture class="moment-image">
                <img src="{{ $card['image'] }}" alt="" class="moment-photo" aria-hidden="true">
              </picture>
              <div class="moment-card-content">
                <div class="moment-card-top">
                  <h3 class="wv-card-title">{{ $card['heading'] }}</h3>
                  <div class="moment-divider"></div>
                  <p>{{ $card['subtext'] }}</p>
                </div>
                <span class="moment-cta wv-card-explore">{{ $card['cta_label'] ?: 'EXPLORE COLLECTION' }} &#8594;</span>
              </div>
            </a>
          @endforeach
        </div>
        <button class="moment-arrow-next" type="button" aria-label="Next moments">
          <i data-lucide="chevron-right" aria-hidden="true"></i>
        </button>
      </div>
      <div class="fav-cta-wrap">
        <a class="fav-view-all" href="{{ !empty($section['view_all_link']['url']) ? $section['view_all_link']['url'] : wc_get_page_permalink('shop') }}">Shop All Moments &#8594;</a>
      </div>
      <div class="moment-dots" aria-hidden="true"></div>
    </section>
  </div>
@endif
