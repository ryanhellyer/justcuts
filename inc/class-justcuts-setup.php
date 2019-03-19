<?php

/**
 * Primary class used to load the theme.
 *
 * @copyright Copyright (c), Ryan Hellyer
 * @author Ryan Hellyer <ryanhellyer@gmail.com>
 */
class JustCuts_Setup {

	/**
	 * Theme version number.
	 * 
	 * @var string
	 */
	const VERSION_NUMBER = '1.0';

	/**
	 * Theme name.
	 * 
	 * @var string
	 */
	const THEME_NAME = 'justcuts';

	/**
	 * Constructor.
	 *
	 * @global  int  $content_width  Sets the media widths (unfortunately required as a global due to WordPress core requirements) 
	 */
	public function __construct() {
		global $content_width;
		$content_width = 680;

		// Add action hooks
		add_action( 'init',               array( $this, 'register_post_types' ) );
		add_action( 'init',               array( $this, 'register_taxonomies' ) );
		add_action( 'admin_menu',         array( $this, 'remove_custom_taxonomy_uis' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'stylesheet' ) );
		add_action( 'after_setup_theme',  array( $this, 'theme_setup' ) );
		add_filter( 'post_type_link',     array( $this, 'remove_slug' ), 10, 3 );
		add_action( 'pre_get_posts',      array( $this, 'parse_request' ) );

	}

	/**
	 * Register post-types.
	 */
	public function register_post_types() {

		register_post_type(
			'business',
			array(
				'public'    => true,
				'label'     => esc_html__( 'Business', 'justcuts' ),
				'supports'  => array( 'title', 'editor' ),
				'menu_icon' => 'dashicons-admin-users',
				'taxonomies' => array( 'post_tag' ),
			)
		);

	}

	/**
	 * Register taxonomies.
	 */
	public function register_taxonomies() {

		$args = array(
			'hierarchical'          => false,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'query_var'             => true,
			'meta_box_cb'           => false,
		);

		// Country taxonomy
		$args['labels'] = array(
			'name'          => _x( 'Countries', 'taxonomy general name', 'justcuts' ),
			'singular_name' => _x( 'Country', 'taxonomy singular name', 'justcuts' ),
			'edit_item'     => __( 'Edit Country', 'justcuts' ),
		);
		$args['rewrite'] = array( 'slug' => 'country' );
		register_taxonomy( 'country', 'business', $args );

		// City taxonomy
		$args['labels'] = array(
			'name'          => _x( 'Cities', 'taxonomy general name', 'justcuts' ),
			'singular_name' => _x( 'City', 'taxonomy singular name', 'justcuts' ),
			'edit_item'     => __( 'Edit City', 'justcuts' ),
		);
		$args['rewrite'] = array( 'slug' => 'city' );
		register_taxonomy( 'city', 'business', $args );

		// Price taxonomy
		$args['labels'] = array(
			'name'          => _x( 'Prices', 'taxonomy general name', 'justcuts' ),
			'singular_name' => _x( 'Price', 'taxonomy singular name', 'justcuts' ),
			'edit_item'     => __( 'Edit Price', 'justcuts' ),
		);
		$args['rewrite'] = array( 'slug' => 'price' );
		register_taxonomy( 'price', 'business', $args );

	}

	/**
	 * Remove country and city taxonomy UI's.
	 * We have our own UI for countries (select box) and cities (text field) so we need to remove the default UI.
	 */
	public function remove_custom_taxonomy_uis() {
		remove_meta_box( 'tagsdiv-country', 'country', 'high' );
		remove_meta_box( 'tagsdiv-city', 'city', 'high' );
	}

	/**
	 * Load stylesheet.
	 */
	public function stylesheet() {
		if ( ! is_admin() ) {
			wp_enqueue_style( self::THEME_NAME, get_stylesheet_directory_uri() . '/assets/css/style.min.css', array(), self::VERSION_NUMBER );
		}
	}

	public function remove_slug( $post_link, $post, $leavename ) {

		if ( 'business' != $post->post_type || 'publish' != $post->post_status ) {
			return $post_link;
		}

		$post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );

		return $post_link;
	}

	public function parse_request( $query ) {

		if ( ! $query->is_main_query() || 2 != count( $query->query ) || ! isset( $query->query['page'] ) ) {
			return;
		}

		if ( ! empty( $query->query['name'] ) ) {
			$query->set( 'post_type', array( 'post', 'business', 'page' ) );
		}
	}

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 */
	public function theme_setup() {

		// Make theme available for translation
		load_theme_textdomain( 'justcuts', get_template_directory() . '/languages' );

		// Add title tags
		add_theme_support( 'title-tag' );
	}

	/**
	 * Get every country.
	 *
	 * @return array
	 */
	function countries() {

		$countries = array(
			'af' => esc_html__( 'Afghanistan', 'justcuts' ),
			'ax' => esc_html__( 'Åland Islands', 'justcuts' ),
			'al' => esc_html__( 'Albania', 'justcuts' ),
			'dz' => esc_html__( 'Algeria', 'justcuts' ),
			'as' => esc_html__( 'American Samoa', 'justcuts' ),
			'ad' => esc_html__( 'Andorra', 'justcuts' ),
			'ao' => esc_html__( 'Angola', 'justcuts' ),
			'ai' => esc_html__( 'Anguilla', 'justcuts' ),
			'aq' => esc_html__( 'Antarctica', 'justcuts' ),
			'ag' => esc_html__( 'Antigua and Barbuda', 'justcuts' ),
			'ar' => esc_html__( 'Argentina', 'justcuts' ),
			'am' => esc_html__( 'Armenia', 'justcuts' ),
			'aw' => esc_html__( 'Aruba', 'justcuts' ),
			'au' => esc_html__( 'Australia', 'justcuts' ),
			'at' => esc_html__( 'Austria', 'justcuts' ),
			'az' => esc_html__( 'Azerbaijan', 'justcuts' ),
			'bs' => esc_html__( 'Bahamas', 'justcuts' ),
			'bh' => esc_html__( 'Bahrain', 'justcuts' ),
			'bd' => esc_html__( 'Bangladesh', 'justcuts' ),
			'bb' => esc_html__( 'Barbados', 'justcuts' ),
			'by' => esc_html__( 'Belarus', 'justcuts' ),
			'be' => esc_html__( 'Belgium', 'justcuts' ),
			'bz' => esc_html__( 'Belize', 'justcuts' ),
			'bj' => esc_html__( 'Benin', 'justcuts' ),
			'bm' => esc_html__( 'Bermuda', 'justcuts' ),
			'bt' => esc_html__( 'Bhutan', 'justcuts' ),
			'bo' => esc_html__( 'Bolivia', 'justcuts' ),
			'ba' => esc_html__( 'Bosnia and Herzegovina', 'justcuts' ),
			'bw' => esc_html__( 'Botswana', 'justcuts' ),
			'bv' => esc_html__( 'Bouvet Island', 'justcuts' ),
			'br' => esc_html__( 'Brazil', 'justcuts' ),
			'io' => esc_html__( 'British Indian Ocean Territory', 'justcuts' ),
			'bn' => esc_html__( 'Brunei Darussalam', 'justcuts' ),
			'bg' => esc_html__( 'Bulgaria', 'justcuts' ),
			'bf' => esc_html__( 'Burkina Faso', 'justcuts' ),
			'bi' => esc_html__( 'Burundi', 'justcuts' ),
			'kh' => esc_html__( 'Cambodia', 'justcuts' ),
			'cm' => esc_html__( 'Cameroon', 'justcuts' ),
			'ca' => esc_html__( 'Canada', 'justcuts' ),
			'cv' => esc_html__( 'Cape Verde', 'justcuts' ),
			'ky' => esc_html__( 'Cayman Islands', 'justcuts' ),
			'cf' => esc_html__( 'Central African Republic', 'justcuts' ),
			'td' => esc_html__( 'Chad', 'justcuts' ),
			'cl' => esc_html__( 'Chile', 'justcuts' ),
			'cn' => esc_html__( 'China', 'justcuts' ),
			'cx' => esc_html__( 'Christmas Island', 'justcuts' ),
			'cc' => esc_html__( 'Cocos (Keeling) Islands', 'justcuts' ),
			'co' => esc_html__( 'Colombia', 'justcuts' ),
			'km' => esc_html__( 'Comoros', 'justcuts' ),
			'cg' => esc_html__( 'Congo', 'justcuts' ),
			'cd' => esc_html__( 'Congo, The Democratic Republic of The', 'justcuts' ),
			'ck' => esc_html__( 'Cook Islands', 'justcuts' ),
			'cr' => esc_html__( 'Costa Rica', 'justcuts' ),
			'ci' => esc_html__( 'Cote D&#039;ivoire', 'justcuts' ),
			'hr' => esc_html__( 'Croatia', 'justcuts' ),
			'cu' => esc_html__( 'Cuba', 'justcuts' ),
			'cy' => esc_html__( 'Cyprus', 'justcuts' ),
			'cz' => esc_html__( 'Czech Republic', 'justcuts' ),
			'dk' => esc_html__( 'Denmark', 'justcuts' ),
			'dj' => esc_html__( 'Djibouti', 'justcuts' ),
			'dm' => esc_html__( 'Dominica', 'justcuts' ),
			'do' => esc_html__( 'Dominican Republic', 'justcuts' ),
			'ec' => esc_html__( 'Ecuador', 'justcuts' ),
			'eg' => esc_html__( 'Egypt', 'justcuts' ),
			'sv' => esc_html__( 'El Salvador', 'justcuts' ),
			'gq' => esc_html__( 'Equatorial Guinea', 'justcuts' ),
			'er' => esc_html__( 'Eritrea', 'justcuts' ),
			'ee' => esc_html__( 'Estonia', 'justcuts' ),
			'et' => esc_html__( 'Ethiopia', 'justcuts' ),
			'fk' => esc_html__( 'Falkland Islands (Malvinas)', 'justcuts' ),
			'fo' => esc_html__( 'Faroe Islands', 'justcuts' ),
			'fj' => esc_html__( 'Fiji', 'justcuts' ),
			'fi' => esc_html__( 'Finland', 'justcuts' ),
			'fr' => esc_html__( 'France', 'justcuts' ),
			'gf' => esc_html__( 'French Guiana', 'justcuts' ),
			'pf' => esc_html__( 'French Polynesia', 'justcuts' ),
			'tf' => esc_html__( 'French Southern Territories', 'justcuts' ),
			'ga' => esc_html__( 'Gabon', 'justcuts' ),
			'gm' => esc_html__( 'Gambia', 'justcuts' ),
			'ge' => esc_html__( 'Georgia', 'justcuts' ),
			'de' => esc_html__( 'Germany', 'justcuts' ),
			'gh' => esc_html__( 'Ghana', 'justcuts' ),
			'gi' => esc_html__( 'Gibraltar', 'justcuts' ),
			'gr' => esc_html__( 'Greece', 'justcuts' ),
			'gl' => esc_html__( 'Greenland', 'justcuts' ),
			'gd' => esc_html__( 'Grenada', 'justcuts' ),
			'gp' => esc_html__( 'Guadeloupe', 'justcuts' ),
			'gu' => esc_html__( 'Guam', 'justcuts' ),
			'gt' => esc_html__( 'Guatemala', 'justcuts' ),
			'gg' => esc_html__( 'Guernsey', 'justcuts' ),
			'gn' => esc_html__( 'Guinea', 'justcuts' ),
			'gw' => esc_html__( 'Guinea-bissau', 'justcuts' ),
			'gy' => esc_html__( 'Guyana', 'justcuts' ),
			'ht' => esc_html__( 'Haiti', 'justcuts' ),
			'hm' => esc_html__( 'Heard Island and Mcdonald Islands', 'justcuts' ),
			'va' => esc_html__( 'Holy See (Vatican City State)', 'justcuts' ),
			'hn' => esc_html__( 'Honduras', 'justcuts' ),
			'hk' => esc_html__( 'Hong Kong', 'justcuts' ),
			'hu' => esc_html__( 'Hungary', 'justcuts' ),
			'is' => esc_html__( 'Iceland', 'justcuts' ),
			'in' => esc_html__( 'India', 'justcuts' ),
			'id' => esc_html__( 'Indonesia', 'justcuts' ),
			'ir' => esc_html__( 'Iran, Islamic Republic of', 'justcuts' ),
			'iq' => esc_html__( 'Iraq', 'justcuts' ),
			'ie' => esc_html__( 'Ireland', 'justcuts' ),
			'im' => esc_html__( 'Isle of Man', 'justcuts' ),
			'il' => esc_html__( 'Israel', 'justcuts' ),
			'it' => esc_html__( 'Italy', 'justcuts' ),
			'jm' => esc_html__( 'Jamaica', 'justcuts' ),
			'jp' => esc_html__( 'Japan', 'justcuts' ),
			'je' => esc_html__( 'Jersey', 'justcuts' ),
			'jo' => esc_html__( 'Jordan', 'justcuts' ),
			'kz' => esc_html__( 'Kazakhstan', 'justcuts' ),
			'ke' => esc_html__( 'Kenya', 'justcuts' ),
			'ki' => esc_html__( 'Kiribati', 'justcuts' ),
			'kp' => esc_html__( 'Korea, Democratic People&#039;s Republic of', 'justcuts' ),
			'kr' => esc_html__( 'Korea, Republic of', 'justcuts' ),
			'kw' => esc_html__( 'Kuwait', 'justcuts' ),
			'kg' => esc_html__( 'Kyrgyzstan', 'justcuts' ),
			'la' => esc_html__( 'Lao People&#039;s Democratic Republic', 'justcuts' ),
			'lv' => esc_html__( 'Latvia', 'justcuts' ),
			'lb' => esc_html__( 'Lebanon', 'justcuts' ),
			'ls' => esc_html__( 'Lesotho', 'justcuts' ),
			'lr' => esc_html__( 'Liberia', 'justcuts' ),
			'ly' => esc_html__( 'Libyan Arab Jamahiriya', 'justcuts' ),
			'li' => esc_html__( 'Liechtenstein', 'justcuts' ),
			'lt' => esc_html__( 'Lithuania', 'justcuts' ),
			'lu' => esc_html__( 'Luxembourg', 'justcuts' ),
			'mo' => esc_html__( 'Macao', 'justcuts' ),
			'mk' => esc_html__( 'Macedonia, The Former Yugoslav Republic of', 'justcuts' ),
			'mg' => esc_html__( 'Madagascar', 'justcuts' ),
			'mw' => esc_html__( 'Malawi', 'justcuts' ),
			'my' => esc_html__( 'Malaysia', 'justcuts' ),
			'mv' => esc_html__( 'Maldives', 'justcuts' ),
			'ml' => esc_html__( 'Mali', 'justcuts' ),
			'mt' => esc_html__( 'Malta', 'justcuts' ),
			'mh' => esc_html__( 'Marshall Islands', 'justcuts' ),
			'mq' => esc_html__( 'Martinique', 'justcuts' ),
			'mr' => esc_html__( 'Mauritania', 'justcuts' ),
			'mu' => esc_html__( 'Mauritius', 'justcuts' ),
			'yt' => esc_html__( 'Mayotte', 'justcuts' ),
			'mx' => esc_html__( 'Mexico', 'justcuts' ),
			'fm' => esc_html__( 'Micronesia, Federated States of', 'justcuts' ),
			'md' => esc_html__( 'Moldova, Republic of', 'justcuts' ),
			'mc' => esc_html__( 'Monaco', 'justcuts' ),
			'mn' => esc_html__( 'Mongolia', 'justcuts' ),
			'me' => esc_html__( 'Montenegro', 'justcuts' ),
			'ms' => esc_html__( 'Montserrat', 'justcuts' ),
			'ma' => esc_html__( 'Morocco', 'justcuts' ),
			'mz' => esc_html__( 'Mozambique', 'justcuts' ),
			'mm' => esc_html__( 'Myanmar', 'justcuts' ),
			'na' => esc_html__( 'Namibia', 'justcuts' ),
			'nr' => esc_html__( 'Nauru', 'justcuts' ),
			'np' => esc_html__( 'Nepal', 'justcuts' ),
			'nl' => esc_html__( 'Netherlands', 'justcuts' ),
			'an' => esc_html__( 'Netherlands Antilles', 'justcuts' ),
			'nc' => esc_html__( 'New Caledonia', 'justcuts' ),
			'nz' => esc_html__( 'New Zealand', 'justcuts' ),
			'ni' => esc_html__( 'Nicaragua', 'justcuts' ),
			'ne' => esc_html__( 'Niger', 'justcuts' ),
			'ng' => esc_html__( 'Nigeria', 'justcuts' ),
			'nu' => esc_html__( 'Niue', 'justcuts' ),
			'nf' => esc_html__( 'Norfolk Island', 'justcuts' ),
			'mp' => esc_html__( 'Northern Mariana Islands', 'justcuts' ),
			'no' => esc_html__( 'Norway', 'justcuts' ),
			'om' => esc_html__( 'Oman', 'justcuts' ),
			'pk' => esc_html__( 'Pakistan', 'justcuts' ),
			'pw' => esc_html__( 'Palau', 'justcuts' ),
			'ps' => esc_html__( 'Palestinian Territory, Occupied', 'justcuts' ),
			'pa' => esc_html__( 'Panama', 'justcuts' ),
			'pg' => esc_html__( 'Papua New Guinea', 'justcuts' ),
			'py' => esc_html__( 'Paraguay', 'justcuts' ),
			'pe' => esc_html__( 'Peru', 'justcuts' ),
			'ph' => esc_html__( 'Philippines', 'justcuts' ),
			'pn' => esc_html__( 'Pitcairn', 'justcuts' ),
			'pl' => esc_html__( 'Poland', 'justcuts' ),
			'pt' => esc_html__( 'Portugal', 'justcuts' ),
			'pr' => esc_html__( 'Puerto Rico', 'justcuts' ),
			'qa' => esc_html__( 'Qatar', 'justcuts' ),
			're' => esc_html__( 'Reunion', 'justcuts' ),
			'ro' => esc_html__( 'Romania', 'justcuts' ),
			'ru' => esc_html__( 'Russian Federation', 'justcuts' ),
			'rw' => esc_html__( 'Rwanda', 'justcuts' ),
			'sh' => esc_html__( 'Saint Helena', 'justcuts' ),
			'kn' => esc_html__( 'Saint Kitts and Nevis', 'justcuts' ),
			'lc' => esc_html__( 'Saint Lucia', 'justcuts' ),
			'pm' => esc_html__( 'Saint Pierre and Miquelon', 'justcuts' ),
			'vc' => esc_html__( 'Saint Vincent and The Grenadines', 'justcuts' ),
			'ws' => esc_html__( 'Samoa', 'justcuts' ),
			'sm' => esc_html__( 'San Marino', 'justcuts' ),
			'st' => esc_html__( 'Sao Tome and Principe', 'justcuts' ),
			'sa' => esc_html__( 'Saudi Arabia', 'justcuts' ),
			'sn' => esc_html__( 'Senegal', 'justcuts' ),
			'rs' => esc_html__( 'Serbia', 'justcuts' ),
			'sc' => esc_html__( 'Seychelles', 'justcuts' ),
			'sl' => esc_html__( 'Sierra Leone', 'justcuts' ),
			'sg' => esc_html__( 'Singapore', 'justcuts' ),
			'sk' => esc_html__( 'Slovakia', 'justcuts' ),
			'si' => esc_html__( 'Slovenia', 'justcuts' ),
			'sb' => esc_html__( 'Solomon Islands', 'justcuts' ),
			'so' => esc_html__( 'Somalia', 'justcuts' ),
			'za' => esc_html__( 'South Africa', 'justcuts' ),
			'gs' => esc_html__( 'South Georgia and The South Sandwich Islands', 'justcuts' ),
			'es' => esc_html__( 'Spain', 'justcuts' ),
			'lk' => esc_html__( 'Sri Lanka', 'justcuts' ),
			'sd' => esc_html__( 'Sudan', 'justcuts' ),
			'sr' => esc_html__( 'Suriname', 'justcuts' ),
			'sj' => esc_html__( 'Svalbard and Jan Mayen', 'justcuts' ),
			'sz' => esc_html__( 'Swaziland', 'justcuts' ),
			'se' => esc_html__( 'Sweden', 'justcuts' ),
			'ch' => esc_html__( 'Switzerland', 'justcuts' ),
			'sy' => esc_html__( 'Syrian Arab Republic', 'justcuts' ),
			'tw' => esc_html__( 'Taiwan, Province of China', 'justcuts' ),
			'tj' => esc_html__( 'Tajikistan', 'justcuts' ),
			'tz' => esc_html__( 'Tanzania, United Republic of', 'justcuts' ),
			'th' => esc_html__( 'Thailand', 'justcuts' ),
			'tl' => esc_html__( 'Timor-leste', 'justcuts' ),
			'tg' => esc_html__( 'Togo', 'justcuts' ),
			'tk' => esc_html__( 'Tokelau', 'justcuts' ),
			'to' => esc_html__( 'Tonga', 'justcuts' ),
			'tt' => esc_html__( 'Trinidad and Tobago', 'justcuts' ),
			'tn' => esc_html__( 'Tunisia', 'justcuts' ),
			'tr' => esc_html__( 'Turkey', 'justcuts' ),
			'tm' => esc_html__( 'Turkmenistan', 'justcuts' ),
			'tc' => esc_html__( 'Turks and Caicos Islands', 'justcuts' ),
			'tv' => esc_html__( 'Tuvalu', 'justcuts' ),
			'ug' => esc_html__( 'Uganda', 'justcuts' ),
			'ua' => esc_html__( 'Ukraine', 'justcuts' ),
			'ae' => esc_html__( 'United Arab Emirates', 'justcuts' ),
			'gb' => esc_html__( 'United Kingdom', 'justcuts' ),
			'us' => esc_html__( 'United States', 'justcuts' ),
			'um' => esc_html__( 'United States Minor Outlying Islands', 'justcuts' ),
			'uy' => esc_html__( 'Uruguay', 'justcuts' ),
			'uz' => esc_html__( 'Uzbekistan', 'justcuts' ),
			'vu' => esc_html__( 'Vanuatu', 'justcuts' ),
			've' => esc_html__( 'Venezuela', 'justcuts' ),
			'vn' => esc_html__( 'Viet Nam', 'justcuts' ),
			'vg' => esc_html__( 'Virgin Islands, British', 'justcuts' ),
			'vi' => esc_html__( 'Virgin Islands, U.S.', 'justcuts' ),
			'wf' => esc_html__( 'Wallis and Futuna', 'justcuts' ),
			'eh' => esc_html__( 'Western Sahara', 'justcuts' ),
			'ye' => esc_html__( 'Yemen', 'justcuts' ),
			'zm' => esc_html__( 'Zambia', 'justcuts' ),
			'zw' => esc_html__( 'Zimbabwe', 'justcuts' ),
		);

		return $countries;
	}

}
