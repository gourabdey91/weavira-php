@if(empty($order))
  <div class="myaccount-empty-state">
    <i data-lucide="alert-circle" aria-hidden="true"></i>
    <p>This order could not be found.</p>
    <a href="{{ wc_get_endpoint_url('orders') }}" class="myaccount-empty-cta">Back to Orders</a>
  </div>
@else
  <p class="myaccount-order-intro">
    Order <mark class="myaccount-order-number">#{{ $order['number'] }}</mark> was placed on <mark>{{ $order['date'] }}</mark> and is currently <mark class="myaccount-order-status myaccount-order-status--{{ $order['statusSlug'] }}">{{ $order['status'] }}</mark>.
  </p>

  <div class="ck-order-items myaccount-view-order-items">
    @foreach($order['items'] as $item)
      <div class="ck-order-item">
        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="ck-order-img" loading="lazy" />
        <div class="ck-order-info">
          <p class="ck-order-name">{{ $item['name'] }}</p>
          <p class="ck-order-meta">Qty: {{ $item['quantity'] }}</p>
        </div>
        <span class="ck-order-price">{!! $item['lineTotalHtml'] !!}</span>
      </div>
    @endforeach
  </div>

  <div class="ck-summary-rows myaccount-view-order-totals">
    <div class="ck-summary-row">
      <span>Subtotal</span>
      <span>{!! $order['subtotal'] !!}</span>
    </div>
    <div class="ck-summary-row">
      <span>Shipping</span>
      <span>{!! $order['shippingTotal'] !!}</span>
    </div>
    @foreach($order['taxRows'] as $tax)
      <div class="ck-summary-row">
        <span>{{ $tax['label'] }}</span>
        <span>{!! $tax['amount'] !!}</span>
      </div>
    @endforeach
    <div class="ck-summary-row myaccount-view-order-payment">
      <span>Payment Method</span>
      <span>{{ $order['paymentMethod'] }}</span>
    </div>
  </div>
  <div class="ck-summary-total myaccount-view-order-total">
    <span class="ck-total-label">Total</span>
    <span class="ck-total-price">{!! $order['total'] !!}</span>
  </div>

  <div class="myaccount-order-address">
    <h2>Billing Address</h2>
    <address>{!! $order['billingAddress'] !!}</address>
  </div>

  @if(!empty($order['notes']))
    <div class="myaccount-order-notes">
      <h2>Order Updates</h2>
      <ol>
        @foreach($order['notes'] as $note)
          <li>
            <p class="myaccount-order-note-meta">{{ $note['date'] }}</p>
            <div class="myaccount-order-note-body">{!! $note['content'] !!}</div>
          </li>
        @endforeach
      </ol>
    </div>
  @endif
@endif
