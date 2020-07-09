<?php
/**
 * Server-side rendering of the `czgb/footer` block.
 *
 * @package CartzillaGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Renders the `czgb/footer` block on server.
 *
 * @since 1.0
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */

if ( ! function_exists( 'cartzilla_render_footer_block' ) ) {
	function cartzilla_render_footer_block( $attributes ) {

		if ( $attributes['enableFooterWidgets'] == false ) {
			add_filter( 'cartzilla_enable_footer_widgets', '__return_false' );
		} else {
			add_filter( 'cartzilla_enable_footer_widgets', '__return_true' );
		}

		if ( $attributes['enableFooterStaticContent'] == false ) {
			add_filter( 'cartzilla_enable_footer_static_content', '__return_false' );
		}  else {
			add_filter( 'cartzilla_enable_footer_static_content', '__return_true' );
		} 

		if ( $attributes['enableFooterMenu'] == false ) {
			add_filter( 'cartzilla_enable_footer_menu', '__return_false' );
		} else {
			add_filter( 'cartzilla_enable_footer_menu', '__return_true' );
		}

		if ( $attributes['enableFooterSocialMenu'] == false ) {
			add_filter( 'cartzilla_enable_footer_social_icons', '__return_false' );
		}  else {
			add_filter( 'cartzilla_enable_footer_social_icons', '__return_true' );
		} 

		if ( $attributes['enableFooterPayment'] == false ) {
			add_filter( 'cartzilla_enable_footer_payment_method', '__return_false' );
		} else {
			add_filter( 'cartzilla_enable_footer_payment_method', '__return_true' );
		}  

		if ( $attributes['enableFooterCopyright'] == false ) {
			add_filter( 'cartzilla_is_copyright', '__return_false' );
		} else {
			add_filter( 'cartzilla_is_copyright', '__return_true' );
		}

		if ( $attributes['enableLogoTitle'] == false ) {
			add_filter( 'cartzilla_footer_logo', '__return_false' );
		} 

		if ( $attributes['enableLanguageCurrency'] == false ) {
			add_filter( 'cartzilla_enable_footer_language_currency_dropdown', '__return_false' );

		}

		if ( $attributes['enableFooterStatistics'] == false ) {
			add_filter( 'cartzilla_enable_footer_statistics', '__return_false' );

		}





		$design              = isset( $attributes['design'] ) ? $attributes['design'] : 'v1';
		$footerType          = isset( $attributes['footerType'] ) ? $attributes['footerType'] : 'dark';
		$footerWidgetColumn1 = isset( $attributes['footerWidgetColumn1'] ) ? $attributes['footerWidgetColumn1'] : 'footer-column-1';

		$footerWidgetColumn2 = isset( $attributes['footerWidgetColumn2'] ) ? $attributes['footerWidgetColumn2'] : 'footer-column-2';

		$footerWidgetColumn3 = isset( $attributes['footerWidgetColumn3'] ) ? $attributes['footerWidgetColumn3'] : 'footer-column-3';

		$footerStaticContentId = isset( $attributes['footerStaticContentId'] ) ? $attributes['footerStaticContentId'] : '';

		$copyrightAlignment = isset( $attributes['copyrightAlignment'] ) ? $attributes['copyrightAlignment'] : 'left';

		$logoImageID = isset( $attributes['logoImageID'] ) ? $attributes['logoImageID'] : '';
		$logoImageID1 = isset( $attributes['logoImageID1'] ) ? $attributes['logoImageID1'] : '';

		$footerPrimaryMenuSlug = isset( $attributes['footerPrimaryMenuSlug'] ) ? $attributes['footerPrimaryMenuSlug'] : '';
		$additionalClass = isset( $attributes['additionalClass'] ) ? $attributes['additionalClass'] : '';
		$copyrightText = isset( $attributes['copyrightText'] ) ? $attributes['copyrightText'] : '';

		$footerSiteTitle = isset( $attributes['footerSiteTitle'] ) ? $attributes['footerSiteTitle'] : '';
		$footerSiteDesc = isset( $attributes['footerSiteDesc'] ) ? $attributes['footerSiteDesc'] : '';

		
		
		add_filter( 'cartzilla_footer_version', function() use ($design) {
			return $design;
		} );

		add_filter( 'cartzilla_footer_type', function() use ($footerType) {
			return $footerType;
		} );

		add_filter( 'cartzilla_footer_widget_1', function() use ($footerWidgetColumn1) {
			return $footerWidgetColumn1;
		} );

		add_filter( 'cartzilla_footer_widget_2', function() use ($footerWidgetColumn2) {
			return $footerWidgetColumn2;
		} );

		add_filter( 'cartzilla_footer_widget_3', function() use ($footerWidgetColumn3) {
			return $footerWidgetColumn3;
		} );

		add_filter( 'cartzilla_footer_static_block_id', function() use ($footerStaticContentId) {
			return $footerStaticContentId;
		} );

		add_filter( 'cartzilla_footer_copyright_alignment', function() use ($copyrightAlignment) {
			return $copyrightAlignment;
		} );

		add_filter( 'cartzilla_custom_footer_logo', function() use ($logoImageID) {
			return $logoImageID;
		} );

		add_filter( 'footer_custom_payment_methods', function() use ($logoImageID1) {
			return $logoImageID1;
		} );

		add_filter( 'cartzilla_footer_menu', function() use ($footerPrimaryMenuSlug) {
			return $footerPrimaryMenuSlug;
		} );


		add_filter( 'cartzilla_bottom_bar_class', function() use ($additionalClass) {
			return $additionalClass;
		} );

		add_filter( 'cartzilla_copyright', function() use ($copyrightText) {
			return $copyrightText;
		} );

		add_filter( 'cartzilla_footer_site_title', function() use ($footerSiteTitle) {
			return $footerSiteTitle;
		} );

		add_filter( 'cartzilla_footer_site_description', function() use ($footerSiteDesc) {
			return $footerSiteDesc;
		} );


		

		$design = isset( $attributes['design'] ) ? $attributes['design'] : 'v1';

		$footer = function_exists( 'cartzilla_footer_version' ) ? cartzilla_footer_version() : $design;
	
		ob_start();

		echo get_template_part( 'templates/footer/footer', $footer );

		return ob_get_clean();
	}
}

if ( ! function_exists( 'cartzillagb_register_footer_block' ) ) {
	/**
	 * Registers the `czgb/footer` block on server.
	 */
	function cartzillagb_register_footer_block() {
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

		register_block_type(
			'czgb/footer',
			array(
				'attributes' => array(
					'className' => array(
						'type' => 'string',
					),

					'design' => array(
						'type' => 'string',
						'default' => 'v1'
					),

					'footerType' => array(
						'type' => 'string',
						'default' => 'dark'
					),

					'enableLogoTitle' => array(
						'type' => 'boolean',
						'default' => true
					),

					'enableFooterWidgets' => array(
						'type' => 'boolean',
						'default' => true
					),

					'enableFooterStaticContent' => array(
						'type' => 'boolean',
						'default' => true
					),

					'enableFooterMenu' => array(
						'type' => 'boolean',
						'default' => true
					),
					'enableFooterSocialMenu' => array(
						'type' => 'boolean',
						'default' => true
					),

					'customLogoWidth' => array(
						'type' => 'number',
					),

					'enableFooterPayment' => array(
						'type' => 'boolean',
						'default' => true
					),

					'enableFooterCopyright' => array(
						'type' => 'boolean',
						'default' => true
					),

					'copyrightText' => array(
						'type' => 'string',
						'default' => esc_html__( '&copy; All rights reserved. Made by <a href="https://createx.studio/" target="_blank" rel="noopener noreferrer">Createx Studio</a>', CZGB_I18N )
					),
					'footerStaticContentId'=> array(
				        'type' =>'number',
				    ),

				    'footerWidgetColumn1'=> array(
				        'type' =>'string',
				        'default' => 'footer-column-1',
				    ),

				    'footerWidgetColumn2'=> array(
				        'type' =>'string',
				         'default' => 'footer-column-2',
				    ),

				    'footerWidgetColumn3'=> array(
				        'type' =>'string',
				        'default' => 'footer-column-3',
				    ),
				    'uniqueClass' => array(
						'type' => 'string',

					),

					'copyrightAlignment' => array(
						'type' => 'string',
						'default' => 'left'

					),

					'logoImageID' => array(
                        'type' => 'number',
                    ),
                    'logoImageUrl' => array(
                        'type' => 'string',
                        'default' => ''
                    ),
                    'logoImageID1' => array(
                        'type' => 'number',
                    ),
                    'logoImageUrl1' => array(
                        'type' => 'string',
                        'default' => ''
                    ),

                    'footerPrimaryMenuSlug' => array(
                        'type' => 'string',
                    ),

                    'additionalClass' => array(
                        'type' => 'string',
                    ),
                    'enableLanguageCurrency'=> array (
				        'type' => 'boolean',
						'default' => true
				    ),
				    'enableFooterStatistics'=> array (
				        'type' => 'boolean',
						'default' => true
				    ),

				    'footerSiteTitle'=> array(
				        'type' =>'string',
				        'default' => esc_html__( 'Marketplace', CZGB_I18N )
				    ),

				    'footerSiteDesc'=> array(
				        'type' =>'string',
				        'default' => esc_html__( 'High quality items created by our global community.',CZGB_I18N )
				    ),

				    

				),
				'render_callback' => 'cartzilla_render_footer_block',
			)
		);
	}
	add_action( 'init', 'cartzillagb_register_footer_block' );
}