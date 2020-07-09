<?php
/**
 * Server-side rendering of the `czgb/megamenu-nav-menu` block.
 *
 * @package CartzillaGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Renders the `czgb/megamenu-nav-menu` block on server.
 *
 * @since 1.0
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */
if ( ! function_exists( 'cartzillagb_render_megamenu_nav_menu_block' ) ) {
    function cartzillagb_render_megamenu_nav_menu_block( $attributes ) {
        ob_start();
        if( function_exists( 'cartzillagb_megamenu_nav_menu' ) ) {
            cartzillagb_megamenu_nav_menu( $attributes );
        }
        return ob_get_clean();
    }
}

if ( ! function_exists( 'cartzillagb_megamenu_nav_menu' ) ) {
    function cartzillagb_megamenu_nav_menu( $args = array() ) {
        $defaults = array(
            'className'                 => '',
            'megaMenuSlug'              => '',
        );

        $args = wp_parse_args( $args, $defaults );
        extract( $args );


        $nav_menu_args = array(
            'fallback_cb'    => false,
            'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
            'container'      => false,
            'menu_class'     => 'dropdown-menu',
            'walker'         => new WP_Bootstrap_Navwalker(),
            'depth'              => 0,
            'classes'        => array(
                'nav-link'        => 'dropdown-item'
            )
        );

        if( ! empty( $megaMenuSlug ) ) {
            $nav_menu_args['menu'] = $megaMenuSlug;
        }
        wp_nav_menu( $nav_menu_args );

    }
}

if ( ! function_exists( 'cartzillagb_register_megamenu_nav_menu_block' ) ) {
    /**
     * Registers the `czgb/megamenu-nav-menu` block on server.
     */
    function cartzillagb_register_megamenu_nav_menu_block() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        register_block_type(
            'czgb/megamenu-nav-menu',
            array(
                'attributes' => array(
                    'className' => array(
                        'type' => 'string',
                    ),
                    'megaMenuSlug' => array(
                        'type' => 'string',
                        'default' => ''
                    ),
                ),
                'render_callback' => 'cartzillagb_render_megamenu_nav_menu_block',
            )
        );
    }
    add_action( 'init', 'cartzillagb_register_megamenu_nav_menu_block' );
}