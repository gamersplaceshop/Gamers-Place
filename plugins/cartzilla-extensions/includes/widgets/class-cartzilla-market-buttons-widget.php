<?php

/**
 * Widget "(Cartzilla) Market Buttons"
 *
 * Display the Google Play, App Store, Windows Store and Amazon.com buttons
 *
 * @uses WP_Widget
 */
class Cartzilla_Market_Buttons_Widget extends WP_Widget {

	/**
	 * Widget id_base
	 *
	 * @var string
	 */
	private $widget_id = 'cartzilla_market_buttons';

	public function __construct() {
		$opts = array( 'description' => esc_html__( 'Google Play, App Store, Windows Store and Amazon.com buttons', 'cartzilla-extensions' ) );
		parent::__construct( $this->widget_id, esc_html__( '(Cartzilla) Market Buttons', 'cartzilla-extensions' ), $opts );
	}

	/**
	 * Display the widget contents
	 *
	 * @param array $args     Widget args described in {@see register_sidebar()}
	 * @param array $instance Widget settings
	 */
	public function widget( $args, $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'title'            => '',
			'app_store_url'    => '',
			'google_play_url'  => '',
			'win_store_url'    => '',
			'amazon_store_url' => ''
		) );

		$title      = apply_filters( 'widget_title', esc_html( trim( $instance['title'] ) ), $instance, $this->id_base );
		$app_store_url    = esc_url( trim( $instance['app_store_url'] ) );
		$google_play_url  = esc_url( trim( $instance['google_play_url'] ) );
		$win_store_url    = esc_url( trim( $instance['win_store_url'] ) );
		$amazon_store_url = esc_url( trim( $instance['amazon_store_url'] ) );

		echo $args['before_widget'];
		if ( $title ) {
			echo $args['before_title'], $title, $args['after_title'];
		}

    ?>
    <?php if ( $app_store_url ) : ?>
      <a href="<?php echo $app_store_url; ?>" class="btn-market btn-apple mr-2 mb-2" target="_blank" rel="noopener noreferrer" role="link">
        <span class="btn-market-subtitle"><?php echo esc_html__( 'Download on the', 'cartzilla-extensions' ); ?></span>
        <span class="btn-market-title"><?php echo esc_html__( 'App Store', 'cartzilla-extensions' ); ?></span>
      </a>
    <?php endif; ?>
    <?php if ( $google_play_url ) : ?>
      <a href="<?php echo $google_play_url; ?>" class="btn-market btn-google mr-2 mb-2" target="_blank" rel="noopener noreferrer" role="link">
        <span class="btn-market-subtitle"><?php echo esc_html__( 'Download on the', 'cartzilla-extensions' ); ?></span>
        <span class="btn-market-title"><?php echo esc_html__( 'Google Play', 'cartzilla-extensions' ); ?></span>
      </a>
    <?php endif; ?>
    <?php if ( $win_store_url ) : ?>
      <a href="<?php echo $win_store_url; ?>" class="btn-market btn-windows mr-2 mb-2" target="_blank" rel="noopener noreferrer" role="link">
        <span class="btn-market-subtitle"><?php echo esc_html__( 'Download on the', 'cartzilla-extensions' ); ?></span>
        <span class="btn-market-title"><?php echo esc_html__( 'Windows Store', 'cartzilla-extensions' ); ?></span>
      </a>
    <?php endif; ?>
    <?php if ( $amazon_store_url ) : ?>
      <a href="<?php echo $amazon_store_url; ?>" class="btn-market btn-amazon mr-2 mb-2" target="_blank" rel="noopener noreferrer" role="link">
        <span class="btn-market-subtitle"><?php echo esc_html__( 'Order now at', 'cartzilla-extensions' ); ?></span>
        <span class="btn-market-title"><?php echo esc_html__( 'Amazon.com', 'cartzilla-extensions' ); ?></span>
      </a>
    <?php endif; ?>
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
			'app_store_url'    => '',
			'google_play_url'  => '',
			'win_store_url'    => '',
			'amazon_store_url' => ''
		) );

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
      <label for="<?php echo esc_attr( $this->get_field_id( 'app_store_url' ) ); ?>">
        <?php echo esc_html__( 'App Store URL', 'cartzilla-extensions' ); ?>
      </label>
      <input type="text" class="widefat"
             id="<?php echo esc_attr( $this->get_field_id( 'app_store_url' ) ); ?>"
             name="<?php echo esc_attr( $this->get_field_name( 'app_store_url' ) ); ?>"
             value="<?php echo esc_url( trim( $instance['app_store_url'] ) ); ?>">
		</p>
		<p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'google_play_url' ) ); ?>">
        <?php echo esc_html__( 'Google Play URL', 'cartzilla-extensions' ); ?>
      </label>
      <input type="text" class="widefat"
             id="<?php echo esc_attr( $this->get_field_id( 'google_play_url' ) ); ?>"
             name="<?php echo esc_attr( $this->get_field_name( 'google_play_url' ) ); ?>"
             value="<?php echo esc_url( trim( $instance['google_play_url'] ) ); ?>">
		</p>
		<p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'win_store_url' ) ); ?>">
        <?php echo esc_html__( 'Windows Store URL', 'cartzilla-extensions' ); ?>
      </label>
      <input type="text" class="widefat"
             id="<?php echo esc_attr( $this->get_field_id( 'win_store_url' ) ); ?>"
             name="<?php echo esc_attr( $this->get_field_name( 'win_store_url' ) ); ?>"
             value="<?php echo esc_url( trim( $instance['win_store_url'] ) ); ?>">
		</p>
		<p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'amazon_store_url' ) ); ?>">
        <?php echo esc_html__( 'Amazon Store URL', 'cartzilla-extensions' ); ?>
      </label>
      <input type="text" class="widefat"
             id="<?php echo esc_attr( $this->get_field_id( 'amazon_store_url' ) ); ?>"
             name="<?php echo esc_attr( $this->get_field_name( 'amazon_store_url' ) ); ?>"
             value="<?php echo esc_url( trim( $instance['amazon_store_url'] ) ); ?>">
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

		$instance['title']            = sanitize_text_field( $new_instance['title'] );
		$instance['app_store_url']    = sanitize_text_field( $new_instance['app_store_url'] );
		$instance['google_play_url']  = sanitize_text_field( $new_instance['google_play_url'] );
		$instance['win_store_url']    = sanitize_text_field( $new_instance['win_store_url'] );
		$instance['amazon_store_url'] = sanitize_text_field( $new_instance['amazon_store_url'] );

		return $instance;
	}
}
