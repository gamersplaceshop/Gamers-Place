<?php
/**
 * Docs Icons
 *
 * Display the portfolio images meta box.
 *
 * @author      MadrasThemes
 * @category    Admin
 * @package     Cartzilla/Admin/Meta Boxes
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Cartzilla_Meta_Box_Docs_Featured_Icon Class.
 */
class Cartzilla_Meta_Box_Docs_Featured_Icon {

	/**
	 * Output the metabox.
	 *
	 * @param WP_Post $post
	 */
	public static function output( $post ) {
		global $post;

		wp_nonce_field( 'cartzilla_save_data', 'cartzilla_meta_nonce' );

		cartzilla_wp_text_input( array(
			'label' => esc_html__( 'Icon Class', 'cartzilla-extensions' ),
			'id'    => '_post_featured_icon'
		) );
	}

	/**
	 * Save meta box data.
	 *
	 * @param int     $post_id
	 * @param WP_Post $post
	 */
	public static function save( $post_id, $post ) {
		$post_id = (int) $post_id;
    	$post_type = get_post_type( $post_id );

		if ( $post_type ) {
	        if ( isset( $_POST['_post_featured_icon'] ) ) {
	            update_post_meta( $post_id, '_post_featured_icon', cartzilla_clean( $_POST['_post_featured_icon'] ) );
	        } else {
	            delete_post_meta( $post_id, '_post_featured_icon');
	        }
	    }
	    return $post_id;
	}
}
