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

		$cmb->add_field( array(
			'name'             => esc_html__( 'Country', 'justcuts' ),
			'id'               => 'country',
			'type'             => 'select',
			'options_cb'       => array( $this, 'countries' ),
			'escape_cb'        => 'esc_html',
			'sanitization_cb'  => 'esc_html',
		) );

		$cmb->add_field( array(
			'name'             => esc_html__( 'City', 'justcuts' ),
			'id'               => 'city',
			'type'             => 'text',
			'options_cb'       => 'city',
			'escape_cb'        => 'esc_html',
			'sanitization_cb'  => 'esc_html',
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
				'add_upload_files_text' => 'Replacement', // default: "Add or Upload Files"
				'remove_image_text'     => 'Replacement', // default: "Remove Image"
				'file_text'             => 'Replacement', // default: "File:"
				'file_download_text'    => 'Replacement', // default: "Download"
				'remove_text'           => 'Replacement', // default: "Remove"
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

}
