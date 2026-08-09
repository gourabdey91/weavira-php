<?php
/**
 * $current_user is provided by WooCommerce's woocommerce_account_dashboard()
 * dispatch — see wc-template-functions.php.
 */

defined('ABSPATH') || exit;

echo view('woocommerce.myaccount.dashboard', compact('current_user'))->render();
