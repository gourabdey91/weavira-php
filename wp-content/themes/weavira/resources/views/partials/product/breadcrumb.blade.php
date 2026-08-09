<nav class="w-pdp-breadcrumb" aria-label="Breadcrumb">
  <div class="breadcrumb-trail">
    <a href="{{ home_url('/') }}">Home</a>
    @if($breadcrumbCategory)
      <span class="bc-sep" aria-hidden="true">&#8250;</span>
      <a href="{{ get_term_link($breadcrumbCategory) }}">{{ $breadcrumbCategory->name }}</a>
    @endif
    <span class="bc-sep" aria-hidden="true">&#8250;</span>
    <span class="bc-current">{{ $product->get_name() }}</span>
  </div>
</nav>
