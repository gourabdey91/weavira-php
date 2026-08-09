<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class HeritageDesigns extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'archive-heritage_design',
    ];

    /**
     * @var int
     */
    protected static $perPage = 8;

    /**
     * Data to be passed to view before rendering. filter_motif/inspiration/
     * weave/color are applied to the main query by the pre_get_posts hook
     * in app/filters.php — "Most Designs" sorting is the one exception,
     * handled entirely here since it orders by a computed value (related
     * product count) WP_Query has no column for.
     *
     * @return array
     */
    public function with()
    {
        global $wp_query;

        $currentSort = isset($_GET['orderby']) ? sanitize_text_field(wp_unslash($_GET['orderby'])) : 'menu_order';

        if ($currentSort === 'most-designs') {
            [$posts, $totalCount, $currentPage, $maxPages] = $this->mostDesignsQuery();
        } else {
            $posts = $wp_query->posts;
            $totalCount = (int) $wp_query->found_posts;
            $currentPage = max(1, (int) get_query_var('paged'));
            $maxPages = (int) $wp_query->max_num_pages;
        }

        return [
            'cards' => array_map([$this, 'cardData'], $posts),
            'totalCount' => $totalCount,
            'currentPage' => $currentPage,
            'maxPages' => $maxPages,
            'filterGroups' => $this->filterGroups(),
            'colourSwatches' => $this->colourSwatches(),
            'currentSort' => $currentSort,
            'activeFilterCount' => $this->activeFilterCount(),
        ];
    }

    /**
     * Comma-separated `filter_{param}` query var, exploded — same
     * convention the Shop page uses.
     *
     * @return array
     */
    protected function chosenSlugs($param)
    {
        $raw = $_GET['filter_' . $param] ?? '';

        if (!is_string($raw) || $raw === '') {
            return [];
        }

        return array_map('sanitize_title', explode(',', sanitize_text_field(wp_unslash($raw))));
    }

    /**
     * Every Heritage Design post, unfiltered — the base set facet counts
     * are computed against, cached for the duration of the request.
     *
     * @return \WP_Post[]
     */
    protected function allMotifPosts()
    {
        static $posts;

        if ($posts === null) {
            $posts = get_posts([
                'post_type' => 'heritage_design',
                'posts_per_page' => -1,
                'orderby' => 'title',
                'order' => 'ASC',
            ]);
        }

        return $posts;
    }

    /**
     * Term usage counts scoped to Heritage Design posts specifically.
     * pa_weave/pa_body-primary-colour are shared with WooCommerce products,
     * so a term's own ->count (used by the Shop page) would double as
     * "how many products", not "how many motifs" — this counts by hand
     * against just this post type instead.
     *
     * @return array term_id => count
     */
    protected function taxonomyCounts($taxonomy)
    {
        $counts = [];

        foreach ($this->allMotifPosts() as $post) {
            foreach (wp_get_post_terms($post->ID, $taxonomy) as $term) {
                $counts[$term->term_id] = ($counts[$term->term_id] ?? 0) + 1;
            }
        }

        return $counts;
    }

    /**
     * Real product count for a motif, via its related Design attribute
     * term — 0 (not fabricated) when no matching product attribute exists
     * yet.
     *
     * @return int
     */
    protected function designCount($post)
    {
        $termId = get_field('related_design_attribute', $post->ID);

        if (!$termId) {
            return 0;
        }

        $term = get_term($termId, 'pa_design');

        return ($term && !is_wp_error($term)) ? (int) $term->count : 0;
    }

    /**
     * @return array
     */
    protected function cardData($post)
    {
        return \App\weavira_heritage_design_card($post);
    }

    /**
     * tax_query array built from the same filter_* params the
     * pre_get_posts hook reads, reused here since "Most Designs" runs its
     * own separate WP_Query.
     *
     * @return array
     */
    protected function buildTaxQuery()
    {
        $taxQuery = [];
        $map = ['inspiration' => 'heritage_inspiration', 'weave' => 'pa_weave', 'color' => 'pa_body-primary-colour'];

        foreach ($map as $param => $taxonomy) {
            $slugs = $this->chosenSlugs($param);

            if (empty($slugs)) {
                continue;
            }

            $taxQuery[] = ['taxonomy' => $taxonomy, 'field' => 'slug', 'terms' => $slugs];
        }

        if (count($taxQuery) > 1) {
            $taxQuery['relation'] = 'AND';
        }

        return $taxQuery;
    }

    /**
     * "Most Designs": fetch every matching post (ignoring DB-level
     * pagination), sort by real design count in PHP, then paginate by
     * hand. The dataset is small (a handful of motifs), so this stays
     * cheap.
     *
     * @return array [posts, totalCount, currentPage, maxPages]
     */
    protected function mostDesignsQuery()
    {
        $args = [
            'post_type' => 'heritage_design',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'no_found_rows' => true,
        ];

        $taxQuery = $this->buildTaxQuery();

        if (!empty($taxQuery)) {
            $args['tax_query'] = $taxQuery;
        }

        $motifSlugs = $this->chosenSlugs('motif');

        if (!empty($motifSlugs)) {
            $args['post_name__in'] = $motifSlugs;
        }

        $posts = (new \WP_Query($args))->posts;

        usort($posts, function ($a, $b) {
            return $this->designCount($b) <=> $this->designCount($a);
        });

        $totalCount = count($posts);
        $currentPage = max(1, (int) get_query_var('paged'));
        $maxPages = max(1, (int) ceil($totalCount / static::$perPage));

        return [
            array_slice($posts, ($currentPage - 1) * static::$perPage, static::$perPage),
            $totalCount,
            $currentPage,
            $maxPages,
        ];
    }

    /**
     * Sidebar checkbox filter groups: Motif/Design (one per Heritage
     * Design entry), Inspiration, and Weave.
     *
     * @return array
     */
    protected function filterGroups()
    {
        $groups = [];
        $chosenMotifs = $this->chosenSlugs('motif');

        $groups[] = [
            'slug' => 'motif',
            'label' => 'Motif / Design',
            'terms' => array_map(function ($post) use ($chosenMotifs) {
                return [
                    'name' => html_entity_decode(get_the_title($post), ENT_QUOTES),
                    'slug' => $post->post_name,
                    'count' => $this->designCount($post),
                    'checked' => in_array($post->post_name, $chosenMotifs, true),
                ];
            }, $this->allMotifPosts()),
        ];

        $taxonomyGroups = [
            'inspiration' => ['taxonomy' => 'heritage_inspiration', 'label' => 'Inspiration'],
            'weave' => ['taxonomy' => 'pa_weave', 'label' => 'Weave'],
        ];

        foreach ($taxonomyGroups as $param => $meta) {
            $counts = $this->taxonomyCounts($meta['taxonomy']);

            if (empty($counts)) {
                continue;
            }

            $terms = get_terms(['taxonomy' => $meta['taxonomy'], 'hide_empty' => false, 'include' => array_keys($counts)]);

            if (is_wp_error($terms) || empty($terms)) {
                continue;
            }

            $chosen = $this->chosenSlugs($param);

            $groups[] = [
                'slug' => $param,
                'label' => $meta['label'],
                'terms' => array_map(function ($term) use ($counts, $chosen) {
                    return [
                        'name' => html_entity_decode($term->name, ENT_QUOTES),
                        'slug' => $term->slug,
                        'count' => $counts[$term->term_id] ?? 0,
                        'checked' => in_array($term->slug, $chosen, true),
                    ];
                }, $terms),
            ];
        }

        return $groups;
    }

    /**
     * Body Primary Colour swatches, counted against Heritage Design usage
     * only (see taxonomyCounts()) rather than the shared taxonomy's
     * product-inclusive term count.
     *
     * @return array
     */
    protected function colourSwatches()
    {
        $taxonomy = 'pa_body-primary-colour';
        $counts = $this->taxonomyCounts($taxonomy);

        if (empty($counts)) {
            return [];
        }

        $terms = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => false, 'include' => array_keys($counts)]);

        if (is_wp_error($terms) || empty($terms)) {
            return [];
        }

        $chosen = $this->chosenSlugs('color');

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
     * @return int
     */
    protected function activeFilterCount()
    {
        return count($this->chosenSlugs('motif'))
            + count($this->chosenSlugs('inspiration'))
            + count($this->chosenSlugs('weave'))
            + count($this->chosenSlugs('color'));
    }
}
