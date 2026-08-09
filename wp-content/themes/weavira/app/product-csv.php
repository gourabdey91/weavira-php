<?php

/**
 * Product bulk import / export.
 *
 * This does not implement a custom CSV parser — it extends WooCommerce's
 * own Product CSV Importer / Exporter (Products > Import / Export), which
 * already handles every attribute taxonomy this store uses via its
 * "Attribute N name/value" columns, and every scalar ACF field via its
 * "Export custom meta" checkbox + "meta:{key}" import column convention.
 * This file only adds a discoverable theme admin page documenting that
 * format, a sample CSV template, and one correctness fix: re-applying the
 * known ACF keys through update_field() after import so ACF's field
 * reference meta is created properly instead of relying on its
 * find-by-name fallback.
 */

namespace App;

/**
 * Scalar "Product Details" ACF fields (see acf-json/group_97086ebcb03a0.json)
 * that round-trip through WooCommerce's CSV "Meta: {key}" column
 * convention. The two repeater fields on that field group (Design Detail
 * Cards, Search Keywords) are intentionally excluded — a flat CSV column
 * can't cleanly represent repeater rows.
 */
const PRODUCT_CSV_ACF_FIELDS = [
    'segment' => 'Product badge, e.g. "Classic" or "New Arrival"',
    'mercerised' => 'Mercerised — Yes or No',
    'weaving_team_size' => 'Weaving team size (number of artisans)',
    'weaving_hours' => 'Weaving hours',
    'weaving_description' => 'Weaving description — overrides the auto-generated team/hours sentence when set',
    'length_meters' => 'Length in metres, excluding blouse piece',
    'net_weight' => 'Net weight (grams)',
    'gross_weight' => 'Gross weight (grams)',
    'wash_care' => 'Wash care instructions',
    'custom_vocabulary' => 'Custom vocabulary (site search synonym)',
    'feel_kicker' => 'Feel section kicker text',
    'feel_scale_value' => 'Feel scale value',
    'feel_body' => 'Feel section description',
    'product_video' => 'Weaving process video — URL of a file already in the Media Library',
    'product_video_poster' => 'Video poster image — Media Library attachment ID',
    'feel_image' => 'Feel section image — Media Library attachment ID',
];

/**
 * Attribute taxonomies (without the pa_ prefix) — matches
 * App\View\Composers\Product::$attributeTaxonomies. These already work
 * through WooCommerce's native "Attribute N name/value(s)" CSV columns.
 */
const PRODUCT_CSV_ATTRIBUTE_TAXONOMIES = [
    'material', 'tissue-type', 'cotton-type', 'warp-thread-type', 'weft-thread-type',
    'weave', 'design', 'theme', 'cluster', 'border-design', 'border-colour', 'border-width',
    'body-primary-colour', 'body-secondary-colour', 'blouse-piece', 'pre-stitched',
    'occasion', 'return-eligibility', 'loom-type',
];

/**
 * Priority 999 — deliberately late. If this submenu is the *first* one
 * registered for the "theme-settings" parent, WordPress auto-inserts a
 * link back to the parent page as the first submenu item using whatever
 * is (or isn't yet) in the $menu array at that moment; registering after
 * ACF has already added its own Global Settings / Header / Footer pages
 * avoids becoming that accidental first/default entry and pushing
 * "Global Settings" out of the way.
 */
add_action('admin_menu', function () {
    add_submenu_page(
        'theme-settings',
        'Product Import / Export',
        'Import / Export',
        'manage_woocommerce',
        'weavira-product-csv',
        'App\\product_csv_render_page'
    );
}, 999);

/**
 * Renders the "Import / Export" theme settings page.
 */
function product_csv_render_page()
{
    $importer_url = admin_url('edit.php?post_type=product&page=product_importer');
    $exporter_url = admin_url('edit.php?post_type=product&page=product_exporter');
    $template_url = wp_nonce_url(
        admin_url('admin-post.php?action=weavira_download_product_csv_template'),
        'weavira_download_product_csv_template'
    );
    ?>
    <div class="wrap">
        <h1>Product Import / Export</h1>
        <p>Bulk product import and export runs through WooCommerce's built-in CSV tools — this page just documents the extra columns this store uses and gives you a ready-made template.</p>

        <p style="margin: 1.5em 0;">
            <a href="<?php echo esc_url($importer_url); ?>" class="button button-primary">Import Products</a>
            <a href="<?php echo esc_url($exporter_url); ?>" class="button button-primary">Export Products</a>
            <a href="<?php echo esc_url($template_url); ?>" class="button">Download Sample CSV Template</a>
        </p>

        <div class="notice notice-warning inline" style="margin: 0 0 1.5em; padding: 12px;">
            <p style="margin: 0;"><strong>When exporting</strong>, tick "Export custom meta? &mdash; Yes, export all custom meta" on the export screen, or the fields below won't be included in the file.</p>
        </div>

        <h2>Attribute columns</h2>
        <p>Use WooCommerce's own <code>Attribute 1 name</code> / <code>Attribute 1 value(s)</code> / <code>Attribute 1 visible</code> / <code>Attribute 1 global</code> columns (repeat for Attribute 2, 3, &hellip;). Set <code>global</code> to <code>1</code> so it maps to the shared attribute taxonomy rather than a one-off custom attribute.</p>
        <table class="widefat striped" style="max-width: 700px;">
            <thead><tr><th>Attribute name</th><th>Taxonomy</th></tr></thead>
            <tbody>
                <?php foreach (PRODUCT_CSV_ATTRIBUTE_TAXONOMIES as $slug): ?>
                    <tr>
                        <td><?php echo esc_html(ucwords(str_replace('-', ' ', $slug))); ?></td>
                        <td><code>pa_<?php echo esc_html($slug); ?></code></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2 style="margin-top: 2em;">Custom field ("Meta:") columns</h2>
        <p>These come from every product's "Product Details" fields. On export they appear as <code>Meta: {key}</code> columns; on import, a column header of <code>meta:{key}</code> (case-insensitive) maps to the same field.</p>
        <table class="widefat striped" style="max-width: 900px;">
            <thead><tr><th>Column</th><th>What it controls</th></tr></thead>
            <tbody>
                <?php foreach (PRODUCT_CSV_ACF_FIELDS as $key => $description): ?>
                    <tr>
                        <td><code>meta:<?php echo esc_html($key); ?></code></td>
                        <td><?php echo esc_html($description); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="notice notice-info inline" style="margin: 1.5em 0; padding: 12px; max-width: 900px;">
            <p style="margin: 0;"><strong>Not covered by CSV:</strong> Design Detail Cards and Search Keywords (both repeater fields) can't be represented in a flat CSV column. Set those per-product on the normal product edit screen.</p>
        </div>
    </div>
    <?php
}

/**
 * Streams a one-row sample CSV built from a real, fully-filled-in product
 * so the column names and an example value are both visible at a glance.
 */
add_action('admin_post_weavira_download_product_csv_template', function () {
    if (!current_user_can('manage_woocommerce') || !check_admin_referer('weavira_download_product_csv_template')) {
        wp_die(__('You do not have permission to do this.', 'sage'));
    }

    $sample = wc_get_products(['limit' => 1, 'status' => 'publish', 'orderby' => 'ID', 'order' => 'ASC']);
    $product = $sample[0] ?? null;

    $headers = ['SKU', 'Name', 'Regular price'];
    $row = [
        $product ? $product->get_sku() : '100099',
        $product ? $product->get_name() : 'Sample Saree Name',
        $product ? $product->get_regular_price() : '9990',
    ];

    $i = 1;
    foreach (PRODUCT_CSV_ATTRIBUTE_TAXONOMIES as $slug) {
        $terms = $product ? get_the_terms($product->get_id(), 'pa_' . $slug) : null;
        $value = ($terms && !is_wp_error($terms)) ? implode(', ', wp_list_pluck($terms, 'name')) : '';

        if ($value === '') {
            continue;
        }

        $headers[] = "Attribute {$i} name";
        $headers[] = "Attribute {$i} value(s)";
        $headers[] = "Attribute {$i} visible";
        $headers[] = "Attribute {$i} global";
        $row[] = ucwords(str_replace('-', ' ', $slug));
        $row[] = $value;
        $row[] = '1';
        $row[] = '1';
        $i++;
    }

    foreach (PRODUCT_CSV_ACF_FIELDS as $key => $description) {
        $value = $product ? get_field($key, $product->get_id()) : '';
        $headers[] = 'meta:' . $key;
        $row[] = is_scalar($value) ? $value : '';
    }

    nocache_headers();
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="weavira-product-import-template.csv"');

    $out = fopen('php://output', 'w');
    fputcsv($out, $headers);
    fputcsv($out, $row);
    fclose($out);
    exit;
});

/**
 * WooCommerce's CSV importer writes "meta:{key}" columns straight to
 * postmeta via update_post_meta(), not through ACF's update_field(). That
 * still resolves correctly on read via ACF's find-by-name fallback, but
 * re-applying it through the real ACF API here creates the proper field
 * reference meta instead of relying on that fallback.
 */
add_action('woocommerce_product_import_inserted_product_object', function ($object) {
    foreach (array_keys(PRODUCT_CSV_ACF_FIELDS) as $key) {
        $value = $object->get_meta($key, true);

        if ($value !== '' && $value !== null) {
            update_field($key, $value, $object->get_id());
        }
    }
}, 10, 1);
