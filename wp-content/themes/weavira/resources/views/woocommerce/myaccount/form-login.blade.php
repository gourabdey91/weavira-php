{{--
  WooCommerce shows this template standalone for logged-out visitors —
  WC_Shortcode_My_Account::output() returns straight after rendering it,
  never reaching myaccount/my-account.php (see woocommerce/myaccount/my-account.php),
  so unlike every other myaccount/*.blade.php view this one needs its own
  page-shell + breadcrumb rather than getting one from the shared layout.
--}}
@php
  $registrationEnabled = get_option('woocommerce_enable_myaccount_registration') === 'yes';
  $activeTab = (!empty($_POST['register']) || !empty($_GET['action']) && $_GET['action'] === 'register') ? 'register' : 'login';
  $postedUsername = isset($_POST['username']) && is_string($_POST['username']) ? esc_attr(wp_unslash($_POST['username'])) : '';
  $postedFirstName = isset($_POST['first_name']) ? esc_attr(wp_unslash($_POST['first_name'])) : '';
  $postedLastName = isset($_POST['last_name']) ? esc_attr(wp_unslash($_POST['last_name'])) : '';
  // Named billing_phone (not mobile) so it lines up with what SMS Alert's
  // own OTP-verification hooks expect on the register form — see the
  // [sa_verify] shortcode below and woocommerce_registration_errors in
  // app/filters.php.
  $postedMobile = isset($_POST['billing_phone']) ? esc_attr(wp_unslash($_POST['billing_phone'])) : '';
  $postedEmail = isset($_POST['email']) ? esc_attr(wp_unslash($_POST['email'])) : '';
  $loginWithOtpEnabled = function_exists('smsalert_get_option') && smsalert_get_option('login_with_otp', 'smsalert_general') === 'on';
@endphp

<main class="myaccount-page page-shell">

  <nav class="wl-breadcrumb" aria-label="Breadcrumb">
    <a href="{{ home_url('/') }}">Home</a>
    <span aria-hidden="true">&rsaquo;</span>
    <span aria-current="page">My Account</span>
  </nav>

  <?php do_action('woocommerce_before_customer_login_form'); ?>

  <div class="myaccount-auth-shell">

    <div class="myaccount-auth-image" aria-hidden="true">
      <img src="{{ wp_get_attachment_image_url(334, 'large') }}" alt="" loading="lazy">
      <div class="myaccount-auth-image-overlay"></div>
      <div class="myaccount-auth-image-text">
        <span class="myaccount-auth-image-kicker">Weavira</span>
        <p>Woven heritage, timeless stories &mdash; sign in to track your orders, save favourites and check out faster.</p>
      </div>
    </div>

    <div class="myaccount-auth-card">

      @if($registrationEnabled)
        <div class="myaccount-auth-tabs" role="tablist">
          <button type="button" class="myaccount-auth-tab @if($activeTab === 'login') is-active @endif" data-auth-tab="login" role="tab" aria-selected="{{ $activeTab === 'login' ? 'true' : 'false' }}">Login</button>
          <button type="button" class="myaccount-auth-tab @if($activeTab === 'register') is-active @endif" data-auth-tab="register" role="tab" aria-selected="{{ $activeTab === 'register' ? 'true' : 'false' }}">Register</button>
        </div>
      @else
        <h2 class="myaccount-auth-heading">Login</h2>
      @endif

      <div class="myaccount-auth-panel" data-auth-panel="login" @if($registrationEnabled && $activeTab !== 'login') hidden @endif>
        @if($loginWithOtpEnabled)
          {{--
            SMS Alert's own [sa_loginwithotp] shortcode — full mobile number
            + OTP login form (same one used for guest checkout's "Continue
            with Mobile Number" step). Requires "Login With OTP" on in SMS
            Alert settings; matches an existing user by their billing_phone
            meta, so no extra wiring needed on our side.
          --}}
          {!! do_shortcode('[sa_loginwithotp sa_label="Mobile Number" sa_placeholder="Enter mobile number" sa_button="Login with OTP"]') !!}
          <div class="ck-auth-or" aria-hidden="true">OR</div>
        @endif
        <form class="woocommerce-form woocommerce-form-login login myaccount-auth-form" method="post" novalidate>
          <p class="myaccount-auth-field">
            <label for="username"><i data-lucide="user" aria-hidden="true"></i>Username or email address <span class="required" aria-hidden="true">*</span></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="{{ $activeTab === 'login' ? $postedUsername : '' }}" required aria-required="true" />
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
      </div>

      @if($registrationEnabled)
        <div class="myaccount-auth-panel" data-auth-panel="register" @if($activeTab !== 'register') hidden @endif>
          <form method="post" class="woocommerce-form woocommerce-form-register register myaccount-auth-form">
            <div class="myaccount-auth-name-row">
              <p class="myaccount-auth-field">
                <label for="reg_first_name"><i data-lucide="user" aria-hidden="true"></i>First name <span class="required" aria-hidden="true">*</span></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="first_name" id="reg_first_name" autocomplete="given-name" value="{{ $postedFirstName }}" required aria-required="true" />
              </p>
              <p class="myaccount-auth-field">
                <label for="reg_last_name">Last name <span class="required" aria-hidden="true">*</span></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="last_name" id="reg_last_name" autocomplete="family-name" value="{{ $postedLastName }}" required aria-required="true" />
              </p>
            </div>

            @if(get_option('woocommerce_registration_generate_username') === 'no')
              <p class="myaccount-auth-field">
                <label for="reg_username"><i data-lucide="user" aria-hidden="true"></i>Username <span class="required" aria-hidden="true">*</span></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="{{ $activeTab === 'register' ? $postedUsername : '' }}" required aria-required="true" />
              </p>
            @endif

            <p class="myaccount-auth-field">
              <label for="reg_email"><i data-lucide="mail" aria-hidden="true"></i>Email address <span class="required" aria-hidden="true">*</span></label>
              <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="{{ $postedEmail }}" required aria-required="true" />
            </p>

            <p class="myaccount-auth-field">
              <label for="reg_mobile"><i data-lucide="phone" aria-hidden="true"></i>Mobile number <span class="required" aria-hidden="true">*</span></label>
              <input type="tel" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_phone" id="reg_mobile" autocomplete="tel" inputmode="numeric" maxlength="10" pattern="[0-9]{10}" value="{{ $postedMobile }}" required aria-required="true" />
            </p>

            @if(get_option('woocommerce_registration_generate_password') === 'no')
              <p class="myaccount-auth-field">
                <label for="reg_password"><i data-lucide="lock" aria-hidden="true"></i>Password <span class="required" aria-hidden="true">*</span></label>
                <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" required aria-required="true" />
              </p>
            @else
              <p class="myaccount-reg-note">A link to set a new password will be sent to your email address.</p>
            @endif

            <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
            <button type="submit" class="myaccount-save-btn myaccount-save-btn--block" id="reg_submit_btn" name="register" value="Register">Create Account</button>
          </form>
          {{--
            SMS Alert's own shortcode, not a custom integration: it clones
            the button above into a "Verify" step (send OTP → popup code
            entry → re-submits the real button once verified), reading the
            phone number from #reg_mobile. Requires "Buyer Signup OTP" on
            in SMS Alert settings and billing_phone (not mobile) as the
            field name — see woocommerce_registration_errors in
            app/filters.php, which the plugin also relies on.
          --}}
          {!! do_shortcode('[sa_verify phone_selector="#reg_mobile" submit_selector="#reg_submit_btn"]') !!}
        </div>
      @endif

    </div>

  </div>

</main>
