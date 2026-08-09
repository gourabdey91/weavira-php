<p class="myaccount-addresses-intro">The following addresses will be used on the checkout page by default.</p>

@if($addresses['showShipping'])
  <div class="myaccount-shipping-book">
    <div class="myaccount-shipping-book-head">
      <h2 class="myaccount-shipping-book-title">Shipping Addresses</h2>
      <a href="{{ $addresses['addShippingUrl'] }}" class="myaccount-address-edit">+ Add new address</a>
    </div>

    @if(empty($addresses['shippingAddresses']))
      <p class="myaccount-address-empty">You have not saved any shipping addresses yet &mdash; add a Home, Office, or any other address for faster checkout.</p>
    @else
      <div class="myaccount-addresses myaccount-addresses--two-col">
        @foreach($addresses['shippingAddresses'] as $address)
          <div class="myaccount-address-card">
            <div class="myaccount-address-card-head">
              <h2>
                {{ $address['label'] }}
                @if($address['isDefault'])
                  <span class="myaccount-address-default-badge">Default</span>
                @endif
              </h2>
              <a href="{{ $address['editUrl'] }}" class="myaccount-address-edit">Edit</a>
            </div>
            <address>{!! $address['formatted'] !!}</address>
            <div class="myaccount-address-actions">
              @unless($address['isDefault'])
                <form method="post">
                  <?php wp_nonce_field('wv_set_default_shipping_address_' . $address['id'], 'wv_shipping_address_nonce'); ?>
                  <input type="hidden" name="action" value="wv_set_default_shipping_address" />
                  <input type="hidden" name="address_id" value="{{ $address['id'] }}" />
                  <button type="submit" class="myaccount-address-set-default">Set as default</button>
                </form>
              @endunless
              <form method="post" class="myaccount-address-delete-form">
                <?php wp_nonce_field('wv_delete_shipping_address_' . $address['id'], 'wv_shipping_address_nonce'); ?>
                <input type="hidden" name="action" value="wv_delete_shipping_address" />
                <input type="hidden" name="address_id" value="{{ $address['id'] }}" />
                <button type="submit" class="myaccount-address-delete">Delete</button>
              </form>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
@endif

<div class="myaccount-shipping-book">
  <div class="myaccount-shipping-book-head">
    <h2 class="myaccount-shipping-book-title">Billing Addresses</h2>
    <a href="{{ $addresses['addBillingUrl'] }}" class="myaccount-address-edit">+ Add new address</a>
  </div>

  @if(empty($addresses['billingAddresses']))
    <p class="myaccount-address-empty">You have not saved any billing addresses yet &mdash; add one if you need GST invoices addressed to a registered business.</p>
  @else
    <div class="myaccount-addresses myaccount-addresses--two-col">
      @foreach($addresses['billingAddresses'] as $address)
        <div class="myaccount-address-card">
          <div class="myaccount-address-card-head">
            <h2>
              {{ $address['label'] }}
              @if($address['isDefault'])
                <span class="myaccount-address-default-badge">Default</span>
              @endif
            </h2>
            <a href="{{ $address['editUrl'] }}" class="myaccount-address-edit">Edit</a>
          </div>
          <address>
            {!! $address['formatted'] !!}
            @if($address['gstin'])
              <br />GSTIN: {{ $address['gstin'] }}
            @endif
          </address>
          <div class="myaccount-address-actions">
            @unless($address['isDefault'])
              <form method="post">
                <?php wp_nonce_field('wv_set_default_billing_address_' . $address['id'], 'wv_billing_address_nonce'); ?>
                <input type="hidden" name="action" value="wv_set_default_billing_address" />
                <input type="hidden" name="address_id" value="{{ $address['id'] }}" />
                <button type="submit" class="myaccount-address-set-default">Set as default</button>
              </form>
            @endunless
            <form method="post" class="myaccount-address-delete-form">
              <?php wp_nonce_field('wv_delete_billing_address_' . $address['id'], 'wv_billing_address_nonce'); ?>
              <input type="hidden" name="action" value="wv_delete_billing_address" />
              <input type="hidden" name="address_id" value="{{ $address['id'] }}" />
              <button type="submit" class="myaccount-address-delete">Delete</button>
            </form>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</div>
