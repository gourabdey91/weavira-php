<?php
/**
 * $current_page, $customer_orders, $has_orders provided by
 * woocommerce_account_orders() — see wc-template-functions.php.
 */

defined('ABSPATH') || exit;

echo view('woocommerce.myaccount.orders', compact('current_page', 'customer_orders', 'has_orders'))->render();
