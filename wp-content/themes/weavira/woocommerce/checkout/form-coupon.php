<?php

defined('ABSPATH') || exit;

if (!wc_coupons_enabled()) {
    return;
}

echo view('woocommerce.checkout.form-coupon')->render();
