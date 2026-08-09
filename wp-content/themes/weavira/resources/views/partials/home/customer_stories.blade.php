@php $stories = $section['story_items'] ?? []; @endphp

@if(!empty($section['featured_title']))
  <div class="page-shell">
    <section class="section wv-stories" id="stories">
      <div class="wv-stories-head">
        <div class="section-heading-center">
          @if(!empty($section['stories_kicker']))<div class="section-kicker">{{ $section['stories_kicker'] }}</div>@endif
          @if(!empty($section['stories_heading']))<h2>{{ $section['stories_heading'] }}</h2>@endif
        </div>
      </div>

      <article class="wv-story-featured">
        <div class="wv-story-featured-text">
          <span class="section-kicker wv-story-featured-label">Featured Story</span>
          <h3>{{ $section['featured_title'] }}</h3>
          @if(!empty($section['featured_quote']))
            <blockquote class="wv-story-quote">&ldquo;{{ $section['featured_quote'] }}&rdquo;</blockquote>
          @endif
          <div class="wv-story-meta">
            @if(!empty($section['featured_location']))<span><i data-lucide="map-pin" aria-hidden="true"></i>{{ $section['featured_location'] }}</span>@endif
            @if(!empty($section['featured_date']))<span><i data-lucide="calendar" aria-hidden="true"></i>{{ $section['featured_date'] }}</span>@endif
          </div>
          <a class="wv-story-read" href="{{ $section['featured_link']['url'] ?? '#' }}">Read Her Story &#8594;</a>
        </div>
        @if(!empty($section['featured_image']))
          <div class="wv-story-featured-media">
            <img src="{{ $section['featured_image'] }}" alt="{{ $section['featured_title'] }}" class="wv-story-featured-img" loading="lazy">
          </div>
        @endif
      </article>

      @if(!empty($stories))
        <div class="wv-story-grid">
          @foreach($stories as $story)
            <article class="wv-story-card">
              @if(!empty($story['story_image']))
                <div class="wv-story-card-media">
                  <img src="{{ $story['story_image'] }}" alt="{{ $story['story_title'] }}" class="wv-story-card-img" loading="lazy">
                </div>
              @endif
              <div class="wv-story-card-body">
                <span class="wv-story-card-quote-badge" aria-hidden="true">&#8220;</span>
                <h4>{{ $story['story_title'] }} <i data-lucide="heart" class="wv-story-card-heart" aria-hidden="true"></i></h4>
                @if(!empty($story['story_quote']))
                  <p class="wv-story-card-quote wv-customer-comment">&ldquo;{{ $story['story_quote'] }}&rdquo;</p>
                @endif
                <div class="wv-story-meta">
                  @if(!empty($story['story_location']))<span><i data-lucide="map-pin" aria-hidden="true"></i>{{ $story['story_location'] }}</span>@endif
                  @if(!empty($story['story_date']))<span><i data-lucide="calendar" aria-hidden="true"></i>{{ $story['story_date'] }}</span>@endif
                </div>
                <a class="wv-story-read" href="{{ $story['story_link']['url'] ?? '#' }}">Read Story &#8594;</a>
              </div>
            </article>
          @endforeach
        </div>
      @endif

      @if(!empty($section['cta_heading']))
        <div class="wv-story-cta">
          <div class="wv-story-cta-left">
            <div class="wv-story-cta-seal" aria-hidden="true">&#10070;</div>
            <h3 class="wv-story-cta-heading">{{ $section['cta_heading'] }}</h3>
          </div>
          <div class="wv-story-cta-right">
            <div class="wv-story-cta-row">
              <i data-lucide="book-open" class="wv-story-cta-icon" aria-hidden="true"></i>
              @if(!empty($section['cta_desc']))<p class="wv-story-cta-desc">{{ $section['cta_desc'] }}</p>@endif
            </div>
            @if(!empty($section['cta_label']))
              <a class="wv-story-cta-btn" href="{{ $section['cta_link']['url'] ?? '#' }}">{{ $section['cta_label'] }} &#8594;</a>
            @endif
          </div>
        </div>
      @endif
    </section>
  </div>
@endif
