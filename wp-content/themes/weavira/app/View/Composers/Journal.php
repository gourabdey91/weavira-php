<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Journal extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'archive-journal',
    ];

    /**
     * Data to be passed to view before rendering. filter_category is
     * applied to the main query by the pre_get_posts hook in
     * app/filters.php.
     *
     * @return array
     */
    public function with()
    {
        global $wp_query;

        return [
            'posts' => array_map('\App\weavira_journal_card', $wp_query->posts),
            'totalCount' => (int) $wp_query->found_posts,
            'currentPage' => max(1, (int) get_query_var('paged')),
            'maxPages' => (int) $wp_query->max_num_pages,
            'categories' => $this->categories(),
            'activeFilterCount' => count($this->chosenSlugs()),
        ];
    }

    /**
     * Comma-separated filter_category query var, exploded.
     *
     * @return array
     */
    protected function chosenSlugs()
    {
        $raw = $_GET['filter_category'] ?? '';

        if (!is_string($raw) || $raw === '') {
            return [];
        }

        return array_map('sanitize_title', explode(',', sanitize_text_field(wp_unslash($raw))));
    }

    /**
     * journal_category terms, scoped to published Journal posts.
     *
     * @return array
     */
    protected function categories()
    {
        $terms = get_terms([
            'taxonomy' => 'journal_category',
            'hide_empty' => true,
        ]);

        if (is_wp_error($terms) || empty($terms)) {
            return [];
        }

        $chosen = $this->chosenSlugs();

        return array_map(function ($term) use ($chosen) {
            return [
                'name' => html_entity_decode($term->name, ENT_QUOTES),
                'slug' => $term->slug,
                'count' => $term->count,
                'checked' => in_array($term->slug, $chosen, true),
            ];
        }, $terms);
    }
}
