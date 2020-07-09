<?php

if ( ! function_exists( 'cartzilla_wc_product_categories' ) ) {

    function cartzilla_wc_product_categories( $atts, $content = null ){
        extract(shortcode_atts(array(
        	'type'              => 'product',
            'columns'           => '',
            'per_page'          => 6,
            'orderby'           => 'title',
            'order'             => 'date',
            'category'          => '',
            'hide_empty'        => true,
        ), $atts ) );

        $args = array(
        	'parent'             => 0,
        	'number'             => $per_page,
            'post_type'          => $type,
            'order'              => $order,
            'orderby'            => $orderby,
            'hide_empty'         => false,
            'taxonomy'           => 'product_cat',
            'slug'             	 => $category,
        );

	    $html = '';
        if( function_exists( 'cartzilla_product_categories' ) ) {
            ob_start();
            cartzilla_product_categories( $args );

            $html = ob_get_clean();
        }
        return $html;

	 }

}

add_shortcode( 'cartzilla_product_categories' , 'cartzilla_wc_product_categories' );