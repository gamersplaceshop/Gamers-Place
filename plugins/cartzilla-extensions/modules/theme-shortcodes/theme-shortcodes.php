<?php

/**
 * Module Name          : Theme Shortcodes
 * Module Description   : Provides additional shortcodes for the Cartzilla theme
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if( ! class_exists( 'Cartzilla_Shortcodes' ) ) {
    class Cartzilla_Shortcodes {

        /**
         * Constructor function.
         * @access  public
         * @since   1.0.0
         * @return  void
         */
        public function __construct() {
            add_action( 'init', array( $this, 'setup_constants' ),  10 );
            add_action( 'init', array( $this, 'includes' ),         10 );
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
            if ( ! defined( 'CARTZILLA_EXTENSIONS_SHORTCODE_DIR' ) ) {
                define( 'CARTZILLA_EXTENSIONS_SHORTCODE_DIR', plugin_dir_path( __FILE__ ) );
            }

            // Plugin Folder URL
            if ( ! defined( 'CARTZILLA_EXTENSIONS_SHORTCODE_URL' ) ) {
                define( 'CARTZILLA_EXTENSIONS_SHORTCODE_URL', plugin_dir_url( __FILE__ ) );
            }

            // Plugin Root File
            if ( ! defined( 'CARTZILLA_EXTENSIONS_SHORTCODE_FILE' ) ) {
                define( 'CARTZILLA_EXTENSIONS_SHORTCODE_FILE', __FILE__ );
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

            #-----------------------------------------------------------------
            # Shortcodes
            #-----------------------------------------------------------------

         
            require_once CARTZILLA_EXTENSIONS_SHORTCODE_DIR . '/elements/compare-page.php';
            //require_once CARTZILLA_EXTENSIONS_SHORTCODE_DIR . '/elements/brands-blocks.php';
            require_once CARTZILLA_EXTENSIONS_SHORTCODE_DIR . '/elements/product-categories.php';
        }
    }
}

// Finally initialize code
new Cartzilla_Shortcodes();
