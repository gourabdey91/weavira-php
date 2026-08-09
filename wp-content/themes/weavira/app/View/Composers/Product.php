<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Product extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'woocommerce.single-product',
    ];

    /**
     * Attribute taxonomies (without the pa_ prefix) read onto the product page,
     * keyed the same way they're referenced in the Blade partials.
     *
     * @var array
     */
    protected static $attributeTaxonomies = [
        'material', 'tissue-type', 'cotton-type', 'warp-thread-type', 'weft-thread-type',
        'weave', 'design', 'theme', 'cluster', 'border-design', 'border-colour', 'border-width',
        'body-primary-colour', 'body-secondary-colour', 'blouse-piece', 'pre-stitched',
        'occasion', 'return-eligibility', 'loom-type',
    ];

    /**
     * Data to be passed to view before rendering, but after merging.
     *
     * @return array
     */
    public function override()
    {
        $product = wc_get_product(get_queried_object_id());

        if (!$product) {
            return [];
        }

        $attrs = $this->attributes($product);

        return [
            'product' => $product,
            'attrs' => $attrs,
            'galleryImages' => $this->galleryImages($product),
            'galleryVideo' => $this->galleryVideo($product),
            'story' => $this->story($product),
            'breadcrumbCategory' => $this->primaryCategory($product),
            'badgeLabel' => get_field('segment', $product->get_id()) ?: null,
            'craftFacts' => $this->craftFacts($product, $attrs),
            'specs' => $this->specs($product, $attrs),
            'relatedGroups' => [
                'design' => $this->relatedByAttribute($product, 'pa_design'),
                'theme' => $this->relatedByAttribute($product, 'pa_theme'),
                'occasion' => $this->relatedByAttribute($product, 'pa_occasion'),
                'similar' => $this->relatedByUpsellCrosssell($product),
            ],
        ];
    }

    /**
     * Flatten every configured attribute taxonomy down to a simple slug => value(s) map.
     *
     * @return array
     */
    protected function attributes($product)
    {
        $values = [];

        foreach (static::$attributeTaxonomies as $slug) {
            $terms = get_the_terms($product->get_id(), 'pa_' . $slug);
            $values[$slug] = ($terms && !is_wp_error($terms))
                ? implode(', ', wp_list_pluck($terms, 'name'))
                : '';
        }

        return $values;
    }

    /**
     * Featured image + gallery images, as plain URLs (matching this theme's
     * existing convention of rendering images as raw <img src="">).
     *
     * @return array
     */
    protected function galleryImages($product)
    {
        $ids = array_filter(array_merge(
            [$product->get_image_id()],
            $product->get_gallery_image_ids()
        ));

        if (empty($ids)) {
            return [[
                'url' => wc_placeholder_img_src('large'),
                'alt' => $product->get_name(),
            ]];
        }

        return array_map(function ($id) use ($product) {
            return [
                'url' => wp_get_attachment_image_url($id, 'large') ?: wc_placeholder_img_src('large'),
                'alt' => get_post_meta($id, '_wp_attachment_image_alt', true) ?: $product->get_name(),
            ];
        }, $ids);
    }

    /**
     * Optional craft/weaving video shown as an extra gallery thumbnail.
     *
     * @return array|null
     */
    protected function galleryVideo($product)
    {
        $url = get_field('product_video', $product->get_id());

        if (!$url) {
            return null;
        }

        $poster = get_field('product_video_poster', $product->get_id())
            ?: wp_get_attachment_image_url($product->get_image_id(), 'large')
            ?: wc_placeholder_img_src('large');

        return ['url' => $url, 'poster' => $poster];
    }

    /**
     * "The Story" banner content, sourced from the product's Theme
     * attribute term (ACF Group: Theme Story, on the pa_theme taxonomy)
     * instead of per-product fields. This lets one Theme term (e.g. "Rath
     * Yatra") carry a single story that every product tagged with it
     * reuses — adding a new Theme term is all that's needed to give a new
     * group of products their own story banner.
     *
     * @return array|null
     */
    protected function story($product)
    {
        $terms = get_the_terms($product->get_id(), 'pa_theme');
        $theme = ($terms && !is_wp_error($terms)) ? reset($terms) : null;

        if (!$theme) {
            return null;
        }

        $termKey = 'pa_theme_' . $theme->term_id;
        $heading = get_field('story_heading', $termKey);
        $body = get_field('story_body', $termKey);

        if (!$heading && !$body) {
            return null;
        }

        $ctaLink = get_field('story_cta_link', $termKey);

        return [
            'heading' => $heading,
            'body' => $body,
            'ctaLabel' => get_field('story_cta_label', $termKey),
            'ctaLink' => $ctaLink,
            'image' => get_field('story_image', $termKey),
        ];
    }

    /**
     * First assigned product category, used for the breadcrumb trail.
     *
     * @return \WP_Term|null
     */
    protected function primaryCategory($product)
    {
        $terms = get_the_terms($product->get_id(), 'product_cat');

        return ($terms && !is_wp_error($terms)) ? reset($terms) : null;
    }

    /**
     * Short trust-building facts shown next to the price, built from real
     * product data instead of hardcoded copy.
     *
     * @return array
     */
    protected function craftFacts($product, $attrs)
    {
        $facts = [];

        if (!empty($attrs['loom-type'])) {
            $place = !empty($attrs['cluster']) ? $attrs['cluster'] : 'Odisha';
            $facts[] = $attrs['loom-type'] . ' in ' . $place;
        }

        $weavingDescription = get_field('weaving_description', $product->get_id());

        if ($weavingDescription) {
            $facts[] = $weavingDescription;
        } else {
            $teamSize = get_field('weaving_team_size', $product->get_id());
            $hours = get_field('weaving_hours', $product->get_id());

            if ($teamSize && $hours) {
                $facts[] = sprintf('Handwoven by %d artisans over %d hours', $teamSize, $hours);
            }
        }

        return $facts;
    }

    /**
     * Rows for the "Specifications" accordion tab — every value here comes
     * from a real WooCommerce attribute or ACF field, nothing hardcoded.
     *
     * @return array
     */
    protected function specs($product, $attrs)
    {
        $rows = [];

        $length = get_field('length_meters', $product->get_id());
        if ($length) {
            $rows[] = ['label' => 'Length', 'value' => $length . ' metres', 'note' => 'excl. blouse piece'];
        }

        if (!empty($attrs['material'])) {
            $rows[] = ['label' => 'Fabric', 'value' => $attrs['material']];
        }

        if (!empty($attrs['weave'])) {
            $rows[] = ['label' => 'Technique', 'value' => $attrs['weave']];
        }

        $colour = trim(implode(' & ', array_filter([$attrs['body-primary-colour'] ?? '', $attrs['body-secondary-colour'] ?? ''])));
        if ($colour) {
            $rows[] = ['label' => 'Colour', 'value' => $colour];
        }

        if (!empty($attrs['blouse-piece'])) {
            $rows[] = ['label' => 'Blouse Piece', 'value' => $attrs['blouse-piece'] === 'Yes' ? 'Included' : 'Not included'];
        }

        $netWeight = get_field('net_weight', $product->get_id());
        if ($netWeight) {
            $rows[] = ['label' => 'Weight', 'value' => 'Approx. ' . $netWeight . 'g'];
        }

        return $rows;
    }

    /**
     * Other published products sharing the same term for a given attribute
     * taxonomy, excluding the current product. Used for the "Similar
     * Stories" filter tabs (Same Design / Same Theme / Festive Picks).
     *
     * @return \WC_Product[]
     */
    protected function relatedByAttribute($product, $taxonomy, $limit = 8)
    {
        $terms = get_the_terms($product->get_id(), $taxonomy);

        if (!$terms || is_wp_error($terms)) {
            return [];
        }

        $query = new \WP_Query([
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => $limit,
            'post__not_in' => [$product->get_id()],
            'tax_query' => [[
                'taxonomy' => $taxonomy,
                'field' => 'term_id',
                'terms' => wp_list_pluck($terms, 'term_id'),
            ]],
            'no_found_rows' => true,
            'fields' => 'ids',
        ]);

        return array_filter(array_map('wc_get_product', $query->posts));
    }

    /**
     * "Similar Products" tab — sourced from the standard WooCommerce
     * Upsells + Cross-sells fields (Product Data > Linked Products), so
     * merchants can drive this section directly without needing matching
     * Design/Theme/Occasion attributes maintained.
     *
     * @return \WC_Product[]
     */
    protected function relatedByUpsellCrosssell($product, $limit = 8)
    {
        $ids = array_unique(array_merge($product->get_upsell_ids(), $product->get_cross_sell_ids()));
        $ids = array_diff($ids, [$product->get_id()]);

        if (empty($ids)) {
            return [];
        }

        $query = new \WP_Query([
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => $limit,
            'post__in' => $ids,
            'orderby' => 'post__in',
            'no_found_rows' => true,
            'fields' => 'ids',
        ]);

        return array_filter(array_map('wc_get_product', $query->posts));
    }
}
