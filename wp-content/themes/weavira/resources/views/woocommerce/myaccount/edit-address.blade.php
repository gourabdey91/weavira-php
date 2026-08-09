@if(!$load_address)
  @include('woocommerce.myaccount.addresses')
@else
  <form method="post" novalidate class="myaccount-address-form">
    <h2>
      @if($load_address === 'shipping')
        {{ !empty($addressId) ? 'Edit shipping address' : 'Add shipping address' }}
      @else
        {{ !empty($addressId) ? 'Edit billing address' : 'Add billing address' }}
      @endif
    </h2>

    {{--
      Named address book entry (Home / Office / ..., or a GSTIN-labelled
      billing identity) layered on top of WooCommerce's own single
      shipping_*/billing_* address — see weavira_save_shipping_address() /
      weavira_save_billing_address() in app/filters.php, which this form's
      custom action posts to instead of WooCommerce's own edit_address
      handler.
    --}}
    <div class="ck-field-grid myaccount-field-grid">
      <p class="form-row form-row-wide">
        <label for="wv_address_label">Label <span class="required" aria-hidden="true">*</span></label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="wv_address_label" id="wv_address_label" placeholder="{{ $load_address === 'shipping' ? 'e.g. Home, Office' : 'e.g. Head Office, Warehouse GST' }}" maxlength="40" value="{{ wc_get_post_data_by_key('wv_address_label', $addressLabel ?? '') }}" required aria-required="true" />
      </p>

      @if($load_address === 'billing')
        <p class="form-row form-row-wide">
          <label for="wv_gst_number">GST Number <span class="required" aria-hidden="true">*</span></label>
          <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="wv_gst_number" id="wv_gst_number" maxlength="15" placeholder="e.g. 22AAAAA0000A1Z5" value="{{ wc_get_post_data_by_key('wv_gst_number', $addressGstin ?? '') }}" required aria-required="true" />
        </p>
      @endif
    </div>

    <div class="ck-field-grid myaccount-field-grid">
      @foreach($address as $key => $field)
        <?php woocommerce_form_field($key, $field, wc_get_post_data_by_key($key, $field['value'])); ?>
      @endforeach
    </div>

    <button type="submit" class="myaccount-save-btn" name="save_address" value="Save address">Save Address</button>

    @if($load_address === 'shipping')
      <?php wp_nonce_field('wv_save_shipping_address', 'wv_shipping_address_nonce'); ?>
      <input type="hidden" name="action" value="wv_save_shipping_address" />
      <input type="hidden" name="address_id" value="{{ $addressId ?? '' }}" />
    @else
      <?php wp_nonce_field('wv_save_billing_address', 'wv_billing_address_nonce'); ?>
      <input type="hidden" name="action" value="wv_save_billing_address" />
      <input type="hidden" name="address_id" value="{{ $addressId ?? '' }}" />
    @endif
  </form>
@endif
