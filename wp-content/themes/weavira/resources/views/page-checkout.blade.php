{{--
  Only ever reached for the Checkout page's WC endpoints (order-received,
  order-pay, add-payment-method) — the main checkout form is intercepted
  earlier by the template_include filter in app/filters.php and rendered by
  checkout.blade.php instead. Those endpoints otherwise fall through to the
  generic page.blade.php, which prints the raw page title ("Order received")
  above WooCommerce's shortcode output with no page-shell/breadcrumb, unlike
  every other page in this theme.
--}}
@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    <main class="page-shell thankyou-page">

      <nav class="wl-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ home_url('/') }}">Home</a>
        <span aria-hidden="true">&rsaquo;</span>
        <span aria-current="page">{{ function_exists('is_order_received_page') && is_order_received_page() ? 'Order Confirmation' : 'Checkout' }}</span>
      </nav>

      @includeFirst(['partials.content-page', 'partials.content'])

    </main>
  @endwhile
@endsection
