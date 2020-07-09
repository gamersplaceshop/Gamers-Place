<?php

/**
 * Widget "(Cartzilla) Product Categories"
 *
 * Display the product categories in accordion with a search field.
 *
 * @uses WP_Widget
 */
class Cartzilla_WC_Categories_Widget extends WP_Widget {
	private $widget_id = 'cartzilla_wc_categories';
	private $widget_settings = [
		'title'      => '',
		'orderby'    => 'name',
		'count'      => 0,
		'search'     => 1,
		'hide_empty' => 0,
	];

	public function __construct() {
		$opts = [ 'description' => esc_html_x( 'A filterable list of product categories.', 'widget', 'cartzilla-extensions' ) ];
		parent::__construct( $this->widget_id, esc_html_x( '(Cartzilla) Product Categories', 'widget', 'cartzilla-extensions' ), $opts );
	}

	/**
	 * Display the widget contents
	 *
	 * @param array $args Widget args described in {@see register_sidebar()}
	 * @param array $instance Widget settings
	 */
	public function widget( $args, $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->widget_settings );
		$title    = apply_filters( 'widget_title', esc_html( trim( $instance['title'] ) ), $instance, $this->id_base );

		$count      = ( (int) $instance['count'] === 1 );
		$is_search  = ( (int) $instance['search'] === 1 );
		$hide_empty = ( (int) $instance['hide_empty'] === 1 );

		// Shared args for get_terms() to fetch top-level categories and wp_list_categories()
		$settings = apply_filters('cartzilla_wc_categories_setting',[
			'taxonomy'   => 'product_cat',
			'hide_empty' => $hide_empty,
			'orderby'    => 'name',
			'order'      => 'ASC',
			'depth'      => 1,
		]);

		if ( $instance['orderby'] === 'order' ) {
			$settings['orderby']  = 'meta_value_num';
			$settings['meta_key'] = 'order';
		}

		// Specific args for get_terms()
		$get_terms_args = array_merge( $settings, [ 'parent' => 0, 'pad_counts' => $count ] );

		// Specific args for wp_list_categories()
		$list_args = array_merge( $settings, [
			'hierarchical'        => true,
			'show_count'          => $count,
			'show_option_all'     => '',
			'show_option_none'    => '',
			'title_li'            => '',
			'hide_title_if_empty' => false,
			'use_desc_for_title'  => false,
			'is_search'           => $is_search,
			'walker'              => new Cartzilla_Category_Walker(),
		] );

		$is_product_category = false;
		$current_category    = null;
		if ( is_tax( 'product_cat' ) ) {
			/** @var WP_Term $current_category */
			$current_category = get_queried_object();
			if ( $current_category && $current_category->taxonomy === 'product_cat' ) {
				$is_product_category           = true;
				$list_args['current_category'] = get_queried_object_id();
			}
		}

		$categories = get_terms( $get_terms_args );
		if ( empty( $categories ) || is_wp_error( $categories ) ) {
			return;
		}

		$first = reset( $categories );
		/** @var WP_Term $category */
		foreach ( $categories as &$category ) {
			$category->active = false;
			if ( $is_product_category ) {
				if ( $category->term_id == $current_category->term_id ) {
					// Current category, open the accordion
					$category->active = true;
				} else {
					$sub_categories = get_terms( [
						'taxonomy'   => $category->taxonomy,
						'child_of'   => $category->term_id,
						'hide_empty' => false,
					] );

					/** @var WP_Term $sub_category */
					foreach ( $sub_categories as $sub_category ) {
						if ( $sub_category->term_id == $current_category->term_id ) {
							$category->active = true;
							break;
						}
					}
				}
			} elseif ( $category->term_id == $first->term_id ) {
				$category->active = true;
			}
		}
		unset( $category );

		echo $args['before_widget'];
		if ( $title ) {
			echo $args['before_title'], $title, $args['after_title'];
		}

		?>
		<div class="accordion mt-n1" id="<?php echo esc_attr( $this->get_field_id( 'shop-categories' ) ); ?>">
			<?php foreach ( $categories as $category ) : ?>
				<div class="card">
					<div class="card-header">
						<h3 class="accordion-heading">
							<a class="collapsed" href="#<?php echo esc_attr( $this->get_field_id( $category->slug ) ); ?>" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="<?php echo esc_attr( $this->get_field_id( $category->slug ) ); ?>">
								<?php echo esc_html( $category->name ); ?>
								<span class="accordion-indicator"></span>
							</a>
						</h3>
					</div>
					<div class="collapse <?php echo ( $category->active ) ? 'show' : ''; ?>"
					     id="<?php echo esc_attr( $this->get_field_id( $category->slug ) ); ?>"
					     data-parent="#<?php echo esc_attr( $this->get_field_id( 'shop-categories' ) ); ?>"
					>
						<div class="card-body">
							<div class="widget widget-links cz-filter">
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
								<ul class="widget-list cz-filter-list pt-1">
									<li class="widget-list-item cz-filter-item">
										<a class="widget-list-link d-flex justify-content-between align-items-center" href="<?php echo esc_url( get_term_link( $category ) ); ?>">
											<span class="cz-filter-item-text"><?php
												/* translators: view all products in current (parent) category */
												echo esc_html_x( 'View all', 'front-end', 'cartzilla-extensions' ); ?></span>
											<?php if ( $count ) : ?>
												<span class="font-size-xs text-muted ml-3"><?php echo number_format_i18n( $category->count ); ?></span>
											<?php endif; ?>
										</a>
									</li>
									<?php wp_list_categories( array_merge( $list_args, [ 'child_of' => $category->term_id ] ) ); ?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
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
			<label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>">
				<?php echo esc_html_x( 'Order by', 'widget', 'cartzilla-extensions' ); ?>
			</label>
			<select class="widefat"
			        id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"
			        name="<?php echo esc_attr( $this->get_field_name('orderby')); ?>"
			>
				<option value="order" <?php selected( $instance['orderby'], 'order' ); ?>><?php echo esc_html_x( 'Category order', 'widget', 'cartzilla-extensions' ); ?></option>
				<option value="name" <?php selected( $instance['orderby'], 'name'  ); ?>><?php echo esc_html_x( 'Name', 'widget', 'cartzilla-extensions' ); ?></option>
			</select>
		</p>
		<p>
			<input type="checkbox" class="checkbox" value="1"
			       id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>"
				<?php checked( $instance['count'], 1 ); ?>
			>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>">
				<?php echo esc_html_x( 'Show product counts', 'widget', 'cartzilla-extensions' ); ?>
			</label>
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
		<p>
			<input type="checkbox" class="checkbox" value="1"
			       id="<?php echo esc_attr( $this->get_field_id( 'hide_empty' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'hide_empty' ) ); ?>"
				<?php checked( $instance['hide_empty'], 1 ); ?>
			>
			<label for="<?php echo esc_attr( $this->get_field_id( 'hide_empty' ) ); ?>">
				<?php echo esc_html_x( 'Hide empty categories', 'widget', 'cartzilla-extensions' ); ?>
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
		$instance['orderby']    = sanitize_key( $new_instance['orderby'] );
		$instance['count']      = empty( $new_instance['count'] ) ? 0 : 1;
		$instance['search']     = empty( $new_instance['search'] ) ? 0 : 1;
		$instance['hide_empty'] = empty( $new_instance['hide_empty'] ) ? 0 : 1;

		return $instance;
	}
}
