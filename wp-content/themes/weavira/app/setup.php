<?php

/**
 * Theme setup.
 */

namespace App;

use function Roots\bundle;

define('IMAGE_PATH', get_template_directory_uri() . "/public/media");
/**
 * Register the theme assets.
 *
 * @return void
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400&family=DM+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap',
        [],
        null
    );
    wp_enqueue_style('main-style', get_template_directory_uri() . '/public/css/main.css', array(), filemtime(get_template_directory() . '/public/css/main.css'), 'all');


    wp_dequeue_script('jquery');

    wp_enqueue_script('icons-script', get_template_directory_uri() . '/public/js/icons.js', [], filemtime(get_template_directory() . '/public/js/icons.js'), true);
    wp_enqueue_script('weavira-script', get_template_directory_uri() . '/public/js/weavira.js', [], filemtime(get_template_directory() . '/public/js/weavira.js'), true);
    wp_enqueue_script('custom-script', get_template_directory_uri() . '/public/js/custom.js', [], filemtime(get_template_directory() . '/public/js/custom.js'), true);
    
    wp_localize_script('custom-script', 'ajax_object', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'review_nonce' => wp_create_nonce('weavira_submit_review'),
        'search_nonce' => wp_create_nonce('weavira_search_products'),
        'add_to_cart_url' => class_exists('WC_AJAX')
            ? \WC_AJAX::get_endpoint('add_to_cart')
            : admin_url('admin-ajax.php?action=woocommerce_add_to_cart'),
        'cart_nonce' => wp_create_nonce('weavira_cart_actions'),
        'wishlist_nonce' => wp_create_nonce('weavira_wishlist_actions'),
        'checkout_nonce' => wp_create_nonce('weavira_checkout_actions'),
        'wishlist_url' => \App\weavira_wishlist_page_url(),
        'saved_shipping_addresses' => (function_exists('is_checkout') && is_checkout() && is_user_logged_in())
            ? \App\weavira_get_shipping_addresses(get_current_user_id())
            : [],
        'saved_billing_addresses' => (function_exists('is_checkout') && is_checkout() && is_user_logged_in())
            ? \App\weavira_get_billing_addresses(get_current_user_id())
            : [],
    ));

}, 100);




/**
 * Register the theme assets with the block editor.
 *
 * @return void
 */
add_action('enqueue_block_editor_assets', function () {
    bundle('editor')->enqueue();
}, 100);

/**
 * Register the initial theme setup.
 *
 * @return void
 */
add_action('after_setup_theme', function () {
    /**
     * Enable features from the Soil plugin if activated.
     *
     * @link https://roots.io/plugins/soil/
     */
    add_theme_support('soil', [
        'clean-up',
        'nav-walker',
        'nice-search',
        'relative-urls',
    ]);

    /**
     * Disable full-site editing support.
     *
     * @link https://wptavern.com/gutenberg-10-5-embeds-pdfs-adds-verse-block-color-options-and-introduces-new-patterns
     */
    remove_theme_support('block-templates');

    /**
     * Register the navigation menus.
     *
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage'),
    ]);

    /**
     * Disable the default block patterns.
     *
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-the-default-block-patterns
     */
    remove_theme_support('core-block-patterns');

    /**
     * Enable plugins to manage the document title.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Enable post thumbnail support.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Declares WooCommerce support. Without this, WC registers the
     * `product` post type with `has_archive` forced to false (see
     * WC_Post_Types::register_post_types()), meaning the Shop page never
     * gets a real product-archive rewrite rule or query — it just renders
     * as an empty WP Page. This is what actually makes /shop/, product
     * categories, and attribute archives resolve to real product queries.
     *
     * @link https://developer.woocommerce.com/docs/theme-development/theme-declaration/
     */
    add_theme_support('woocommerce');

    /**
     * Enable responsive embed support.
     *
     * @link https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/#responsive-embedded-content
     */
    add_theme_support('responsive-embeds');

    /**
     * Enable HTML5 markup support.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', [
        'caption',
        'comment-form',
        'comment-list',
        'gallery',
        'search-form',
        'script',
        'style',
    ]);

    /**
     * Enable selective refresh for widgets in customizer.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#customize-selective-refresh-widgets
     */
    add_theme_support('customize-selective-refresh-widgets');
}, 20);

/**
 * Register the Journal post type and its category taxonomy, used by the
 * header's Journal mega menu (featured post + category tiles).
 *
 * @return void
 */
add_action('init', function () {
    register_post_type('journal', [
        'labels' => [
            'name' => __('Journal', 'sage'),
            'singular_name' => __('Journal Entry', 'sage'),
            'add_new_item' => __('Add New Journal Entry', 'sage'),
        ],
        'public' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => 'journal'],
        'menu_icon' => 'dashicons-book-alt',
        'supports' => ['title', 'editor', 'excerpt', 'thumbnail'],
        'show_in_rest' => true,
    ]);

    register_taxonomy('journal_category', 'journal', [
        'labels' => [
            'name' => __('Journal Categories', 'sage'),
            'singular_name' => __('Journal Category', 'sage'),
        ],
        'public' => true,
        'hierarchical' => true,
        'rewrite' => ['slug' => 'journal-category'],
        'show_in_rest' => true,
        'show_admin_column' => true,
    ]);
});

/**
 * Register the Wishlist post type. Each visitor (guest or logged-in) owns
 * exactly one wishlist post, resolved by App\weavira_get_wishlist_post() in
 * app/filters.php. The post's slug doubles as its shareable link token, so
 * it stays private (no public archive/front-end routing of its own).
 *
 * @return void
 */
add_action('init', function () {
    register_post_type('wv_wishlist', [
        'labels' => [
            'name' => __('Wishlists', 'sage'),
            'singular_name' => __('Wishlist', 'sage'),
        ],
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => false,
        'supports' => ['title'],
        'capability_type' => 'post',
    ]);
});

/**
 * Register the Heritage Designs post type — one entry per saree motif
 * (Pasapalli, Rudrakhya, Lotus, ...), each with its own story, image, and
 * Inspiration classification, per html/heritage-designs.html. Also attaches
 * the existing pa_weave product attribute taxonomy (Sambalpuri, Bomkai) so
 * the page's Weave filter reuses real catalogue data instead of a
 * duplicate taxonomy.
 *
 * @return void
 */
add_action('init', function () {
    register_post_type('heritage_design', [
        'labels' => [
            'name' => __('Heritage Designs', 'sage'),
            'singular_name' => __('Heritage Design', 'sage'),
            'add_new_item' => __('Add New Heritage Design', 'sage'),
        ],
        'public' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => 'heritage-designs'],
        'menu_icon' => 'dashicons-art',
        'supports' => ['title', 'editor', 'excerpt', 'thumbnail'],
        'show_in_rest' => true,
    ]);

    register_taxonomy('heritage_inspiration', 'heritage_design', [
        'labels' => [
            'name' => __('Inspiration', 'sage'),
            'singular_name' => __('Inspiration', 'sage'),
        ],
        'public' => true,
        'hierarchical' => true,
        'rewrite' => ['slug' => 'heritage-inspiration'],
        'show_in_rest' => true,
        'show_admin_column' => true,
    ]);

    if (taxonomy_exists('pa_weave')) {
        register_taxonomy_for_object_type('pa_weave', 'heritage_design');
    }

    // Reuses the same Body Primary Colour taxonomy (and its swatch_color
    // term field) as the Shop page's Color filter, for consistency.
    if (taxonomy_exists('pa_body-primary-colour')) {
        register_taxonomy_for_object_type('pa_body-primary-colour', 'heritage_design');
    }
});

/**
 * Register the theme sidebars.
 *
 * @return void
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ];

    register_sidebar([
        'name' => __('Primary', 'sage'),
        'id' => 'sidebar-primary',
    ] + $config);

    register_sidebar([
        'name' => __('Footer', 'sage'),
        'id' => 'sidebar-footer',
    ] + $config);
});


// 
