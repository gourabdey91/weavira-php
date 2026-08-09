@php $stats = $section['stats'] ?? []; @endphp

@if(!empty($stats))
  <section class="wv-jnl-stats">
    @foreach($stats as $stat)
      <div class="wv-jnl-stats-item">
        <i data-lucide="{!! $stat['stat_icon'] ?: 'circle' !!}" aria-hidden="true"></i>
        <strong>{!! $stat['stat_value'] !!}</strong>
        <span>{!! $stat['stat_label'] !!}</span>
      </div>
    @endforeach
  </section>
@endif
