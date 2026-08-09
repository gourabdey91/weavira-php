<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Shop extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'woocommerce.archive-product',
    ];

    /**
     * Attribute taxonomies (without the pa_ prefix) shown as checkbox
     * filter groups in the sidebar, matching html/plp.html.
     *
     * @var array
     */
    protected static $filterAttributes = [
        'material' => 'Material Type',
        'tissue-type' => 'Tissue Type',
        'cotton-type' => 'Cotton Type',
        'design' => 'Design',
        'theme' => 'Theme',
        'occasion' => 'Occasion',
    ];

    /**
     * Data to be passed to view before rendering. Products/pagination come
     * straight from the main query — WooCommerce's own WC_Query hooks
     * (pre_get_posts) already apply the filter_*, min_price/max_price and
     * orderby query vars to it natively, so there's no custom tax_query or
     * sorting logic to duplicate here.
     *
     * @return array
     */
    public function with()
    {
        global $wp_query;

        $products = array_filter(array_map(function ($post) {
            return wc_get_product($post->ID);
        }, $wp_query->posts));

        return [
            'products' => $products,
            'totalProducts' => (int) $wp_query->found_posts,
            'currentPage' => max(1, (int) get_query_var('paged')),
            'maxPages' => (int) $wp_query->max_num_pages,
            'filterGroups' => $this->filterGroups(),
            'colourSwatches' => $this->colourSwatches(),
            'priceRange' => $this->priceRange(),
            'currentSort' => isset($_GET['orderby']) ? sanitize_text_field(wp_unslash($_GET['orderby'])) : 'menu_order',
            'banner' => $this->banner(),
            'breadcrumb' => $this->breadcrumb(),
            'activeFilterCount' => $this->activeFilterCount(),
        ];
    }

    /**
     * Comma-separated `filter_{attribute}` query var, exploded — the same
     * convention WooCommerce's own layered nav widget uses (and that
     * WC_Query::get_layered_nav_chosen_attributes() already reads to
     * filter the main query), plus the header mega menu's "Shop by
     * Colour"/attribute links.
     *
     * @return array
     */
    protected function chosenSlugs($attributeSlug)
    {
        $raw = $_GET['filter_' . $attributeSlug] ?? '';

        if (!is_string($raw) || $raw === '') {
            return [];
        }

        return array_map('sanitize_title', explode(',', wc_clean(wp_unslash($raw))));
    }

    /**
     * Sidebar checkbox filter groups (Material / Tissue / Cotton / Design /
     * Theme / Occasion), each term carrying a real product count. Tissue
     * Type and Cotton Type are attribute-hierarchy children of Material
     * Type — Tissue Type only makes sense for silk sarees, Cotton Type only
     * for cotton ones — so each is hidden entirely unless the current
     * (unpaginated) filtered result set actually contains a matching
     * material.
     *
     * @return array
     */
    protected function filterGroups()
    {
        $groups = [];

        foreach (static::$filterAttributes as $slug => $label) {
            $taxonomy = 'pa_' . $slug;

            if (!taxonomy_exists($taxonomy)) {
                continue;
            }

            if ($slug === 'tissue-type' && !$this->materialFamilyPresent('silk')) {
                continue;
            }

            if ($slug === 'cotton-type' && !$this->materialFamilyPresent('cotton')) {
                continue;
            }

            $terms = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => true]);

            if (is_wp_error($terms) || empty($terms)) {
                continue;
            }

            $chosen = $this->chosenSlugs($slug);

            $groups[] = [
                'slug' => $slug,
                'label' => $label,
                'terms' => array_map(function ($term) use ($chosen) {
                    return [
                        'name' => html_entity_decode($term->name, ENT_QUOTES),
                        'slug' => $term->slug,
                        'count' => $term->count,
                        'checked' => in_array($term->slug, $chosen, true),
                    ];
                }, $terms),
            ];
        }

        return $groups;
    }

    /**
     * Whether any product in the current (unpaginated) filtered result set
     * has a Material Type term whose slug contains $needle — e.g. "silk"
     * matches Silk/Mix Silk/Tissue Silk, "cotton" matches Cotton.
     *
     * @return bool
     */
    protected function materialFamilyPresent($needle)
    {
        foreach ($this->currentMaterialSlugs() as $slug) {
            if (str_contains($slug, $needle)) {
                return true;
            }
        }

        return false;
    }

    /**
     * pa_material term slugs used by products matching the current filter
     * state, ignoring pagination — reruns the main query's own query_vars
     * (already shaped by WooCommerce's filter_* handling) with
     * posts_per_page => -1 so a term missing from just the visible page
     * doesn't incorrectly hide a dependent filter group.
     *
     * @return array
     */
    protected function currentMaterialSlugs()
    {
        static $slugs;

        if ($slugs !== null) {
            return $slugs;
        }

        global $wp_query;

        $args = $wp_query->query_vars;
        $args['posts_per_page'] = -1;
        $args['nopaging'] = true;
        $args['paged'] = 1;
        $args['fields'] = 'ids';
        $args['no_found_rows'] = true;

        $ids = (new \WP_Query($args))->posts;

        if (empty($ids)) {
            return $slugs = [];
        }

        $terms = wp_get_object_terms($ids, 'pa_material', ['fields' => 'slugs']);

        return $slugs = is_wp_error($terms) ? [] : array_unique($terms);
    }

    /**
     * Body Primary Colour terms as swatches, reusing the same swatch_color
     * term field the header's "Shop by Colour" mega menu and PDP variation
     * swatches already use.
     *
     * @return array
     */
    protected function colourSwatches()
    {
        $taxonomy = 'pa_body-primary-colour';

        if (!taxonomy_exists($taxonomy)) {
            return [];
        }

        $terms = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => true]);

        if (is_wp_error($terms) || empty($terms)) {
            return [];
        }

        $chosen = $this->chosenSlugs('body-primary-colour');

        return array_map(function ($term) use ($taxonomy, $chosen) {
            return [
                'name' => html_entity_decode($term->name, ENT_QUOTES),
                'slug' => $term->slug,
                'hex' => get_field('swatch_color', $taxonomy . '_' . $term->term_id) ?: '#cccccc',
                'checked' => in_array($term->slug, $chosen, true),
            ];
        }, $terms);
    }

    /**
     * Real min/max price across the whole catalogue (for the slider's
     * bounds) plus the currently selected min/max, if any.
     *
     * @return array
     */
    protected function priceRange()
    {
        global $wpdb;

        $bounds = $wpdb->get_row("SELECT MIN(min_price) AS floor_price, MAX(max_price) AS ceil_price FROM {$wpdb->wc_product_meta_lookup}");

        $floor = $bounds && $bounds->floor_price !== null ? (float) $bounds->floor_price : 0;
        $ceil = $bounds && $bounds->ceil_price !== null ? (float) $bounds->ceil_price : 0;

        return [
            'floor' => $floor,
            'ceil' => $ceil,
            'min' => isset($_GET['min_price']) ? (float) $_GET['min_price'] : $floor,
            'max' => isset($_GET['max_price']) ? (float) $_GET['max_price'] : $ceil,
        ];
    }

    /**
     * The single attribute term to treat as "active" for banner/breadcrumb
     * purposes — only when exactly one filter group has exactly one term
     * chosen (matches how the header mega menu links here: one click, one
     * term). Multiple simultaneous filters fall back to the default banner.
     *
     * @return \WP_Term|null
     */
    protected function singleActiveFilterTerm()
    {
        foreach (array_keys(static::$filterAttributes) as $slug) {
            $chosen = $this->chosenSlugs($slug);

            if (count($chosen) === 1) {
                $term = get_term_by('slug', $chosen[0], 'pa_' . $slug);

                if ($term) {
                    return $term;
                }
            }
        }

        return null;
    }

    /**
     * The Featured Image of the Heritage Design post related to a Design
     * attribute term (via that post's related_design_attribute field —
     * see weavira_heritage_design_card()), null for any other attribute
     * or when no Heritage Design post links to this term.
     *
     * @return string|null
     */
    protected function heritageDesignImage($term)
    {
        if ($term->taxonomy !== 'pa_design') {
            return null;
        }

        $posts = get_posts([
            'post_type' => 'heritage_design',
            'posts_per_page' => 1,
            'no_found_rows' => true,
            'meta_key' => 'related_design_attribute',
            'meta_value' => $term->term_id,
        ]);

        return $posts ? get_the_post_thumbnail_url($posts[0], 'full') : null;
    }

    /**
     * Hero banner: a real product category's own WooCommerce thumbnail; for
     * the Design attribute specifically, the related Heritage Design post's
     * own Featured Image (set per-design, see HeritageDesigns composer)
     * takes priority; otherwise an attribute term's dedicated banner_image
     * field (see acf-json/group_7ab3c9e21f04d.json); or the default Shop
     * banner — in that order.
     *
     * @return array
     */
    protected function banner()
    {
        if (is_product_category() || is_product_taxonomy()) {
            $term = get_queried_object();

            if (is_product_category()) {
                $thumbId = get_term_meta($term->term_id, 'thumbnail_id', true);
                $image = $thumbId ? wp_get_attachment_image_url($thumbId, 'full') : null;
            } else {
                $image = $this->heritageDesignImage($term) ?: get_field('banner_image', $term->taxonomy . '_' . $term->term_id);
            }

            return [
                'image' => $image ?: get_field('shop_banner_image', 'option'),
                'heading' => html_entity_decode($term->name, ENT_QUOTES),
                'sub' => $term->description ?: get_field('shop_banner_sub', 'option'),
            ];
        }

        $activeTerm = $this->singleActiveFilterTerm();

        if ($activeTerm) {
            $image = $this->heritageDesignImage($activeTerm) ?: get_field('banner_image', $activeTerm->taxonomy . '_' . $activeTerm->term_id);

            return [
                'image' => $image ?: get_field('shop_banner_image', 'option'),
                'heading' => html_entity_decode($activeTerm->name, ENT_QUOTES),
                'sub' => $activeTerm->description ?: get_field('shop_banner_sub', 'option'),
            ];
        }

        return [
            'image' => get_field('shop_banner_image', 'option'),
            'heading' => get_field('shop_banner_heading', 'option') ?: 'Shop All Sarees',
            'sub' => get_field('shop_banner_sub', 'option') ?: '',
        ];
    }

    /**
     * @return array Breadcrumb trail segments after "Home".
     */
    protected function breadcrumb()
    {
        if (is_product_category()) {
            return ['Collections', html_entity_decode(get_queried_object()->name, ENT_QUOTES)];
        }

        if (is_product_taxonomy()) {
            return ['Shop', html_entity_decode(get_queried_object()->name, ENT_QUOTES)];
        }

        $activeTerm = $this->singleActiveFilterTerm();

        if ($activeTerm) {
            return ['Shop', html_entity_decode($activeTerm->name, ENT_QUOTES)];
        }

        return ['Shop'];
    }

    /**
     * @return int
     */
    protected function activeFilterCount()
    {
        $count = count($this->chosenSlugs('body-primary-colour'));

        foreach (array_keys(static::$filterAttributes) as $slug) {
            $count += count($this->chosenSlugs($slug));
        }

        return $count;
    }
}
