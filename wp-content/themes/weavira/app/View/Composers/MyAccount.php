<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class MyAccount extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'woocommerce.myaccount.dashboard',
        'woocommerce.myaccount.orders',
        'woocommerce.myaccount.view-order',
        'woocommerce.myaccount.addresses',
        'woocommerce.myaccount.edit-address',
    ];

    /**
     * Data to be passed to view before rendering, but after merging.
     *
     * @return array
     */
    public function override()
    {
        switch ($this->view->name()) {
            case 'woocommerce.myaccount.dashboard':
                return ['recentOrder' => $this->recentOrder()];

            case 'woocommerce.myaccount.orders':
                $customerOrders = $this->view->getData()['customer_orders'] ?? null;

                return [
                    'orders' => $this->ordersList(),
                    'currentPage' => $this->view->getData()['current_page'] ?? 1,
                    'maxPages' => $customerOrders->max_num_pages ?? 1,
                ];

            case 'woocommerce.myaccount.view-order':
                return ['order' => $this->orderDetail()];

            case 'woocommerce.myaccount.addresses':
                return ['addresses' => $this->addresses()];

            case 'woocommerce.myaccount.edit-address':
                return $this->editShippingAddress();
        }

        return [];
    }

    /**
     * The current customer's single most recent order, shaped for the
     * Dashboard's "Your Most Recent Order" card — null if they have none.
     *
     * @return array|null
     */
    protected function recentOrder()
    {
        $orders = wc_get_orders([
            'customer' => get_current_user_id(),
            'limit' => 1,
            'orderby' => 'date',
            'order' => 'DESC',
        ]);

        $order = $orders[0] ?? null;

        if (!$order) {
            return null;
        }

        return [
            'number' => $order->get_order_number(),
            'date' => wc_format_datetime($order->get_date_created()),
            'status' => wc_get_order_status_name($order->get_status()),
            'statusSlug' => $order->get_status(),
            'total' => $order->get_formatted_order_total(),
            'viewUrl' => $order->get_view_order_url(),
        ];
    }

    /**
     * @return array
     */
    protected function ordersList()
    {
        $view = $this->view;
        $customerOrders = $view->getData()['customer_orders'] ?? null;

        if (!$customerOrders || empty($customerOrders->orders)) {
            return [];
        }

        return array_map(function ($order) {
            $order = wc_get_order($order);
            $itemCount = $order->get_item_count() - $order->get_item_count_refunded();

            return [
                'number' => $order->get_order_number(),
                'date' => wc_format_datetime($order->get_date_created()),
                'status' => wc_get_order_status_name($order->get_status()),
                'statusSlug' => $order->get_status(),
                'itemCount' => $itemCount,
                'total' => $order->get_formatted_order_total(),
                'actions' => $this->orderActions($order),
            ];
        }, $customerOrders->orders);
    }

    /**
     * @return array
     */
    protected function orderActions($order)
    {
        return array_map(function ($key, $action) {
            return ['key' => $key, 'url' => $action['url'], 'name' => $action['name']];
        }, array_keys(wc_get_account_orders_actions($order)), wc_get_account_orders_actions($order));
    }

    /**
     * Full detail for the Single Order view, in the same shape as the
     * Checkout Step 4 order-summary items (image/name/quantity/lineTotalHtml)
     * so resources/views/woocommerce/myaccount/view-order.blade.php can
     * reuse the .ck-order-item / .ck-summary-rows CSS as-is.
     *
     * @return array|null
     */
    protected function orderDetail()
    {
        $orderId = $this->view->getData()['order_id'] ?? null;
        $order = $orderId ? wc_get_order($orderId) : null;

        if (!$order || !current_user_can('view_order', $orderId)) {
            return null;
        }

        return \App\weavira_order_summary($order);
    }

    /**
     * Both billing and shipping are now address books (Home / Office / ...
     * and per-GSTIN billing entries respectively — see
     * weavira_get_shipping_addresses()/weavira_get_billing_addresses() in
     * app/filters.php), replacing WooCommerce's own single-address cards.
     * Billing became a book alongside shipping once GST invoicing made a
     * customer's billing identity something that can legitimately vary
     * too — see the checkout GST section in checkout.blade.php.
     *
     * @return array
     */
    protected function addresses()
    {
        $showShipping = !wc_ship_to_billing_address_only() && wc_shipping_enabled();

        return [
            'showShipping' => $showShipping,
            'shippingAddresses' => $showShipping ? $this->shippingAddresses() : [],
            'addShippingUrl' => add_query_arg('address_id', 'new', wc_get_endpoint_url('edit-address', 'shipping')),
            'billingAddresses' => $this->billingAddresses(),
            'addBillingUrl' => add_query_arg('address_id', 'new', wc_get_endpoint_url('edit-address', 'billing')),
        ];
    }

    /**
     * @return array
     */
    protected function shippingAddresses()
    {
        $saved = \App\weavira_get_shipping_addresses(get_current_user_id());

        return array_map(function ($address) {
            return [
                'id' => $address['id'],
                'label' => $address['label'],
                'isDefault' => !empty($address['is_default']),
                'formatted' => WC()->countries->get_formatted_address($address),
                'editUrl' => add_query_arg('address_id', $address['id'], wc_get_endpoint_url('edit-address', 'shipping')),
            ];
        }, $saved);
    }

    /**
     * @return array
     */
    protected function billingAddresses()
    {
        $saved = \App\weavira_get_billing_addresses(get_current_user_id());

        return array_map(function ($address) {
            return [
                'id' => $address['id'],
                'label' => $address['label'],
                'gstin' => $address['gstin'] ?? '',
                'isDefault' => !empty($address['is_default']),
                'formatted' => WC()->countries->get_formatted_address($address),
                'editUrl' => add_query_arg('address_id', $address['id'], wc_get_endpoint_url('edit-address', 'billing')),
            ];
        }, $saved);
    }

    /**
     * Overrides the shipping/billing edit-address form's field values to
     * come from one saved address-book entry (?address_id=...) instead of
     * WooCommerce's own single shipping_ / billing_ user meta — see
     * weavira_save_shipping_address() / weavira_save_billing_address()'s
     * companion template_redirect handlers in app/filters.php, which this
     * form posts to.
     *
     * @return array
     */
    protected function editShippingAddress()
    {
        $data = $this->view->getData();
        $type = $data['load_address'] ?? null;

        if ($type === 'shipping') {
            return $this->editAddressBookEntry('shipping', \App\weavira_get_shipping_addresses(get_current_user_id()));
        }

        if ($type === 'billing') {
            return $this->editAddressBookEntry('billing', \App\weavira_get_billing_addresses(get_current_user_id()));
        }

        return [];
    }

    /**
     * Shared shaping for both address-book edit forms — same field-value
     * lookup logic, just against a different saved-entries array and a
     * different WC field prefix.
     *
     * @return array
     */
    protected function editAddressBookEntry($type, array $savedEntries)
    {
        $addressId = (!empty($_GET['address_id']) && $_GET['address_id'] !== 'new')
            ? sanitize_text_field(wp_unslash($_GET['address_id']))
            : null;

        $saved = null;

        if ($addressId) {
            foreach ($savedEntries as $entry) {
                if ($entry['id'] === $addressId) {
                    $saved = $entry;
                    break;
                }
            }
        }

        $country = $saved['country'] ?? WC()->countries->get_base_country();
        $fields = WC()->countries->get_address_fields($country, "{$type}_");

        // billing_phone/billing_email are always the account's own single
        // contact identity (see checkout.blade.php) — never part of a
        // billing-book entry, unlike WC's default billing fieldset which
        // includes both.
        if ($type === 'billing') {
            unset($fields['billing_phone'], $fields['billing_email']);
        }

        foreach ($fields as $key => $field) {
            $shortKey = substr($key, strlen("{$type}_"));
            $fields[$key]['value'] = $saved[$shortKey] ?? '';
        }

        return [
            'address' => $fields,
            'addressId' => $addressId,
            'addressLabel' => $saved['label'] ?? '',
            'addressGstin' => $saved['gstin'] ?? '',
        ];
    }
}
