<?php

/**
 * Admin UI for businesses..
 *
 * @copyright Copyright (c), Ryan Hellyer
 * @author Ryan Hellyer <ryanhellyer@gmail.com>
 */
class JustCuts_Admin_UI extends JustCuts_Setup {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'cmb2_admin_init', array( $this, 'location_metaboxes' ) );
		add_action( 'cmb2_admin_init', array( $this, 'image_metaboxes' ) );
		add_action( 'cmb2_admin_init', array( $this, 'contact_metaboxes' ) );
		add_action( 'cmb2_admin_init', array( $this, 'price_metaboxes' ) );

		add_action( 'add_meta_boxes', array( $this, 'add_country_metabox' ) );
		add_action( 'save_post',      array( $this, 'country_save' ), 10, 2 );

		add_action( 'add_meta_boxes', array( $this, 'add_city_metabox' ) );
		add_action( 'save_post',      array( $this, 'city_save' ), 10, 2 );
	}

	/**
	 * Hook in and add a metabox to demonstrate repeatable grouped fields
	 */
	public function location_metaboxes() {
		$slug = 'event';

		$cmb = new_cmb2_box( array(
			'id'           => $slug,
			'title'        => esc_html__( 'Event Information', 'justcuts' ),
			'object_types' => array( 'business', ),
		) );

		$cmb->add_field( array(
			'name'             => esc_html__( 'Longitude', 'justcuts' ),
			'id'               => 'longitude',
			'type'             => 'text',
			'attributes'       => array(
				'type'    => 'number',
				'pattern' => '\d*',
			),
			'sanitization_cb' => 'absint',
			'escape_cb'       => 'absint',
		) );

		$cmb->add_field( array(
			'name'             => esc_html__( 'Latitude', 'justcuts' ),
			'id'               => 'latitude',
			'type'             => 'text',
			'attributes'       => array(
				'type'    => 'number',
				'pattern' => '\d*',
			),
			'escape_cb'       => 'absint',
			'sanitization_cb' => 'absint',
		) );

		$cmb->add_field( array(
			'name'             => esc_html__( 'Open Street Maps ID', 'justcuts' ),
			'id'               => 'osm-id',
			'type'             => 'text',
			'attributes'       => array(
				'type'    => 'number',
				'pattern' => '\d*',
			),
			'escape_cb'       => 'absint',
			'sanitization_cb' => 'absint',
		) );

	}

	/**
	 * Add image metaboxes.
	 */
	public function image_metaboxes() {
		$slug = 'images';

		$cmb = new_cmb2_box( array(
			'id'           => $slug,
			'title'        => esc_html__( 'Images', 'justcuts' ),
			'object_types' => array( 'business', ),
		) );

		$cmb->add_field( array(
			'name'             => esc_html__( 'Images', 'justcut' ),
			'desc'             => '',
			'id'               => 'wiki_test_file_list',
			'type'             => 'file_list',
			// 'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
			// 'query_args' => array( 'type' => 'image' ), // Only images attachment
			// Optional, override default text strings
			'text'             => array(
				'add_upload_files_text' => esc_html__( 'Add or Upload Files', 'justcuts' ),
				'remove_image_text'     => esc_html__( 'Remove Image', 'justcuts' ),
				'file_text'             => esc_html__( 'File', 'justcuts' ),
				'file_download_text'    => esc_html__( 'Download', 'justcuts' ),
				'remove_text'           => esc_html__( 'Remove', 'justcuts' ),
			),
		) );

	}

	/**
	 * Add contact metaboxes.
	 */
	public function contact_metaboxes() {
		$slug = 'contact';

		$cmb = new_cmb2_box( array(
			'id'           => $slug,
			'title'        => esc_html__( 'Contact', 'justcuts' ),
			'object_types' => array( 'business', ),
		) );

		$cmb->add_field( array(
			'name'            => esc_html__( 'Phone number', 'justcuts' ),
			'id'              => 'phone-number',
			'type'            => 'text',
			'escape_cb'       => 'esc_html',
			'sanitization_cb' => 'wp_kses_post',
		) );

		$cmb->add_field( array(
			'name'            => esc_html__( 'Website URL', 'justcuts' ),
			'id'              => 'website',
			'type'            => 'text',
			'escape_cb'       => 'esc_url',
			'sanitization_cb' => 'esc_url',
		) );

		$cmb->add_field( array(
			'name'            => esc_html__( 'Contact Form URL', 'justcuts' ),
			'id'              => 'website',
			'type'            => 'text',
			'escape_cb'       => 'esc_url',
			'sanitization_cb' => 'esc_url',
		) );

		$cmb->add_field( array(
			'name'            => esc_html__( 'Email address', 'justcuts' ),
			'id'              => 'email-address',
			'type'            => 'text',
			'escape_cb'       => 'esc_html',
			'sanitization_cb' => 'sanitize_email',
		) );

	}

	/**
	 * Add price metaboxes.
	 */
	public function price_metaboxes() {
		$slug = 'price';

		$cmb = new_cmb2_box( array(
			'id'           => $slug,
			'title'        => esc_html__( 'Price', 'justcuts' ),
			'object_types' => array( 'business', ),
		) );

		$cmb->add_field( array(
			'name'             => esc_html__( 'Price', 'justcuts' ),
			'id'               => 'price',
			'type'             => 'text',
			'attributes'       => array(
				'type'    => 'number',
				'pattern' => '\d*',
			),
			'escape_cb'       => 'absint',
			'sanitization_cb' => 'absint',
		) );

	}

	/**
	 * Add country metabox.
	 */
	public function add_country_metabox() {

		add_meta_box(
			'country', // ID
			__( 'Country', 'justcuts' ), // Title
			array(
				$this,
				'country_metabox', // Callback to method to display HTML
			),
			'business', // Post type
			'side', // Context, choose between 'normal', 'advanced', or 'side'
			'low'  // Position, choose between 'high', 'core', 'default' or 'low'
		);

	}

	/**
	 * Output the country meta box.
	 */
	public function country_metabox() {

		?>

		<p>
			<label for="_country"><strong><?php _e( 'Select a country', 'justcuts' ); ?></strong></label>
			<br />
			<select name="_country" id="_country"><?php

			foreach ( $this->countries() as $code => $country ) {
				$term = $this->get_country_code( get_the_ID() );

				echo '<option ' . selected( $code, $term ) . ' value="' . esc_attr( $code ) . '">' . esc_html( $country ) . '</option>';
			}

			?>
			</select>
			<input type="hidden" id="country-nonce" name="country-nonce" value="<?php echo esc_attr( wp_create_nonce( __FILE__ ) ); ?>">
		</p><?php
	}

	private function get_country_code( $post_id ) {

		$terms = wp_get_post_terms( $post_id, 'country', array() );
		$term = '';
		if ( isset( $terms[0]->slug ) ) {
			$term = $terms[0]->slug;
		}

		return $term;
	}

	private function get_country_id( $post_id ) {

		$terms = wp_get_post_terms( $post_id, 'country', array() );
		$term_id = '';
		if ( isset( $terms[0]->term_id ) ) {
			$term_id = $terms[0]->term_id;
		}

		return $term_id;
	}

	/**
	 * Save opening times meta box data.
	 *
	 * @param  int     $post_id  The post ID
	 * @param  object  $post     The post object
	 */
	public function country_save( $post_id, $post ) {

		// Only save if correct post data sent
		if ( isset( $_POST['_country'] ) ) {

			// Do nonce security check
			if ( ! wp_verify_nonce( $_POST['country-nonce'], __FILE__ ) ) {
				return;
			}

			// Sanitize and store the data
			$_country = wp_kses_post( $_POST['_country'] );

			wp_set_post_terms( $post_id, $_country, 'country', false );

			// Set term name
			$term_id = $this->get_country_id( $post_id );
			wp_update_term(
				$term_id,
				'country',
				array(
					'name' => 'Non Catégorisé',
					'slug' => 'non-categorise'
				)
			);

		}

	}








	/**
	 * Add city metabox.
	 */
	public function add_city_metabox() {

		add_meta_box(
			'city', // ID
			__( 'City', 'justcuts' ), // Title
			array(
				$this,
				'city_metabox', // Callback to method to display HTML
			),
			'business', // Post type
			'side', // Context, choose between 'normal', 'advanced', or 'side'
			'low'  // Position, choose between 'high', 'core', 'default' or 'low'
		);

	}

	/**
	 * Output the city meta box.
	 */
	public function city_metabox() {

		$term = $this->get_city_name( get_the_ID() );
		?>

		<p>
			<label for="_city"><strong><?php _e( 'Enter the city', 'justcuts' ); ?></strong></label>
			<br />
			<input type="text" name="_city" id="_city" value="<?php echo esc_attr( $term ); ?>" />
			<input type="hidden" id="city-nonce" name="city-nonce" value="<?php echo esc_attr( wp_create_nonce( __FILE__ ) ); ?>">
		</p><?php
	}

	private function get_city_name( $post_id ) {

		$terms = wp_get_post_terms( $post_id, 'city', array() );
		$term = '';
		if ( isset( $terms[0]->name ) ) {
			$term = $terms[0]->name;
		}

		return $term;
	}

	/**
	 * Save opening times meta box data.
	 *
	 * @param  int     $post_id  The post ID
	 * @param  object  $post     The post object
	 */
	public function city_save( $post_id, $post ) {

		// Only save if correct post data sent
		if ( isset( $_POST['_city'] ) ) {

			// Do nonce security check
			if ( ! wp_verify_nonce( $_POST['city-nonce'], __FILE__ ) ) {
				return;
			}

			// Sanitize and store the data
			$_city = wp_kses_post( $_POST['_city'] );

			wp_set_post_terms( $post_id, $_city, 'city', false );

		}

	}

}
