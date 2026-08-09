@php $milestones = $section['milestones'] ?? []; @endphp

@if(!empty($milestones))
  <section class="wv-jnl-timeline">
    <ol class="wv-jnl-timeline-list">
      @foreach($milestones as $milestone)
        <li class="wv-jnl-timeline-item">
          <span class="wv-jnl-timeline-dot" aria-hidden="true"></span>
          <span class="wv-jnl-timeline-year">{!! $milestone['milestone_year'] !!}</span>
          <p class="wv-jnl-timeline-desc">{!! $milestone['milestone_desc'] !!}</p>
        </li>
      @endforeach
    </ol>
  </section>
@endif
