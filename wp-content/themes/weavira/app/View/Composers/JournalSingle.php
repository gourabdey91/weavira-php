<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class JournalSingle extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'single-journal',
    ];

    /**
     * Each row of the journal_sections flexible content field is passed
     * through as-is, plus (for the sections backed by Post Object /
     * Product references) resolved real data the partial can render
     * directly, so business logic stays out of Blade.
     *
     * @return array
     */
    public function with()
    {
        $rows = get_field('journal_sections') ?: [];

        return [
            'sections' => array_map([$this, 'enrich'], $rows),
        ];
    }

    /**
     * @return array
     */
    protected function enrich($row)
    {
        switch ($row['acf_fc_layout'] ?? '') {
            case 'collection_carousel':
                $row['resolvedProducts'] = $this->resolveProducts($row['products'] ?? []);
                break;

            case 'related_articles':
            case 'continue_reading':
                $row['resolvedArticles'] = $this->resolveArticles($row['articles'] ?? []);
                break;
        }

        return $row;
    }

    /**
     * @return \WC_Product[]
     */
    protected function resolveProducts($items)
    {
        $products = array_map(function ($item) {
            $id = $item['product'] ?? null;

            return $id ? wc_get_product($id) : null;
        }, $items);

        return array_values(array_filter($products));
    }

    /**
     * @return array
     */
    protected function resolveArticles($items)
    {
        $articles = array_map(function ($item) {
            $id = $item['article'] ?? null;
            $post = $id ? get_post($id) : null;

            return $post ? \App\weavira_journal_card($post) : null;
        }, $items);

        return array_values(array_filter($articles));
    }
}
