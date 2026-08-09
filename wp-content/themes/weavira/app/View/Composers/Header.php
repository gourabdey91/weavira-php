<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Header extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'sections.header',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'cartCount' => $this->cartCount(),
            'wishlistCount' => \App\weavira_wishlist_count(),
            'shopMega' => $this->shopMega(),
            'journalMega' => $this->journalMega(),
            'giftingMega' => $this->giftingMega(),
            'aboutMega' => $this->aboutMega(),
        ];
    }

    /**
     * Items currently in the WooCommerce cart, for the header cart badge.
     *
     * @return int
     */
    protected function cartCount()
    {
        return (function_exists('WC') && WC()->cart) ? WC()->cart->get_cart_contents_count() : 0;
    }

    /**
     * "Shop" mega menu data. The facet lists (material/design/occasion/weave/
     * colour) are read live from the matching WooCommerce attribute
     * taxonomies rather than a manually managed list, so a new attribute
     * term shows up here automatically.
     *
     * @return array
     */
    protected function shopMega()
    {
        return [
            'feature' => [
                'image' => get_field('shop_feature_image', 'option'),
                'label' => get_field('shop_feature_label', 'option'),
                'link' => get_field('shop_feature_link', 'option'),
            ],
            'materials' => $this->attributeTerms('pa_material', 'thumbnail'),
            'designs' => $this->attributeTerms('pa_design', 'thumbnail'),
            'occasions' => $this->attributeTerms('pa_occasion', 'icon'),
            'weaves' => $this->attributeTerms('pa_weave', 'thumbnail'),
            'colours' => $this->colourTerms(),
            'collections' => get_field('shop_collections', 'option') ?: [],
            'budgets' => $this->budgetTiers(),
            'bannerHeading' => get_field('shop_banner_heading', 'option'),
            'bannerSub' => get_field('shop_banner_sub', 'option'),
        ];
    }

    /**
     * Terms of a WooCommerce attribute taxonomy, with a generated shop link
     * and (optionally) a mega-menu thumbnail or icon read from a term-level
     * ACF field.
     *
     * @return array
     */
    protected function attributeTerms($taxonomy, $extra = null, $limit = 8)
    {
        $terms = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => false, 'number' => $limit]);

        if (is_wp_error($terms) || empty($terms)) {
            return [];
        }

        $attribute = str_replace('pa_', '', $taxonomy);
        $shopUrl = wc_get_page_permalink('shop');

        return array_map(function ($term) use ($taxonomy, $attribute, $shopUrl, $extra) {
            $row = [
                'name' => html_entity_decode($term->name, ENT_QUOTES),
                'link' => add_query_arg('filter_' . $attribute, $term->slug, $shopUrl),
            ];

            if ($extra === 'thumbnail') {
                $row['thumbnail'] = get_field('menu_thumbnail', $taxonomy . '_' . $term->term_id) ?: null;
            }

            if ($extra === 'icon') {
                $row['icon'] = get_field('menu_icon', $taxonomy . '_' . $term->term_id) ?: 'circle';
            }

            return $row;
        }, $terms);
    }

    /**
     * Body Primary Colour terms as swatches, for "Shop by Colour".
     *
     * @return array
     */
    protected function colourTerms($limit = 12)
    {
        $taxonomy = 'pa_body-primary-colour';
        $terms = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => false, 'number' => $limit]);

        if (is_wp_error($terms) || empty($terms)) {
            return [];
        }

        $shopUrl = wc_get_page_permalink('shop');

        return array_map(function ($term) use ($taxonomy, $shopUrl) {
            return [
                'name' => html_entity_decode($term->name, ENT_QUOTES),
                'hex' => get_field('swatch_color', $taxonomy . '_' . $term->term_id) ?: '#cccccc',
                'link' => add_query_arg('filter_body-primary-colour', $term->slug, $shopUrl),
            ];
        }, $terms);
    }

    /**
     * "Shop by Budget" tiers, with links to the shop page pre-filtered by
     * price range (the same min_price/max_price query vars WooCommerce's
     * own price filter widget uses).
     *
     * @return array
     */
    protected function budgetTiers()
    {
        $rows = get_field('shop_budget_tiers', 'option') ?: [];
        $shopUrl = wc_get_page_permalink('shop');

        return array_map(function ($row) use ($shopUrl) {
            $args = array_filter([
                'min_price' => $row['min_price'] ?: null,
                'max_price' => $row['max_price'] ?: null,
            ]);

            return [
                'label' => $row['label'],
                'link' => $args ? add_query_arg($args, $shopUrl) : $shopUrl,
            ];
        }, $rows);
    }

    /**
     * "Journal" mega menu data. The featured editorial and category tiles
     * are sourced live from the `journal` post type / `journal_category`
     * taxonomy rather than a manually managed list, so publishing a new
     * Journal entry (and optionally checking "Editor's Pick") is all it
     * takes to update the menu.
     *
     * @return array
     */
    protected function journalMega()
    {
        return [
            'kicker' => get_field('journal_kicker', 'option'),
            'heading' => get_field('journal_heading', 'option'),
            'desc' => get_field('journal_desc', 'option'),
            'featured' => $this->journalFeatured(),
            'categories' => $this->journalCategories(),
            'exploreLink' => get_field('journal_explore_link', 'option') ?: ['url' => get_post_type_archive_link('journal')],
        ];
    }

    /**
     * The Journal entry to show as the mega menu's featured editorial:
     * whichever post has "Editor's Pick" checked, or the most recent
     * published entry if none is picked.
     *
     * @return array
     */
    protected function journalFeatured()
    {
        $featured = get_posts([
            'post_type' => 'journal',
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'meta_key' => 'journal_is_featured',
            'meta_value' => '1',
            'no_found_rows' => true,
        ]);

        $post = $featured[0] ?? (get_posts([
            'post_type' => 'journal',
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'no_found_rows' => true,
        ])[0] ?? null);

        if (!$post) {
            return ['image' => null];
        }

        return [
            'image' => get_the_post_thumbnail_url($post, 'large'),
            'kicker' => "EDITOR'S PICK",
            'heading' => html_entity_decode(get_the_title($post), ENT_QUOTES),
            'desc' => html_entity_decode(get_the_excerpt($post), ENT_QUOTES),
            'readtime' => \App\weavira_journal_read_time($post),
            'link' => ['url' => get_permalink($post)],
        ];
    }

    /**
     * Journal category tiles, one per `journal_category` term that has at
     * least one published entry.
     *
     * @return array
     */
    protected function journalCategories($limit = 4)
    {
        $terms = get_terms(['taxonomy' => 'journal_category', 'hide_empty' => true, 'number' => $limit]);

        if (is_wp_error($terms) || empty($terms)) {
            return [];
        }

        return array_map(function ($term) {
            $latest = get_posts([
                'post_type' => 'journal',
                'posts_per_page' => 1,
                'no_found_rows' => true,
                'tax_query' => [[
                    'taxonomy' => 'journal_category',
                    'field' => 'term_id',
                    'terms' => $term->term_id,
                ]],
            ]);
            $latest = $latest[0] ?? null;

            return [
                'title' => html_entity_decode($term->name, ENT_QUOTES),
                'desc' => $term->description ?: ($latest ? html_entity_decode(get_the_excerpt($latest), ENT_QUOTES) : ''),
                'image' => get_field('menu_thumbnail', 'journal_category_' . $term->term_id)
                    ?: ($latest ? get_the_post_thumbnail_url($latest, 'medium') : null),
                'link' => ['url' => get_term_link($term)],
            ];
        }, $terms);
    }

    /**
     * "Gifting" mega menu data.
     *
     * @return array
     */
    protected function giftingMega()
    {
        return [
            'kicker' => get_field('gifting_kicker', 'option'),
            'heading' => get_field('gifting_heading', 'option'),
            'sub' => get_field('gifting_sub', 'option'),
            'features' => get_field('gifting_features', 'option') ?: [],
            'image' => get_field('gifting_image', 'option'),
            'occasions' => get_field('gifting_occasions', 'option') ?: [],
            'occasionsViewAll' => get_field('gifting_occasions_view_all', 'option'),
            'relations' => get_field('gifting_relations', 'option') ?: [],
            'relationsViewAll' => get_field('gifting_relations_view_all', 'option'),
            'services' => get_field('gifting_services', 'option') ?: [],
            'whatsappHeading' => get_field('gifting_whatsapp_heading', 'option'),
            'whatsappLink' => get_field('gifting_whatsapp_link', 'option'),
        ];
    }

    /**
     * "About Us" mega menu data.
     *
     * @return array
     */
    protected function aboutMega()
    {
        return [
            'hero' => [
                'image' => get_field('about_hero_image', 'option'),
                'heading' => get_field('about_hero_heading', 'option'),
                'tagline' => get_field('about_hero_tagline', 'option'),
                'body' => get_field('about_hero_body', 'option'),
                'ctaLabel' => get_field('about_hero_cta_label', 'option'),
                'ctaLink' => get_field('about_hero_cta_link', 'option'),
            ],
            'col1' => [
                'title' => get_field('about_col1_title', 'option'),
                'desc' => get_field('about_col1_desc', 'option'),
                'points' => get_field('about_col1_points', 'option') ?: [],
                'ctaLabel' => get_field('about_col1_cta_label', 'option'),
                'ctaLink' => get_field('about_col1_cta_link', 'option'),
            ],
            'col2' => [
                'title' => get_field('about_col2_title', 'option'),
                'desc' => get_field('about_col2_desc', 'option'),
                'points' => get_field('about_col2_points', 'option') ?: [],
                'ctaLabel' => get_field('about_col2_cta_label', 'option'),
                'ctaLink' => get_field('about_col2_cta_link', 'option'),
            ],
            'contact' => [
                'title' => get_field('about_contact_title', 'option'),
                'sub' => get_field('about_contact_sub', 'option'),
                'actions' => get_field('about_contact_actions', 'option') ?: [],
            ],
            'quote' => get_field('about_quote', 'option'),
        ];
    }
}
