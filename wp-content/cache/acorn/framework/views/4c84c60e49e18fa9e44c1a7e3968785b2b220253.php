
<?php
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

      <?php if($registrationEnabled): ?>
        <div class="myaccount-auth-tabs" role="tablist">
          <button type="button" class="myaccount-auth-tab <?php if($activeTab === 'login'): ?> is-active <?php endif; ?>" data-auth-tab="login" role="tab" aria-selected="<?php echo e($activeTab === 'login' ? 'true' : 'false'); ?>">Login</button>
          <button type="button" class="myaccount-auth-tab <?php if($activeTab === 'register'): ?> is-active <?php endif; ?>" data-auth-tab="register" role="tab" aria-selected="<?php echo e($activeTab === 'register' ? 'true' : 'false'); ?>">Register</button>
        </div>
      <?php else: ?>
        <h2 class="myaccount-auth-heading">Login</h2>
      <?php endif; ?>

      <div class="myaccount-auth-panel" data-auth-panel="login" <?php if($registrationEnabled && $activeTab !== 'login'): ?> hidden <?php endif; ?>>
        <?php if($loginWithOtpEnabled): ?>
          
          <?php echo do_shortcode('[sa_loginwithotp sa_label="Mobile Number" sa_placeholder="Enter mobile number" sa_button="Login with OTP"]'); ?>

          <div class="ck-auth-or" aria-hidden="true">OR</div>
        <?php endif; ?>
        <form class="woocommerce-form woocommerce-form-login login myaccount-auth-form" method="post" novalidate>
          <p class="myaccount-auth-field">
            <label for="username"><i data-lucide="user" aria-hidden="true"></i>Username or email address <span class="required" aria-hidden="true">*</span></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo e($activeTab === 'login' ? $postedUsername : ''); ?>" required aria-required="true" />
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
      </div>

      <?php if($registrationEnabled): ?>
        <div class="myaccount-auth-panel" data-auth-panel="register" <?php if($activeTab !== 'register'): ?> hidden <?php endif; ?>>
          <form method="post" class="woocommerce-form woocommerce-form-register register myaccount-auth-form">
            <div class="myaccount-auth-name-row">
              <p class="myaccount-auth-field">
                <label for="reg_first_name"><i data-lucide="user" aria-hidden="true"></i>First name <span class="required" aria-hidden="true">*</span></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="first_name" id="reg_first_name" autocomplete="given-name" value="<?php echo e($postedFirstName); ?>" required aria-required="true" />
              </p>
              <p class="myaccount-auth-field">
                <label for="reg_last_name">Last name <span class="required" aria-hidden="true">*</span></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="last_name" id="reg_last_name" autocomplete="family-name" value="<?php echo e($postedLastName); ?>" required aria-required="true" />
              </p>
            </div>

            <?php if(get_option('woocommerce_registration_generate_username') === 'no'): ?>
              <p class="myaccount-auth-field">
                <label for="reg_username"><i data-lucide="user" aria-hidden="true"></i>Username <span class="required" aria-hidden="true">*</span></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo e($activeTab === 'register' ? $postedUsername : ''); ?>" required aria-required="true" />
              </p>
            <?php endif; ?>

            <p class="myaccount-auth-field">
              <label for="reg_email"><i data-lucide="mail" aria-hidden="true"></i>Email address <span class="required" aria-hidden="true">*</span></label>
              <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo e($postedEmail); ?>" required aria-required="true" />
            </p>

            <p class="myaccount-auth-field">
              <label for="reg_mobile"><i data-lucide="phone" aria-hidden="true"></i>Mobile number <span class="required" aria-hidden="true">*</span></label>
              <input type="tel" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_phone" id="reg_mobile" autocomplete="tel" inputmode="numeric" maxlength="10" pattern="[0-9]{10}" value="<?php echo e($postedMobile); ?>" required aria-required="true" />
            </p>

            <?php if(get_option('woocommerce_registration_generate_password') === 'no'): ?>
              <p class="myaccount-auth-field">
                <label for="reg_password"><i data-lucide="lock" aria-hidden="true"></i>Password <span class="required" aria-hidden="true">*</span></label>
                <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" required aria-required="true" />
              </p>
            <?php else: ?>
              <p class="myaccount-reg-note">A link to set a new password will be sent to your email address.</p>
            <?php endif; ?>

            <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
            <button type="submit" class="myaccount-save-btn myaccount-save-btn--block" id="reg_submit_btn" name="register" value="Register">Create Account</button>
          </form>
          
          <?php echo do_shortcode('[sa_verify phone_selector="#reg_mobile" submit_selector="#reg_submit_btn"]'); ?>

        </div>
      <?php endif; ?>

    </div>

  </div>

</main>
<?php /**PATH C:\Users\Admin\Local Sites\weavira\app\public\wp-content\themes\weavira\resources\views/woocommerce/myaccount/form-login.blade.php ENDPATH**/ ?>