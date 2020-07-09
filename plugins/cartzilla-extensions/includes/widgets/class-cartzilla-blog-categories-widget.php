<?php

/**
 * Widget "(Cartzilla) Blog Categories"
 *
 * Display the Blog categories with counts
 *
 * @uses WP_Widget
 */
class Cartzilla_Blog_Categories_Widget extends WP_Widget {

	/**
	 * Widget id_base
	 *
	 * @var string
	 */
	private $widget_id = 'cartzilla_blog_categories';

	public function __construct() {
		$opts = array( 'description' => esc_html__( 'Blog categories list with counts', 'cartzilla-extensions' ) );
		parent::__construct( $this->widget_id, esc_html__( '(Cartzilla) Blog Categories', 'cartzilla-extensions' ), $opts );
	}

	/**
	 * Display the widget contents
	 *
	 * @param array $args     Widget args described in {@see register_sidebar()}
	 * @param array $instance Widget settings
	 */
	public function widget( $args, $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'title' => '',
			'count' => 0,
		) );

		$title      = apply_filters( 'widget_title', esc_html( trim( $instance['title'] ) ), $instance, $this->id_base );
		$categories = get_categories();
		$count      = $instance['count'];

		echo $args['before_widget'];
		if ( $title ) {
			echo $args['before_title'], $title, $args['after_title'];
		}

		?>
		<ul>
			<?php foreach ( $categories as $category ) : ?>
				<li>
					<a href="<?php echo esc_url( get_category_link( $category ) ); ?>" class="d-flex justify-content-between align-items-center">
						<span><?php echo esc_html( $category->name ); ?></span>
						<?php if ( $count ) : ?>
							<span class="font-size-xs text-muted ml-3"><?php echo esc_html( $category->count ); ?></span>
						<?php endif; ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
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
		$instance = wp_parse_args( (array) $instance, array(
			'title' => '',
			'count' => 0
		) );
		$count    = isset( $instance['count'] ) ? (bool) $instance['count'] : false;

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
			<input type="checkbox" class="checkbox"
			       id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>"
				<?php checked( $count ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>">
				<?php echo esc_html_x( 'Show post counts', 'widget settings', 'cartzilla-extensions' ); ?>
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

		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['count'] = isset( $new_instance['count'] ) ? 1 : 0;

		return $instance;
	}
}
