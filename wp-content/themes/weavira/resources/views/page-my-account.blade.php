{{--
  Matches WordPress's page-{slug}.blade.php template hierarchy for the
  "My account" page specifically — skips the generic partials.page-header
  include used by page.blade.php, since woocommerce/myaccount/layout.blade.php
  (rendered inside the_content() below via the [woocommerce_my_account]
  shortcode) already renders its own styled breadcrumb + title.
--}}
@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    @includeFirst(['partials.content-page', 'partials.content'])
  @endwhile
@endsection
