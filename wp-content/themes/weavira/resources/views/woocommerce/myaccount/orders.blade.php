@if(!empty($orders))
  <div class="myaccount-orders-list">
    @foreach($orders as $order)
      <div class="myaccount-order-card">
        <div class="myaccount-order-card-head">
          <div>
            <span class="myaccount-order-number">Order #{{ $order['number'] }}</span>
            <span class="myaccount-order-date">{{ $order['date'] }}</span>
          </div>
          <span class="myaccount-order-status myaccount-order-status--{{ $order['statusSlug'] }}">{{ $order['status'] }}</span>
        </div>
        <div class="myaccount-order-card-body">
          <span>{{ $order['itemCount'] }} item{{ $order['itemCount'] === 1 ? '' : 's' }}</span>
          <span class="myaccount-order-total">{!! $order['total'] !!}</span>
        </div>
        <div class="myaccount-order-card-actions">
          @foreach($order['actions'] as $action)
            <a href="{{ $action['url'] }}" class="myaccount-order-action @if($action['key'] === 'view') myaccount-order-action--primary @endif">{{ $action['name'] }}</a>
          @endforeach
        </div>
      </div>
    @endforeach
  </div>

  @if($maxPages > 1)
    <div class="myaccount-orders-pagination">
      @if($currentPage > 1)
        <a href="{{ wc_get_endpoint_url('orders', $currentPage - 1) }}" class="myaccount-orders-page-link">&larr; Previous</a>
      @endif
      @if($currentPage < $maxPages)
        <a href="{{ wc_get_endpoint_url('orders', $currentPage + 1) }}" class="myaccount-orders-page-link">Next &rarr;</a>
      @endif
    </div>
  @endif
@else
  <div class="myaccount-empty-state">
    <i data-lucide="package" aria-hidden="true"></i>
    <p>You haven&rsquo;t placed any orders yet.</p>
    <a href="{{ wc_get_page_permalink('shop') }}" class="myaccount-empty-cta">Start Shopping &#8594;</a>
  </div>
@endif
