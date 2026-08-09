<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class SearchOverlay extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.search-overlay',
    ];

    /**
     * Attribute taxonomies pooled for the "Popular Searches" chips, since
     * this catalog doesn't yet have enough WooCommerce product categories
     * to make a useful chip list.
     *
     * @var array
     */
    protected static $chipTaxonomies = ['pa_design', 'pa_material', 'pa_occasion', 'pa_weave', 'pa_theme'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'popularSearches' => $this->popularSearches(),
        ];
    }

    /**
     * A random handful of real attribute terms from this catalog, used as
     * the "Popular Searches" chips. Different on every page load.
     *
     * @return array
     */
    protected function popularSearches($limit = 7)
    {
        $names = [];

        foreach (static::$chipTaxonomies as $taxonomy) {
            $terms = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => true]);

            if (!is_wp_error($terms)) {
                $names = array_merge($names, wp_list_pluck($terms, 'name'));
            }
        }

        $names = array_values(array_unique($names));
        shuffle($names);

        return array_slice($names, 0, $limit);
    }
}
