<?php

namespace App\View\Composers;

class Checkout extends Cart
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'woocommerce.checkout',
    ];

    /**
     * Same order data as the cart page (items, totals, tax rows), plus the
     * subset of items marked as a gift — driving the "Gift Details" step.
     *
     * @return array
     */
    public function with()
    {
        $data = parent::with();

        $data['giftItems'] = array_values(array_filter($data['cartItems'], function ($item) {
            return !empty($item['gift']);
        }));

        // Address book (Home / Office / ...) for the Delivery Address
        // panel's "Use a saved address" picker — see
        // \App\weavira_get_shipping_addresses() in app/filters.php and the
        // matching JS autofill in weavira.js.
        $data['savedShippingAddresses'] = is_user_logged_in()
            ? \App\weavira_get_shipping_addresses(get_current_user_id())
            : [];

        // Same, but for the GST/billing address book — see
        // \App\weavira_get_billing_addresses() in app/filters.php.
        $data['savedBillingAddresses'] = is_user_logged_in()
            ? \App\weavira_get_billing_addresses(get_current_user_id())
            : [];

        return $data;
    }

    /**
     * No "You May Also Love" carousel on checkout — skip the query.
     *
     * @return array
     */
    protected function recommendations($cart, $limit = 8)
    {
        return [];
    }
}
