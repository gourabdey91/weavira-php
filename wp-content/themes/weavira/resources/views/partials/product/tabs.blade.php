@php
  $washCare = get_field('wash_care', $product->get_id());
  $reviewsEnabled = wc_reviews_enabled() && $product->get_reviews_allowed();
@endphp

<section class="product-tabs">

  @if(!empty($specs))
    <div class="tab-item">
      <button class="tab-header" aria-expanded="false">
        <span class="tab-icon"><svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><rect x="3" y="3" width="14" height="14" rx="1"/><line x1="3" y1="8" x2="17" y2="8"/><line x1="8" y1="8" x2="8" y2="17"/></svg></span>
        <span class="tab-label">SPECIFICATIONS</span>
        <span class="tab-sub">Size, material &amp; details</span>
        <span class="tab-toggle" aria-hidden="true">+</span>
      </button>
      <div class="tab-body">
        <div class="spec-grid">
          @foreach($specs as $row)
            <span class="spec-label">{{ $row['label'] }}</span>
            <span class="spec-value">{{ $row['value'] }} @if(!empty($row['note']))<span class="spec-note">({{ $row['note'] }})</span>@endif</span>
          @endforeach
        </div>
      </div>
    </div>
  @endif

  @if($washCare)
    <div class="tab-item">
      <button class="tab-header" aria-expanded="false">
        <span class="tab-icon"><svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><path d="M4 4h12v9a6 6 0 0 1-12 0V4z"/></svg></span>
        <span class="tab-label">CARE GUIDE</span>
        <span class="tab-sub">How to preserve your saree</span>
        <span class="tab-toggle" aria-hidden="true">+</span>
      </button>
      <div class="tab-body">
        <p>{{ $washCare }}</p>
      </div>
    </div>
  @endif

  @if($reviewsEnabled)
    <div class="tab-item">
      <button class="tab-header" aria-expanded="false">
        <span class="tab-icon"><svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><path d="M10 2l2.4 5 5.6.8-4 3.9.9 5.5L10 14.8l-4.9 2.4.9-5.5L2 7.8l5.6-.8z"/></svg></span>
        <span class="tab-label">REVIEWS <span class="tab-count">({{ $product->get_review_count() }})</span></span>
        <span class="tab-sub">What our customers say</span>
        <span class="tab-toggle" aria-hidden="true">+</span>
      </button>
      <div class="tab-body">
        {{--
          Real WooCommerce reviews (ratings, verified-owner labels, review form).
          Must go through WordPress's own comments_template() — not wc_get_template()
          directly — since that's what populates $wp_query->comments (have_comments()
          returns false otherwise) and it's what WooCommerce's own comments_template
          filter hooks into to swap in single-product-reviews.php.
        --}}
        @php comments_template(); @endphp
      </div>
    </div>
  @endif

</section>
