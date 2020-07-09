<?php

if ( ! function_exists( 'cartzilla_wc_brands_element' ) ) {

    function cartzilla_wc_brands_element( $atts, $content = null ){
        extract(shortcode_atts(array(
            'columns'           => $columns,
            'section_title'     => '',
            'limit'             => 12,
            'orderby'           => 'date',
            'order'             => 'DESC',
            'slugs'             => '',
            'hide_empty'        => false,
        ), $atts));

        $section_args = array(
            'section_title'           => $section_title
        );

        $taxonomy_args = array(
            'orderby'           => $orderby,
            'order'             => $order,
            'number'            => $limit,
            'hide_empty'        => $hide_empty
        );


        $html = '';
        if( function_exists( 'cartzilla_wc_brands' ) ) {
            ob_start();
            cartzilla_wc_brands( $section_args, $taxonomy_args );
            $html = ob_get_clean();
        }

        return $html;
    }
    

}

add_shortcode( 'cartzilla_brands' , 'cartzilla_wc_brands_element' );

