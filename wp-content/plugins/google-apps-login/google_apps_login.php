<?php
/**
 * Plugin Name: 	  Google Apps Login
 * Plugin URI: 		  https://wp-glogin.com/
 * Description: 	  Simple secure login for WordPress through users' Google Apps accounts (uses secure OAuth2, and MFA if enabled)
 * Requires at least: 5.5
 * Requires PHP:      7.2
 * Version: 		  3.5.2
 * Author: 			  WP Glogin Team
 * Author URI: 		  https://wp-glogin.com/
 * Text Domain: 	  google-apps-login
 * Domain Path: 	  /lang
 * Network: 		  true
 *
 * Google Apps Login is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Google Apps Login is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Google Apps Login. If not, see <https://www.gnu.org/licenses/>.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'Core_Google_Apps_Login' ) ) {
	global $gal_core_already_exists;
	$gal_core_already_exists = true;
} else {
	require_once plugin_dir_path( __FILE__ ) . '/core/core_google_apps_login.php';
}

/**
 * The main plugin class.
 */
class Basic_Google_Apps_Login extends Core_Google_Apps_Login {

	protected $plugin_version = '3.5.2';

	/**
	 * Singleton Var.
	 *
	 * @var Basic_Google_Apps_Login
	 */
	private static $instance;

	/**
	 * Singleton
	 *
	 * @return object
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Activation Hook.
	 *
	 * @param bool $network_wide Is Network Wide.
	 *
	 * @return void
	 */
	public function ga_activation_hook( $network_wide ) {
		parent::ga_activation_hook( $network_wide );

		// If installed previously, keep 'poweredby' to off (default) since they were used to that.
		$old_options = get_site_option( $this->get_options_name() );

		if ( ! $old_options ) {
			$new_options                 = $this->get_option_galogin();
			$new_options['ga_poweredby'] = true;
			$this->save_option_galogin( $new_options );
		}
	}

	protected function add_actions() {
		parent::add_actions();
	}

	protected function ga_section_text_end() {
		?>

		<p>
			<strong>
				<?php esc_html_e( 'For full support, and premium features that greatly simplify WordPress user management for admins, please visit:', 'google-apps-login' ); ?>
				<a href="https://wp-glogin.com/glogin/?utm_source=Admin%20Promo&utm_medium=freemium&utm_campaign=Freemium" target="_blank">https://wp-glogin.com/</a>
			</strong>
		</p>

		<?php
	}

	/**
	 * Admin area sidebar.
	 */
	protected function ga_options_do_sidebar() {

		$upgradelink = 'https://wp-glogin.com/glogin/?utm_source=Admin%20Sidebar&utm_medium=freemium&utm_campaign=Freemium';
		$drivelink   = 'https://wp-glogin.com/drive/?utm_source=Admin%20Sidebar&utm_medium=freemium&utm_campaign=Drive';
		?>

		<div id="gal-tableright" class="gal-tablecell">

			<div>
				<a href="<?php echo esc_url( $upgradelink ); ?>" target="_blank">
					<img alt="<?php esc_attr_e( 'Login upgrade', 'google-apps-login' ); ?>" src="<?php echo esc_url( $this->my_plugin_url() . 'img/basic_loginupgrade.png' ); ?>" />
				</a>
				<span>
					<?php
					printf(
						wp_kses( /* translators: %s: Link to the site. */
							__( 'Buy our <a href="%s" target="_blank">premium Login plugin</a> to revolutionize user management', 'google-apps-login' ),
							[ 'a' => [ 'href' => [], 'target' => [] ] ]
						),
						esc_url( $upgradelink )
					);
					?>
				</span>
			</div>

			<div>
				<a href="<?php echo esc_url( $drivelink ); ?>" target="_blank">
					<img alt="<?php esc_attr_e( 'Google Drive Embedder Plugin', 'google-apps-login' ); ?>" src="<?php echo esc_url( $this->my_plugin_url() . 'img/basic_driveplugin.png' ); ?>" />
				</a>
				<span>
					<?php
					printf(
						wp_kses( /* translators: %s: Link to the site. */
							__( 'Try our <a href="%s" target="_blank">Google Drive Embedder</a> plugin', 'google-apps-login' ),
							[ 'a' => [ 'href' => [], 'target' => [] ] ]
						),
						esc_url( $drivelink )
					);
					?>
				</span>
			</div>
		</div>

		<?php
	}

	/**
	 * Admin area: Domain Control section.
	 */
	protected function ga_domainsection_text() {

		?>

		<div id="domain-section" class="galtab">
			<p>
				<?php esc_html_e( 'The Domain Control section is only applicable to the premium and enterprise versions of this plugin.', 'google-apps-login' ); ?>
			</p>

			<p>
				<?php esc_html_e( 'In this basic version of the plugin, any existing WordPress account corresponding to a Google email address can authenticate via Google.', 'google-apps-login' ); ?>
			</p>

			<h3><?php esc_html_e( 'Premium Upgrade', 'google-apps-login' ); ?></h3>

			<p>
				<?php esc_html_e( 'In our professional plugins, you can specify your G Suite (Google Apps) domain name to obtain more powerful features.', 'google-apps-login' ); ?>
			</p>

			<ul class="ul-disc">
				<li><?php esc_html_e( 'Save time and increase security', 'google-apps-login' ); ?></li>
				<li><?php esc_html_e( 'Completely forget about WordPress user management - it syncs users from G Suite (Google Apps) automatically', 'google-apps-login' ); ?></li>
				<li><?php esc_html_e( 'Ensures that employees who leave or change roles no longer have unauthorized access to sensitive sites', 'google-apps-login' ); ?></li>
				<li><?php esc_html_e( 'Specify Google Groups or Organizational Units whose members should be mapped to different roles in WordPress (Enterprise only)', 'google-apps-login' ); ?></li>
			</ul>

			<p>
				<?php esc_html_e( 'Find out more about purchase options on our website:', 'google-apps-login' ); ?>
				<a href="https://wp-glogin.com/glogin/?utm_source=Domain%20Control&utm_medium=freemium&utm_campaign=Freemium" target="_blank">https://wp-glogin.com/</a>
			</p>
		</div>

		<?php
	}

	protected function set_other_admin_notices() {
		global $pagenow;

		if ( in_array( $pagenow, array( 'users.php', 'user-new.php' ), true ) ) {
			$no_thanks = get_user_meta( get_current_user_id(), $this->get_options_name() . '_no_thanks', true );

			if ( ! $no_thanks ) {

				if ( isset( $_REQUEST['google_apps_login_action'] ) && $_REQUEST['google_apps_login_action'] === 'no_thanks' ) {
					$this->ga_said_no_thanks( null );
				}

				add_action( 'admin_notices', array( $this, 'ga_user_screen_upgrade_message' ) );

				if ( is_multisite() ) {
					add_action( 'network_admin_notices', array( $this, 'ga_user_screen_upgrade_message' ) );
				}
			}
		}
	}

	public function ga_said_no_thanks( $data ) {
		update_user_meta( get_current_user_id(), $this->get_options_name() . '_no_thanks', true );
		wp_safe_redirect( remove_query_arg( 'google_apps_login_action' ) );
		exit;
	}

	public function ga_user_screen_upgrade_message() {

		$purchase_url = 'https://wp-glogin.com/glogin/?utm_source=User%20Pages&utm_medium=freemium&utm_campaign=Freemium';
		$nothanks_url = add_query_arg( 'google_apps_login_action', 'no_thanks' );
		?>

		<div class="updated">
			<p>
				<?php
				printf(
					wp_kses(/* translators: %s: Link to the site. */
						esc_html__( 'Completely forget about WordPress user management - upgrade to <a href="%s">Login for Google Apps Premium or Enterprise</a> to automatically sync users from your Google Apps domain', 'google-apps-login' ),
						[ 'a' => [ 'href' => [] ] ]
					),
					esc_url( $purchase_url )
				);
				?>
				<br>
				<a href="<?php echo esc_url( $purchase_url ); ?>" class="button-secondary"><?php echo esc_html__( 'Find out more', 'google-apps-login' ); ?></a>&nbsp;
				<a href="<?php echo esc_url( $nothanks_url ) ?>" class="button-secondary"><?php echo esc_html__( 'No Thanks', 'google-apps-login' ); ?></a>
			</p>
		</div>

		<?php
	}

	public function my_plugin_basename() {

		$basename = plugin_basename( __FILE__ );

		if ( __FILE__ === '/' . $basename ) { // Maybe due to symlink.
			$basename = basename( dirname( __FILE__ ) ) . '/' . basename( __FILE__ );
		}

		return $basename;
	}

	protected function my_plugin_url() {

		$basename = plugin_basename( __FILE__ );

		if ( __FILE__ === '/' . $basename ) { // Maybe due to symlink.
			return plugins_url() . '/' . basename( dirname( __FILE__ ) ) . '/';
		}

		// Normal case (non symlink).
		return plugin_dir_url( __FILE__ );
	}
}

/**
 * Plugin Init Method
 *
 * @return Basic_Google_Apps_Login
 */
function gal_basic_google_apps_login() {
	return Basic_Google_Apps_Login::get_instance();
}

// Initialise at least once.
gal_basic_google_apps_login();

if ( ! function_exists( 'google_apps_login' ) ) {
	/**
	 * Plugin Init Method
	 *
	 * @return Basic_Google_Apps_Login
	 */
	function google_apps_login() {
		return gal_basic_google_apps_login();
	}
}
