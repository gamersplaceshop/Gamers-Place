<?php
/**
 * Plugin Name: Cartzilla Gutenberg Blocks
 * Plugin URI: https://demo2.madrasthemes.com/cartzilla/
 * Description: Gutenberg Blocks for Cartzilla WordPress Theme
 * Author: MadrasThemes
 * Author URI: https://madrasthemes.com/
 * Text Domain: cartzillagb
 * Version: 1.0.2
 *
 * @package CartzillaGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

defined( 'CZGB_SHOW_PRO_NOTICES' ) || define( 'CZGB_SHOW_PRO_NOTICES', true );
defined( 'CZGB_VERSION' ) || define( 'CZGB_VERSION', '1.0.2' );
defined( 'CZGB_FILE' ) || define( 'CZGB_FILE', __FILE__ );
defined( 'CZGB_I18N' ) || define( 'CZGB_I18N', 'cartzillagb-ultimate-gutenberg-blocks' ); // Plugin slug.
defined( 'CZGB_CLOUDFRONT_URL' ) || define( 'CZGB_CLOUDFRONT_URL', 'https://d3gt1urn7320t9.cloudfront.net' ); // CloudFront CDN URL

/********************************************************************************************
 * Activation & PHP version checks.
 ********************************************************************************************/

if ( ! function_exists( 'cartzillagb_php_requirement_activation_check' ) ) {

	/**
	 * Upon activation, check if we have the proper PHP version.
	 * Show an error if needed and don't continue with the plugin.
	 *
	 * @since 1.9
	 */
	function cartzillagb_php_requirement_activation_check() {
		if ( version_compare( PHP_VERSION, '5.3.0', '<' ) ) {
			deactivate_plugins( basename( __FILE__ ) );
			wp_die(
				sprintf(
					__( '%s"CartzillaGB" can not be activated. %s It requires PHP version 5.3.0 or higher, but PHP version %s is used on the site. Please upgrade your PHP version first ✌️ %s Back %s', CZGB_I18N ),
					'<strong>',
					'</strong><br><br>',
					PHP_VERSION,
					'<br /><br /><a href="' . esc_url( get_dashboard_url( get_current_user_id(), 'plugins.php' ) ) . '" class="button button-primary">',
					'</a>'
				)
			);
		}
	}
	register_activation_hook( __FILE__, 'cartzillagb_php_requirement_activation_check' );
}

/**
 * Always check the PHP version at the start.
 * If the PHP version isn't sufficient, don't continue to prevent any unwanted errors.
 *
 * @since 1.9
 */
if ( version_compare( PHP_VERSION, '5.3.0', '<' ) ) {
	if ( ! function_exists( 'cartzillagb_php_requirement_notice' ) ) {
		function cartzillagb_php_requirement_notice() {
	        printf(
	            '<div class="notice notice-error"><p>%s</p></div>',
	            sprintf( __( '"CartzillaGB" requires PHP version 5.3.0 or higher, but PHP version %s is used on the site.', CZGB_I18N ), PHP_VERSION )
	        );
		}
	}
	add_action( 'admin_notices', 'cartzillagb_php_requirement_notice' );
	return;
}

/**
 * Always keep note of the CartzillaGB version.
 *
 * @since 2.0
 */
if ( ! function_exists( 'cartzillagb_version_upgrade_check' ) ) {
	function cartzillagb_version_upgrade_check() {
		// This is triggered only when V1 was previously activated, and this is the first time V2 is activated.
		// Will not trigger after successive V2 activations.
		if ( get_option( 'cartzillagb_activation_date' ) && ! get_option( 'cartzillagb_current_version_installed' ) ) {
			update_option( 'cartzillagb_current_version_installed', '1' );
		}

		// Always check the current version installed. Trigger if it changes.
		if ( get_option( 'cartzillagb_current_version_installed' ) !== CZGB_VERSION ) {
			do_action( 'cartzillagb_version_upgraded', get_option( 'cartzillagb_current_version_installed' ), CZGB_VERSION );
			update_option( 'cartzillagb_current_version_installed', CZGB_VERSION );
		}
	}
	add_action( 'admin_menu', 'cartzillagb_version_upgrade_check', 1 );
}

/********************************************************************************************
 * END Activation & PHP version checks.
 ********************************************************************************************/

/**
 * Block Initializer.
 */
require_once( plugin_dir_path( __FILE__ ) . 'src/ajax-functions.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/shortcode/index.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/disabled-blocks.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/init.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/fonts.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/jetpack.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/design-library/init.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/metabox.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/header/index.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/footer/index.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/hero-search-form/index.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/megamenu-nav-menu/index.php' );

if ( ! class_exists( 'Cartzilla_Products' ) ) {
	require_once( plugin_dir_path( __FILE__ ) . 'src/class-cartzilla-products.php' );
}
