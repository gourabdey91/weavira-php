
<?php
  $postedUsername = isset($_POST['username']) && is_string($_POST['username']) ? esc_attr(wp_unslash($_POST['username'])) : '';
  $loginWithOtpEnabled = function_exists('smsalert_get_option') && smsalert_get_option('login_with_otp', 'smsalert_general') === 'on';
?>

<main class="myaccount-page page-shell">

  <nav class="wl-breadcrumb" aria-label="Breadcrumb">
    <a href="<?php echo e(home_url('/')); ?>">Home</a>
    <span aria-hidden="true">&rsaquo;</span>
    <span aria-current="page">My Account</span>
  </nav>

  <?php do_action('woocommerce_before_customer_login_form'); ?>

  <div class="myaccount-auth-shell">

    <div class="myaccount-auth-image" aria-hidden="true">
      <img src="<?php echo e(wp_get_attachment_image_url(334, 'large')); ?>" alt="" loading="lazy">
      <div class="myaccount-auth-image-overlay"></div>
      <div class="myaccount-auth-image-text">
        <span class="myaccount-auth-image-kicker">Weavira</span>
        <p>Woven heritage, timeless stories &mdash; sign in to track your orders, save favourites and check out faster.</p>
      </div>
    </div>

    <div class="myaccount-auth-card">

      <?php if($loginWithOtpEnabled): ?>
        
        <div class="ck-panel-head">
          <div class="ck-panel-text">
            <h1 class="ck-panel-title">Log in or Sign Up</h1>
            <p class="ck-panel-sub">Quick, secure, and password-free.</p>
          </div>
        </div>

        <div class="ck-auth-grid">

          <div class="ck-auth-col">
            <div class="ck-phone-row">
              <?php echo do_shortcode('[sa_loginwithotp sa_label="Mobile Number" sa_placeholder="Enter mobile number"]'); ?>

              <?php echo do_shortcode('[sa_verify phone_selector="#phone" submit_selector=".btn"]'); ?>

            </div>
          </div>

          <div class="ck-auth-or" aria-hidden="true">OR</div>

          <div class="ck-social-col" style="align-items: center;">
            <!--<button class="ck-social-btn" type="button" disabled title="Coming soon">-->
            <!--  <svg class="ck-social-icon" viewBox="0 0 24 24" aria-label="Google" role="img">-->
            <!--    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>-->
            <!--    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>-->
            <!--    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/>-->
            <!--    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>-->
            <!--  </svg>-->
            <!--  Continue with Google-->
            <!--</button>-->
            <?php echo do_shortcode('[nextend_social_login]'); ?>

            <button class="ck-social-btn" type="button" disabled title="Coming soon">
              <svg class="ck-social-icon" viewBox="0 0 24 24" fill="currentColor" aria-label="Apple" role="img">
                <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
              </svg>
              Continue with Apple
            </button>
          </div>

        </div><!-- /ck-auth-grid -->

        <p class="ck-panel-trust">
          <i data-lucide="shield-check" aria-hidden="true"></i>
          Secure sign-in <span class="ck-panel-trust-dot" aria-hidden="true">&bull;</span> Your information is protected
        </p>
      <?php else: ?>
        
        <h2 class="myaccount-auth-heading">Login</h2>
        <form class="woocommerce-form woocommerce-form-login login myaccount-auth-form" method="post" novalidate>
          <p class="myaccount-auth-field">
            <label for="username"><i data-lucide="user" aria-hidden="true"></i>Username or email address <span class="required" aria-hidden="true">*</span></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo e($postedUsername); ?>" required aria-required="true" />
          </p>
          <p class="myaccount-auth-field">
            <label for="password"><i data-lucide="lock" aria-hidden="true"></i>Password <span class="required" aria-hidden="true">*</span></label>
            <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" required aria-required="true" />
          </p>

          <p class="myaccount-login-actions">
            <label class="myaccount-remember">
              <input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span>Remember me</span>
            </label>
            <a href="<?php echo e(wp_lostpassword_url()); ?>" class="myaccount-lost-password">Lost your password?</a>
          </p>
          <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
          <button type="submit" class="myaccount-save-btn myaccount-save-btn--block" name="login" value="Log in">Log In</button>
        </form>
      <?php endif; ?>

    </div>

  </div>

</main>
<?php /**PATH C:\Users\Admin\Local Sites\weavira\app\public\wp-content\themes\weavira\resources\views/woocommerce/myaccount/form-login.blade.php ENDPATH**/ ?>