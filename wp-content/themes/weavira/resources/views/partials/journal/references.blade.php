@php
  $refs = array_values(array_filter(wp_list_pluck($section['references'] ?? [], 'reference_text')));
  $columns = !empty($refs) ? array_chunk($refs, (int) ceil(count($refs) / 3)) : [];
@endphp

@if(!empty($refs))
  <section class="wv-jnl-references">
    <h3>References</h3>
    <div class="wv-jnl-references-grid">
      @foreach($columns as $column)
        <ul>
          @foreach($column as $ref)
            <li>{!! $ref !!}</li>
          @endforeach
        </ul>
      @endforeach
    </div>
  </section>
@endif
