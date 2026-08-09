<?php
/**
 * $load_address ('' | 'billing' | 'shipping') and $address (WC's prepared
 * field definitions, ready for woocommerce_form_field()) are provided by
 * WC_Shortcode_My_Account::edit_address() — see
 * includes/shortcodes/class-wc-shortcode-my-account.php. When $load_address
 * is empty this is really the Addresses list view (WooCommerce's own
 * form-edit-address.php falls back to myaccount/my-address.php in that
 * case) — resources/views/woocommerce/myaccount/edit-address.blade.php
 * mirrors that same branch instead of needing a separate override file.
 */

defined('ABSPATH') || exit;

echo view('woocommerce.myaccount.edit-address', compact('load_address', 'address'))->render();
