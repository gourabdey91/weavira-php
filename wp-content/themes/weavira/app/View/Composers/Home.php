<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Home extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'template-home',
    ];

    /**
     * Data to be passed to view before rendering. Each row of the
     * home_sections flexible content field is passed through as-is, plus
     * (for the sections backed by real data — products, Journal posts,
     * Heritage Designs) an extra key of resolved content the partial can
     * render directly, so business logic stays out of Blade.
     *
     * @return array
     */
    public function with()
    {
        $postId = get_the_ID();
        $rows = get_field('home_sections', $postId) ?: [];
        $rows = array_values(array_filter($rows, function ($row, $index) use ($postId) {
            return !$this->isLayoutDisabled($postId, $index);
        }, ARRAY_FILTER_USE_BOTH));

        return [
            'sections' => array_map([$this, 'enrich'], $rows),
        ];
    }

    /**
     * ACF Pro's flexible content "Disable Layout" editor feature stores
     * which rows are disabled in a separate `_{field}_layout_meta` postmeta
     * entry (e.g. `{"disabled":[3],"renamed":[]}`, keyed by 0-based row
     * index) rather than in the field's own row data — get_field() returns
     * disabled rows exactly like enabled ones, so without this check a
     * "disabled" section still rendered on the live page.
     *
     * @return bool
     */
    protected function isLayoutDisabled($postId, $rowIndex)
    {
        $layoutMeta = get_post_meta($postId, '_home_sections_layout_meta', true);
        $disabledIndexes = $layoutMeta['disabled'] ?? [];

        return in_array($rowIndex, $disabledIndexes, true);
    }

    /**
     * @return array
     */
    protected function enrich($row)
    {
        switch ($row['acf_fc_layout'] ?? '') {
            case 'new_arrivals':
                $row['products'] = $this->newestProducts((int) ($row['products_count'] ?: 8));
                break;

            case 'weavira_favorites':
                $row['products'] = $this->bestSellingProducts((int) ($row['products_count'] ?: 7));
                break;

            case 'discover_designs':
                $row['designs'] = $this->heritageDesigns((int) ($row['designs_count'] ?: 8));
                break;

            case 'journal_section':
                $journal = $this->journalPosts();
                $row['featuredPost'] = $journal['featured'];
                $row['posts'] = $journal['list'];
                break;
        }

        return $row;
    }

    /**
     * @return \WC_Product[]
     */
    protected function newestProducts($limit)
    {
        return wc_get_products([
            'limit' => $limit,
            'status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
        ]);
    }

    /**
     * @return \WC_Product[]
     */
    protected function bestSellingProducts($limit)
    {
        $products = wc_get_products([
            'limit' => $limit,
            'status' => 'publish',
            'orderby' => 'meta_value_num',
            'meta_key' => 'total_sales',
            'order' => 'DESC',
        ]);

        if (!empty($products)) {
            return $products;
        }

        // No sales recorded yet anywhere — fall back to newest so the
        // section isn't empty rather than fabricating a "bestseller".
        return $this->newestProducts($limit);
    }

    /**
     * @return array
     */
    protected function heritageDesigns($limit)
    {
        $posts = get_posts([
            'post_type' => 'heritage_design',
            'posts_per_page' => $limit,
            'orderby' => 'date',
            'order' => 'DESC',
        ]);

        return array_map('\App\weavira_heritage_design_card', $posts);
    }

    /**
     * Featured Journal entry (checked "Editor's Pick", or most recent) plus
     * the 3 next-latest entries for the list — same selection rules as the
     * header's Journal mega menu.
     *
     * @return array ['featured' => array|null, 'list' => array]
     */
    protected function journalPosts()
    {
        $featured = get_posts([
            'post_type' => 'journal',
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'meta_key' => 'journal_is_featured',
            'meta_value' => '1',
            'no_found_rows' => true,
        ]);

        $latest = get_posts([
            'post_type' => 'journal',
            'post_status' => 'publish',
            'posts_per_page' => 4,
            'no_found_rows' => true,
        ]);

        $featuredPost = $featured[0] ?? ($latest[0] ?? null);

        $list = array_filter($latest, function ($post) use ($featuredPost) {
            return !$featuredPost || $post->ID !== $featuredPost->ID;
        });

        return [
            'featured' => $featuredPost ? \App\weavira_journal_card($featuredPost) : null,
            'list' => array_map('\App\weavira_journal_card', array_slice(array_values($list), 0, 3)),
        ];
    }
}
