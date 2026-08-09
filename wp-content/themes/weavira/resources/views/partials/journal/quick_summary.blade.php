@php
  $points = $section['summary_points'] ?? [];
  $stats = $section['summary_stats'] ?? [];
@endphp

@if(!empty($points) || !empty($stats))
  <section class="wv-jnl-summary">
    @if(!empty($points))
      <div class="wv-jnl-summary-list-col">
        <span class="wv-jnl-summary-label">{!! $section['summary_label'] ?: 'In Short' !!}</span>
        <ul class="wv-jnl-summary-list">
          @foreach($points as $point)
            <li>{!! $point['point_text'] !!}</li>
          @endforeach
        </ul>
      </div>
    @endif
    @if(!empty($stats))
      <div class="wv-jnl-summary-stats">
        <span class="wv-jnl-summary-label">{!! $section['stats_label'] ?: 'Highlights' !!}</span>
        <div class="wv-jnl-summary-stats-grid">
          @foreach($stats as $stat)
            <div class="wv-jnl-summary-stat">
              <i data-lucide="{!! $stat['stat_icon'] ?: 'circle' !!}" aria-hidden="true"></i>
              <strong>{!! $stat['stat_value'] !!}</strong>
              <span>{!! $stat['stat_label'] !!}</span>
            </div>
          @endforeach
        </div>
      </div>
    @endif
  </section>
@endif
