<?php

/**
 * Widget "(Cartzilla) Filter Products by Attribute"
 *
 * Display a slider to filter products in your store by price.
 *
 * @uses WP_Widget
 */
class Cartzilla_WC_Filter_By_Attribute_Widget extends WP_Widget {
	private $widget_id = 'cartzilla_wc_attribute_filter';
	private $widget_settings = [
		'title'      => '',
		'attribute'  => '',
		'search'     => 1,
		'query_type' => 'and',
	];

	public function __construct() {
		$opts = [ 'description' => esc_html_x( 'Display a list of attributes to filter products in your store.', 'widget', 'cartzilla-extensions' ) ];
		parent::__construct( $this->widget_id, esc_html_x( '(Cartzilla) Filter Products by Attribute', 'widget', 'cartzilla-extensions' ), $opts );
	}

	/**
	 * Display the widget contents
	 *
	 * @param array $args Widget args described in {@see register_sidebar()}
	 * @param array $instance Widget settings
	 */
	public function widget( $args, $instance ) {
		if ( ! is_shop() && ! is_product_taxonomy() ) {
			return;
		}

		$instance = wp_parse_args( (array) $instance, $this->widget_settings );

		$taxonomy = $this->get_instance_taxonomy( $instance );
		if ( ! taxonomy_exists( $taxonomy ) ) {
			return;
		}

		$terms = get_terms( $taxonomy, [ 'hide_empty' => 1 ] );
		if ( empty( $terms ) || is_wp_error( $terms ) ) {
			return;
		}

		$is_search   = ( (int) $instance['search'] === 1 );
		$query_type  = $this->get_instance_query_type( $instance );
		$term_counts = $this->get_filtered_term_product_counts( wp_list_pluck( $terms, 'term_id' ), $taxonomy, $query_type );
		$base_link   = $this->get_current_page_url();

		$_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();

		$filter_name    = 'filter_' . wc_attribute_taxonomy_slug( $taxonomy );
		$current_filter = isset( $_GET[ $filter_name ] ) ? explode( ',', wc_clean( wp_unslash( $_GET[ $filter_name ] ) ) ) : array(); // WPCS: input var ok, CSRF ok.
		$current_filter = array_map( 'sanitize_title', $current_filter );
		$current_values = isset( $_chosen_attributes[ $taxonomy ]['terms'] ) ? $_chosen_attributes[ $taxonomy ]['terms'] : array();

		$title = apply_filters( 'widget_title', esc_html( trim( $instance['title'] ) ), $instance, $this->id_base );
		echo $args['before_widget'];
		if ( $title ) {
			echo $args['before_title'], $title, $args['after_title'];
		}

		?>
		<div class="cz-filter">
			<?php if ( $is_search ) : ?>
				<div class="input-group-overlay input-group-sm mb-2">
					<input class="cz-filter-search form-control form-control-sm appended-form-control" type="text" placeholder="<?php
					/* translators: placeholder for search field in Product Categories widget */
					echo esc_html_x( 'Search', 'front-end', 'cartzilla-extensions' ); ?>">
					<div class="input-group-append-overlay">
						<span class="input-group-text"><i class="czi-search"></i></span>
					</div>
				</div>
			<?php endif; ?>
			<ul class="widget-list cz-filter-list list-unstyled pt-1" style="max-height: 12rem;" data-simplebar data-simplebar-auto-hide="false">
				<?php
				foreach ( $terms as $term ) :
					$option_is_set = in_array( $term->slug, $current_values, true );
					$option_count  = isset( $term_counts[ $term->term_id ] ) ? $term_counts[ $term->term_id ] : 0;

					// Only show options with count > 0.
					if ( 0 === $option_count && ! $option_is_set ) {
						continue;
					}

					// Skip the term for the current archive.
					if ( $this->get_current_term_id() === $term->term_id ) {
						continue;
					}

					if ( ! in_array( $term->slug, $current_filter, true ) ) {
						$current_filter[] = $term->slug;
					}

					$link = remove_query_arg( $filter_name, $base_link );

					// Add current filters to URL.
					foreach ( $current_filter as $key => $value ) {
						// Exclude query arg for current term archive term.
						if ( $value === $this->get_current_term_slug() ) {
							unset( $current_filter[ $key ] );
						}

						// Exclude self so filter can be unset on click.
						if ( $option_is_set && $value === $term->slug ) {
							unset( $current_filter[ $key ] );
						}
					}

					if ( ! empty( $current_filter ) ) {
						asort( $current_filter );
						$link = add_query_arg( $filter_name, implode( ',', $current_filter ), $link );

						// Add Query type Arg to URL.
						if ( 'or' === $query_type && ! ( 1 === count( $current_filter ) && $option_is_set ) ) {
							$link = add_query_arg( 'query_type_' . wc_attribute_taxonomy_slug( $taxonomy ), 'or', $link );
						}
						$link = str_replace( '%2C', ',', $link );
					}

					if ( $option_count > 0 || $option_is_set ) {
						$link      = apply_filters( 'cartzilla_wc_layered_nav_link', $link, $term, $taxonomy );
						$term_html = '<a rel="nofollow" href="' . esc_url( $link ) . '" class="custom-control-label cz-filter-item-text">' . esc_html( $term->name ) . '</a>';
					} else {
						$link      = false;
						$term_html = '<span class="custom-control-label cz-filter-item-text">' . esc_html( $term->name ) . '</span>';
					}

					?>
					<li class="cz-filter-item d-flex justify-content-between align-items-center mb-1 woocommerce-widget-layered-nav-list__item wc-layered-nav-term <?php echo ( $option_is_set ? 'woocommerce-widget-layered-nav-list__item--chosen chosen' : '' ); ?>">
						<div class="custom-control <?php echo ( 'or' === $query_type ) ? 'custom-radio' : 'custom-checkbox'; ?>">
							<?php echo apply_filters( 'cartzilla_wc_layered_nav_term_html', $term_html, $term, $link, $option_count ); // WPCS: XSS ok. ?>
						</div>
						<?php echo apply_filters( 'cartzilla_wc_layered_nav_count', sprintf( '<span class="font-size-xs text-muted">%d</span>', absint( $option_count ) ), $option_count, $term ); ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php

		echo $args['after_widget'];
	}

	/**
	 * Output the widget settings form
	 *
	 * @param array $instance Current settings
	 *
	 * @return bool
	 */
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->widget_settings );

		$taxonomies = wc_get_attribute_taxonomies();
		$attributes = [];
		if ( ! empty( $taxonomies ) ) {
			foreach ( $taxonomies as $tax ) {
				if ( taxonomy_exists( wc_attribute_taxonomy_name( $tax->attribute_name ) ) ) {
					$attributes[ $tax->attribute_name ] = $tax->attribute_name;
				}
			}
		}

		// Current attribute - get from settings or first value from an array
		$attribute  = isset( $instance['attribute'] ) ? $instance['attribute'] : current( $attributes );
		$query_type = sanitize_key( $instance['query_type'] );

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php echo esc_html_x( 'Title', 'widget', 'cartzilla-extensions' ); ?>
			</label>
			<input type="text" class="widefat"
			       id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
			       value="<?php echo esc_attr( trim( $instance['title'] ) ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'attribute' ) ); ?>">
				<?php echo esc_html_x( 'Attribute', 'widget', 'cartzilla-extensions' ); ?>
			</label>
			<select class="widefat"
			        id="<?php echo esc_attr( $this->get_field_id( 'attribute' ) ); ?>"
			        name="<?php echo esc_attr( $this->get_field_name( 'attribute' ) ); ?>"
			>
				<?php foreach ( $attributes as $key => $name ) : ?>
					<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $attribute ); ?>><?php echo esc_html( $name ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'query_type' ) ); ?>">
				<?php echo esc_html_x( 'Query type', 'widget', 'cartzilla-extensions' ); ?>
			</label>
			<select class="widefat"
			        id="<?php echo esc_attr( $this->get_field_id( 'query_type' ) ); ?>"
			        name="<?php echo esc_attr( $this->get_field_name( 'query_type' ) ); ?>"
			>
				<option value="and" <?php selected( $query_type, 'and' ); ?>><?php echo esc_html_x( 'AND', 'widget', 'cartzilla-extensions' ); ?></option>
				<option value="or" <?php selected( $query_type, 'or' ); ?>><?php echo esc_html_x( 'OR', 'widget', 'cartzilla-extensions' ); ?></option>
			</select>
		</p>
		<p>
			<input type="checkbox" class="checkbox" value="1"
			       id="<?php echo esc_attr( $this->get_field_id( 'search' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'search' ) ); ?>"
				<?php checked( $instance['search'], 1 ); ?>
			>
			<label for="<?php echo esc_attr( $this->get_field_id( 'search' ) ); ?>">
				<?php echo esc_html_x( 'Show search field', 'widget', 'cartzilla-extensions' ); ?>
			</label>
		</p>
		<?php

		return true;
	}

	/**
	 * Update widget
	 *
	 * @param array $new_instance New values
	 * @param array $old_instance Old values
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']      = sanitize_text_field( trim( $new_instance['title'] ) );
		$instance['attribute']  = sanitize_text_field( $new_instance['attribute'] );
		$instance['query_type'] = sanitize_key( $new_instance['query_type'] );
		$instance['search']     = empty( $new_instance['search'] ) ? 0 : 1;

		return $instance;
	}

	/**
	 * Get this widgets taxonomy.
	 *
	 * @param array $instance Array of instance options.
	 * @return string
	 */
	protected function get_instance_taxonomy( $instance ) {
		if ( isset( $instance['attribute'] ) ) {
			return wc_attribute_taxonomy_name( $instance['attribute'] );
		}

		$attribute_taxonomies = wc_get_attribute_taxonomies();

		if ( ! empty( $attribute_taxonomies ) ) {
			foreach ( $attribute_taxonomies as $tax ) {
				if ( taxonomy_exists( wc_attribute_taxonomy_name( $tax->attribute_name ) ) ) {
					return wc_attribute_taxonomy_name( $tax->attribute_name );
				}
			}
		}

		return '';
	}

	/**
	 * Get this widgets query type.
	 *
	 * @param array $instance Array of instance options.
	 * @return string
	 */
	protected function get_instance_query_type( $instance ) {
		return isset( $instance['query_type'] ) ? $instance['query_type'] : 'and';
	}

	/**
	 * Return the currently viewed taxonomy name.
	 *
	 * @return string
	 */
	protected function get_current_taxonomy() {
		return is_tax() ? get_queried_object()->taxonomy : '';
	}

	/**
	 * Return the currently viewed term ID.
	 *
	 * @return int
	 */
	protected function get_current_term_id() {
		return absint( is_tax() ? get_queried_object()->term_id : 0 );
	}

	/**
	 * Return the currently viewed term slug.
	 *
	 * @return int
	 */
	protected function get_current_term_slug() {
		return absint( is_tax() ? get_queried_object()->slug : 0 );
	}

	/**
	 * Get current page URL with various filtering props supported by WC.
	 *
	 * @return string
	 * @since  3.3.0
	 */
	protected function get_current_page_url() {
		if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
			$link = home_url();
		} elseif ( is_shop() ) {
			$link = get_permalink( wc_get_page_id( 'shop' ) );
		} elseif ( is_product_category() ) {
			$link = get_term_link( get_query_var( 'product_cat' ), 'product_cat' );
		} elseif ( is_product_tag() ) {
			$link = get_term_link( get_query_var( 'product_tag' ), 'product_tag' );
		} else {
			$queried_object = get_queried_object();
			$link           = get_term_link( $queried_object->slug, $queried_object->taxonomy );
		}

		// Min/Max.
		if ( isset( $_GET['min_price'] ) ) {
			$link = add_query_arg( 'min_price', wc_clean( wp_unslash( $_GET['min_price'] ) ), $link );
		}

		if ( isset( $_GET['max_price'] ) ) {
			$link = add_query_arg( 'max_price', wc_clean( wp_unslash( $_GET['max_price'] ) ), $link );
		}

		// Order by.
		if ( isset( $_GET['orderby'] ) ) {
			$link = add_query_arg( 'orderby', wc_clean( wp_unslash( $_GET['orderby'] ) ), $link );
		}

		/**
		 * Search Arg.
		 * To support quote characters, first they are decoded from &quot; entities, then URL encoded.
		 */
		if ( get_search_query() ) {
			$link = add_query_arg( 's', rawurlencode( htmlspecialchars_decode( get_search_query() ) ), $link );
		}

		// Post Type Arg.
		if ( isset( $_GET['post_type'] ) ) {
			$link = add_query_arg( 'post_type', wc_clean( wp_unslash( $_GET['post_type'] ) ), $link );

			// Prevent post type and page id when pretty permalinks are disabled.
			if ( is_shop() ) {
				$link = remove_query_arg( 'page_id', $link );
			}
		}

		// Min Rating Arg.
		if ( isset( $_GET['rating_filter'] ) ) {
			$link = add_query_arg( 'rating_filter', wc_clean( wp_unslash( $_GET['rating_filter'] ) ), $link );
		}

		// All current filters.
		if ( $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes() ) { // phpcs:ignore Squiz.PHP.DisallowMultipleAssignments.Found, WordPress.CodeAnalysis.AssignmentInCondition.Found
			foreach ( $_chosen_attributes as $name => $data ) {
				$filter_name = wc_attribute_taxonomy_slug( $name );
				if ( ! empty( $data['terms'] ) ) {
					$link = add_query_arg( 'filter_' . $filter_name, implode( ',', $data['terms'] ), $link );
				}
				if ( 'or' === $data['query_type'] ) {
					$link = add_query_arg( 'query_type_' . $filter_name, 'or', $link );
				}
			}
		}

		return apply_filters( 'woocommerce_widget_get_current_page_url', $link, $this );
	}

	/**
	 * Count products within certain terms, taking the main WP query into consideration.
	 *
	 * This query allows counts to be generated based on the viewed products, not all products.
	 *
	 * @param  array  $term_ids Term IDs.
	 * @param  string $taxonomy Taxonomy.
	 * @param  string $query_type Query Type.
	 * @return array
	 */
	protected function get_filtered_term_product_counts( $term_ids, $taxonomy, $query_type ) {
		global $wpdb;

		$tax_query  = WC_Query::get_main_tax_query();
		$meta_query = WC_Query::get_main_meta_query();

		if ( 'or' === $query_type ) {
			foreach ( $tax_query as $key => $query ) {
				if ( is_array( $query ) && $taxonomy === $query['taxonomy'] ) {
					unset( $tax_query[ $key ] );
				}
			}
		}

		$meta_query     = new WP_Meta_Query( $meta_query );
		$tax_query      = new WP_Tax_Query( $tax_query );
		$meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
		$tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );

		// Generate query.
		$query           = array();
		$query['select'] = "SELECT COUNT( DISTINCT {$wpdb->posts}.ID ) as term_count, terms.term_id as term_count_id";
		$query['from']   = "FROM {$wpdb->posts}";
		$query['join']   = "
			INNER JOIN {$wpdb->term_relationships} AS term_relationships ON {$wpdb->posts}.ID = term_relationships.object_id
			INNER JOIN {$wpdb->term_taxonomy} AS term_taxonomy USING( term_taxonomy_id )
			INNER JOIN {$wpdb->terms} AS terms USING( term_id )"
		                   . $tax_query_sql['join'] . $meta_query_sql['join'];

		$query['where'] = "
			WHERE {$wpdb->posts}.post_type IN ( 'product' )
			AND {$wpdb->posts}.post_status = 'publish'" . $tax_query_sql['where'] . $meta_query_sql['where']
		                  . 'AND terms.term_id IN (' . implode( ',', array_map( 'absint', $term_ids ) ) . ')';

		$search = WC_Query::get_main_search_query_sql();
		if ( $search ) {
			$query['where'] .= ' AND ' . $search;
		}

		$query['group_by'] = 'GROUP BY terms.term_id';
		$query             = apply_filters( 'woocommerce_get_filtered_term_product_counts_query', $query );
		$query             = implode( ' ', $query );

		// We have a query - let's see if cached results of this query already exist.
		$query_hash = md5( $query );

		// Maybe store a transient of the count values.
		$cache = apply_filters( 'woocommerce_layered_nav_count_maybe_cache', true );
		if ( true === $cache ) {
			$cached_counts = (array) get_transient( 'wc_layered_nav_counts_' . sanitize_title( $taxonomy ) );
		} else {
			$cached_counts = array();
		}

		if ( ! isset( $cached_counts[ $query_hash ] ) ) {
			$results                      = $wpdb->get_results( $query, ARRAY_A ); // @codingStandardsIgnoreLine
			$counts                       = array_map( 'absint', wp_list_pluck( $results, 'term_count', 'term_count_id' ) );
			$cached_counts[ $query_hash ] = $counts;
			if ( true === $cache ) {
				set_transient( 'wc_layered_nav_counts_' . sanitize_title( $taxonomy ), $cached_counts, DAY_IN_SECONDS );
			}
		}

		return array_map( 'absint', (array) $cached_counts[ $query_hash ] );
	}
}
