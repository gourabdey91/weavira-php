@extends('layouts.app')

@section('content')
<main class="cart-page page-shell">

  <nav class="wl-breadcrumb" aria-label="Breadcrumb">
    <a href="{{ home_url('/') }}">Home</a>
    <span aria-hidden="true">&rsaquo;</span>
    <span aria-current="page">Your Cart</span>
  </nav>

  <div class="cart-page-head">
    <div>
      <h1 class="cart-title">Your Weavira Collection</h1>
      <p class="cart-subtitle">{{ $cartCount }} handwoven {{ $cartCount === 1 ? 'saree' : 'sarees' }} in your cart</p>
    </div>
    <a href="{{ wc_get_page_permalink('shop') }}" class="cart-continue-link">
      <i data-lucide="arrow-left" aria-hidden="true"></i> Continue Exploring
    </a>
  </div>

  @if(empty($cartItems))
    <div class="cart-empty">
      <i data-lucide="shopping-bag" aria-hidden="true"></i>
      <p>Your cart is empty.</p>
      <a href="{{ wc_get_page_permalink('shop') }}" class="cart-continue-link">Browse the collection &rarr;</a>
    </div>
  @else
    <div class="cart-layout">

      <div class="cart-items">
        @foreach($cartItems as $item)
          <div class="cart-item" data-cart-item-key="{{ $item['key'] }}">
            <div class="cart-item-row">
              <div class="cart-item-img-wrap">
                <a href="{{ $item['permalink'] }}">
                  <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="cart-item-img" />
                </a>
              </div>
              <div class="cart-item-body">
                <div class="cart-item-top">
                  <div>
                    <h2 class="cart-item-name"><a href="{{ $item['permalink'] }}">{{ $item['name'] }}</a></h2>
                    @if($item['collection'])
                      <p class="cart-item-collection">{{ $item['collection'] }}</p>
                    @endif
                  </div>
                </div>
                <div class="cart-amount-badges">
                  <div class="cart-price-qty">
                    <div class="cart-amount">
                      <p class="cart-item-unit-price">{!! $item['unitPriceHtml'] !!} <span class="cart-item-unit-suffix">/ item</span></p>
                      <p class="cart-item-price">{!! $item['lineTotalHtml'] !!}</p>
                      @if(wc_tax_enabled())
                        <p class="cart-item-gst">Incl. GST</p>
                      @endif
                    </div>
                    <div class="cart-qty">
                      <button class="cart-qty-btn" type="button" aria-label="Decrease quantity">&#8722;</button>
                      <span class="cart-qty-val">{{ $item['quantity'] }}</span>
                      <button class="cart-qty-btn" type="button" aria-label="Increase quantity">&#43;</button>
                    </div>
                  </div>
                  @if(!empty($item['badges']))
                    <div class="cart-item-badges">
                      @foreach($item['badges'] as $badge)
                        <span class="cart-item-badge">{{ $badge }}</span>
                      @endforeach
                    </div>
                  @endif
                </div>
                <div class="cart-item-footer">
                  <label class="cart-gift-label">
                    <input type="checkbox" class="cart-gift-checkbox" data-gift-checkbox @checked($item['gift'])> This will be a Gift
                  </label>
                  <button class="cart-remove-btn" type="button">Remove</button>
                </div>
              </div>
            </div>
            <div class="wv-gift-fields" data-gift-fields @if(!$item['gift']) hidden @endif>
              <div class="wv-gift-field">
                <label for="wv-gift-for-{{ $loop->index }}">Gift For</label>
                <select id="wv-gift-for-{{ $loop->index }}" class="wv-gift-for">
                  <option value="" @selected(empty($item['gift']['gift_for'])) disabled>Select</option>
                  @foreach(\App\weavira_gift_for_options() as $option)
                    <option value="{{ $option }}" @selected(($item['gift']['gift_for'] ?? '') === $option)>{{ $option }}</option>
                  @endforeach
                </select>
              </div>
              <div class="wv-gift-field">
                <label for="wv-gift-occasion-{{ $loop->index }}">Occasion</label>
                <select id="wv-gift-occasion-{{ $loop->index }}" class="wv-gift-occasion">
                  <option value="" @selected(empty($item['gift']['occasion'])) disabled>Select</option>
                  @foreach(\App\weavira_gift_occasion_options() as $option)
                    <option value="{{ $option }}" @selected(($item['gift']['occasion'] ?? '') === $option)>{{ $option }}</option>
                  @endforeach
                </select>
              </div>
              <div class="wv-gift-field wv-gift-field--full">
                <label for="wv-gift-recipient-{{ $loop->index }}">Gift Recipient Name</label>
                <input type="text" id="wv-gift-recipient-{{ $loop->index }}" class="wv-gift-recipient" value="{{ $item['gift']['recipient_name'] ?? '' }}" placeholder="Enter recipient&rsquo;s name" maxlength="80" />
              </div>
              <p class="wv-gift-disclaimer">This data is collected only for Customized Packaging.</p>
              <p class="cart-gift-status" aria-live="polite"></p>
            </div>
          </div>
        @endforeach
      </div><!-- /cart-items -->

      <aside class="cart-summary">
        <h2 class="cart-summary-title">Order Summary</h2>
        <div class="cart-summary-rows">
          <div class="cart-summary-row">
            <span>Subtotal</span>
            <span class="cart-summary-subtotal">{!! $subtotal !!}</span>
          </div>
          <div class="cart-summary-row">
            <span>Shipping</span>
            <span class="cart-summary-shipping @if($isFreeShipping) cart-summary-free @endif">{{ $shippingLabel ?: 'Calculated at checkout' }}</span>
          </div>
          <div class="cart-summary-taxes">
            @foreach($taxRows as $tax)
              <div class="cart-summary-row">
                <span>{{ $tax['label'] }} (Included)</span>
                <span>{!! $tax['amount'] !!}</span>
              </div>
            @endforeach
          </div>
        </div>
        <div class="cart-summary-total">
          <span>Total</span>
          <span class="cart-summary-total-price">{!! $total !!}</span>
        </div>
        @if(wc_tax_enabled())
          <p class="cart-summary-note">Prices are inclusive of GST. A tax invoice will be provided after purchase.</p>
        @endif
        <a href="{{ wc_get_checkout_url() }}" class="cart-checkout-btn">
          <i data-lucide="lock" aria-hidden="true"></i>
          Proceed to Secure Checkout
        </a>
      </aside>

    </div><!-- /cart-layout -->
  @endif

  @php $packagingImage = get_field('cart_packaging_image', 'option'); @endphp
  <section class="cart-packaging" aria-label="Signature Packaging">
    <div class="cart-packaging-left">
      @if($packagingImage)
        <img src="{{ $packagingImage }}" alt="Weavira signature gift box" class="cart-packaging-img" loading="lazy">
      @endif
      <div class="cart-packaging-content">
        <h2 class="cart-packaging-title">Signature Packaging</h2>
        <p class="cart-packaging-desc">Every Weavira saree is wrapped in our signature presentation, making it ready for gifting or preserving as a keepsake.</p>
      </div>
    </div>
    <ul class="cart-packaging-features" aria-label="Packaging features">
      <li class="cart-packaging-feature">
        <i data-lucide="package" aria-hidden="true"></i>
        <span>Complementary Name on Box</span>
      </li>
      <li class="cart-packaging-feature">
        <i data-lucide="shield" aria-hidden="true"></i>
        <span>Custom Message</span>
      </li>
      <li class="cart-packaging-feature">
        <i data-lucide="mail" aria-hidden="true"></i>
        <span>Thank-you card</span>
      </li>
      <li class="cart-packaging-feature">
        <i data-lucide="gift" aria-hidden="true"></i>
        <span>Complimentary gift wrapping</span>
      </li>
    </ul>
  </section>

  <div class="cart-promise-strip">
    <img src="{{ get_field('arc_option_logo', 'option') }}" alt="Weavira" class="cart-promise-img" loading="lazy">
    <div>
      <h2 class="cart-promise-title">Weavira Promise</h2>
      <p class="cart-promise-desc">Every saree is hand-inspected before dispatch, carefully folded to preserve the weave, and packed in our signature presentation. An official GST invoice is included with every order.</p>
    </div>
    <div class="cart-help">
      <div>
        <p class="cart-help-title">Need Help?</p>
        <p class="cart-help-sub">We&rsquo;re here to assist you with your selection or order.</p>
      </div>
      <div class="cart-help-actions">
        @php $whatsapp = get_field('gifting_whatsapp_link', 'option'); @endphp
        <a href="{{ $whatsapp['url'] ?? '#' }}" class="cart-help-action" aria-label="WhatsApp Us">
          <span class="cart-help-icon"><i data-lucide="message-circle" aria-hidden="true"></i></span>
          <span>WhatsApp</span>
        </a>
        <a href="mailto:hello@weavira.com" class="cart-help-action" aria-label="Email Us">
          <span class="cart-help-icon"><i data-lucide="mail" aria-hidden="true"></i></span>
          <span>Email</span>
        </a>
        <a href="tel:+919123456789" class="cart-help-action" aria-label="Call Us">
          <span class="cart-help-icon"><i data-lucide="headphones" aria-hidden="true"></i></span>
          <span>Call</span>
        </a>
      </div>
    </div>
  </div>

  @if(!empty($recommendations))
    <section class="cart-recs" aria-label="You May Also Love">
      <div class="cart-recs-head">
        <h2 class="cart-recs-title">You May Also Love</h2>
        <a href="{{ wc_get_page_permalink('shop') }}" class="cart-recs-viewall">View all &#8594;</a>
      </div>
      <div class="carousel-stage">
        <button class="carousel-arrow carousel-arrow-prev cart-recs-prev" aria-label="Previous">
          <i data-lucide="chevron-left" aria-hidden="true"></i>
        </button>
        <div class="loom-track" id="cart-recs-carousel">
          @foreach($recommendations as $recProduct)
            @include('components.product-card', ['product' => $recProduct])
          @endforeach
        </div>
        <button class="carousel-arrow carousel-arrow-next cart-recs-next" aria-label="Next">
          <i data-lucide="chevron-right" aria-hidden="true"></i>
        </button>
      </div>
      <div class="cart-recs-dots" role="tablist" aria-label="Carousel navigation"></div>
    </section>
  @endif

  <div class="cart-trust-bar" role="list">
    <div class="cart-trust-bar-item" role="listitem">Handwoven in Odisha</div>
    <div class="cart-trust-bar-item" role="listitem">Secure Payment</div>
    <div class="cart-trust-bar-item" role="listitem">Free Shipping</div>
    <div class="cart-trust-bar-item" role="listitem">Easy Returns</div>
  </div>

</main>
@endsection
