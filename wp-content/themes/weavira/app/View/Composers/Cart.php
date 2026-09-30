<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Cart extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'woocommerce.cart',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        $cart = WC()->cart;

        return [
            'cartItems' => $this->cartItems($cart),
            'cartCount' => $cart->get_cart_contents_count(),
            'subtotal' => $cart->get_cart_subtotal(),
            'isFreeShipping' => $this->isFreeShipping(),
            'shippingLabel' => $this->shippingLabel(),
            'taxRows' => $this->taxRows($cart),
            'total' => $cart->get_total(),
            'recommendations' => $this->recommendations($cart),
        ];
    }

    /**
     * Real cart line items, with product data, "collection" label, spec
     * badges, and any gift details already saved for that line (see
     * app/filters.php's weavira_save_gift_details AJAX handler).
     *
     * @return array
     */
    protected function cartItems($cart)
    {
        $items = [];

        foreach ($cart->get_cart() as $key => $cartItem) {
            $product = $cartItem['data'];

            if (!$product) {
                continue;
            }

            $items[] = [
                'key' => $key,
                'product' => $product,
                'name' => $product->get_name(),
                'permalink' => $product->get_permalink(),
                'image' => wp_get_attachment_image_url($product->get_image_id(), 'large') ?: wc_placeholder_img_src('large'),
                'collection' => $this->collectionLabel($product),
                'badges' => $this->badges($product, $cartItem),
                'quantity' => $cartItem['quantity'],
                // get_product_subtotal() reads woocommerce_tax_display_cart
                // itself (WC_Cart::display_prices_including_tax(), which this
                // was previously avoiding since that option used to disagree
                // with woocommerce_tax_display_shop — see git history,
                // "Cart Fix 1"). Now that both options are kept in sync (see
                // GST pricing-mode plan), this is the correct, settings-aware
                // call: it already matches get_cart_subtotal() below for the
                // summary's own Subtotal, and it already appends WooCommerce's
                // own "(ex. tax)"/"(incl. tax)" suffix when the display mode
                // and the stored price's own inclusive/exclusive nature
                // differ, so nothing needs to be reimplemented here.
                'unitPriceHtml' => $cart->get_product_subtotal($product, 1),
                'lineTotalHtml' => $cart->get_product_subtotal($product, $cartItem['quantity']),
                'gift' => $cartItem['wv_gift'] ?? null,
            ];
        }

        return $items;
    }

    /**
     * "Konark Collection" style label from the product's Theme attribute.
     *
     * @return string
     */
    protected function collectionLabel($product)
    {
        $productId = $product->is_type('variation') ? $product->get_parent_id() : $product->get_id();
        $terms = get_the_terms($productId, 'pa_theme');

        if ($terms && !is_wp_error($terms)) {
            return reset($terms)->name . ' Collection';
        }

        $categories = get_the_terms($productId, 'product_cat');

        return ($categories && !is_wp_error($categories)) ? reset($categories)->name . ' Collection' : '';
    }

    /**
     * Design / Material / Colour badges. For a variation, the colour badge
     * reflects the specific variation chosen rather than the parent's full
     * set of colour options.
     *
     * @return array
     */
    protected function badges($product, $cartItem)
    {
        $productId = $product->is_type('variation') ? $product->get_parent_id() : $product->get_id();

        $design = wp_list_pluck(get_the_terms($productId, 'pa_design') ?: [], 'name');
        $material = wp_list_pluck(get_the_terms($productId, 'pa_material') ?: [], 'name');

        $colour = '';
        $variationColourSlug = $cartItem['variation']['attribute_pa_body-primary-colour'] ?? null;

        if ($variationColourSlug) {
            $term = get_term_by('slug', $variationColourSlug, 'pa_body-primary-colour');
            $colour = $term ? $term->name : '';
        } else {
            $colourTerms = wp_list_pluck(get_the_terms($productId, 'pa_body-primary-colour') ?: [], 'name');
            $colour = $colourTerms[0] ?? '';
        }

        return array_values(array_filter([$design[0] ?? '', $material[0] ?? '', $colour]));
    }

    /**
     * Whether Free Shipping is the (or among the) available rate(s) for
     * the current cart package.
     *
     * @return bool
     */
    protected function isFreeShipping()
    {
        if (!WC()->cart->needs_shipping()) {
            return false;
        }

        WC()->cart->calculate_shipping();

        $packages = WC()->shipping()->get_packages();

        foreach ($packages as $package) {
            if (!empty($package['rates'])) {
                foreach ($package['rates'] as $rate) {
                    if ($rate->method_id === 'free_shipping') {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * @return string
     */
    protected function shippingLabel()
    {
        return $this->isFreeShipping() ? 'FREE' : '';
    }

    /**
     * Tax breakdown rows (label + formatted amount) for the order summary.
     *
     * @return array
     */
    protected function taxRows($cart)
    {
        if (!wc_tax_enabled()) {
            return [];
        }

        $rows = [];

        foreach ($cart->get_tax_totals() as $tax) {
            $rows[] = ['label' => $tax->label, 'amount' => $tax->formatted_amount];
        }

        return $rows;
    }

    /**
     * "You May Also Love" — published products not already in the cart,
     * preferring the store's configured cross-sells where set.
     *
     * @return \WC_Product[]
     */
    protected function recommendations($cart, $limit = 8)
    {
        $excludeIds = array_map(function ($cartItem) {
            return $cartItem['product_id'];
        }, $cart->get_cart());

        $crossSellIds = array_diff($cart->get_cross_sells(), $excludeIds);

        if (!empty($crossSellIds)) {
            return array_filter(array_map('wc_get_product', array_slice($crossSellIds, 0, $limit)));
        }

        $query = new \WP_Query([
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => $limit,
            'post__not_in' => $excludeIds,
            'orderby' => 'rand',
            'no_found_rows' => true,
            'fields' => 'ids',
        ]);

        return array_filter(array_map('wc_get_product', $query->posts));
    }
}
