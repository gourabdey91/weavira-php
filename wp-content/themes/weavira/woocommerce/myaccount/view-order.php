<?php
/**
 * WooCommerce passes $order (a WC_Order object) and $order_id here — only
 * $order_id is forwarded; the MyAccount composer fetches and shapes the
 * order data itself (see App\View\Composers\MyAccount), keeping the same
 * "$order is an array the Blade view can just read" shape used by
 * Cart.php/Checkout.php elsewhere in this theme rather than mixing a raw
 * WC_Order object into Blade.
 */

defined('ABSPATH') || exit;

echo view('woocommerce.myaccount.view-order', compact('order_id'))->render();
