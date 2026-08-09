@extends('layouts.app')

@section('content')
<div class="page-shell">
<main class="wv-jnl-article">
  @foreach($sections as $section)
    @includeFirst(['partials.journal.' . $section['acf_fc_layout'], 'partials.journal.missing'], ['section' => $section])
  @endforeach
</main>
</div>
@endsection
