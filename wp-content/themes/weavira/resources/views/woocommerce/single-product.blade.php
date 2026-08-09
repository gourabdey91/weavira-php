@extends('layouts.app')

@section('content')
@while (have_posts())
  @php
    the_post();
    wc_print_notices();
  @endphp

<div class="pdp-layout">
  @include('partials.product.gallery')

  <div class="pdp-info-shell">
    @include('partials.product.breadcrumb')
    @include('partials.product.info')
  </div>
</div>

<div class="page-shell">
  <main>
    @include('partials.product.details-cards')
    @include('partials.product.story')
    @include('partials.product.craft-journey')
    @include('partials.product.design-story-row')
    @include('partials.product.feel-scale')
    @include('partials.product.tabs')
    @include('partials.product.related')
    @include('partials.product.recently-viewed')
  </main>
</div>

@include('partials.promise-strip')

@endwhile
@endsection
