<?php
/**
 * Server-side rendering of the `czgb/shortcode` block.
 *
 * @package TologGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Renders the `czgb/shortcode` block on server.
 *
 * @since 1.0
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */
if ( ! function_exists( 'cartzillagb_render_shortcode_block' ) ) {
    function cartzillagb_render_shortcode_block( $attributes ) {
        if( ! empty( $attributes['text'] ) && ! empty( $attributes["className"] ) ) {
            return '<div class="czgb-shortcode ' . esc_attr( $attributes["uniqueClass"] ) . esc_attr( ! empty( $attributes["className"] ) ? ' ' . $attributes["className"] : '' ) . '">' . do_shortcode( $attributes['text'] ) . '</div>';
        } else {
            return ! empty( $attributes['text'] ) ? do_shortcode( $attributes['text'] ) : '';
        }
    }
}

if ( ! function_exists( 'cartzillagb_register_shortcode_block' ) ) {
    /**
     * Registers the `czgb/shortcode` block on server.
     */
    function cartzillagb_register_shortcode_block() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        register_block_type(
            'czgb/shortcode',
            array(
                'attributes'      => array(
                    'label' => array(
                        'type'   => 'string',
                    ),
                    'placeholder' => array(
                        'type'   => 'string',
                    ),
                    'text' => array(
                        'type'   => 'string',
                    ),
                    'className'     => array(
                        'type'      => 'string',
                    ),
                    'uniqueClass'  => array(
                        'type'      => 'string',
                    ),
                ),
                'render_callback' => 'cartzillagb_render_shortcode_block',
            )
        );
    }
    add_action( 'init', 'cartzillagb_register_shortcode_block' );
}