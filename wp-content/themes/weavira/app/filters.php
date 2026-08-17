<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});

/**
 * Route WooCommerce templates through Blade.
 *
 * WooCommerce's own `template_include` filter (priority 10) resolves product
 * pages to a PHP file in the theme root's `woocommerce/` folder — it has no
 * awareness of Acorn's `resources/views` Blade pipeline. Running before
 * Acorn's own `template_include` filter (priority 100), this hands back a
 * path that IS inside `resources/views`, so Acorn resolves it to the Blade
 * view the same way it already does for every other page in this theme.
 */
add_filter('template_include', function ($template) {
    if (function_exists('is_product') && is_product()) {
        $blade = get_theme_file_path('resources/views/woocommerce/single-product.blade.php');
        if (file_exists($blade)) {
            return $blade;
        }
    }

    if (function_exists('is_cart') && is_cart()) {
        $blade = get_theme_file_path('resources/views/woocommerce/cart.blade.php');
        if (file_exists($blade)) {
            return $blade;
        }
    }

    // Only the main checkout form — order-pay/order-received/add-payment-method
    // endpoints keep WooCommerce's own templates.
    if (function_exists('is_checkout') && is_checkout() && !is_wc_endpoint_url()) {
        $blade = get_theme_file_path('resources/views/woocommerce/checkout.blade.php');
        if (file_exists($blade)) {
            return $blade;
        }
    }

    if (function_exists('is_shop') && (is_shop() || is_product_taxonomy())) {
        $blade = get_theme_file_path('resources/views/woocommerce/archive-product.blade.php');
        if (file_exists($blade)) {
            return $blade;
        }
    }

    // Full-screen "Moments" story viewer (mobile bottom-nav → Moments) — same
    // distraction-free, no-header/footer treatment as checkout.blade.php.
    if (is_page('moments')) {
        $blade = get_theme_file_path('resources/views/page-moments.blade.php');
        if (file_exists($blade)) {
            return $blade;
        }
    }

    return $template;
}, 20);

/**
 * Move the coupon form out of its default position at the very top of the
 * checkout page, into the Order Summary sidebar (between the item list and
 * the totals) — see checkout.blade.php, which calls
 * woocommerce_checkout_coupon_form() directly at that spot. The function
 * itself, its wc_coupons_enabled() guard, and WooCommerce's own toggle/AJAX
 * JS (checkout.js, keyed on the .showcoupon/.checkout_coupon/#coupon_code
 * selectors, not on markup structure) are untouched — only *where* it
 * renders changes. The restyled markup itself lives in the theme's
 * woocommerce/checkout/form-coupon.php override.
 */
add_action('init', function () {
    remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
});

/**
 * Drop the privacy policy text ("Your personal data will be used to
 * process your order...") from checkout entirely. WooCommerce's
 * checkout/terms.php template hooks this onto
 * woocommerce_checkout_terms_and_conditions at priority 20; the
 * terms-and-conditions checkbox (if enabled) is a separate block in that
 * same template and is untouched.
 */
add_action('init', function () {
    remove_action('woocommerce_checkout_terms_and_conditions', 'wc_checkout_privacy_policy_text', 20);
});

/**
 * "Place order" → "Pay ₹24,000.00" — the button states the exact amount
 * being charged instead of a generic label. Reuses WC()->cart->get_total(),
 * the same source the sidebar's Total row is built from, so the two always
 * agree; wp_strip_all_tags() drops its currency-amount <span> wrapper since
 * the button text/value/data-value attributes are escaped as plain text.
 */
add_filter('woocommerce_order_button_text', function ($text) {
    if (!function_exists('WC') || !WC()->cart) {
        return $text;
    }

    return sprintf(__('Pay %s', 'sage'), wp_strip_all_tags(WC()->cart->get_total()));
});

/**
 * The checkout page is a distraction-free flow with its own minimal header
 * (see checkout.blade.php) instead of the site's normal header/mega-menu/
 * footer, so it skips the `inner` body class those expect and gets its own
 * background hook instead. The Moments story viewer gets the same
 * treatment, plus its own scroll-lock class (see main.css .moments-page).
 */
add_filter('body_class', function ($classes) {
    if (function_exists('is_checkout') && is_checkout() && !is_wc_endpoint_url()) {
        $classes[] = 'ck-body';
    }

    if (is_page('moments')) {
        $classes[] = 'ck-body';
        $classes[] = 'moments-page';
    }

    return $classes;
});

/**
 * "Buy It Now": add to cart, then skip the cart page and go straight to checkout.
 */
add_filter('woocommerce_add_to_cart_redirect', function ($url) {
    if (!empty($_REQUEST['weavira_buy_now'])) {
        return wc_get_checkout_url();
    }

    return $url;
});

add_filter('woocommerce_product_single_add_to_cart_text', function () {
    return __('Add to Bag', 'sage');
});

/**
 * Cart badge fragment for AJAX add-to-cart. The header and mobile topbar
 * both render a `.wv-cart-badge` span (see sections/header.blade.php) that
 * this keeps in sync without a page reload — see the "Add to Bag" handler
 * in public/js/weavira.js for the request side.
 */
add_filter('woocommerce_add_to_cart_fragments', function ($fragments) {
    $count = WC()->cart->get_cart_contents_count();
    $label = $count . ' item' . ($count === 1 ? '' : 's');

    $fragments['.wv-cart-badge'] = sprintf(
        '<span class="nav-badge wv-cart-badge" aria-label="%s"%s>%d</span>',
        esc_attr($label),
        $count > 0 ? '' : ' hidden',
        $count
    );

    return $fragments;
});

/**
 * Colour swatches instead of a dropdown for variation attributes that have
 * a swatch colour set (see Mega Menu Swatch, acf-json/group_69f7c1b5e308a
 * — same term-level field the header's "Shop by Colour" list uses). The
 * real <select> WooCommerce needs for its own variation-matching JS is
 * kept in the markup, just visually hidden — see the swatch click handler
 * in public/js/weavira.js, which drives it via a "change" event.
 */
add_filter('woocommerce_dropdown_variation_attribute_options_html', function ($html, $args) {
    $taxonomy = $args['attribute'] ?? '';

    if (!in_array($taxonomy, ['pa_body-primary-colour', 'pa_body-secondary-colour'], true)) {
        return $html;
    }

    $options = $args['options'] ?: [];

    if (empty($options) && !empty($args['product']) && !empty($taxonomy)) {
        $attributes = $args['product']->get_variation_attributes();
        $options = $attributes[$taxonomy] ?? [];
    }

    if (empty($options)) {
        return $html;
    }

    $selected = $args['selected'] ?: '';

    ob_start(); ?>
        <div class="wv-variation-swatches">
            <?php echo $html; // phpcs:ignore -- the real <select>, kept for WC's own variation JS ?>
            <div class="wv-swatch-row" role="listbox" aria-label="<?php echo esc_attr(wc_attribute_label($taxonomy)); ?>">
                <?php foreach ($options as $slug):
                    $term = get_term_by('slug', $slug, $taxonomy);
                    if (!$term) {
                        continue;
                    }
                    $hex = get_field('swatch_color', $taxonomy . '_' . $term->term_id) ?: '#cccccc';
                    $isSelected = ($selected === $slug);
                ?>
                    <button type="button"
                        class="wv-swatch<?php echo $isSelected ? ' wv-swatch--selected' : ''; ?>"
                        data-value="<?php echo esc_attr($slug); ?>"
                        title="<?php echo esc_attr($term->name); ?>"
                        aria-label="<?php echo esc_attr($term->name); ?>"
                        aria-pressed="<?php echo $isSelected ? 'true' : 'false'; ?>">
                        <span class="wv-swatch-dot" style="background:<?php echo esc_attr($hex); ?>"></span>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    <?php
    return ob_get_clean();
}, 10, 2);

/**
 * Force WooCommerce's real review template on product pages.
 *
 * Acorn's own `comments_template` filter (registered by the Sage bridge)
 * unconditionally swaps in `partials.comments` — a generic blog-comments
 * Blade view — whenever it runs after WooCommerce's filter, which silently
 * replaces the actual review list/rating form with the wrong template.
 * Running at a very late priority guarantees this has the final say.
 */
add_filter('comments_template', function ($template) {
    if (function_exists('is_product') && is_product() && function_exists('wc_locate_template')) {
        $wc_template = wc_locate_template('single-product-reviews.php');
        if ($wc_template && file_exists($wc_template)) {
            return $wc_template;
        }
    }

    return $template;
}, 999);

/**
 * Restyle the "write a review" form to match the PDP mockup's custom
 * star-rating + upload widget, while still submitting through WooCommerce's
 * real comment/review handling (same field names: `rating`, `comment`).
 *
 * Photo selection only builds a client-side preview (public/js/weavira.js
 * already does this) — files are not actually uploaded/attached to the
 * review yet, since WooCommerce reviews have no native photo-attachment
 * support without a plugin.
 */
add_filter('woocommerce_product_review_comment_form_args', function ($args) {
    $args['title_reply'] = __('Write a Review', 'sage');
    $args['title_reply_before'] = '<h4 id="reply-title" class="review-write-heading">';
    $args['title_reply_after'] = '</h4>';
    $args['class_submit'] = 'review-submit';
    $args['label_submit'] = __('Submit Review', 'sage');
    $args['submit_button'] = '<button name="%1$s" type="submit" id="%2$s" class="%3$s">%4$s</button>';

    ob_start();
    ?>
    <p class="review-write-sub"><?php esc_html_e('Your Rating', 'sage'); ?></p>
    <div class="review-star-rating" role="radiogroup" aria-label="<?php esc_attr_e('Rate this product', 'sage'); ?>">
        <?php for ($i = 5; $i >= 1; $i--): ?>
            <input type="radio" id="star<?php echo esc_attr($i); ?>" name="rating" value="<?php echo esc_attr($i); ?>" class="star-input">
            <label for="star<?php echo esc_attr($i); ?>" class="star-label" title="<?php echo esc_attr(sprintf(_n('%d star', '%d stars', $i, 'sage'), $i)); ?>">&#9733;</label>
        <?php endfor; ?>
    </div>
    <textarea name="comment" id="comment" class="review-textarea" placeholder="<?php esc_attr_e('Share your experience with this saree…', 'sage'); ?>" rows="4" required></textarea>
    <div class="review-upload">
        <input type="file" id="review-photos" name="review_photos[]" accept="image/*" multiple class="review-photo-input" aria-label="<?php esc_attr_e('Add photos to your review', 'sage'); ?>">
        <label for="review-photos" class="review-upload-btn">
            <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true">
                <rect x="1" y="5" width="18" height="13" rx="1.5"/>
                <circle cx="10" cy="12" r="3"/>
                <path d="M7 5V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v1"/>
            </svg>
            <?php esc_html_e('Add Photos', 'sage'); ?>
        </label>
        <span class="review-upload-hint"><?php esc_html_e('Up to 5 · JPG or PNG', 'sage'); ?></span>
    </div>
    <div class="review-photo-preview" id="review-photo-preview" role="list" aria-label="<?php esc_attr_e('Selected photos', 'sage'); ?>"></div>
    <?php
    $args['comment_field'] = ob_get_clean();

    return $args;
});

/**
 * Render each review with the PDP mockup's own markup/classes
 * (.tab-review / .tab-review-stars / .tab-review-text / .tab-review-author)
 * instead of WooCommerce's default avatar+meta layout — reuses the CSS
 * that already ships in main.css, no new styles added.
 *
 * Uploaded review photos (see the `comment_post` handler below) are shown
 * as small thumbnails under the review text, reusing the same
 * `.review-photo-preview` / `.review-photo-thumb` classes the upload
 * widget's live preview already uses — no new CSS needed there either.
 */
add_filter('woocommerce_product_review_list_args', function ($args) {
    $args['callback'] = function ($comment, $args, $depth) {
        $rating = (int) get_comment_meta($comment->comment_ID, 'rating', true);
        $photo_ids = get_comment_meta($comment->comment_ID, 'review_photo_ids', true) ?: [];
        ?>
        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
            <div class="tab-review">
                <?php if ($rating > 0): ?>
                    <div class="tab-review-stars"><?php echo str_repeat('&#9733;', $rating); ?></div>
                <?php endif; ?>
                <p class="tab-review-text">&ldquo;<?php echo esc_html(get_comment_text()); ?>&rdquo;</p>
                <p class="tab-review-author">&mdash; <?php comment_author(); ?></p>
                <?php if (!empty($photo_ids)): ?>
                    <div class="review-photo-preview">
                        <?php foreach ($photo_ids as $attachment_id): ?>
                            <?php $url = wp_get_attachment_image_url($attachment_id, 'thumbnail'); ?>
                            <?php if ($url): ?>
                                <a href="<?php echo esc_url(wp_get_attachment_url($attachment_id)); ?>" class="review-photo-thumb" target="_blank" rel="noopener">
                                    <img src="<?php echo esc_url($url); ?>" alt="<?php esc_attr_e('Photo from reviewer', 'sage'); ?>">
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php
        // Closing </li> intentionally left out — Walker_Comment adds it.
    };

    return $args;
});

/**
 * Upload review photos to the Media Library and attach them to the review.
 *
 * comment_form() has no built-in support for file fields, so the form's
 * enctype is switched to multipart/form-data client-side (public/js/weavira.js).
 * Sideloaded via WordPress's own media_handle_sideload(), which validates
 * the actual file contents/type — not just the client-supplied MIME type.
 */
add_action('comment_post', function ($comment_id) {
    if (empty($_FILES['review_photos']['name']) || !is_array($_FILES['review_photos']['name'])) {
        return;
    }

    $comment = get_comment($comment_id);
    if (!$comment || get_post_type($comment->comment_post_ID) !== 'product') {
        return;
    }

    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';

    $allowed_types = ['image/jpeg', 'image/png'];
    $max_photos = 5;
    $attachment_ids = [];
    $files = $_FILES['review_photos'];
    $count = min(count($files['name']), $max_photos);

    for ($i = 0; $i < $count; $i++) {
        if ($files['error'][$i] !== UPLOAD_ERR_OK || empty($files['name'][$i])) {
            continue;
        }

        $file_type = wp_check_filetype($files['name'][$i]);
        if (!in_array($file_type['type'], $allowed_types, true)) {
            continue;
        }

        $file = [
            'name' => $files['name'][$i],
            'type' => $files['type'][$i],
            'tmp_name' => $files['tmp_name'][$i],
            'error' => $files['error'][$i],
            'size' => $files['size'][$i],
        ];

        $attachment_id = media_handle_sideload($file, $comment->comment_post_ID);

        if (!is_wp_error($attachment_id)) {
            $attachment_ids[] = $attachment_id;
        }
    }

    if (!empty($attachment_ids)) {
        add_comment_meta($comment_id, 'review_photo_ids', $attachment_ids);
    }
});

/**
 * AJAX review submission — same underlying WordPress/WooCommerce pipeline
 * as a normal POST (wp_new_comment() fires the same `comment_post` action,
 * so the photo-upload handler above runs unchanged), just without the
 * full-page reload. See public/js/custom.js for the request side.
 */
add_action('wp_ajax_weavira_submit_review', 'App\\weavira_handle_review_submission');
add_action('wp_ajax_nopriv_weavira_submit_review', 'App\\weavira_handle_review_submission');

function weavira_handle_review_submission()
{
    check_ajax_referer('weavira_submit_review', 'security');

    $product_id = isset($_POST['comment_post_ID']) ? absint($_POST['comment_post_ID']) : 0;

    if (!$product_id || get_post_type($product_id) !== 'product') {
        wp_send_json_error(['message' => __('Invalid product.', 'sage')], 400);
    }

    $content = isset($_POST['comment']) ? trim(wp_kses_post(wp_unslash($_POST['comment']))) : '';

    if ($content === '') {
        wp_send_json_error(['message' => __('Please write a review before submitting.', 'sage')], 400);
    }

    if (function_exists('wc_review_ratings_required') && wc_review_ratings_required() && empty($_POST['rating'])) {
        wp_send_json_error(['message' => __('Please select a rating.', 'sage')], 400);
    }

    $comment_data = [
        'comment_post_ID' => $product_id,
        'comment_content' => $content,
        'comment_type' => 'review',
        'comment_parent' => 0,
        'comment_author_url' => '',
    ];

    if (is_user_logged_in()) {
        $user = wp_get_current_user();
        $comment_data['user_id'] = $user->ID;
        $comment_data['comment_author'] = $user->display_name;
        $comment_data['comment_author_email'] = $user->user_email;
    } else {
        $author = isset($_POST['author']) ? sanitize_text_field(wp_unslash($_POST['author'])) : '';
        $email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';

        if (get_option('require_name_email', 1) && (empty($author) || !is_email($email))) {
            wp_send_json_error(['message' => __('Please provide your name and a valid email.', 'sage')], 400);
        }

        $comment_data['comment_author'] = $author;
        $comment_data['comment_author_email'] = $email;
    }

    $comment_id = wp_new_comment($comment_data, true);

    if (is_wp_error($comment_id)) {
        wp_send_json_error(['message' => $comment_id->get_error_message()], 400);
    }

    if (!empty($_POST['rating'])) {
        add_comment_meta($comment_id, 'rating', (int) $_POST['rating']);
    }

    $comment = get_comment($comment_id);
    $approved = $comment && (int) $comment->comment_approved === 1;

    $photo_ids = get_comment_meta($comment_id, 'review_photo_ids', true) ?: [];
    $photos = array_values(array_filter(array_map(function ($id) {
        return [
            'thumb' => wp_get_attachment_image_url($id, 'thumbnail'),
            'full' => wp_get_attachment_url($id),
        ];
    }, $photo_ids)));

    wp_send_json_success([
        'comment_id' => $comment_id,
        'rating' => isset($_POST['rating']) ? (int) $_POST['rating'] : 0,
        'comment' => wp_kses($content, []), // plain text for client-side rendering
        'author' => $comment_data['comment_author'],
        'photos' => $photos,
        'approved' => $approved,
        'message' => $approved
            ? __('Thank you for your review!', 'sage')
            : __('Thank you! Your review has been submitted and is awaiting approval.', 'sage'),
    ]);
}

/**
 * Mirror the "Search Keywords" repeater into a single flat meta value on
 * save, so it can be matched with a plain meta LIKE query — ACF repeater
 * sub-fields are stored under indexed keys (search_keywords_0_keyword, …),
 * which isn't something a meta_query can search across directly.
 */
add_action('acf/save_post', function ($post_id) {
    if (get_post_type($post_id) !== 'product') {
        return;
    }

    $rows = get_field('search_keywords', $post_id) ?: [];
    $keywords = implode(' ', array_filter(wp_list_pluck($rows, 'keyword')));

    update_post_meta($post_id, '_wv_search_keywords', $keywords);
}, 20);

/**
 * AJAX product search for the header/mobile search overlay. Matches a
 * product's title/content (native WP search) as well as its "Search
 * Keywords" field, so a product tagged "Bridal" or "Gift" surfaces for
 * those searches even if the words aren't in its title. See
 * public/js/weavira.js for the request side.
 */
add_action('wp_ajax_weavira_search_products', 'App\\weavira_handle_product_search');
add_action('wp_ajax_nopriv_weavira_search_products', 'App\\weavira_handle_product_search');

/**
 * Published product IDs matching a search term by title or by the curated
 * `_wv_search_keywords` synonym list (e.g. "Wedding" finding a saree whose
 * name doesn't literally contain that word) — shared by the search
 * overlay's live AJAX results and the Shop page's "View all results" link
 * below, so both surfaces agree on what counts as a match.
 *
 * @return int[]
 */
function weavira_search_product_ids($term)
{
    $base_args = [
        'post_type' => 'product',
        'post_status' => 'publish',
        'fields' => 'ids',
        'no_found_rows' => true,
        'posts_per_page' => -1,
    ];

    $title_matches = get_posts($base_args + ['s' => $term]);

    $keyword_matches = get_posts($base_args + [
        'meta_query' => [[
            'key' => '_wv_search_keywords',
            'value' => $term,
            'compare' => 'LIKE',
        ]],
    ]);

    return array_values(array_unique(array_merge($title_matches, $keyword_matches)));
}

function weavira_handle_product_search()
{
    check_ajax_referer('weavira_search_products', 'security');

    $term = isset($_GET['term']) ? sanitize_text_field(wp_unslash($_GET['term'])) : '';

    if ($term === '') {
        wp_send_json_success(['total' => 0, 'products' => []]);
    }

    $ids = weavira_search_product_ids($term);

    $products = array_map(function ($post_id) {
        $product = wc_get_product($post_id);

        $meta = array_filter([
            wp_list_pluck(get_the_terms($post_id, 'pa_design') ?: [], 'name')[0] ?? '',
            wp_list_pluck(get_the_terms($post_id, 'pa_material') ?: [], 'name')[0] ?? '',
        ]);

        return [
            'name' => $product->get_name(),
            'permalink' => $product->get_permalink(),
            'image' => wp_get_attachment_image_url($product->get_image_id(), 'thumbnail') ?: wc_placeholder_img_src('thumbnail'),
            'price_html' => wp_strip_all_tags($product->get_price_html()),
            'meta' => implode(' • ', $meta),
        ];
    }, array_slice($ids, 0, 3));

    wp_send_json_success([
        'total' => count($ids),
        // The Shop page (archive-product.blade.php), not WordPress's own
        // generic /?s= search results template — this theme never built
        // out search.blade.php, so that page renders unstyled. The `s`
        // param is picked up by the pre_get_posts hook below.
        'view_all_url' => add_query_arg('s', $term, wc_get_page_permalink('shop')),
        'products' => $products,
    ]);
}

/**
 * Shared response payload for the cart AJAX actions below — everything the
 * cart page's JS needs to refresh totals in place after a quantity change,
 * removal, or gift-details save, without a page reload.
 *
 * @return array
 */
function weavira_cart_totals_payload($cart_item_key = null)
{
    $cart = WC()->cart;
    $cart->calculate_totals();

    $isFreeShipping = false;

    if ($cart->needs_shipping()) {
        $cart->calculate_shipping();

        foreach (WC()->shipping()->get_packages() as $package) {
            foreach ($package['rates'] ?? [] as $rate) {
                if ($rate->method_id === 'free_shipping') {
                    $isFreeShipping = true;
                }
            }
        }
    }

    $taxRows = [];

    if (wc_tax_enabled()) {
        foreach ($cart->get_tax_totals() as $tax) {
            $taxRows[] = ['label' => $tax->label, 'amount' => $tax->formatted_amount];
        }
    }

    $lineTotal = null;

    if ($cart_item_key && isset($cart->cart_contents[$cart_item_key])) {
        $item = $cart->cart_contents[$cart_item_key];
        // Matches Cart.php's cartItems() — tax-inclusive, independent of the
        // woocommerce_tax_display_cart option (see comment there).
        $lineTotal = wc_price(wc_get_price_including_tax($item['data'], ['qty' => $item['quantity']]));
    }

    return [
        'cartCount' => $cart->get_cart_contents_count(),
        'isEmpty' => $cart->is_empty(),
        'subtotal' => $cart->get_cart_subtotal(),
        'isFreeShipping' => $isFreeShipping,
        'shippingLabel' => $isFreeShipping ? 'FREE' : '',
        'taxRows' => $taxRows,
        'total' => $cart->get_total(),
        'lineTotal' => $lineTotal,
    ];
}

/**
 * Placed-order summary (items/totals/address/notes), shaped so both the My
 * Account "Single Order" view and the Checkout thank-you page can render it
 * with the exact same .ck-order-item / .ck-summary-rows markup — reused
 * rather than duplicated per the project's one-pattern-per-UI rule.
 *
 * @return array
 */
function weavira_order_summary($order)
{
    $items = array_map(function ($item) use ($order) {
        $product = $item->get_product();

        return [
            'name' => $item->get_name(),
            'quantity' => $item->get_quantity(),
            'image' => $product ? (wp_get_attachment_image_url($product->get_image_id(), 'medium') ?: wc_placeholder_img_src('medium')) : wc_placeholder_img_src('medium'),
            'lineTotalHtml' => $order->get_formatted_line_subtotal($item),
        ];
    }, $order->get_items());

    $taxRows = array_map(function ($label, $amount) {
        return ['label' => $label, 'amount' => $amount];
    }, array_keys($order->get_tax_totals()), array_map(function ($tax) {
        return $tax->formatted_amount;
    }, $order->get_tax_totals()));

    return [
        'number' => $order->get_order_number(),
        'date' => wc_format_datetime($order->get_date_created()),
        'status' => wc_get_order_status_name($order->get_status()),
        'statusSlug' => $order->get_status(),
        'items' => $items,
        'subtotal' => wc_price($order->get_subtotal()),
        'shippingTotal' => $order->get_shipping_to_display() ?: __('Free', 'sage'),
        'taxRows' => $taxRows,
        'paymentMethod' => $order->get_payment_method_title(),
        'total' => $order->get_formatted_order_total(),
        'billingAddress' => $order->get_formatted_billing_address() ?: __('N/A', 'sage'),
        'notes' => array_map(function ($note) {
            return [
                'date' => date_i18n('l jS \o\f F Y, h:ia', strtotime($note->comment_date)),
                'content' => wpautop(wptexturize($note->comment_content)),
            ];
        }, $order->get_customer_order_notes()),
    ];
}

/**
 * AJAX quantity +/- for a cart line item. See the .cart-qty-btn handler in
 * public/js/weavira.js for the request side.
 */
add_action('wp_ajax_weavira_update_cart_item', 'App\\weavira_handle_cart_update_qty');
add_action('wp_ajax_nopriv_weavira_update_cart_item', 'App\\weavira_handle_cart_update_qty');

function weavira_handle_cart_update_qty()
{
    check_ajax_referer('weavira_cart_actions', 'security');

    $key = isset($_POST['cart_item_key']) ? sanitize_text_field(wp_unslash($_POST['cart_item_key'])) : '';
    $qty = isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : 0;

    if (!$key || !isset(WC()->cart->cart_contents[$key])) {
        wp_send_json_error(['message' => __('Cart item not found.', 'sage')], 400);
    }

    if ($qty < 1) {
        WC()->cart->remove_cart_item($key);
        wp_send_json_success(weavira_cart_totals_payload());
    }

    // Cap to available stock — set_quantity() itself doesn't check this, it's
    // only otherwise caught much later at checkout, which is too late for the
    // +/- buttons to give any feedback.
    $product = WC()->cart->cart_contents[$key]['data'];
    $stockMessage = null;

    if ($product->managing_stock() && !$product->backorders_allowed()) {
        $available = $product->get_stock_quantity();

        if ($available !== null && $qty > $available) {
            $qty = max(1, $available);
            $stockMessage = $available > 0
                ? sprintf(__('Only %d left in stock.', 'sage'), $available)
                : __('This item is out of stock.', 'sage');
        }
    }

    WC()->cart->set_quantity($key, $qty, true);

    $payload = weavira_cart_totals_payload($key);

    if ($stockMessage) {
        $payload['stockMessage'] = $stockMessage;
        $payload['quantity'] = $qty;
    }

    wp_send_json_success($payload);
}

/**
 * AJAX "Remove" for a cart line item.
 */
add_action('wp_ajax_weavira_remove_cart_item', 'App\\weavira_handle_cart_remove_item');
add_action('wp_ajax_nopriv_weavira_remove_cart_item', 'App\\weavira_handle_cart_remove_item');

function weavira_handle_cart_remove_item()
{
    check_ajax_referer('weavira_cart_actions', 'security');

    $key = isset($_POST['cart_item_key']) ? sanitize_text_field(wp_unslash($_POST['cart_item_key'])) : '';

    if (!$key || !isset(WC()->cart->cart_contents[$key])) {
        wp_send_json_error(['message' => __('Cart item not found.', 'sage')], 400);
    }

    WC()->cart->remove_cart_item($key);

    wp_send_json_success(weavira_cart_totals_payload());
}

/**
 * Shared "Gift For" / "Occasion" choices, used by the cart page's gift
 * form, the checkout page's gift review step, and the AJAX save handler
 * below — one list each instead of three copies to keep in sync.
 *
 * @return array
 */
function weavira_gift_for_options()
{
    return ['Wife', 'Girl Friend', 'Bestie', 'Friend', 'Teacher', 'Mother', 'Sister', 'Aunt', 'Sister in Law', 'Mother in Law', 'Niece', 'Daughter'];
}

/**
 * @return array
 */
function weavira_gift_occasion_options()
{
    return ['Anniversary', 'Birthday', 'Marriage', 'Festive Celebration', 'Just Because', 'Saying Thank You'];
}

/**
 * "EXCLUSIVE" / "BESTSELLER" / "NEW" corner badge, from real product
 * signals (Featured flag, sales count, publish date) rather than a manual
 * per-product choice — used on the Shop/PLP grid and the Wishlist page.
 * Most products carry none, matching the mockup.
 *
 * @return array|null ['label' => string, 'class' => string]
 */
function weavira_product_badge($product)
{
    if ($product->is_featured()) {
        return ['label' => 'EXCLUSIVE', 'class' => 'plp-badge--excl'];
    }

    if ($product->get_total_sales() >= 3) {
        return ['label' => 'BESTSELLER', 'class' => 'plp-badge--best'];
    }

    $daysOld = (time() - get_post_time('U', true, $product->get_id())) / DAY_IN_SECONDS;

    if ($daysOld <= 30) {
        return ['label' => 'NEW', 'class' => 'plp-badge--new'];
    }

    return null;
}

/**
 * Shared Heritage Design "card" shape — name, excerpt, image, real product
 * count + link via the motif's related Design attribute — used by both the
 * Heritage Designs archive and the home page's "Discover Designs" carousel.
 *
 * @return array
 */
function weavira_heritage_design_card($post)
{
    $termId = get_field('related_design_attribute', $post->ID);
    $term = $termId ? get_term($termId, 'pa_design') : null;
    $hasRealTerm = $term && !is_wp_error($term);

    return [
        'name' => html_entity_decode(get_the_title($post), ENT_QUOTES),
        'excerpt' => get_the_excerpt($post),
        'image' => get_the_post_thumbnail_url($post, 'medium') ?: wc_placeholder_img_src('medium'),
        'count' => $hasRealTerm ? (int) $term->count : 0,
        'link' => $hasRealTerm ? add_query_arg('filter_design', $term->slug, wc_get_page_permalink('shop')) : wc_get_page_permalink('shop'),
    ];
}

/**
 * Shared Journal "card" shape — title, excerpt, image, category, read time,
 * date, link — used by the home page's Journal section, the header's
 * Journal mega menu, and the Journal single template's Related
 * Articles / Continue Reading sections.
 *
 * @return array
 */
function weavira_journal_card($post)
{
    $categories = get_the_terms($post, 'journal_category');
    $category = ($categories && !is_wp_error($categories)) ? reset($categories) : null;

    return [
        'title' => html_entity_decode(get_the_title($post), ENT_QUOTES),
        'excerpt' => html_entity_decode(get_the_excerpt($post), ENT_QUOTES),
        'image' => get_the_post_thumbnail_url($post, 'large') ?: wc_placeholder_img_src('large'),
        'category' => $category ? html_entity_decode($category->name, ENT_QUOTES) : '',
        'readTime' => weavira_journal_read_time($post),
        'date' => get_the_date('d M, Y', $post),
        'link' => get_permalink($post),
    ];
}

/**
 * Rough reading time from word count, ~200 words/minute. The article body
 * lives in the journal_sections flexible content field rather than
 * post_content, so every text value across every section is counted.
 *
 * @return string
 */
function weavira_journal_read_time($post)
{
    $text = wp_strip_all_tags($post->post_content);

    $sections = get_field('journal_sections', $post->ID) ?: [];
    array_walk_recursive($sections, function ($value) use (&$text) {
        if (is_string($value)) {
            $text .= ' ' . wp_strip_all_tags($value);
        }
    });

    $words = str_word_count($text);

    return max(1, (int) ceil($words / 200)) . ' min read';
}

/**
 * AJAX "This will be a Gift" details — saved on the specific cart line
 * item only (WC()->cart->cart_contents[$key]['wv_gift']), so adding 3
 * products and marking just one as a gift only ever affects that one
 * line. Copied onto the order line item at checkout — see
 * woocommerce_checkout_create_order_line_item below.
 */
add_action('wp_ajax_weavira_save_gift_details', 'App\\weavira_handle_save_gift_details');
add_action('wp_ajax_nopriv_weavira_save_gift_details', 'App\\weavira_handle_save_gift_details');

function weavira_handle_save_gift_details()
{
    check_ajax_referer('weavira_cart_actions', 'security');

    $key = isset($_POST['cart_item_key']) ? sanitize_text_field(wp_unslash($_POST['cart_item_key'])) : '';

    if (!$key || !isset(WC()->cart->cart_contents[$key])) {
        wp_send_json_error(['message' => __('Cart item not found.', 'sage')], 400);
    }

    $isGift = !empty($_POST['is_gift']);

    if (!$isGift) {
        unset(WC()->cart->cart_contents[$key]['wv_gift']);
        WC()->cart->set_session();
        wp_send_json_success(['saved' => false]);
    }

    $giftForOptions = weavira_gift_for_options();
    $occasionOptions = weavira_gift_occasion_options();
    $giftFor = isset($_POST['gift_for']) ? sanitize_text_field(wp_unslash($_POST['gift_for'])) : '';
    $occasion = isset($_POST['occasion']) ? sanitize_text_field(wp_unslash($_POST['occasion'])) : '';

    $gift = [
        'recipient_name' => isset($_POST['recipient_name']) ? sanitize_text_field(wp_unslash($_POST['recipient_name'])) : '',
        'gift_for' => in_array($giftFor, $giftForOptions, true) ? $giftFor : '',
        'occasion' => in_array($occasion, $occasionOptions, true) ? $occasion : '',
    ];

    if ($gift['recipient_name'] === '') {
        wp_send_json_error(['message' => __('Please add a recipient name.', 'sage')], 400);
    }

    WC()->cart->cart_contents[$key]['wv_gift'] = $gift;
    WC()->cart->set_session();

    wp_send_json_success(['saved' => true]);
}

/**
 * Copy a cart line's gift details onto the corresponding order line item
 * when the order is placed, so they show automatically in the wp-admin
 * order screen (Order items meta) and in order emails — no extra
 * templating needed, WooCommerce displays visible (non-underscore) item
 * meta in both by default.
 */
add_action('woocommerce_checkout_create_order_line_item', function ($item, $cart_item_key, $values, $order) {
    if (empty($values['wv_gift']['recipient_name'])) {
        return;
    }

    $gift = $values['wv_gift'];

    $item->add_meta_data(__('Gift Recipient', 'sage'), $gift['recipient_name']);

    if (!empty($gift['gift_for'])) {
        $item->add_meta_data(__('Gift For', 'sage'), $gift['gift_for']);
    }

    if (!empty($gift['occasion'])) {
        $item->add_meta_data(__('Occasion', 'sage'), $gift['occasion']);
    }
}, 10, 4);

/**
 * "I need a GST Invoice" checkbox (Delivery Address step) — recorded as
 * order meta only. There's no invoice-document generation yet, so this
 * just flags the order for manual follow-up; the second hook below surfaces
 * that flag on the admin order screen (same
 * woocommerce_admin_order_data_after_billing_address hook the SMS Alert
 * plugin uses for its own order-level flags), since WooCommerce doesn't
 * show a generic custom-fields panel for orders by default.
 */
add_action('woocommerce_checkout_create_order', function ($order, $data) {
    if (!empty($_POST['wv_gst_invoice'])) {
        $order->update_meta_data('_wv_gst_invoice_requested', 'yes');

        if (!empty($_POST['wv_gst_number'])) {
            $order->update_meta_data('_wv_gst_number', sanitize_text_field(wp_unslash($_POST['wv_gst_number'])));
        }
    }
}, 10, 2);

add_action('woocommerce_admin_order_data_after_billing_address', function ($order) {
    if ($order->get_meta('_wv_gst_invoice_requested') === 'yes') {
        echo '<p><strong>' . esc_html__('GST Invoice Requested', 'sage') . '</strong></p>';

        $gstNumber = $order->get_meta('_wv_gst_number');
        if ($gstNumber) {
            echo '<p><strong>' . esc_html__('GSTIN', 'sage') . ':</strong> ' . esc_html($gstNumber) . '</p>';
        }
    }
});

/**
 * Delivery Address (shipping_*) is the primary, always-required address on
 * checkout — see checkout.blade.php. billing_* only gets its own distinct
 * values when the customer checks "I need a GST Invoice"; otherwise
 * WooCommerce still needs *some* valid billing_* data to create the order,
 * so this mirrors the delivery address into it. Fires on
 * woocommerce_checkout_process (before WC_Checkout::get_posted_data() reads
 * $_POST), so the mirrored values are read by validation/order-creation the
 * same as if the customer had typed them — no JS dependency.
 *
 * billing_phone/billing_email are deliberately excluded: they're the
 * purchaser's own account identity (see the SMS Alert billing_phone
 * dependency below), never derived from the delivery address.
 */
add_action('woocommerce_checkout_process', function () {
    if (!empty($_POST['wv_gst_invoice'])) {
        return;
    }

    foreach (['first_name', 'last_name', 'address_1', 'address_2', 'city', 'state', 'postcode', 'country'] as $key) {
        if (isset($_POST['shipping_' . $key])) {
            $_POST['billing_' . $key] = $_POST['shipping_' . $key];
        }
    }
});

/**
 * ─── Wishlist ────────────────────────────────────────────────────────────
 *
 * Storage: one `wv_wishlist` CPT post per visitor. Logged-in visitors are
 * matched by a `_wv_owner_user_id` meta value (so the wishlist follows
 * their account across devices); guests are matched by a random token
 * stored in a long-lived cookie. That same token is the post's slug, and
 * doubles as the "Share" link identifier — anyone with the link can view
 * the wishlist read-only (see page-wishlist.blade.php's `?share=` handling)
 * without gaining the cookie needed to edit it.
 */
const WISHLIST_COOKIE = 'wv_wishlist_token';

/**
 * @return string
 */
function weavira_wishlist_page_url()
{
    $page = get_page_by_path('wishlist');

    return $page ? get_permalink($page) : home_url('/wishlist/');
}

/**
 * Resolve the current visitor's wishlist post, creating one on first use.
 *
 * @param bool $create
 * @return \WP_Post|null
 */
function weavira_get_wishlist_post($create = true)
{
    $userId = get_current_user_id();

    if ($userId) {
        $existing = get_posts([
            'post_type' => 'wv_wishlist',
            'post_status' => 'publish',
            'meta_key' => '_wv_owner_user_id',
            'meta_value' => $userId,
            'posts_per_page' => 1,
            'no_found_rows' => true,
        ]);

        if ($existing) {
            return $existing[0];
        }

        return $create ? weavira_create_wishlist_post(['_wv_owner_user_id' => $userId]) : null;
    }

    $token = isset($_COOKIE[WISHLIST_COOKIE]) ? sanitize_text_field(wp_unslash($_COOKIE[WISHLIST_COOKIE])) : '';

    if ($token) {
        $existing = get_posts([
            'post_type' => 'wv_wishlist',
            'post_status' => 'publish',
            'name' => $token,
            'posts_per_page' => 1,
            'no_found_rows' => true,
        ]);

        if ($existing) {
            return $existing[0];
        }
    }

    if (!$create) {
        return null;
    }

    $post = weavira_create_wishlist_post();

    if ($post && !headers_sent()) {
        setcookie(WISHLIST_COOKIE, $post->post_name, time() + YEAR_IN_SECONDS, '/', '', is_ssl(), true);
        $_COOKIE[WISHLIST_COOKIE] = $post->post_name;
    }

    return $post;
}

/**
 * @param array $meta
 * @return \WP_Post|null
 */
function weavira_create_wishlist_post($meta = [])
{
    $token = wp_generate_password(24, false, false);

    $postId = wp_insert_post([
        'post_type' => 'wv_wishlist',
        'post_status' => 'publish',
        'post_title' => 'Wishlist ' . $token,
        'post_name' => $token,
    ], true);

    if (is_wp_error($postId) || !$postId) {
        return null;
    }

    foreach ($meta as $key => $value) {
        update_post_meta($postId, $key, $value);
    }

    update_post_meta($postId, '_wv_wishlist_items', []);

    return get_post($postId);
}

/**
 * @param \WP_Post|null $post
 * @return array Each entry: ['product_id' => int, 'added' => int (timestamp)]
 */
function weavira_wishlist_items($post)
{
    if (!$post) {
        return [];
    }

    $items = get_post_meta($post->ID, '_wv_wishlist_items', true);

    return is_array($items) ? $items : [];
}

/**
 * @param \WP_Post $post
 * @param array $items
 * @return void
 */
function weavira_wishlist_save_items($post, $items)
{
    update_post_meta($post->ID, '_wv_wishlist_items', array_values($items));
}

/**
 * @param int $productId
 * @return bool
 */
function weavira_wishlist_contains($productId)
{
    foreach (weavira_wishlist_items(weavira_get_wishlist_post(false)) as $item) {
        if ((int) $item['product_id'] === (int) $productId) {
            return true;
        }
    }

    return false;
}

/**
 * @return int
 */
function weavira_wishlist_count()
{
    return count(weavira_wishlist_items(weavira_get_wishlist_post(false)));
}

/**
 * Create a guest's wishlist cookie ahead of rendering the wishlist page
 * itself, so App\View\Composers\Wishlist can rely on it already existing.
 * Skipped for shared (read-only, `?share=`) views — those must not create
 * or touch the viewer's own wishlist.
 */
add_action('template_redirect', function () {
    if (function_exists('is_page') && is_page('wishlist') && empty($_GET['share'])) {
        weavira_get_wishlist_post(true);
    }
});

/**
 * Individual Heritage Design posts have no single-page template of their
 * own (see html/heritage-designs.html — only the archive/listing page
 * exists as a design), so a single post redirects straight to its
 * equivalent filtered Shop URL via its related Design attribute. The
 * archive itself is a real page — resources/views/archive-heritage_design.blade.php
 * — and is not redirected.
 */
add_action('template_redirect', function () {
    if (is_singular('heritage_design')) {
        $termId = get_field('related_design_attribute', get_the_ID());
        $term = $termId ? get_term($termId, 'pa_design') : null;

        $url = ($term && !is_wp_error($term))
            ? add_query_arg('filter_design', $term->slug, wc_get_page_permalink('shop'))
            : wc_get_page_permalink('shop');

        wp_safe_redirect($url, 301);
        exit;
    }
});

/**
 * AJAX: toggle a product in/out of the current visitor's wishlist. Used by
 * every heart button site-wide (product cards, PDP gallery).
 */
add_action('wp_ajax_weavira_toggle_wishlist', 'App\\weavira_handle_toggle_wishlist');
add_action('wp_ajax_nopriv_weavira_toggle_wishlist', 'App\\weavira_handle_toggle_wishlist');

function weavira_handle_toggle_wishlist()
{
    check_ajax_referer('weavira_wishlist_actions', 'security');

    $productId = isset($_POST['product_id']) ? absint($_POST['product_id']) : 0;
    $product = $productId ? wc_get_product($productId) : null;

    if (!$product) {
        wp_send_json_error(['message' => __('Product not found.', 'sage')], 400);
    }

    $post = weavira_get_wishlist_post(true);

    if (!$post) {
        wp_send_json_error(['message' => __('Could not access wishlist.', 'sage')], 500);
    }

    $items = weavira_wishlist_items($post);
    $remaining = array_values(array_filter($items, function ($item) use ($productId) {
        return (int) $item['product_id'] !== $productId;
    }));

    $inWishlist = count($remaining) === count($items);

    if ($inWishlist) {
        $remaining[] = ['product_id' => $productId, 'added' => time()];
    }

    weavira_wishlist_save_items($post, $remaining);

    wp_send_json_success([
        'inWishlist' => $inWishlist,
        'count' => count($remaining),
    ]);
}

/**
 * AJAX: remove a wishlist item and add it to the cart in one step, for the
 * wishlist page's "Move to Bag" button. Variable products can't be added
 * without choosing options, so those hand back a redirect to the PDP
 * instead of failing silently.
 */
add_action('wp_ajax_weavira_wishlist_move_to_cart', 'App\\weavira_handle_wishlist_move_to_cart');
add_action('wp_ajax_nopriv_weavira_wishlist_move_to_cart', 'App\\weavira_handle_wishlist_move_to_cart');

function weavira_handle_wishlist_move_to_cart()
{
    check_ajax_referer('weavira_wishlist_actions', 'security');

    $productId = isset($_POST['product_id']) ? absint($_POST['product_id']) : 0;
    $product = $productId ? wc_get_product($productId) : null;

    if (!$product) {
        wp_send_json_error(['message' => __('Product not found.', 'sage')], 400);
    }

    if ($product->is_type('variable')) {
        wp_send_json_error([
            'message' => __('Please choose options for this product.', 'sage'),
            'redirect' => get_permalink($productId),
        ], 400);
    }

    if (!WC()->cart->add_to_cart($productId)) {
        wp_send_json_error(['message' => __('Could not add to bag.', 'sage')], 400);
    }

    $post = weavira_get_wishlist_post(true);
    $items = array_values(array_filter(weavira_wishlist_items($post), function ($item) use ($productId) {
        return (int) $item['product_id'] !== $productId;
    }));
    weavira_wishlist_save_items($post, $items);

    wp_send_json_success([
        'count' => count($items),
        'cartCount' => WC()->cart->get_cart_contents_count(),
    ]);
}

/**
 * AJAX: remove a wishlist item (the wishlist page's delete/trash button).
 */
add_action('wp_ajax_weavira_wishlist_remove', 'App\\weavira_handle_wishlist_remove');
add_action('wp_ajax_nopriv_weavira_wishlist_remove', 'App\\weavira_handle_wishlist_remove');

function weavira_handle_wishlist_remove()
{
    check_ajax_referer('weavira_wishlist_actions', 'security');

    $productId = isset($_POST['product_id']) ? absint($_POST['product_id']) : 0;
    $post = weavira_get_wishlist_post(false);

    if (!$productId || !$post) {
        wp_send_json_error(['message' => __('Wishlist item not found.', 'sage')], 400);
    }

    $items = array_values(array_filter(weavira_wishlist_items($post), function ($item) use ($productId) {
        return (int) $item['product_id'] !== $productId;
    }));
    weavira_wishlist_save_items($post, $items);

    wp_send_json_success(['count' => count($items)]);
}

/**
 * Heritage Designs archive filtering — filter_motif/filter_inspiration/
 * filter_weave/filter_color GET params, same comma-separated-slugs
 * convention as the Shop page's filter_* links, but applied by hand since
 * WooCommerce's own layered-nav query vars only touch product queries.
 * "Most Designs" sorting is handled separately in
 * App\View\Composers\HeritageDesigns, since it orders by a computed value
 * (related product count) that WP_Query can't sort by directly.
 */
add_action('pre_get_posts', function ($query) {
    if (is_admin() || !$query->is_main_query() || !$query->is_post_type_archive('heritage_design')) {
        return;
    }

    $taxQuery = [];

    $taxonomyFilters = [
        'inspiration' => 'heritage_inspiration',
        'weave' => 'pa_weave',
        'color' => 'pa_body-primary-colour',
    ];

    foreach ($taxonomyFilters as $param => $taxonomy) {
        $raw = $_GET['filter_' . $param] ?? '';

        if (!is_string($raw) || $raw === '') {
            continue;
        }

        $taxQuery[] = [
            'taxonomy' => $taxonomy,
            'field' => 'slug',
            'terms' => array_map('sanitize_title', explode(',', sanitize_text_field(wp_unslash($raw)))),
        ];
    }

    if (count($taxQuery) > 1) {
        $taxQuery['relation'] = 'AND';
    }

    if (!empty($taxQuery)) {
        $query->set('tax_query', $taxQuery);
    }

    $motifRaw = $_GET['filter_motif'] ?? '';

    if (is_string($motifRaw) && $motifRaw !== '') {
        $query->set('post_name__in', array_map('sanitize_title', explode(',', sanitize_text_field(wp_unslash($motifRaw)))));
    }

    if (isset($_GET['orderby'])) {
        $orderby = sanitize_text_field(wp_unslash($_GET['orderby']));

        if ($orderby === 'title') {
            $query->set('orderby', 'title');
            $query->set('order', 'ASC');
        } elseif ($orderby === 'date') {
            $query->set('orderby', 'date');
            $query->set('order', 'DESC');
        }
    }
});

/**
 * Journal archive filtering — filter_category GET param, same
 * comma-separated-slugs convention as Shop/Heritage Designs.
 */
add_action('pre_get_posts', function ($query) {
    if (is_admin() || !$query->is_main_query() || !$query->is_post_type_archive('journal')) {
        return;
    }

    $raw = $_GET['filter_category'] ?? '';

    if (is_string($raw) && $raw !== '') {
        $query->set('tax_query', [[
            'taxonomy' => 'journal_category',
            'field' => 'slug',
            'terms' => array_map('sanitize_title', explode(',', sanitize_text_field(wp_unslash($raw)))),
        ]]);
    }
});

/**
 * My Account registration adds First Name / Last Name / Mobile Number on
 * top of WooCommerce's default Email (+ optional Username/Password) fields
 * — see resources/views/woocommerce/myaccount/form-login.blade.php. These
 * aren't core WC registration fields, so they need their own validation
 * (mirroring wc_create_new_customer()'s own WP_Error pattern) and their
 * own save step once the account actually exists.
 *
 * The phone field is named billing_phone rather than a one-off "mobile" so
 * it lines up with the SMS Alert plugin's own OTP-verification checks on
 * this same form (see form-login.blade.php's [sa_verify] shortcode and
 * "Buyer Signup OTP" under SMS Alert settings) — the plugin reads
 * $_POST['billing_phone'] and, since this filter runs first (both are
 * default priority 10, and this one is registered earlier, on theme
 * bootstrap), any error added here blocks the plugin's OTP send/duplicate
 * check too, per its own woocommerceSiteRegistrationErrors() bail-out.
 */
add_filter('woocommerce_registration_errors', function ($errors) {
    $firstName = isset($_POST['first_name']) ? trim(wp_unslash($_POST['first_name'])) : '';
    $lastName = isset($_POST['last_name']) ? trim(wp_unslash($_POST['last_name'])) : '';
    $mobile = isset($_POST['billing_phone']) ? weavira_normalize_indian_mobile(wp_unslash($_POST['billing_phone'])) : '';

    if ($firstName === '') {
        $errors->add('registration-error-first-name', __('Please enter your first name.', 'sage'));
    }

    if ($lastName === '') {
        $errors->add('registration-error-last-name', __('Please enter your last name.', 'sage'));
    }

    if ($mobile === null) {
        $errors->add('registration-error-mobile', __('Please enter a valid 10-digit mobile number.', 'sage'));
    } elseif (get_users(['meta_key' => 'billing_phone', 'meta_value' => $mobile, 'number' => 1, 'fields' => 'ID'])) {
        $errors->add('registration-error-mobile-exists', __('An account is already registered with this mobile number. Please login instead.', 'sage'));
    }

    return $errors;
});

add_action('woocommerce_created_customer', function ($customerId) {
    wp_update_user([
        'ID' => $customerId,
        'first_name' => isset($_POST['first_name']) ? sanitize_text_field(wp_unslash($_POST['first_name'])) : '',
        'last_name' => isset($_POST['last_name']) ? sanitize_text_field(wp_unslash($_POST['last_name'])) : '',
        'display_name' => isset($_POST['first_name']) ? sanitize_text_field(wp_unslash($_POST['first_name'])) : '',
    ]);

    if (isset($_POST['billing_phone'])) {
        $mobile = weavira_normalize_indian_mobile(wp_unslash($_POST['billing_phone']));

        if ($mobile !== null) {
            update_user_meta($customerId, 'billing_phone', $mobile);
        }
    }
});

/**
 * The register form's phone field submits as a bare 10-digit number by
 * default, but SMS Alert's own intl-tel-input widget (triggered by the
 * [sa_verify] shortcode adding the .phone-valid class to it — see
 * form-login.blade.php) reformats it to include the +91/91 country-code
 * prefix once the OTP flow runs. Accept and normalize both shapes to a
 * plain 10-digit number so validation, storage, and the duplicate-number
 * lookup above all compare consistently regardless of which path the
 * value came through. Returns null if it's not a valid Indian mobile.
 *
 * @return string|null
 */
function weavira_normalize_indian_mobile($raw)
{
    $digits = preg_replace('/\D/', '', $raw);

    if (strlen($digits) === 12 && str_starts_with($digits, '91')) {
        $digits = substr($digits, 2);
    } elseif (strlen($digits) === 11 && str_starts_with($digits, '0')) {
        $digits = substr($digits, 1);
    }

    return preg_match('/^[6-9][0-9]{9}$/', $digits) ? $digits : null;
}

/**
 * Multiple named shipping addresses ("Home" / "Office" / ...) — an
 * address book layered on top of WooCommerce's own single shipping
 * address, stored as its own user meta rather than replacing shipping_*
 * so WooCommerce's native default-address behaviour (checkout pre-fill,
 * order snapshots) keeps working untouched. Whichever entry is default
 * is mirrored into shipping_* on save, which is what actually keeps the
 * two in sync — see weavira_save_shipping_address() below.
 *
 * @return array
 */
function weavira_get_shipping_addresses($userId)
{
    $addresses = get_user_meta($userId, 'wv_shipping_addresses', true);

    return is_array($addresses) ? array_values($addresses) : [];
}

/**
 * @return array The saved address record (including its id).
 */
function weavira_save_shipping_address($userId, array $data, $addressId = null)
{
    $addresses = weavira_get_shipping_addresses($userId);
    $isFirst = empty($addresses);

    $record = array_merge([
        'id' => $addressId ?: 'addr_' . uniqid(),
        'label' => '',
        'first_name' => '',
        'last_name' => '',
        'company' => '',
        'address_1' => '',
        'address_2' => '',
        'city' => '',
        'state' => '',
        'postcode' => '',
        'country' => '',
        'phone' => '',
        'is_default' => $isFirst,
    ], $data);

    $found = false;

    foreach ($addresses as $index => $existing) {
        if ($existing['id'] === $record['id']) {
            $record['is_default'] = $existing['is_default'];
            $addresses[$index] = $record;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $addresses[] = $record;
    }

    update_user_meta($userId, 'wv_shipping_addresses', $addresses);

    if ($record['is_default']) {
        weavira_mirror_default_shipping_address($userId, $record);
    }

    return $record;
}

/**
 * @return void
 */
function weavira_delete_shipping_address($userId, $addressId)
{
    $addresses = weavira_get_shipping_addresses($userId);
    $deletedWasDefault = false;
    $remaining = [];

    foreach ($addresses as $address) {
        if ($address['id'] === $addressId) {
            $deletedWasDefault = !empty($address['is_default']);
            continue;
        }

        $remaining[] = $address;
    }

    if ($deletedWasDefault && !empty($remaining)) {
        $remaining[0]['is_default'] = true;
        weavira_mirror_default_shipping_address($userId, $remaining[0]);
    }

    update_user_meta($userId, 'wv_shipping_addresses', $remaining);
}

/**
 * @return void
 */
function weavira_set_default_shipping_address($userId, $addressId)
{
    $addresses = weavira_get_shipping_addresses($userId);
    $newDefault = null;

    foreach ($addresses as $index => $address) {
        $addresses[$index]['is_default'] = ($address['id'] === $addressId);

        if ($addresses[$index]['is_default']) {
            $newDefault = $addresses[$index];
        }
    }

    update_user_meta($userId, 'wv_shipping_addresses', $addresses);

    if ($newDefault) {
        weavira_mirror_default_shipping_address($userId, $newDefault);
    }
}

/**
 * Keeps WooCommerce's own shipping_* user meta (what pre-fills checkout
 * before any address book selection, and what orders snapshot) in sync
 * with whichever saved address is marked default.
 *
 * @return void
 */
function weavira_mirror_default_shipping_address($userId, array $address)
{
    foreach (['first_name', 'last_name', 'company', 'address_1', 'address_2', 'city', 'state', 'postcode', 'country', 'phone'] as $key) {
        update_user_meta($userId, 'shipping_' . $key, $address[$key] ?? '');
    }
}

add_action('template_redirect', function () {
    if (empty($_POST['action']) || 'wv_save_shipping_address' !== $_POST['action'] || !is_user_logged_in()) {
        return;
    }

    check_admin_referer('wv_save_shipping_address', 'wv_shipping_address_nonce');

    $userId = get_current_user_id();
    $addressId = isset($_POST['address_id']) ? sanitize_text_field(wp_unslash($_POST['address_id'])) : '';
    $label = isset($_POST['wv_address_label']) ? trim(sanitize_text_field(wp_unslash($_POST['wv_address_label']))) : '';

    $fields = ['first_name', 'last_name', 'company', 'address_1', 'address_2', 'city', 'state', 'postcode', 'country', 'phone'];
    $data = ['label' => $label];

    foreach ($fields as $key) {
        $data[$key] = isset($_POST['shipping_' . $key]) ? sanitize_text_field(wp_unslash($_POST['shipping_' . $key])) : '';
    }

    $required = ['label', 'first_name', 'last_name', 'address_1', 'city', 'postcode', 'country'];
    $missing = array_filter($required, fn ($key) => $data[$key] === '');

    if (!empty($missing)) {
        wc_add_notice(__('Please fill in all required address fields, including a label.', 'sage'), 'error');
        wp_safe_redirect(add_query_arg('address_id', $addressId ?: 'new', wc_get_endpoint_url('edit-address', 'shipping')));
        exit;
    }

    weavira_save_shipping_address($userId, $data, $addressId ?: null);

    wc_add_notice(__('Address saved.', 'sage'));
    wp_safe_redirect(wc_get_endpoint_url('edit-address'));
    exit;
});

add_action('template_redirect', function () {
    if (empty($_POST['action']) || !is_user_logged_in()) {
        return;
    }

    $userId = get_current_user_id();
    $addressId = isset($_POST['address_id']) ? sanitize_text_field(wp_unslash($_POST['address_id'])) : '';

    if (!$addressId) {
        return;
    }

    if ('wv_delete_shipping_address' === $_POST['action']) {
        check_admin_referer('wv_delete_shipping_address_' . $addressId, 'wv_shipping_address_nonce');
        weavira_delete_shipping_address($userId, $addressId);
        wc_add_notice(__('Address removed.', 'sage'));
        wp_safe_redirect(wc_get_endpoint_url('edit-address'));
        exit;
    }

    if ('wv_set_default_shipping_address' === $_POST['action']) {
        check_admin_referer('wv_set_default_shipping_address_' . $addressId, 'wv_shipping_address_nonce');
        weavira_set_default_shipping_address($userId, $addressId);
        wc_add_notice(__('Default shipping address updated.', 'sage'));
        wp_safe_redirect(wc_get_endpoint_url('edit-address'));
        exit;
    }
});

/**
 * AJAX: save the Delivery Address panel's fields as a shipping address book
 * entry. Two callers: (1) the zero-saved-addresses inline flow, which fires
 * this silently when a checkout customer clicks Continue past a freshly
 * typed address (see weavira.js's .ck-continue-btn handler) — no address_id
 * posted, always creates a new entry; (2) the Add/Edit modal shown once 1+
 * addresses exist (see weavira.js's modal IIFE) — address_id posted when
 * editing an existing card, empty when adding a new one. Both paths funnel
 * into the same, unchanged weavira_save_shipping_address(), which already
 * knows how to create vs. update based on whether $addressId matches an
 * existing entry. Logged-in only — a guest has no account to save to, so
 * there is no wp_ajax_nopriv_ variant.
 */
add_action('wp_ajax_weavira_save_checkout_shipping_address', 'App\\weavira_handle_save_checkout_shipping_address');

function weavira_handle_save_checkout_shipping_address()
{
    check_ajax_referer('weavira_checkout_actions', 'security');

    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => __('You must be logged in.', 'sage')], 403);
    }

    $addressId = isset($_POST['address_id']) ? sanitize_text_field(wp_unslash($_POST['address_id'])) : '';
    $label = isset($_POST['label']) ? trim(sanitize_text_field(wp_unslash($_POST['label']))) : '';

    $fields = ['first_name', 'last_name', 'company', 'address_1', 'address_2', 'city', 'state', 'postcode', 'country', 'phone'];
    $data = ['label' => $label ?: 'Home'];

    foreach ($fields as $key) {
        $data[$key] = isset($_POST[$key]) ? sanitize_text_field(wp_unslash($_POST[$key])) : '';
    }

    $required = ['first_name', 'last_name', 'address_1', 'city', 'state', 'postcode', 'country'];
    $missing = array_filter($required, fn ($key) => $data[$key] === '');

    if (!empty($missing)) {
        wp_send_json_error(['message' => __('Missing required address fields.', 'sage')], 400);
    }

    $record = weavira_save_shipping_address(get_current_user_id(), $data, $addressId ?: null);

    wp_send_json_success(['id' => $record['id']]);
}

/**
 * ─── Billing / GST address book ─────────────────────────────────────────
 *
 * Same "Home / Office" pattern as the shipping address book above (its own
 * parallel set of functions, not a shared/generalized one — see the plan:
 * billing entries carry gstin/business_name that shipping ones don't, and
 * this keeps the already-working shipping book untouched), for customers
 * who invoice against more than one registered business/GSTIN. Storage:
 * wv_billing_addresses user meta. Default entry mirrors into WooCommerce's
 * native billing_* user meta — except phone, which is deliberately never
 * touched here (see weavira_mirror_default_billing_address() below).
 */

/**
 * @return array
 */
function weavira_get_billing_addresses($userId)
{
    $addresses = get_user_meta($userId, 'wv_billing_addresses', true);

    return is_array($addresses) ? array_values($addresses) : [];
}

/**
 * @return array The saved address record (including its id).
 */
function weavira_save_billing_address($userId, array $data, $addressId = null)
{
    $addresses = weavira_get_billing_addresses($userId);
    $isFirst = empty($addresses);

    $record = array_merge([
        'id' => $addressId ?: 'addr_' . uniqid(),
        'label' => '',
        'gstin' => '',
        'first_name' => '',
        'last_name' => '',
        'company' => '', // business/legal name — same field WC's billing_company already is
        'address_1' => '',
        'address_2' => '',
        'city' => '',
        'state' => '',
        'postcode' => '',
        'country' => '',
        'is_default' => $isFirst,
    ], $data);

    $found = false;

    foreach ($addresses as $index => $existing) {
        if ($existing['id'] === $record['id']) {
            $record['is_default'] = $existing['is_default'];
            $addresses[$index] = $record;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $addresses[] = $record;
    }

    update_user_meta($userId, 'wv_billing_addresses', $addresses);

    if ($record['is_default']) {
        weavira_mirror_default_billing_address($userId, $record);
    }

    return $record;
}

/**
 * @return void
 */
function weavira_delete_billing_address($userId, $addressId)
{
    $addresses = weavira_get_billing_addresses($userId);
    $deletedWasDefault = false;
    $remaining = [];

    foreach ($addresses as $address) {
        if ($address['id'] === $addressId) {
            $deletedWasDefault = !empty($address['is_default']);
            continue;
        }

        $remaining[] = $address;
    }

    if ($deletedWasDefault && !empty($remaining)) {
        $remaining[0]['is_default'] = true;
        weavira_mirror_default_billing_address($userId, $remaining[0]);
    }

    update_user_meta($userId, 'wv_billing_addresses', $remaining);
}

/**
 * @return void
 */
function weavira_set_default_billing_address($userId, $addressId)
{
    $addresses = weavira_get_billing_addresses($userId);
    $newDefault = null;

    foreach ($addresses as $index => $address) {
        $addresses[$index]['is_default'] = ($address['id'] === $addressId);

        if ($addresses[$index]['is_default']) {
            $newDefault = $addresses[$index];
        }
    }

    update_user_meta($userId, 'wv_billing_addresses', $addresses);

    if ($newDefault) {
        weavira_mirror_default_billing_address($userId, $newDefault);
    }
}

/**
 * Keeps WooCommerce's own billing_* user meta in sync with whichever saved
 * billing/GST address is marked default — except phone, unlike the
 * shipping equivalent of this function. billing_phone is the purchaser's
 * own OTP-verified number (SMS Alert's checkout-OTP feature depends on it
 * staying exactly that, see checkout.blade.php) and must never be
 * overwritten by an address-book entry that was never asked for one.
 * GSTIN isn't a WooCommerce field at all, so it's stored separately.
 *
 * @return void
 */
function weavira_mirror_default_billing_address($userId, array $address)
{
    foreach (['first_name', 'last_name', 'company', 'address_1', 'address_2', 'city', 'state', 'postcode', 'country'] as $key) {
        update_user_meta($userId, 'billing_' . $key, $address[$key] ?? '');
    }

    update_user_meta($userId, '_wv_gstin', $address['gstin'] ?? '');
}

add_action('template_redirect', function () {
    if (empty($_POST['action']) || 'wv_save_billing_address' !== $_POST['action'] || !is_user_logged_in()) {
        return;
    }

    check_admin_referer('wv_save_billing_address', 'wv_billing_address_nonce');

    $userId = get_current_user_id();
    $addressId = isset($_POST['address_id']) ? sanitize_text_field(wp_unslash($_POST['address_id'])) : '';
    $label = isset($_POST['wv_address_label']) ? trim(sanitize_text_field(wp_unslash($_POST['wv_address_label']))) : '';
    // Same POST key checkout's GST section uses (see checkout.blade.php),
    // kept consistent rather than inventing a second name for the same thing.
    $gstin = isset($_POST['wv_gst_number']) ? trim(sanitize_text_field(wp_unslash($_POST['wv_gst_number']))) : '';

    $fields = ['first_name', 'last_name', 'company', 'address_1', 'address_2', 'city', 'state', 'postcode', 'country'];
    $data = ['label' => $label, 'gstin' => $gstin];

    foreach ($fields as $key) {
        $data[$key] = isset($_POST['billing_' . $key]) ? sanitize_text_field(wp_unslash($_POST['billing_' . $key])) : '';
    }

    // 'company' (Business / Legal Name) is required here — a GST address
    // book entry without one isn't useful for invoicing purposes.
    $required = ['label', 'gstin', 'first_name', 'last_name', 'company', 'address_1', 'city', 'postcode', 'country'];
    $missing = array_filter($required, fn ($key) => $data[$key] === '');

    if (!empty($missing)) {
        wc_add_notice(__('Please fill in all required address fields, including a label.', 'sage'), 'error');
        wp_safe_redirect(add_query_arg('address_id', $addressId ?: 'new', wc_get_endpoint_url('edit-address', 'billing')));
        exit;
    }

    weavira_save_billing_address($userId, $data, $addressId ?: null);

    wc_add_notice(__('Address saved.', 'sage'));
    wp_safe_redirect(wc_get_endpoint_url('edit-address'));
    exit;
});

add_action('template_redirect', function () {
    if (empty($_POST['action']) || !is_user_logged_in()) {
        return;
    }

    $userId = get_current_user_id();
    $addressId = isset($_POST['address_id']) ? sanitize_text_field(wp_unslash($_POST['address_id'])) : '';

    if (!$addressId) {
        return;
    }

    if ('wv_delete_billing_address' === $_POST['action']) {
        check_admin_referer('wv_delete_billing_address_' . $addressId, 'wv_billing_address_nonce');
        weavira_delete_billing_address($userId, $addressId);
        wc_add_notice(__('Address removed.', 'sage'));
        wp_safe_redirect(wc_get_endpoint_url('edit-address'));
        exit;
    }

    if ('wv_set_default_billing_address' === $_POST['action']) {
        check_admin_referer('wv_set_default_billing_address_' . $addressId, 'wv_billing_address_nonce');
        weavira_set_default_billing_address($userId, $addressId);
        wc_add_notice(__('Default billing address updated.', 'sage'));
        wp_safe_redirect(wc_get_endpoint_url('edit-address'));
        exit;
    }
});

/**
 * Search overlay's "View all N results" link (weavira_handle_product_search()
 * above) sends visitors to the Shop page with ?s= rather than WordPress's
 * own unstyled /?s= search template — WC_Query's own filter_/price/orderby
 * query var handling doesn't include a plain keyword search, so this is the
 * one query var the Shop page needs a manual pre_get_posts hook for.
 * Uses the same weavira_search_product_ids() matching (title OR curated
 * keyword synonyms) the overlay's own live results use, via post__in,
 * rather than WP_Query's native `s` (which only matches title/content and
 * would silently miss anything found only through a search keyword) —
 * composes fine with the Shop page's existing attribute/price filters
 * since those still apply as additional conditions on top.
 */
add_action('pre_get_posts', function ($query) {
    if (is_admin() || !$query->is_main_query() || !function_exists('is_shop') || !is_shop()) {
        return;
    }

    $term = isset($_GET['s']) ? sanitize_text_field(wp_unslash($_GET['s'])) : '';

    if ($term === '') {
        return;
    }

    // Leave the query's native `s` var populated — get_search_query()/the
    // page title read it — but drop WordPress's own title/content search
    // SQL for this query so it doesn't get ANDed with post__in below; if
    // it stayed, "Wedding" never literally appearing in the matched
    // product's title would silently zero out an otherwise-correct match.
    add_filter('posts_search', function ($search, $wp_query) use ($query) {
        return $wp_query === $query ? '' : $search;
    }, 10, 2);

    $ids = \App\weavira_search_product_ids($term);
    $query->set('post__in', empty($ids) ? [0] : $ids);
});

/**
 * "Sort by: Featured" (?orderby=menu_order, also the Shop page's default
 * when no orderby is set) shows featured products first — WooCommerce
 * tracks "featured" via a product_visibility taxonomy term rather than
 * postmeta, so this needs a JOIN + custom ORDER BY rather than a simple
 * meta_key sort. Scoped to only the Featured sort — Price/Newest/Best
 * Sellers stay exactly as those labels promise.
 */
add_filter('posts_clauses', function ($clauses, $query) {
    if (is_admin() || !$query->is_main_query() || !function_exists('is_shop') || !(is_shop() || is_product_taxonomy())) {
        return $clauses;
    }

    $orderby = isset($_GET['orderby']) ? sanitize_text_field(wp_unslash($_GET['orderby'])) : 'menu_order';

    if ($orderby !== 'menu_order') {
        return $clauses;
    }

    $term = get_term_by('slug', 'featured', 'product_visibility');

    if (!$term) {
        return $clauses;
    }

    global $wpdb;

    $clauses['join'] .= $wpdb->prepare(
        " LEFT JOIN {$wpdb->term_relationships} AS wv_featured_tr ON ({$wpdb->posts}.ID = wv_featured_tr.object_id AND wv_featured_tr.term_taxonomy_id = %d)",
        $term->term_taxonomy_id
    );

    $clauses['orderby'] = '(wv_featured_tr.object_id IS NOT NULL) DESC, ' . $clauses['orderby'];

    return $clauses;
}, 20, 2);
