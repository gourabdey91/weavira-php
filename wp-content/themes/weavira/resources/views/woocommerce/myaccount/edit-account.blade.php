<form class="woocommerce-EditAccountForm edit-account myaccount-account-form" action="" method="post">

  <div class="ck-field-grid myaccount-field-grid">
    <p class="form-row form-row-first">
      <label for="account_first_name">First name <span class="required" aria-hidden="true">*</span></label>
      <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="{{ esc_attr($user->first_name) }}" />
    </p>
    <p class="form-row form-row-last">
      <label for="account_last_name">Last name <span class="required" aria-hidden="true">*</span></label>
      <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="{{ esc_attr($user->last_name) }}" />
    </p>
    <p class="form-row form-row-wide">
      <label for="account_display_name">Display name <span class="required" aria-hidden="true">*</span></label>
      <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" value="{{ esc_attr($user->display_name) }}" />
      <span class="myaccount-field-note">This will be how your name is displayed in the account section and in reviews</span>
    </p>
    <p class="form-row form-row-wide">
      <label for="account_email">Email address <span class="required" aria-hidden="true">*</span></label>
      <input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" autocomplete="email" value="{{ esc_attr($user->user_email) }}" />
    </p>
  </div>

  <fieldset class="myaccount-password-fieldset">
    <legend>Password Change</legend>
    <div class="ck-field-grid myaccount-field-grid">
      <p class="form-row form-row-wide">
        <label for="password_current">Current password (leave blank to leave unchanged)</label>
        <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" autocomplete="current-password" />
      </p>
      <p class="form-row form-row-wide">
        <label for="password_1">New password (leave blank to leave unchanged)</label>
        <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" autocomplete="new-password" />
      </p>
      <p class="form-row form-row-wide">
        <label for="password_2">Confirm new password</label>
        <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" autocomplete="new-password" />
      </p>
    </div>
  </fieldset>

  <?php wp_nonce_field('save_account_details', 'save-account-details-nonce'); ?>
  <button type="submit" class="myaccount-save-btn" name="save_account_details" value="Save changes">Save Changes</button>
  <input type="hidden" name="action" value="save_account_details" />

</form>
