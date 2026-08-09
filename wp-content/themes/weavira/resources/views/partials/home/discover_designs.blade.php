@php $designs = $section['designs'] ?? []; @endphp

@if(!empty($designs))
  <div class="page-shell">
    <section class="section designs" id="designs">
      <div class="section-heading-center">
        @if(!empty($section['section_heading']))<h2>{{ $section['section_heading'] }}</h2>@endif
        @if(!empty($section['section_subtext']))<p>{{ $section['section_subtext'] }}</p>@endif
      </div>
      <div class="carousel-stage">
        <button class="carousel-arrow carousel-arrow-prev design-arrow-prev" type="button" aria-label="Previous designs">
          <i data-lucide="chevron-left" aria-hidden="true"></i>
        </button>
        <div class="design-track" id="design-carousel">
          @foreach($designs as $design)
            <a class="design-card" href="{{ $design['link'] }}">
              <div class="design-info">
                <span class="design-icon" aria-hidden="true"><i data-lucide="gem"></i></span>
                <h3 class="wv-card-title">{{ $design['name'] }}</h3>
                <span class="design-rule" aria-hidden="true"></span>
                @if($design['excerpt'])<p>{{ $design['excerpt'] }}</p>@endif
                <span class="design-explore wv-card-explore">EXPLORE DESIGNS &#8594;</span>
              </div>
              <div class="design-img-wrap">
                <img src="{{ $design['image'] }}" alt="{{ $design['name'] }} design" class="design-img" loading="lazy">
              </div>
            </a>
          @endforeach
        </div>
        <button class="carousel-arrow carousel-arrow-next design-arrow-next" type="button" aria-label="Next designs">
          <i data-lucide="chevron-right" aria-hidden="true"></i>
        </button>
      </div>
      <div class="fav-cta-wrap">
        <a class="fav-view-all" href="{{ !empty($section['view_all_link']['url']) ? $section['view_all_link']['url'] : get_post_type_archive_link('heritage_design') }}">View All Heritage Designs &#8594;</a>
      </div>
    </section>
  </div>
@endif
