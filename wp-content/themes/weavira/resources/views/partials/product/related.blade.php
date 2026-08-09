@php
  $relatedTabs = [
    'design' => 'Same Design',
    'theme' => 'Same Theme',
    'occasion' => 'Festive Picks',
    'similar' => 'Similar Products',
  ];
  $relatedTabs = array_filter($relatedTabs, fn($label, $key) => !empty($relatedGroups[$key]), ARRAY_FILTER_USE_BOTH);
@endphp

@if(!empty($relatedTabs))
  <section class="section similar-stories">
    <div class="similar-stories-head">
      <h2 class="similar-stories-title">SIMILAR STORIES</h2>
      @if(count($relatedTabs) > 1)
        <div class="similar-stories-filters">
          @foreach($relatedTabs as $key => $label)
            <button class="similar-filter @if($loop->first) active @endif" data-related-filter="{{ $key }}">{{ $label }}</button>
          @endforeach
        </div>
      @endif
    </div>
    <div class="carousel-stage">
      <button class="carousel-arrow carousel-arrow-prev similar-arrow-prev" aria-label="Previous">
        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M13 4L7 10l6 6"/></svg>
      </button>
      <div class="loom-track" id="similar-carousel">
        @foreach($relatedGroups[array_key_first($relatedTabs)] as $relatedProduct)
          @include('components.product-card', ['product' => $relatedProduct])
        @endforeach
      </div><!-- /.loom-track -->
      <button class="carousel-arrow carousel-arrow-next similar-arrow-next" aria-label="Next">
        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M7 4l6 6-6 6"/></svg>
      </button>
    </div><!-- /.carousel-stage -->

    @foreach($relatedTabs as $key => $label)
      @if(!$loop->first)
        <template data-related-source="{{ $key }}">
          @foreach($relatedGroups[$key] as $relatedProduct)
            @include('components.product-card', ['product' => $relatedProduct])
          @endforeach
        </template>
      @endif
    @endforeach
  </section>
@endif
