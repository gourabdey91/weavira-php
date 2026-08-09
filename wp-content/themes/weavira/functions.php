<?php 

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our theme. We will simply require it into the script here so that we
| don't have to worry about manually loading any of our classes later on.
|
*/

if (!file_exists($composer = __DIR__ . '/vendor/autoload.php')) {
  wp_die(__('Error locating autoloader. Please run <code>composer install</code>.', 'sage'));
}

require $composer;

/*
|--------------------------------------------------------------------------
| Register The Bootloader
|--------------------------------------------------------------------------
|
| The first thing we will do is schedule a new Acorn application container
| to boot when WordPress is finished loading the theme. The application
| serves as the "glue" for all the components of Laravel and is
| the IoC container for the system binding all of the various parts.
|
*/

if (!function_exists('\Roots\bootloader')) {
  wp_die(
    __('You need to install Acorn to use this theme.', 'sage'),
    '',
    [
      'link_url' => 'https://roots.io/acorn/docs/installation/',
      'link_text' => __('Acorn Docs: Installation', 'sage'),
    ]
  );
}

\Roots\bootloader()->boot();

/*
|--------------------------------------------------------------------------
| Register Sage Theme Files
|--------------------------------------------------------------------------
|
| Out of the box, Sage ships with categorically named theme files
| containing common functionality and setup to be bootstrapped with your
| theme. Simply add (or remove) files from the array below to change what
| is registered alongside Sage.
|
*/

collect(['setup', 'filters', 'product-csv'])
  ->each(function ($file) {
    if (!locate_template($file = "app/{$file}.php", true, true)) {
      wp_die(
        /* translators: %s is replaced with the relative file path */
        sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file)
      );
    }
  });



function my_remove_admin_menus()
{
  remove_menu_page('edit-comments.php');
  // remove_menu_page('nav-menus.php');
  // remove_submenu_page('themes.php', 'nav-menus.php');
  // menus
  // add_menu_page(
  //   'Menus',
  //   'Menus',
  //   'manage_options', 
  //   'nav-menus.php',
  //   'dashicons-menu',
  //   // 1
  // );
}

add_action('admin_menu', 'my_remove_admin_menus');



// Removes from post and pages
function remove_comment_support()
{
  remove_post_type_support('post', 'comments');
  remove_post_type_support('page', 'comments');
}

add_action('init', 'remove_comment_support', 100);


add_filter("editable_roles", function ($roles) {
  unset($roles["wpseo_manager"]);
  unset($roles["wpseo_editor"]);
  unset($roles["author"]);
  unset($roles["contributor"]);
  unset($roles["subscriber"]);

  return $roles;
  //    return ['administrator', 'cve_user'];
});

add_filter("custom_menu_order", "dgtlnk_custom_menu_order", 10, 1);

add_filter("menu_order", "dgtlnk_custom_menu_order", 10, 1);

function dgtlnk_custom_menu_order($menu_ord)
{
  if (!$menu_ord) {
    return true;
  }

  return [
    "index.php", // Dashboard
    "separator1", // Separator
    "edit.php", // Posts
    "edit.php?post_type=expert_article",
    "edit.php?post_type=pet_care_article",

    "separator2", // Separator
    "edit.php?post_type=page", // Pages
    "upload.php", // Media
    "edit.php?post_type=dog_product",
    "edit.php?post_type=cat_product",
    "edit.php?post_type=stockist",
    "edit.php?post_type=online_store",
    "edit.php?post_type=review",
    "wpcf7",
    "flamingo",

    "separator2", // Separator
   
  ];
}

// Removes from admin bar
function mytheme_admin_bar_render()
{
  global $wp_admin_bar;
  $wp_admin_bar->remove_menu('comments');
}

add_action('wp_before_admin_bar_render', 'mytheme_admin_bar_render');

function cc_mime_types($mimes)
{
  $mimes["svg"] = "image/svg+xml";
  return $mimes;
}

add_filter("upload_mimes", "cc_mime_types");

function wporg_image_editor_output_format($formats)
{
  // https://developer.wordpress.org/themes/functionality/media/images/
  // Automatically convert all sub-size images to webp on upload
  $formats["image/jpg"] = "image/webp";

  return $formats;
}

add_filter("image_editor_output_format", "wporg_image_editor_output_format");

/*
 * Remove wp logo from admin bar
 */
function placesst_remove_wp_logo()
{
  global $wp_admin_bar;

  if (class_exists('acf')) {
    $wp_help = get_field('arc_options_admin_wp_help', 'option');
    if (empty($wp_help)) {
      $wp_admin_bar->remove_menu('wp-logo');
    }
  }
}
add_action('wp_before_admin_bar_render', 'placesst_remove_wp_logo');
/*
 * Custom login logo
 */
function placesst_custom_login_logo()
{
  if (class_exists('acf')) {
    $wp_login_logo = get_field('arc_options_admin_login_logo', 'option');
    $wp_login_w = get_field('arc_options_admin_width', 'option');
    $wp_login_h = get_field('arc_options_admin_height', 'option');
    $wp_login_bg = get_field('arc_options_admin_bg', 'option');
    $wp_login_btn_c = get_field('arc_options_admin_buton_color', 'option');
    $wp_login_btn_c_h = get_field('arc_options_admin_buton_color_hover', 'option');
    if (!empty($wp_login_logo)) {
?>
<style type="text/css">
.login h1 a {
  background-image: url('<?php echo $wp_login_logo; ?>') !important;
  background-size:
    <?php echo $wp_login_w . 'px ';
  ?>auto ! important;
  <?php echo $wp_login_h . 'px';
  ?> !important;
  width: <?php echo $wp_login_w . 'px';
  ?> !important;
}
</style>
<?php
    }

    if (!empty($wp_login_bg)) {
    ?>
<style type="text/css">
.login label {
  color: #fff !important;
}

body.login {
  background: #133759 url("<?php echo $wp_login_bg; ?>") no-repeat center;
  background-size: cover;
}

body.login form {
  background: rgba(0, 0, 0, 0.2);
  padding: 40px;
}

.l ogin form {
  margin-top: 20px;
  margin-left: 0;
  padding: 26px 24px 34px;
  font-weight: 400;
  overflow: hidden;
  background: #fff;
  border: 1px solid #c3c4c7;
  box-shadow: 0 1px 3px rgb(0 0 0 / 4%);
}

body.login #login form p {
  margin-bottom: 15px;
}

.l ogin form .input,
.login input[type=password],
.login input[type=text] {
  min-height: 50px !important;
}

body.login #login {
  width: 460px !important;
}

.login #nav a,
.login #backtoblog a {
  color: #fff !important;
  margin: 24px 0 0 0;
  font-weight: 500
}

.l ogin label {
  font-size: 15px;
  line-height: 1.5;
  display: inline-block;
  margin-bottom: 3px;
  color: #fff;
  font-weight: 500
}

.login a.privacy-policy-link {
  color: #000;
  font-weight: 500
}

body.login div#login form#loginform input[type=password],
.login input[type=text] {
  padding: 12px 16px !important
}









body.login div#login form#loginform input#wp-submit {
  background-color:
    <?php echo $wp_login_btn_c;
  ?> !important;
  width: 160px;
  height: 50px;
  font-size: 20px;
}










body.login div#login form#loginform input#wp-submit:hover {
  background-color:
    <?php echo $wp_login_btn_c_h;
  ?> !important;
}
</style>
<?php
    }
  }
}
add_action('login_enqueue_scripts', 'placesst_custom_login_logo');
/*
 * Change custom login page url
 */
function placesst_loginpage_custom_link()
{
  $site_url = esc_url(home_url('/'));
  return $site_url;
}
add_filter('login_headerurl', 'placesst_loginpage_custom_link');
/*
 * Change title on logo
 */
function placesst_change_title_on_logo()
{
  $site_title = get_bloginfo('name');
  return $site_title;
}
add_filter('login_headertext', 'placesst_change_title_on_logo');
/*
 * Change admin your favicon
 */
function placesst_admin_favicon()
{
  if (class_exists('acf')) {
    $favicon_url = get_field('arc_options_admin_favicon', 'option');
    if (!empty($favicon_url)) {
      echo '<link rel="icon" type="image/x-icon" href="' . $favicon_url . '" />';
    }
  }
}
add_action('login_head', 'placesst_admin_favicon');
add_action('admin_head', 'placesst_admin_favicon');
add_action('wp_head', 'placesst_admin_favicon');

function ad_login_footer()
{
  $ref = wp_get_referer();
  if ($ref) : ?>
<script type="text/javascript">
jQuery(document).ready(function($) {
  jQuery("p#backtoblog a").attr("href", 'https://rajangupta.com/');
  jQuery("p#backtoblog a").empty();
});
</script>
<?php endif;
}
add_action('login_footer', 'ad_login_footer');

function origo_custom_admin_footer()
{
  _e('<span id="footer-thankyou">Designed & developed by <a href="https://rajangupta.com/" style="color:#f47c30">Rajan Gupta
    </a>', 'castree');
}
add_filter('admin_footer_text', 'origo_custom_admin_footer');


add_filter('use_block_editor_for_post', '__return_false');


#add_action('after_setup_theme', 'theme_custom_image_sizes');

function theme_custom_image_sizes()
{
  add_image_size('post-thumbnail', 431.33, 340, true);
  add_image_size('team-thumbnail', 351.5, 400, true);
}

// storie
// PHP function to load taxonomy options
 


// Map Api
  
 


// disable Comment

// Disable support for comments and trackbacks in post types
// (except 'product' — WooCommerce reviews run on the comments system)
function disable_comments_post_types_support()
{
  $post_types = get_post_types();
  foreach ($post_types as $post_type) {
    if ($post_type === 'product') {
      continue;
    }
    if (post_type_supports($post_type, 'comments')) {
      remove_post_type_support($post_type, 'comments');
      remove_post_type_support($post_type, 'trackbacks');
    }
  }
}
add_action('admin_init', 'disable_comments_post_types_support');

// Close comments on the front-end, except for products (WooCommerce reviews)
function disable_comments_status($open, $post_id = null)
{
  if ($post_id && get_post_type($post_id) === 'product') {
    return $open;
  }
  return false;
}
add_filter('comments_open', 'disable_comments_status', 20, 2);
add_filter('pings_open', 'disable_comments_status', 20, 2);

// Hide existing comments, except product reviews
function disable_comments_hide_existing_comments($comments, $post_id = 0)
{
  if ($post_id && get_post_type($post_id) === 'product') {
    return $comments;
  }
  return array();
}
add_filter('comments_array', 'disable_comments_hide_existing_comments', 10, 2);

// Remove comments page in menu
function disable_comments_admin_menu()
{
  remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'disable_comments_admin_menu');

// Redirect any user trying to access comments page
function disable_comments_admin_menu_redirect()
{
  global $pagenow;
  if ($pagenow === 'edit-comments.php') {
    wp_redirect(admin_url());
    exit;
  }
}
add_action('admin_init', 'disable_comments_admin_menu_redirect');

// Remove comments metabox from dashboard
function disable_comments_dashboard()
{
  remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}
add_action('admin_init', 'disable_comments_dashboard');

// Remove comments links from admin bar
function disable_comments_admin_bar()
{
  if (is_admin_bar_showing()) {
    remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
  }
}
add_action('init', 'disable_comments_admin_bar');
 

function is_current_url($url) {
  $current_url = home_url(add_query_arg(array()));
  return $current_url === $url;
}

function header_analytics_code() {
    $aCode = get_field('header_analytics_code', 'options');
    if ($aCode) {
        echo $aCode;
    }
}
add_action('wp_head', 'header_analytics_code');

function footer_footer_script() {
    $footerCode = get_field('footer_footer_script', 'options');
    if ($footerCode) {
        echo $footerCode;
    }
}
add_action('wp_footer', 'footer_footer_script');

 
function register_footer_menu() {
  register_nav_menu('footer-menu', __('Footer Menu', 'verypc')); 
}
add_action('after_setup_theme', 'register_footer_menu');

function hide_appearance_submenus() {
    remove_submenu_page('themes.php', 'widgets.php');
    remove_submenu_page('themes.php', 'theme-editor.php');
    remove_submenu_page('site-editor.php', 'site-editor.php');
    remove_submenu_page('themes.php', 'site-editor.php');
}
add_action('admin_menu', 'hide_appearance_submenus', 999);





add_filter('user_contactmethods', function ($methods) {
    $methods['linkedin'] = 'LinkedIn URL';
    $methods['instagram'] = 'Instagram URL';
    $methods['twitter'] = 'X / Twitter URL';
    return $methods;
});


add_filter('user_contactmethods', function ($methods) {
    unset($methods['aim'], $methods['yim'], $methods['jabber']);

    $methods['linkedin'] = __('LinkedIn URL', 'sage');
    $methods['instagram'] = __('Instagram URL', 'sage');
    $methods['twitter'] = __('X / Twitter URL', 'sage');
    $methods['youtube'] = __('YouTube URL', 'sage');
    $methods['facebook'] = __('Facebook URL', 'sage');

    return $methods;
});




// 


