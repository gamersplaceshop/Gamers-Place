<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since 	0.1
 * @package CartzillaGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'cartzillagb_block_assets' ) ) {

	/**
	* Enqueue block assets for both frontend + backend.
	*
	* @since 0.1
	*/
	function cartzillagb_block_assets() {

		$enqueue_styles_in_frontend = apply_filters( 'cartzillagb_enqueue_styles', ! is_admin() );
		$enqueue_scripts_in_frontend = apply_filters( 'cartzillagb_enqueue_scripts', ! is_admin() );

		// Frontend block styles.
		if ( is_admin() || $enqueue_styles_in_frontend ) {
			wp_enqueue_style(
				'czgb-style-css',
				plugins_url( 'dist/frontend_blocks.css', CZGB_FILE ),
				array(),
				CZGB_VERSION
			);
		}

		// Frontend only scripts.
		if ( $enqueue_scripts_in_frontend ) {
			wp_enqueue_script(
				'czgb-block-frontend-js',
				plugins_url( 'dist/frontend_blocks.js', CZGB_FILE ),
				array( 'wp-blocks', 'wp-element', 'wp-components', 'wp-util', 'wp-plugins', 'wp-i18n', 'slick-carousel' ),
				CZGB_VERSION
			);

			wp_localize_script( 'czgb-block-frontend-js', 'cartzillagb', cartzillagb_get_localize_script_data() );
		}
	}
	add_action( 'enqueue_block_assets', 'cartzillagb_block_assets' );
}

if ( ! function_exists( 'cartzillagb_block_editor_assets' ) ) {

	/**
	 * Enqueue block assets for backend editor.
	 *
	 * @since 0.1
	 */
	function cartzillagb_block_editor_assets() {

		// Enqueue CodeMirror for Custom CSS.
		wp_enqueue_code_editor( array(
			'type' => 'text/css', // @see https://developer.wordpress.org/reference/functions/wp_get_code_editor_settings/
			'codemirror' => array(
				'indentUnit' => 2,
				'tabSize' => 2,
			),
		) );

		// Backend editor scripts: common vendor files.
		wp_enqueue_script(
			'czgb-block-js-vendor',
			plugins_url( 'dist/editor_vendor.js', CZGB_FILE ),
			array(),
			CZGB_VERSION
		);

		// Backend editor scripts: blocks.
		wp_enqueue_script(
			'czgb-block-js',
			plugins_url( 'dist/editor_blocks.js', CZGB_FILE ),
			array( 'czgb-block-js-vendor', 'code-editor', 'wp-blocks', 'wp-element', 'wp-components', 'wp-editor', 'wp-util', 'wp-plugins', 'wp-edit-post', 'wp-i18n', 'cartzilla-scripts', 'tiny-slider', 'slick-carousel' ),
			CZGB_VERSION
		);

		// Add translations.
		wp_set_script_translations( 'czgb-block-js', CZGB_I18N );

		// Backend editor scripts: meta.
        wp_enqueue_script(
            'czgb-meta-js',
            plugins_url( 'dist/editor_meta.js', CZGB_FILE ),
            array( 'wp-plugins', 'wp-edit-post', 'wp-i18n', 'wp-element' ),
            CZGB_VERSION
        );


		// Backend editor only styles.
		wp_enqueue_style(
			'czgb-block-editor-css',
			plugins_url( 'dist/editor_blocks.css', CZGB_FILE ),
			array( 'wp-edit-blocks' ),
			CZGB_VERSION
		);

		wp_localize_script( 'czgb-meta-js', 'cartzillagb', cartzillagb_get_localize_script_data() );

		wp_localize_script( 'czgb-block-js-vendor', 'cartzillagb', cartzillagb_get_localize_script_data() );
	}

	// Enqueue in a higher number so that other scripts that add on CartzillaGB can load first. E.g. Premium.
	add_action( 'enqueue_block_editor_assets', 'cartzillagb_block_editor_assets', 20 );
}

if ( ! function_exists( 'cartzillagb_get_localize_script_data' ) ) {

	/**
	 * Localize.
	 */
	function cartzillagb_get_localize_script_data() {
		global $content_width, $wp_registered_sidebars;

		$admin_ajax_url = admin_url( 'admin-ajax.php' );
		$current_lang   = apply_filters( 'wpml_current_language', NULL );

		if ( $current_lang ) {
			$admin_ajax_url = add_query_arg( 'lang', $current_lang, $admin_ajax_url );
		}

		return array(
			'ajaxUrl' => $admin_ajax_url,
			'srcUrl' => untrailingslashit( plugins_url( '/', CZGB_FILE ) ),
			'contentWidth' => isset( $content_width ) ? $content_width : 1260,
			'i18n' => CZGB_I18N,
			'pluginAssetsURL' => cartzillagb_get_assets_url(),
			'disabledBlocks' => cartzillagb_get_disabled_blocks(),
			'nonce' => wp_create_nonce( 'cartzillagb' ),
			'devMode' => defined( 'WP_ENV' ) ? WP_ENV === 'development' : false,
			'cdnUrl' => CZGB_CLOUDFRONT_URL,
			'displayWelcomeVideo' => function_exists( 'cartzillagb_display_welcome_video' ) ? cartzillagb_display_welcome_video() : false,
			'hasCustomLogo'         => has_custom_logo(),
            'isWoocommerceActive'   => function_exists( 'cartzilla_is_woocommerce_activated' ) && cartzilla_is_woocommerce_activated(),
            'isYithWcWlActive'   => function_exists( 'cartzilla_is_yith_wcwl_activated' ) && cartzilla_is_yith_wcwl_activated(),
            'themeAssetsURL'        => cartzilla_get_assets_url(),
            'isMasStaticActive'     => function_exists( 'cartzilla_is_mas_static_content_activated' ) && cartzilla_is_mas_static_content_activated(),
             'wpRegisteredSidebars'  => json_encode( $wp_registered_sidebars ),
             'isYithCompareActive'   =>  function_exists( 'cartzilla_is_yith_woocompare_activated' ) && cartzilla_is_yith_woocompare_activated(),
             'isRTL'                 => is_rtl(),

            

			// Fonts.
			'locale' => get_locale(),

			// Overridable default primary color for buttons and other blocks.
			'primaryColor' => get_theme_mod( 's_primary_color', '#2091e1' ),
		);
	}
}

if ( ! function_exists( 'cartzillagb_get_assets_url' ) ) {
    function cartzillagb_get_assets_url() {
        return untrailingslashit( plugins_url( '/', CZGB_FILE ) ) . '/assets/';
    }
}


if ( ! function_exists( 'cartzilla_get_assets_url' ) ) {
    function cartzilla_get_assets_url() {
        return get_template_directory_uri() . '/assets/';
    }
}


if ( ! function_exists( 'cartzillagb_load_plugin_textdomain' ) ) {

	/**
	 * Translations.
	 */
	function cartzillagb_load_plugin_textdomain() {
		load_plugin_textdomain( 'cartzillagb' );
	}
	add_action( 'plugins_loaded', 'cartzillagb_load_plugin_textdomain' );
}

if ( ! function_exists( 'cartzillagb_block_category' ) ) {

	/**
	 * Add our custom block category for CartzillaGB blocks.
	 *
	 * @since 0.6
	 */
	function cartzillagb_block_category( $categories, $post ) {
		return array_merge(
			$categories,
			array(
				array(
					'slug' => 'cartzillagb',
					'title' => __( 'CartzillaGB', CZGB_I18N ),
				),
			)
		);
	}
	add_filter( 'block_categories', 'cartzillagb_block_category', 10, 2 );
}

if ( ! function_exists( 'cartzillagb_add_required_block_styles' ) ) {

	/**
	 * Adds the required global styles for CartzillaGB blocks.
	 *
	 * @since 1.3
	 */
	function cartzillagb_add_required_block_styles() {
		global $content_width;
		$full_width_block_inner_width = isset( $content_width ) ? $content_width : 900;

		$custom_css = ':root {
			--content-width: ' . esc_attr( $full_width_block_inner_width ) . 'px;
		}';
		wp_add_inline_style( 'czgb-style-css', $custom_css );
	}
	add_action( 'enqueue_block_assets', 'cartzillagb_add_required_block_styles', 11 );
}

if ( ! function_exists( 'cartzillagb_allow_safe_style_css' ) ) {

	/**
	 * Fix block saving for Non-Super-Admins (no unfiltered_html capability).
	 * For Non-Super-Admins, some styles & HTML tags/attributes are removed upon saving,
	 * this allows CartzillaGB styles from being saved.
	 *
	 * For every CartzillaGB block, add the styles used here.
	 * Inlined styles are the only ones filtered out. Styles inside
	 * <style> tags are okay.
	 *
	 * @see The list of style rules allowed: https://core.trac.wordpress.org/browser/tags/5.2/src/wp-includes/kses.php#L2069
	 * @see https://github.com/gambitph/CartzillaGB/issues/184
	 *
	 * @param array $styles Allowed CSS style rules.
	 *
	 * @return array Modified CSS style rules.
	 */
	function cartzillagb_allow_safe_style_css( $styles ) {
		return array_merge( $styles, array(
			'border-radius',
			'opacity',
			'justify-content',
			'display',
		) );
	}
	add_filter( 'safe_style_css', 'cartzillagb_allow_safe_style_css' );
}

if ( ! function_exists( 'cartzillagb_allow_wp_kses_allowed_html' ) ) {

	/**
	 * Fix block saving for Non-Super-Admins (no unfiltered_html capability).
	 * For Non-Super-Admins, some styles & HTML tags/attributes are removed upon saving,
	 * this allows CartzillaGB HTML tags & attributes from being saved.
	 *
	 * For every CartzillaGB block, add the HTML tags and attributes used here.
	 *
	 * @see The list of tags & attributes currently allowed: https://core.trac.wordpress.org/browser/tags/5.2/src/wp-includes/kses.php#L61
	 * @see https://github.com/gambitph/CartzillaGB/issues/184
	 *
	 * @param array $tags Allowed HTML tags & attributes.
	 * @param string $context The context wherein the HTML is being filtered.
	 *
	 * @return array Modified HTML tags & attributes.
	 */
	function cartzillagb_allow_wp_kses_allowed_html( $tags, $context ) {
		$tags['style'] = array();

		// Used by Separators & Icons.
		$tags['svg'] = array(
			'viewbox' => true,
			'filter' => true,
			'enablebackground' => true,
			'xmlns' => true,
			'class' => true,
			'preserveaspectratio' => true,
			'aria-hidden' => true,
			'data-*' => true,
			'role' => true,
			'height' => true,
			'width' => true,
		);
		$tags['path'] = array(
			'class' => true,
			'fill' => true,
			'd' => true,
		);
		$tags['filter'] = array(
			'id' => true,
		);
		$tags['fegaussianblur'] = array(
			'in' => true,
			'stddeviation' => true,
		);
		$tags['fecomponenttransfer'] = array();
		$tags['fefunca'] = array(
			'type' => true,
			'slope' => true,
		);
		$tags['femerge'] = array();
		$tags['femergenode'] = array(
			'in' => true,
		);

		_cartzillagb_common_attributes( $tags, 'div' );
		_cartzillagb_common_attributes( $tags, 'h1' );
		_cartzillagb_common_attributes( $tags, 'h2' );
		_cartzillagb_common_attributes( $tags, 'h3' );
		_cartzillagb_common_attributes( $tags, 'h4' );
		_cartzillagb_common_attributes( $tags, 'h5' );
		_cartzillagb_common_attributes( $tags, 'h6' );
		_cartzillagb_common_attributes( $tags, 'svg' );

		return $tags;
	}

	function _cartzillagb_common_attributes( &$tags, $tag ) {
		$tags[ $tag ]['aria-hidden'] = true; // Used by Separators & Icons
		$tags[ $tag ]['aria-expanded'] = true; // Used by Expand block.
		$tags[ $tag ]['aria-level'] = true; // Used by Accordion block.
		$tags[ $tag ]['role'] = true; // Used by Accordion block.
		$tags[ $tag ]['tabindex'] = true; // Used by Accordion block.
	}
	add_filter( 'wp_kses_allowed_html', 'cartzillagb_allow_wp_kses_allowed_html', 10, 2 );
}

if ( ! function_exists( 'cartzillagb_get_assets_url' ) ) {
	function cartzillagb_get_assets_url() {
		return untrailingslashit( plugins_url( '/', CZGB_FILE ) ) . '/assets/';
	}
}

/**
 * Call a shortcode function by tag name.
 *
 * @param string $tag     The shortcode whose function to call.
 * @param array  $atts    The attributes to pass to the shortcode function. Optional.
 * @param array  $content The shortcode's content. Default is null (none).
 *
 * @return string|bool False on failure, the result of the shortcode on success.
 */
function cartzillagb_do_shortcode( $tag, array $atts = array(), $content = null ) {
	global $shortcode_tags;
	if ( ! isset( $shortcode_tags[ $tag ] ) ) {
		return false;
	}

	return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
}

function cartzillagb_nav_menu_taxonomy_args( $args, $taxonomy_name, $object_type ) {
    if ( 'nav_menu' === $taxonomy_name ) {
        $args['show_in_rest'] = true;
    }

    return $args;
}

add_filter( 'register_taxonomy_args', 'cartzillagb_nav_menu_taxonomy_args', 10, 3 );