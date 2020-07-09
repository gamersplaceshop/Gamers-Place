<?php

/**
 * Widget "(Cartzilla) Recent Posts"
 *
 * Display the recent posts according to design.
 *
 * @uses WP_Widget
 */
class Cartzilla_Recent_Posts_Widget extends WP_Widget {
	/**
	 * Widget id_base
	 *
	 * @var string
	 */
	private $widget_id = 'cartzilla_recent_posts';

	/**
	 * Widget default values
	 *
	 * @var array
	 */
	private $defaults = [
		'title'    => '',
		'number'   => 3,
		'category' => '',
	];

	public function __construct() {
		$opts = array( 'description' => esc_html__( 'Your latest posts in a fancy manner.', 'cartzilla-extensions' ) );
		parent::__construct( $this->widget_id, esc_html__( '(Cartzilla) Recent Posts', 'cartzilla-extensions' ), $opts );
	}

	/**
	 * Display the widget contents
	 *
	 * @param array $args     Widget args described in {@see register_sidebar()}
	 * @param array $instance Widget settings
	 */
	public function widget( $args, $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );
		$title    = apply_filters( 'widget_title', esc_html( trim( $instance['title'] ) ), $instance, $this->id_base );
		$number   = false === (bool) $instance['number'] ? 3 : (int) $instance['number'];
		$category = ( 'all' === $instance['category'] || empty( $instance['category'] ) ) ? '' : absint( $instance['category'] );

		/**
		 * Filter the argument for querying Recent Posts widget
		 *
		 * @since 1.0.0
		 *
		 * @param array $args An array of arguments for WP_Query
		 */
		$query = new WP_Query( apply_filters( 'cartzilla_widget_recent_posts_query_args', [
			'cat'                 => $category,
			'post_status'         => 'publish',
			'no_found_rows'       => true,
			'suppress_filters'    => true,
			'posts_per_page'      => $number,
			'ignore_sticky_posts' => true,
		] ) );

		echo $args['before_widget'];
		if ( $title ) {
			echo $args['before_title'], $title, $args['after_title'];
		}

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				?>
				<div <?php post_class( 'media align-items-center mb-3' ); ?>>
					<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
						<a href="<?php the_permalink(); ?>" class="widget-post-thumb">
							<?php the_post_thumbnail( 'post-thumbnail', [
								'class' => 'rounded',
								'alt'   => the_title_attribute( [ 'echo' => false ] ),
							] ); ?>
						</a>
					<?php endif; ?>
					<div class="media-body">
						<?php
						the_title(
							sprintf( '<h6 class="blog-entry-title font-size-sm mb-0"><a href="%s">', esc_url( get_permalink() ) ),
							'</a></h6>'
						); ?>
						<span class="font-size-ms text-muted"><?php
							/* translators: posted by */
							echo esc_html_x( 'by', 'front-end', 'cartzilla-extensions' );?>
							<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="blog-entry-meta-link"><?php echo esc_html( get_the_author() ); ?></a>
						</span>
					</div>
				</div>
				<?php
			}
			wp_reset_postdata();
		} else {
			echo '<p class="font-size-sm text-muted">', esc_html__( 'Posts not found.', 'cartzilla-extensions' ), '</p>';
		}

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
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		$categories = get_terms( array(
			'taxonomy'     => 'category',
			'hide_empty'   => false,
			'hierarchical' => false,
		) );

		if ( empty( $categories ) || is_wp_error( $categories ) ) {
			$categories = array();
		}

		$data = array();
		foreach ( $categories as $category ) {
			$data[] = array(
				'label' => $category->name,
				'value' => $category->slug,
			);
		}
		unset( $category );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php echo esc_html_x( 'Title', 'widget title', 'cartzilla-extensions' ); ?>
			</label>
			<input type="text" class="widefat"
			       id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
			       value="<?php echo esc_html( trim( $instance['title'] ) ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>">
				<?php echo esc_html__( 'Number of posts', 'cartzilla-extensions' ); ?>
			</label>
			<input type="number" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>"
			       value="<?php echo esc_attr( $instance['number'] ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>">
				<?php echo esc_html__( 'Category', 'cartzilla-extensions' ); ?>
			</label>
			<select class="widefat"
			        name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>"
			        id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>">
				<option value="all"><?php
					/* translators: "All categories" option in recent Posts widget */
					echo esc_html__( 'All', 'cartzilla-extensions' ); ?></option>
				<?php
				/** @var WP_Term $category */
				foreach ( (array) $categories as $category ) :
					echo sprintf( '<option value="%1$s" %3$s>%2$s</option>',
						(int) $category->term_id,
						esc_html( $category->name ),
						selected( $category->term_id, $instance['category'], false )
					);
				endforeach;
				?>
			</select>
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

		$instance['title']    = sanitize_text_field( trim( $new_instance['title'] ) );
		$instance['number']   = absint( $new_instance['number'] );
		$instance['category'] = absint( $new_instance['category'] );

		return $instance;
	}
}
