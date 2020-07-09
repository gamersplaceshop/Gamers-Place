<?php
/**
 * Plugin Name:     Cartzilla Extensions
 * Plugin URI:      https://madrasthemes.com/cartzilla
 * Description:     This selection of extensions compliment our theme Cartzilla. Please note: they don’t work with any WordPress theme, just Cartzilla.
 * Author:          MadrasThemes
 * Author URI:      https://madrasthemes.com/
 * Version:         1.0.2
 * Text Domain:     cartzilla-extensions
 * Domain Path:     /languages
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define CARTZILLA_PLUGIN_FILE.
if ( ! defined( 'CARTZILLA_PLUGIN_FILE' ) ) {
    define( 'CARTZILLA_PLUGIN_FILE', __FILE__ );
}

if( ! class_exists( 'Cartzilla_Extensions' ) ) {
    /**
     * Main Cartzilla_Extensions Class
     *
     * @class Cartzilla_Extensions
     * @version 1.0.0
     * @since 1.0.0
     * @package Cartzilla
     * @author MadrasThemes
     */
    final class Cartzilla_Extensions {

        /**
         * Cartzilla_Extensions The single instance of Cartzilla_Extensions.
         * @var     object
         * @access  private
         * @since   1.0.0
         */
        private static $_instance = null;

        /**
         * The token.
         * @var     string
         * @access  public
         * @since   1.0.0
         */
        public $token;

        /**
         * The version number.
         * @var     string
         * @access  public
         * @since   1.0.0
         */
        public $version;

        /**
         * Constructor function.
         * @access  public
         * @since   1.0.0
         * @return  void
         */
        public function __construct () {

            $this->token    = 'cartzilla-extensions';
            $this->version  = '1.0.0';

            add_action( 'plugins_loaded',       array( $this, 'setup_constants' ),              10 );
            add_action( 'plugins_loaded',       array( $this, 'includes' ),                     20 );
        }

        /**
         * Main Cartzilla_Extensions Instance
         *
         * Ensures only one instance of Cartzilla_Extensions is loaded or can be loaded.
         *
         * @since 1.0.0
         * @static
         * @see Cartzilla_Extensions()
         * @return Main Cartzilla instance
         */
        public static function instance () {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        /**
         * Setup plugin constants
         *
         * @access public
         * @since  1.0.0
         * @return void
         */
        public function setup_constants() {

            // Plugin Folder Path
            if ( ! defined( 'CARTZILLA_EXTENSIONS_DIR' ) ) {
                define( 'CARTZILLA_EXTENSIONS_DIR', plugin_dir_path( __FILE__ ) );
            }

            // Plugin Folder URL
            if ( ! defined( 'CARTZILLA_EXTENSIONS_URL' ) ) {
                define( 'CARTZILLA_EXTENSIONS_URL', plugin_dir_url( __FILE__ ) );
            }

            // Plugin Root File
            if ( ! defined( 'CARTZILLA_EXTENSIONS_FILE' ) ) {
                define( 'CARTZILLA_EXTENSIONS_FILE', __FILE__ );
            }

            // Modules File
            if ( ! defined( 'CARTZILLA_MODULES_DIR' ) ) {
                define( 'CARTZILLA_MODULES_DIR', CARTZILLA_EXTENSIONS_DIR . '/modules' );
            }

            $this->define( 'CARTZILLA_ABSPATH', dirname( CARTZILLA_EXTENSIONS_FILE ) . '/' );
            $this->define( 'CARTZILLA_VERSION', $this->version );
        }

        /**
         * Define constant if not already set.
         *
         * @param string      $name  Constant name.
         * @param string|bool $value Constant value.
         */
        private function define( $name, $value ) {
            if ( ! defined( $name ) ) {
                define( $name, $value );
            }
        }

        /**
         * What type of request is this?
         *
         * @param  string $type admin, ajax, cron or cartzillaend.
         * @return bool
         */
        private function is_request( $type ) {
            switch ( $type ) {
                case 'admin':
                    return is_admin();
                case 'ajax':
                    return defined( 'DOING_AJAX' );
                case 'cron':
                    return defined( 'DOING_CRON' );
                case 'cartzillaend':
                    return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' ) && ! $this->is_rest_api_request();
            }
        }

        /**
         * Include required files
         *
         * @access public
         * @since  1.0.0
         * @return void
         */
        public function includes() {
            /**
             * Class autoloader.
             */
            include_once CARTZILLA_EXTENSIONS_DIR . '/includes/class-cartzilla-autoloader.php';

            /**
             * Core classes.
             */
            require CARTZILLA_EXTENSIONS_DIR . '/includes/functions.php';

            /**
             * Theme Shortcodes
             */
            require_once CARTZILLA_MODULES_DIR . '/theme-shortcodes/theme-shortcodes.php';

            if ( $this->is_request( 'admin' ) ) {
                include_once CARTZILLA_EXTENSIONS_DIR . '/includes/admin/class-cartzilla-admin.php';
            }
        }

        /**
         * Get the plugin url.
         *
         * @return string
         */
        public function plugin_url() {
            return untrailingslashit( plugins_url( '/', CARTZILLA_PLUGIN_FILE ) );
        }

        /**
         * Cloning is forbidden.
         *
         * @since 1.0.0
         */
        public function __clone () {
            _doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'cartzilla-extensions' ), '1.0.0' );
        }

        /**
         * Unserializing instances of this class is forbidden.
         *
         * @since 1.0.0
         */
        public function __wakeup () {
            _doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'cartzilla-extensions' ), '1.0.0' );
        }
    }
}

/**
 * Returns the main instance of Cartzilla_Extensions to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object Cartzilla_Extensions
 */
function Cartzilla_Extensions() {
    return Cartzilla_Extensions::instance();
}

/**
 * Initialise the plugin
 */
Cartzilla_Extensions();
