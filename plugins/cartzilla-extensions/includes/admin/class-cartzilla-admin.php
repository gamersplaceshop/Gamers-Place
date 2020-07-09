<?php
/**
 * Cartzilla Admin
 *
 * @class    Cartzilla_Admin
 * @author   MadrasThemes
 * @category Admin
 * @package  CartzillaExtensions/Admin
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Cartzilla_Admin class.
 */
class Cartzilla_Admin {

    /**
     * Constructor.
     */
    public function __construct() {
        add_action( 'init', array( $this, 'includes' ) );
        add_action( 'admin_init', array( $this, 'buffer' ), 1 );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_styles' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );

    }

    /**
     * Output buffering allows admin screens to make redirects later on.
     */
    public function buffer() {
        ob_start();
    }

    /**
     * Include any classes we need within admin.
     */
    public function includes() {
        include_once dirname( __FILE__ ) . '/cartzilla-meta-box-functions.php';
        include_once dirname( __FILE__ ) . '/class-cartzilla-admin-meta-boxes.php';
    }

    /**
     * Enqueue style.
     */
    public function admin_styles() {

        $screen    = get_current_screen();
        $screen_id = $screen ? $screen->id : '';

        //wp_register_style( 'cartzilla_admin_styles', Cartzilla_Extensions()->plugin_url() . '/assets/css/admin/admin.css', array(), CARTZILLA_VERSION );
        //wp_enqueue_style( 'cartzilla_admin_styles' );
    }

    /**
     * Enqueue scripts.
     */
    public function admin_scripts() {
        global $wp_query, $post;

        $screen              = get_current_screen();
        $screen_id           = $screen ? $screen->id : '';
        $cartzilla_screen_id = sanitize_title( __( 'Cartzilla', 'cartzilla-extensions' ) );
        $suffix              = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

        if ( in_array( $screen_id, array( 'jetpack-portfolio' ) ) ) {
            //wp_enqueue_media();
            //wp_register_script( 'cartzilla-admin-portfolio-meta-boxes', Cartzilla_Extensions()->plugin_url() . '/assets/js/admin/meta-boxes-portfolio' . $suffix . '.js', array( 'jquery', 'jquery-ui-sortable', 'media-models' ), CARTZILLA_VERSION );
            //wp_enqueue_script( 'cartzilla-admin-portfolio-meta-boxes' );
        }
    }

    /**
     * Include admin files conditionally.
     */
    public function conditional_includes() {
        if ( ! $screen = get_current_screen() ) {
            return;
        }
    }
}

return new Cartzilla_Admin();
