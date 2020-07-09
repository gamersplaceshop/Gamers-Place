<?php
/**
 * Server-side rendering of the `czgb/hero-search-form` block.
 *
 * @package FrontGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Renders the `czgb/hero-search-form` block on server.
 *
 * @since 1.7
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */
if ( ! function_exists( 'cartzillagb_render_hero_search_form_block' ) ) {
    function cartzillagb_render_hero_search_form_block( $attributes ) {


        $keywordsPlaceholderText      = isset( $attributes['keywordsPlaceholderText'] ) ? $attributes['keywordsPlaceholderText'] : 'Start your search';

        $dropdownText      = isset( $attributes['dropdownText'] ) ? $attributes['dropdownText'] : 'All categories';

        $uniqueClass      = isset( $attributes['uniqueClass'] ) ? $attributes['uniqueClass'] : '';

        $className      = isset( $attributes['className'] ) ? $attributes['className'] : '';


        add_filter( 'cartzilla_search_placehler_text', function() use ($keywordsPlaceholderText) {
            return $keywordsPlaceholderText;
        } );

        add_filter( 'cartzilla_search_dropdown_text', function() use ($dropdownText) {
            return $dropdownText;
        } );


        extract( $attributes );

        ob_start();

        echo cartzilla_search_form( $attributes ); 
            
        return ob_get_clean();
    }
}

if ( ! function_exists( 'cartzillagb_register_hero_search_form_block' ) ) {
    /**
     * Registers the `czgb/hero-search-form` block on server.
     */
    function cartzillagb_register_hero_search_form_block() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        register_block_type(
            'czgb/hero-search-form',
            array(
                'attributes' => array(
                    'className' => array(
                        'type' => 'string',
                    ),

                    'keywordsPlaceholderText' => array(
                        'type'    => 'string',
                        'default' =>  __(  "Start your search", CZGB_I18N ),
                    ),
                    'dropdownText' => array(
                        'type'    => 'string',
                        'default' =>  __(  "All categories", CZGB_I18N ),
                    ),
                    'uniqueClass' => array(
                        'type' => 'string',

                    ),

                ),
                'render_callback' => 'cartzillagb_render_hero_search_form_block',
            )
        );
    }
    add_action( 'init', 'cartzillagb_register_hero_search_form_block' );
}
