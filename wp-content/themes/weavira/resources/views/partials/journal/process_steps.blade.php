@php $steps = $section['steps'] ?? []; @endphp

@if(!empty($steps))
  <section class="wv-jnl-process">
    <ol class="wv-jnl-process-list">
      @foreach($steps as $i => $step)
        <li class="wv-jnl-process-step">
          <span class="wv-jnl-process-num">{!! $i + 1 !!}</span>
          <h3>{!! $step['step_label'] !!}</h3>
          <p>{!! $step['step_desc'] !!}</p>
        </li>
      @endforeach
    </ol>
  </section>
@endif
