<?php
/**
 * $user is provided by WC_Shortcode_My_Account::edit_account() — see
 * includes/shortcodes/class-wc-shortcode-my-account.php.
 */

defined('ABSPATH') || exit;

echo view('woocommerce.myaccount.edit-account', compact('user'))->render();
