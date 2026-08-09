{{-- <a class="sr-only focus:not-sr-only" href="#main">
  {{ __('Skip to content') }}
</a> --}}
@include('sections.header')

<main id="main">
    @yield('content')
</main>

@hasSection('sidebar')
    <aside class="sidebar">
        @yield('sidebar')
    </aside>
@endif

@include('sections.footer')
@include('partials.search-overlay')
@include('partials.cart-toast')
