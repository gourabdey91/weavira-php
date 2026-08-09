<?php
/**
 * Overrides WooCommerce's myaccount/my-account.php — the two do_action()
 * calls this wraps (woocommerce_account_navigation / _content) still
 * dispatch to the other myaccount/*.php overrides in this folder exactly
 * as WooCommerce's own version does; this file only adds the site's
 * page-shell layout around them. See resources/views/woocommerce/myaccount/layout.blade.php.
 */

defined('ABSPATH') || exit;

echo view('woocommerce.myaccount.layout')->render();
