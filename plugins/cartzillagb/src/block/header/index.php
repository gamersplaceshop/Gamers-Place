<?php
/**
 * Server-side rendering of the `czgb/header` block.
 *
 * @package CartzillaGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Renders the `czgb/header` block on server.
 *
 * @since 1.0
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */

if ( ! function_exists( 'cartzilla_render_header_block' ) ) {
	function cartzilla_render_header_block( $attributes ) {

		if ( $attributes['enableCart'] == false ) {
			add_filter( 'cartzilla_navbar_is_cart', '__return_false' );
		} 

		if ( $attributes['enableAccount'] == false ) {
			add_filter( 'cartzilla_navbar_is_account', '__return_false' );
		} 

		if ( $attributes['enableSearch'] == false ) {
			add_filter( 'cartzilla_navbar_is_search', '__return_false' );
		} 

		if ( $attributes['enableFullwidth'] == false ) {
			add_filter( 'cartzilla_header_is_fw', '__return_false' );
		} 

		if ( $attributes['enableHeaderSticky'] == false ) {
			add_filter( 'cartzilla_header_is_sticky', '__return_false' );
		} 

		if ( $attributes['enableDepartmentMenu'] == false ) {
			add_filter( 'cartzilla_is_departments_menu', '__return_false' );
		}

		if ( $attributes['enableButton'] == true ) {
			add_filter( 'cartzilla_is_custom_header', '__return_true' );
		}

		if ( $attributes['enableWishlist'] == false ) {
			add_filter( 'cartzilla_enable_wishlist', '__return_false' );
		}

		if ( $attributes['enableCompare'] == false ) {
			add_filter( 'cartzilla_enable_compare', '__return_false' );
		}

		if ( $attributes['enableOrderTracking'] == false ) {
			add_filter( 'cartzilla_enable_ordertracking', '__return_false' );
		}


		if ( $attributes['buttonShadow'] == true ) {
			add_filter( 'cartzilla_custom_button_shadow', '__return_true' );
		}

		if ( $attributes['buttonIconAfterText'] == true ) {
			add_filter( 'cartzilla_custom_button_icon_after_text', '__return_true' );
		}

		if ( $attributes['buttonButtonIcon'] == true ) {
			add_filter( 'cartzilla_custom_is_button_icon', '__return_true' );
		}

		if ( $attributes['enableSupportInfo'] == false ) {
			add_filter( 'cartzilla_enable_site_info_support', '__return_false' );
		}

		if ( $attributes['enableSiteContactInfo'] == false ) {
			add_filter( 'cartzilla_enable_site_info_contact', '__return_false' );
		}

		if ( $attributes['enableheaderSocialMenu'] == false ) {
			add_filter( 'cartzilla_enable_header_social_menu', '__return_false' );
		}

		if ( $attributes['enableTopbar'] == false ) {
			add_filter( 'cartzilla_enable_topbar', '__return_false' );

		}

		if ( $attributes['enableGroceryDepartmentMenu'] == false ) {
			add_filter( 'cartzilla_grocery_department_menu', '__return_false' );

		}

		if ( $attributes['enableLanguageCurrency'] == false ) {
			add_filter( 'cartzilla_enable_topbar_language_currency_dropdown', '__return_false' );

		}


		$headerPrimaryMenuId      = isset( $attributes['headerPrimaryMenuId'] ) ? $attributes['headerPrimaryMenuId'] : '';
		$headerPrimaryMenuSlug      = isset( $attributes['headerPrimaryMenuSlug'] ) ? $attributes['headerPrimaryMenuSlug'] : '';

		$headerDepartmentMenuID      = isset( $attributes['headerDepartmentMenuID'] ) ? $attributes['headerDepartmentMenuID'] : '';

		$headerDepartmentMenuSlug      = isset( $attributes['headerDepartmentMenuSlug'] ) ? $attributes['headerDepartmentMenuSlug'] : '';
		$headerOffcanvasMenuID      = isset( $attributes['headerOffcanvasMenuID'] ) ? $attributes['headerOffcanvasMenuID'] : '';

		$headerHandheldDepartmentMenuID      = isset( $attributes['headerHandheldDepartmentMenuID'] ) ? $attributes['headerHandheldDepartmentMenuID'] : '';

		$headerHandheldDepartmentMenuSlug      = isset( $attributes['headerHandheldDepartmentMenuSlug'] ) ? $attributes['headerHandheldDepartmentMenuSlug'] : '';

		$headerOffcanvasMenuSlug      = isset( $attributes['headerOffcanvasMenuSlug'] ) ? $attributes['headerOffcanvasMenuSlug'] : '';

		
		$design      = isset( $attributes['design'] ) ? $attributes['design'] : '1-level-light';
		$topbar_skin = isset( $attributes['skin'] ) ? $attributes['skin'] : 'light';
		$contactInfo = isset( $attributes['contactInfo'] ) ? $attributes['contactInfo'] : 'Support';
		$promo = isset( $attributes['promo'] ) ? $attributes['promo'] : 'Free shipping for order over $200';
		$title = isset( $attributes['departmentTitle'] ) ? $attributes['departmentTitle'] : 'Departments';
		$logoImageID = isset( $attributes['logoImageID'] ) ? $attributes['logoImageID'] : '0';
		$mobileLogoImageID = isset( $attributes['mobileLogoImageID'] ) ? $attributes['mobileLogoImageID'] : '0';
		$logoImageUrl = isset( $attributes['logoImageUrl'] ) ? $attributes['logoImageUrl'] : '';
		$buttonText      = isset( $attributes['buttonText'] ) ? $attributes['buttonText'] : 'Buy Now';
		$departmentIcon      = isset( $attributes['departmentIcon'] ) ? $attributes['departmentIcon'] : 'czi-menu';


		$buttonUrl      = isset( $attributes['buttonUrl'] ) ? $attributes['buttonUrl'] : '#';
		$buttonAnimation      = isset( $attributes['buttonAnimation'] ) ? $attributes['buttonAnimation'] : 'none';
		$buttonDelay      = isset( $attributes['buttonDelay'] ) ? $attributes['buttonDelay'] : 'none';
		$buttonSize      = isset( $attributes['buttonSize'] ) ? $attributes['buttonSize'] : 'Default';
		//$buttonShadow      = isset( $attributes['buttonShadow'] ) ? $attributes['buttonShadow'] : false;
		$buttonBackground      = isset( $attributes['buttonBackgroundColor'] ) ? $attributes['buttonBackgroundColor'] : 'primary';
		$buttonIcon      = isset( $attributes['buttonIcon'] ) ? $attributes['buttonIcon'] : 'czi-cart';
		//$buttonIsIconAfterText      = isset( $attributes['buttonIsIconAfterText'] ) ? $attributes['buttonIsIconAfterText'] : false;
		$buttonShape      = isset( $attributes['buttonShape'] ) ? $attributes['buttonShape'] : 'default';
		$isIconButton      = isset( $attributes['isIconButton'] ) ? $attributes['isIconButton'] : false;

		$buttonDesign      = isset( $attributes['buttonDesign'] ) ? $attributes['buttonDesign'] : 'solid';
		$socialMenuTitle      = isset( $attributes['socialMenuTitle'] ) ? $attributes['socialMenuTitle'] : 'Follow us';


		$supportInfoTitle      = isset( $attributes['supportInfoTitle'] ) ? $attributes['supportInfoTitle'] : 'Support';
		$supportInfoIcon      = isset( $attributes['supportInfoIcon'] ) ? $attributes['supportInfoIcon'] : 'czi-support';
		$supportText      = isset( $attributes['supportText'] ) ? $attributes['supportText'] : '+1 (00) 33 169 7720';
		$supportLink      = isset( $attributes['supportLink'] ) ? $attributes['supportLink'] : 'tel:+100331697720';

		$contactInfoTitle      = isset( $attributes['contactInfoTitle'] ) ? $attributes['contactInfoTitle'] : 'Email';
		$contactInfoIcon      = isset( $attributes['contactInfoIcon'] ) ? $attributes['contactInfoIcon'] : 'czi-mail';
		$contactText      = isset( $attributes['contactText'] ) ? $attributes['contactText'] : 'customer@example.com';
		$contactLink      = isset( $attributes['contactLink'] ) ? $attributes['contactLink'] : 'mailto:customer@example.com';

		$handheldDropdownTitle      = isset( $attributes['handheldDropdownTitle'] ) ? $attributes['handheldDropdownTitle'] : '';
		$handheldDropdownContent      = isset( $attributes['handheldDropdownContent'] ) ? $attributes['handheldDropdownContent'] : '';
		
		// add_filter( 'cartzilla_primary_menu', function() use ($headerPrimaryMenuId) {
		// 	return $headerPrimaryMenuId;
		// } );

		add_filter( 'cartzilla_primary_menu', function() use ($headerPrimaryMenuSlug) {
			return $headerPrimaryMenuSlug;
		} );

		add_filter( 'cartzilla_header_department_menu', function() use ($headerDepartmentMenuSlug) {
			return $headerDepartmentMenuSlug;
		} );

		add_filter( 'cartzilla_offcanvas_primary_menu', function() use ($headerOffcanvasMenuSlug) {
			return $headerOffcanvasMenuSlug;
		} );

		add_filter( 'cartzilla_header_handheld_department_menu', function() use ($headerHandheldDepartmentMenuSlug) {
			return $headerHandheldDepartmentMenuSlug;
		} );

		add_filter( 'cartzilla_header_layout', function() use ($design) {
			return $design;
		} );

		add_filter( 'cartzilla_topbar_skin', function() use ($topbar_skin) {
			return $topbar_skin;
		});

		add_filter( 'cartzilla_enable_topbar_contact', function() use ($contactInfo) {
			return $contactInfo;
		} );

		add_filter( 'cartzilla_enable_topbar_promo', function() use ($promo) {
			return $promo;
		} );

		add_filter( 'cartzilla_departments_menu_title', function() use ($title) {
			return $title;
		} );

		add_filter( 'cartzilla_custom_logo', function() use ($logoImageID) {
			return $logoImageID;
		} );

		add_filter( 'cartzilla_custom_mobile_logo', function() use ($mobileLogoImageID) {
			return $mobileLogoImageID;
		} );

		add_filter( 'cartzilla_custom_button_design', function() use ($buttonDesign) {
			return $buttonDesign;
		} );

		add_filter( 'cartzilla_custom_button_text', function() use ($buttonText) {
			return $buttonText;
		} );

		add_filter( 'cartzilla_custom_button_url', function() use ($buttonUrl) {
			return $buttonUrl;
		} );

		add_filter( 'cartzilla_custom_button_animation', function() use ($buttonAnimation) {
			return $buttonAnimation;
		} );
		add_filter( 'cartzilla_custom_button_delay', function() use ($buttonDelay) {
			return $buttonDelay;
		} );

		add_filter( 'cartzilla_custom_button_size', function() use ($buttonSize) {
			return $buttonSize;
		} );

		add_filter( 'cartzilla_custom_button_bg', function() use ($buttonBackground) {
			return $buttonBackground;
		} );

		add_filter( 'cartzilla_custom_button_icon', function() use ($buttonIcon) {
			return $buttonIcon;
		} );

		

		add_filter( 'cartzilla_custom_button_shape', function() use ($buttonShape) {
			return $buttonShape;
		} );

		add_filter( 'cartzilla_custom_button_is_icon', function() use ($isIconButton) {
			return $isIconButton;
		} );

		add_filter( 'cartzilla_site_info_contact_icon', function() use ($contactInfoIcon) {
			return $contactInfoIcon;
		} );

		add_filter( 'cartzilla_site_info_contact_title', function() use ($contactInfoTitle) {
			return $contactInfoTitle;
		} );

		add_filter( 'cartzilla_site_info_contact_text', function() use ($contactText) {
			return $contactText;
		} );
		
		add_filter( 'cartzilla_site_info_contact_link', function() use ($contactLink) {
			return $contactLink;
		} );

		add_filter( 'cartzilla_site_info_support_icon', function() use ($supportInfoIcon) {
			return $supportInfoIcon;
		} );

		add_filter( 'cartzilla_site_info_support_title', function() use ($supportInfoTitle) {
			return $supportInfoTitle;
		} );

		add_filter( 'cartzilla_site_info_support_text', function() use ($supportText) {
			return $supportText;
		} );
		
		add_filter( 'cartzilla_site_info_support_link', function() use ($supportLink) {
			return $supportLink;
		} );

		add_filter( 'cartzilla_header_social_menu_title', function() use ($socialMenuTitle) {
			return $socialMenuTitle;
		} );


		add_filter( 'cartzilla_department_menu_icon_class', function() use ($departmentIcon) {
			return $departmentIcon;
		} );

		$layout = function_exists( 'cartzilla_header_layout' ) ? cartzilla_header_layout() : $design;

		ob_start();

		echo get_template_part( 'templates/header/header', $layout );

		return ob_get_clean();
		
	}
}

if ( ! function_exists( 'cartzillagb_register_header_block' ) ) {
	/**
	 * Registers the `czgb/header` block on server.
	 */
	function cartzillagb_register_header_block() {
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

		register_block_type(
			'czgb/header',
			array(
				'attributes' => array(
					'className' => array(
						'type' => 'string',
					),

					'design' => array(
						'type' => 'string',
						'default' => '1-level-light'
					),
					
					'enableFullwidth' => array(
						'type' => 'boolean',
						'default' => false
					),

					'enableHeaderSticky' => array(
						'type' => 'boolean',
						'default' => false
					),

					'enableAccount' => array(
						'type' => 'boolean',
						'default' => true
					),
					'enableTopbar' => array(
						'type' => 'boolean',
						'default' => true
					),

					'enableCart' => array(
						'type' => 'boolean',
						'default' => true
					),

					'enableSearch' => array(
						'type' => 'boolean',
						'default' => true
					),

					'enableOrderTracking' => array(
						'type' => 'boolean',
						'default' => true
					),

					'enableCompare' => array(
						'type' => 'boolean',
						'default' => true
					),

					'enableButton' => array(
						'type' => 'boolean',
						'default' => false
					),

					'enableDepartmentMenu' => array(
						'type' => 'boolean',
						'default' => true
					),

					'departmentTitle' => array(
						'type' => 'string',
						'default' => esc_html__( 'Departments', CZGB_I18N )
					),

					'departmentIcon' => array(
						'type' => 'string',
						'default' => 'czi-menu'
					),

					'skin' => array(
						'type' => 'string',
						'default' => 'light'
					),

					'contactInfo' => array(
						'type' => 'string',
						'default' => 'Support'
					),

					'promo' => array(
						'type' => 'string',
						'default' => esc_html__('Free shipping for order over $200', CZGB_I18N )
					),

					'uniqueClass' => array(
						'type' => 'string',
					),
					'logoImageID' => array(
                        'type' => 'number',
                        'default' => 0
                    ),
                    'logoImageUrl' => array(
                        'type' => 'string',
                        'default' => ''
                    ),
                    'mobileLogoImageID' => array(
                        'type' => 'number',
                        'default' => 0
                    ),
                    'mobileLogoImageUrl' => array(
                        'type' => 'string',
                        'default' => ''
                    ),
                    'enableSupportInfo' => array(
						'type' => 'boolean',
						'default' => true
					),
					'enableSiteContactInfo' => array(
						'type' => 'boolean',
						'default' => true
					),
					
					'supportInfoTitle' => array(
						'type' => 'string',
						'default' => 'Support'
					),
					'supportInfoIcon' => array(
						'type' => 'string',
						'default' => 'czi-support'
					),
					'supportText' => array(
						'type' => 'string',
						'default' => esc_html__( '+1 (00) 33 169 7720', CZGB_I18N )
					),
					'supportLink' => array(
						'type' => 'string',
						'default' => esc_html__( 'tel:+100331697720', CZGB_I18N )
					),


					'contactInfoTitle' => array(
						'type' => 'string',
						'default' => esc_html__( 'Email', CZGB_I18N )
					),
					'contactInfoIcon' => array(
						'type' => 'string',
						'default' => esc_html__( 'czi-mail', CZGB_I18N )
					),
					'contactText' => array(
						'type' => 'string',
						'default' => esc_html__( 'customer@example.com', CZGB_I18N )
					),
					'contactLink' => array(
						'type' => 'string',
						'default' => esc_html__( 'mailto:customer@example.com', CZGB_I18N )
					),
					'buttonText' => array (
						'type' => 'string',
						'default' => esc_html__( 'Buy Now', CZGB_I18N )
					),
					'buttonUrl'=> array (
				        'type' => 'string',
				        'default' => '#',
				    ),
				    'buttonDesign'=> array (
				        'type' => 'string',
				        'default' => 'solid',
				    ),
				    'buttonIcon'=> array (
				        'type' => 'string',
				        'default' => 'czi-cart',
				    ),
				    'buttonSize'=> array (
				        'type' => 'string',
				        'default' => 'default',
				    ),
				    'buttonShape'=> array (
				        'type' => 'string',
				        'default' => 'default',
				    ),

				    'buttonShadow' => array(
						'type' => 'boolean',
						'default' => false
					),

				    'buttonButtonIcon'=> array (
				        'type' => 'boolean',
						'default' => false
				    ),
				    'buttonIconAfterText'=> array (
				        'type' => 'boolean',
						'default' => false
				    ),
				    'buttonBackgroundColor'=> array (
				        'type' => 'string',
				        'default' => 'primary',
				    ),
				    'buttonAnimation'=> array (
				        'type' => 'string',
				        'default' => 'none',
				    ),
				    'buttonDelay'=> array (
				        'type' => 'string',
				        'default' => 'none',
				    ),
				    'enableWishlist' => array(
						'type' => 'boolean',
						'default' => true
					),
					'enableheaderSocialMenu' => array(
						'type' => 'boolean',
						'default' => true
					),
					'socialMenuTitle'=> array (
				        'type' => 'string',
				        'default' => esc_html__('Follow us', CZGB_I18N )
				    ),

				    'enableGroceryDepartmentMenu'=> array (
				        'type' => 'boolean',
						'default' => true
				    ),

				    'headerPrimaryMenuId' => array(
                        'type' => 'number',
                    ),

                    'headerPrimaryMenuSlug' => array(
                        'type' => 'string',
                    ),

                    'headerDepartmentMenuSlug' => array(
                        'type' => 'string',
                    ),

                    'headerOffcanvasMenuSlug' => array(
                        'type' => 'string',
                    ),

                    
                    'headerDepartmentMenuID' => array(
                        'type' => 'number',
                    ),

                    'headerOffcanvasMenuID' => array(
                        'type' => 'number',
                    ),

                    'headerHandheldDepartmentMenuID' => array(
                        'type' => 'number',
                    ),

                    'headerHandheldDepartmentMenuSlug' => array(
                        'type' => 'string',
                    ),

                    'enableLanguageCurrency'=> array (
				        'type' => 'boolean',
						'default' => true
				    ),
                
				),
				'render_callback' => 'cartzilla_render_header_block',
			)
		);
	}
	add_action( 'init', 'cartzillagb_register_header_block' );
}