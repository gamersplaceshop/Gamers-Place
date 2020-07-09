<?php
/**
 * This is in charge of enabling/disabling blocks WP-side.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'cartzillagb_get_disabled_blocks' ) ) {

	/**
	 * Gets the list of block names of the disabled blocks.
	 *
	 * @return Array
	 */
	function cartzillagb_get_disabled_blocks() {
		$disabled_blocks = get_option( 'cartzillagb_disabled_blocks' );
		if ( false === $disabled_blocks ) {
			return array();
		}

		return $disabled_blocks;
	}
}

if ( ! function_exists( 'cartzillagb_ajax_update_disable_blocks' ) ) {

	/**
	 * Ajax handler for saving the list of disabled blocks.
	 */
	function cartzillagb_ajax_update_disable_blocks() {
		$nonce = isset( $_POST['nonce'] ) ? sanitize_key( $_POST['nonce'] ) : '';

		if ( ! wp_verify_nonce( $nonce, 'cartzillagb_disable_blocks' ) ) {
			wp_send_json_error( __( 'Security error, please refresh the page and try again.', CZGB_I18N ) );
		}

		$disabled_blocks = isset( $_POST['disabledBlocks'] ) ? $_POST['disabledBlocks'] : array();
		update_option( 'cartzillagb_disabled_blocks', $disabled_blocks );
		wp_send_json_success();
	}
	add_action( 'wp_ajax_cartzillagb_update_disable_blocks', 'cartzillagb_ajax_update_disable_blocks' );
}

if ( ! function_exists( 'cartzillagb_get_disabled_blocks_nonce' ) ) {

	/**
	 * Create a nonce for disabling blocks.
	 *
	 * @return String
	 */
	function cartzillagb_get_disabled_blocks_nonce() {
		return wp_create_nonce( 'cartzillagb_disable_blocks' );
	}
}
