<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Wishlist extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'page-wishlist',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        $post = $this->resolvePost();
        $items = $this->items($post);

        return [
            'wishlistItems' => $items,
            'wishlistCount' => count($items),
            'isSharedView' => $this->isSharedView(),
            'shareUrl' => $post ? add_query_arg('share', $post->post_name, \App\weavira_wishlist_page_url()) : '',
            'recommendations' => $this->recommendations($items),
        ];
    }

    /**
     * The wishlist being viewed: the shared (read-only) one identified by
     * `?share=token` if present, otherwise the current visitor's own.
     *
     * @return \WP_Post|null
     */
    protected function resolvePost()
    {
        if ($this->isSharedView()) {
            $token = sanitize_text_field(wp_unslash($_GET['share']));
            $posts = get_posts([
                'post_type' => 'wv_wishlist',
                'post_status' => 'publish',
                'name' => $token,
                'posts_per_page' => 1,
                'no_found_rows' => true,
            ]);

            return $posts[0] ?? null;
        }

        return \App\weavira_get_wishlist_post(true);
    }

    /**
     * @return bool
     */
    protected function isSharedView()
    {
        return !empty($_GET['share']);
    }

    /**
     * Real wishlist line items, newest-saved first, skipping any product
     * that's been deleted/unpublished since it was saved.
     *
     * @return array
     */
    protected function items($post)
    {
        $rows = \App\weavira_wishlist_items($post);
        usort($rows, fn ($a, $b) => $b['added'] <=> $a['added']);

        $items = [];

        foreach ($rows as $row) {
            $product = wc_get_product($row['product_id']);

            if (!$product || $product->get_status() !== 'publish') {
                continue;
            }

            $variant = wp_list_pluck(get_the_terms($product->get_id(), 'pa_body-primary-colour') ?: [], 'name');

            $items[] = [
                'product' => $product,
                'productId' => $product->get_id(),
                'name' => $product->get_name(),
                'permalink' => $product->get_permalink(),
                'variant' => $variant[0] ?? '',
                'priceHtml' => $product->get_price_html(),
                'image' => wp_get_attachment_image_url($product->get_image_id(), 'large') ?: wc_placeholder_img_src('large'),
                'material' => $this->materialLabel($product),
                'badge' => $this->badge($product),
                'savedAgo' => human_time_diff($row['added']) . ' ago',
            ];
        }

        return $items;
    }

    /**
     * @return string
     */
    protected function materialLabel($product)
    {
        $terms = wp_list_pluck(get_the_terms($product->get_id(), 'pa_material') ?: [], 'name');

        return $terms[0] ?? '';
    }

    /**
     * @return array|null ['label' => string, 'class' => string]
     */
    protected function badge($product)
    {
        return \App\weavira_product_badge($product);
    }

    /**
     * "You may also love" — published products not already in this
     * wishlist.
     *
     * @return \WC_Product[]
     */
    protected function recommendations($items, $limit = 8)
    {
        $excludeIds = wp_list_pluck($items, 'productId');

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
