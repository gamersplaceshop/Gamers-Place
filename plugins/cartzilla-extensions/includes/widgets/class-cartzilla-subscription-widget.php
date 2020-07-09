<?php

/**
 * Widget "(Cartzilla) Subscription"
 *
 * Display the MailChimp subscription form
 *
 * @uses WP_Widget
 */
class Cartzilla_Subscription_Widget extends WP_Widget {

	/**
	 * Widget id_base
	 *
	 * @var string
	 */
	private $widget_id = 'cartzilla_subscription';

	public function __construct() {
		$opts = array( 'description' => esc_html__( 'Cartzilla Subscription Form', 'cartzilla-extensions' ) );
		parent::__construct( $this->widget_id, esc_html__( '(Cartzilla) Subscription', 'cartzilla-extensions' ), $opts );
	}

	/**
	 * Display the widget contents
	 *
	 * @param array $args     Widget args described in {@see register_sidebar()}
	 * @param array $instance Widget settings
	 */
	public function widget( $args, $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'title'			=> '',
			'form'			=> '',
		) );

		$title = apply_filters( 'widget_title', esc_html( trim( $instance['title'] ) ), $instance, $this->id_base );
		$form   = trim( $instance['form'] );

		echo $args['before_widget'];

		if ( $title ) {
			echo $args['before_title'], $title, $args['after_title'];
		}

		if ( ! empty( $form ) ) {
			echo do_shortcode( $form );
		} else {
			?>
			<form class="validate cz-subscribe-form" method="get">
				<div class="input-group input-group-overlay flex-nowrap">
					<div class="input-group-prepend-overlay">
						<span class="input-group-text text-muted font-size-base">
							<i class="czi-mail"></i>
						</span>
					</div>
					<input class="form-control prepended-form-control" type="email" name="EMAIL" placeholder="<?php echo esc_html__( 'Your email', 'cartzilla-extensions' ); ?>" required>
					<div class="input-group-append">
						<button class="btn btn-primary" type="submit"><?php
							/* translators: text on submit button */
							esc_html_e( 'Subscribe', 'cartzilla-extensions' ); ?></button>
					</div>
				</div>
				<div class="subscribe-status"></div>
			</form>
			<?php	
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
		$instance = wp_parse_args( (array) $instance, array(
			'title'       => '',
			'form'        => '',
		) );

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php echo esc_html__( 'Title', 'cartzilla-extensions' ); ?>
			</label>
			<input type="text" class="widefat"
			       id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
			       value="<?php echo esc_html( trim( $instance['title'] ) ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'form' ) ); ?>">
				<?php echo esc_html__( 'Form Shortcode', 'cartzilla-extensions' ); ?>
			</label>
			<textarea class="widefat"
			          id="<?php echo esc_attr( $this->get_field_id( 'form' ) ); ?>"
			          name="<?php echo esc_attr( $this->get_field_name( 'form' ) ); ?>"
			><?php echo esc_textarea( trim( $instance['form'] ) ); ?></textarea>
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

		$instance['title']       = sanitize_text_field( $new_instance['title'] );
		$instance['form']		 = sanitize_textarea_field( $new_instance['form'] );

		return $instance;
	}
}
