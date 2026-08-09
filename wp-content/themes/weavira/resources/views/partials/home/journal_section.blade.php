@php
  $featured = $section['featuredPost'] ?? null;
  $posts = $section['posts'] ?? [];
@endphp

@if($featured)
  <div class="page-shell">
    <section class="section wv-journal" id="journal">
      <div class="wv-journal-grid">
        <div class="wv-journal-intro">
          @if(!empty($section['journal_kicker']))
            <span class="section-kicker">{{ $section['journal_kicker'] }} <span aria-hidden="true">&#9670;</span></span>
          @endif
          @if(!empty($section['journal_heading']))<h2>{{ $section['journal_heading'] }}</h2>@endif
          @if(!empty($section['journal_subtext']))<p>{{ $section['journal_subtext'] }}</p>@endif
        </div>

        <div class="wv-journal-content">
          <a class="wv-journal-featured" href="{{ $featured['link'] }}">
            <div class="wv-journal-featured-media">
              <span class="wv-journal-featured-badge">Featured</span>
              <img src="{{ $featured['image'] }}" alt="{{ $featured['title'] }}" class="wv-journal-featured-img" loading="lazy">
            </div>
            <div class="wv-journal-featured-body">
              <div class="wv-journal-meta-row">
                @if($featured['category'])<span class="section-kicker wv-journal-category">{{ $featured['category'] }}</span>@endif
                <span class="wv-journal-readtime">{{ $featured['readTime'] }}</span>
              </div>
              <h3>{{ $featured['title'] }}</h3>
              @if($featured['excerpt'])<p>{{ $featured['excerpt'] }}</p>@endif
              <div class="wv-story-meta">
                <span><i data-lucide="clock" aria-hidden="true"></i>{{ $featured['readTime'] }}</span>
                <span>{{ $featured['date'] }}</span>
              </div>
              <span class="wv-story-read wv-journal-read">Read Story &#8594;</span>
            </div>
          </a>

          @if(!empty($posts))
            <div class="wv-journal-list">
              @foreach($posts as $post)
                <a class="wv-journal-item" href="{{ $post['link'] }}">
                  <div class="wv-journal-item-media">
                    <img src="{{ $post['image'] }}" alt="{{ $post['title'] }}" class="wv-journal-item-img" loading="lazy">
                  </div>
                  <div class="wv-journal-item-body">
                    <div class="wv-journal-meta-row">
                      @if($post['category'])<span class="section-kicker wv-journal-category">{{ $post['category'] }}</span>@endif
                      <span class="wv-journal-readtime">{{ $post['readTime'] }}</span>
                    </div>
                    <h4>{{ $post['title'] }}</h4>
                    @if($post['excerpt'])<p class="wv-journal-item-desc">{{ $post['excerpt'] }}</p>@endif
                    <div class="wv-story-meta">
                      <span><i data-lucide="clock" aria-hidden="true"></i>{{ $post['readTime'] }}</span>
                      <i data-lucide="arrow-right" class="wv-journal-item-arrow" aria-hidden="true"></i>
                    </div>
                    <span class="wv-story-read wv-journal-read">Read Story &#8594;</span>
                  </div>
                </a>
              @endforeach
            </div>
          @endif

          <div class="fav-cta-wrap">
            <a class="fav-view-all" href="{{ !empty($section['journal_cta_link']['url']) ? $section['journal_cta_link']['url'] : get_post_type_archive_link('journal') }}">{{ $section['journal_cta_label'] ?: 'Explore All Journal Stories' }} &#8594;</a>
          </div>
        </div>
      </div>
    </section>
  </div>
@endif
