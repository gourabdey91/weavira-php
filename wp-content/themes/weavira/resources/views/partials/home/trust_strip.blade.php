@php $items = $section['trust_items'] ?? []; @endphp

@if(!empty($items))
  <section class="hero-features">
    @foreach($items as $item)
      <div class="hero-feature">
        <div class="feature-icon">{!! $item['icon_character'] !!}</div>
        <div>
          <p class="feature-title">{!! $item['title'] !!}</p>
          <p>{!! $item['subtitle'] !!}</p>
        </div>
      </div>
    @endforeach
  </section>
@endif
