{{--
  WooCommerce shows this template standalone for logged-out visitors —
  WC_Shortcode_My_Account::output() returns straight after rendering it,
  never reaching myaccount/my-account.php (see woocommerce/myaccount/my-account.php),
  so unlike every other myaccount/*.blade.php view this one needs its own
  page-shell + breadcrumb rather than getting one from the shared layout.
--}}
@php
  $postedUsername = isset($_POST['username']) && is_string($_POST['username']) ? esc_attr(wp_unslash($_POST['username'])) : '';
  // The unified form below renders [sa_signupwithmobile], not
  // [sa_loginwithotp] — the option that actually gates that shortcode's
  // output is "Signup With Mobile", not "Login With OTP".
  $signupWithMobileEnabled = function_exists('smsalert_get_option') && smsalert_get_option('signup_with_mobile', 'smsalert_general') === 'on';
  // Editable from the My Account page in wp-admin (see acf-json/group_myaccount_login_images.json),
  // same pattern as the Home page's own image fields. Falls back to the
  // original hardcoded photo (attachment 334) until someone uploads one.
  $defaultLoginImage = wp_get_attachment_image_url(334, 'large');
  $loginImageDesktop = get_field('myaccount_login_image_desktop') ?: $defaultLoginImage;
  $loginImageMobile = get_field('myaccount_login_image_mobile') ?: $defaultLoginImage;
@endphp

<main class="myaccount-page myaccount-login-page page-shell">

  <nav class="wl-breadcrumb" aria-label="Breadcrumb">
    <a href="{{ home_url('/') }}">Home</a>
    <span aria-hidden="true">&rsaquo;</span>
    <span aria-current="page">My Account</span>
  </nav>

  <?php do_action('woocommerce_before_customer_login_form'); ?>

  <div class="myaccount-auth-shell">

    <div class="myaccount-auth-image" aria-hidden="true">
      <picture>
        <source media="(min-width: 769px)" srcset="{{ $loginImageDesktop }}">
        <img src="{{ $loginImageMobile }}" alt="" loading="lazy">
      </picture>
      <div class="myaccount-auth-image-overlay"></div>
      <div class="myaccount-auth-image-text">
        <span class="myaccount-auth-image-kicker">Weavira</span>
        <h2 class="myaccount-auth-image-heading">Woven heritage.<br>Timeless stories.</h2>
        <p class="myaccount-auth-image-tagline">People &bull; Places &bull; Craft &bull; You</p>
      </div>
    </div>

    <div class="myaccount-auth-card">

      @if($signupWithMobileEnabled)
        {{--
          One unified form instead of separate Login/Register tabs, same
          shortcode as checkout Step 1: [sa_signupwithmobile], NOT
          [sa_loginwithotp] (that one is login-only — it rejects any
          number without an existing account, it never creates one). This
          embeds its own [sa_verify] internally. On OTP verification, SMS
          Alert matches the mobile number against an existing user's
          billing_phone meta and logs them in, or creates a minimal new
          account (phone only) and logs that in — see app/filters.php for
          the fix to its billing_phone-persistence bug this relies on.
        --}}
        <div class="myaccount-auth-welcome">
          <span class="myaccount-auth-welcome-kicker">Welcome to</span>
          <h1 class="myaccount-auth-welcome-heading">Weavira</h1>
          <p class="myaccount-auth-welcome-sub">Your journey through India&rsquo;s woven heritage begins here.</p>
        </div>

        <div class="ck-auth-grid">

          <div class="ck-auth-col">
            <div class="ck-phone-row">
              {!! do_shortcode('[sa_loginwithotp sa_label="Mobile Number" sa_placeholder="Enter your mobile number" sa_button="Continue"]') !!}
              {!! do_shortcode('[sa_verify phone_selector="#phone" submit_selector=".btn"]') !!}</div>
          </div>

          <div class="ck-auth-or" aria-hidden="true">OR</div>

          <div class="ck-social-col">
            {{-- Nextend Social Login's own shortcode — already integrated
                 and functional (do not replace with a custom button); only
                 restyled via .nsl-* CSS overrides to match this layout. --}}
            {!! do_shortcode('[nextend_social_login]') !!}
            <button class="ck-social-btn" type="button" disabled title="Coming soon">
              <svg class="ck-social-icon" viewBox="0 0 24 24" fill="currentColor" aria-label="Apple" role="img">
                <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
              </svg>
              Continue with Apple
            </button>
          </div>

        </div><!-- /ck-auth-grid -->

        <p class="myaccount-auth-legal">
          <i data-lucide="shield-check" aria-hidden="true"></i>
          By continuing, you agree to Weavira&rsquo;s
          <a href="#">Terms of Service</a>
          and
          <a href="{{ get_privacy_policy_url() ?: '#' }}">Privacy Policy</a>.
        </p>
      @else
        {{-- Fallback when SMS Alert's "Login With OTP" setting is off —
             still a single form, just username/password instead of OTP. --}}
        <h2 class="myaccount-auth-heading">Login</h2>
        <form class="woocommerce-form woocommerce-form-login login myaccount-auth-form" method="post" novalidate>
          <p class="myaccount-auth-field">
            <label for="username"><i data-lucide="user" aria-hidden="true"></i>Username or email address <span class="required" aria-hidden="true">*</span></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="{{ $postedUsername }}" required aria-required="true" />
          </p>
          <p class="myaccount-auth-field">
            <label for="password"><i data-lucide="lock" aria-hidden="true"></i>Password <span class="required" aria-hidden="true">*</span></label>
            <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" required aria-required="true" />
          </p>

          <p class="myaccount-login-actions">
            <label class="myaccount-remember">
              <input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span>Remember me</span>
            </label>
            <a href="{{ wp_lostpassword_url() }}" class="myaccount-lost-password">Lost your password?</a>
          </p>
          <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
          <button type="submit" class="myaccount-save-btn myaccount-save-btn--block" name="login" value="Log in">Log In</button>
        </form>
      @endif

    </div>

  </div>

</main>
