@php $images = $section['images'] ?? []; @endphp

@if(!empty($images))
  <section class="wv-jnl-gallery">
    <ul class="wv-jnl-gallery-list">
      @foreach($images as $img)
        @if(!empty($img['image']))
          <li class="wv-jnl-gallery-item"><img src="{{ $img['image'] }}" alt="" loading="lazy"></li>
        @endif
      @endforeach
    </ul>
  </section>
@endif
