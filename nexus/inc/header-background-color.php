<?php
/**
 * Customizer functionality
 */

/**
 * Sets up the WordPress core custom header and custom background features.
 */
function nexus_custom_header_and_background() {
	/**
	 * Filter the arguments used when adding 'custom-background' support in Persona.
	 *
	 * @param array $args {
	 *     An array of custom-background support arguments.
	 *
	 *     @type string $default-color Default color of the background.
	 * }
	 */
	add_theme_support( 'custom-background', apply_filters( 'nexus_custom_background_args', array(
		'default-color' => '#111111',
	) ) );

	/**
	 * Filter the arguments used when adding 'custom-header' support in Persona.
	 *
	 * @param array $args {
	 *     An array of custom-header support arguments.
	 *
	 *     @type string $default-text-color Default color of the header text.
	 *     @type int      $width            Width in pixels of the custom header image. Default 1200.
	 *     @type int      $height           Height in pixels of the custom header image. Default 280.
	 *     @type bool     $flex-height      Whether to allow flexible-height header images. Default true.
	 *     @type callable $wp-head-callback Callback function used to style the header image and text
	 *                                      displayed on the blog.
	 * }
	 */
	add_theme_support( 'custom-header', apply_filters( 'nexus_custom_header_args', array(
		'default-image'      	 => get_parent_theme_file_uri( '/assets/images/Event-bg.jpg' ),
		'default-text-color'     => '#000000',
		'width'                  => 1920,
		'height'                 => 822,
		'flex-height'            => true,
		'flex-width'            => true,
		'wp-head-callback'       => 'nexus_header_style',
	) ) );

	register_default_headers( array(
		'default-image' => array(
			'url'           => '%s/assets/images/Event-bg.jpg',
			'thumbnail_url' => '%s/assets/images/Event-bg-275x155.jpg',
			'description'   => esc_html__( 'Default Header Image', 'nexus' ),
		),
	) );
}
add_action( 'after_setup_theme', 'nexus_custom_header_and_background' );


if ( ! function_exists( 'nexus_header_style' ) ) :
	/**
	 * Styles the header text displayed on the site.
	 */
	function nexus_header_style() {
	// If the header text has been hidden.
	?>
	<?php
	// If the header text option is untouched, let's bail.
	if ( display_header_text() ) {
		$header_text_color = get_header_textcolor();

		if ( '000000' !== $header_text_color ) :
		?>
		<style type="text/css" id="nexus-header-css">
		.site-title a,
		.site-description {
			color: #<?php echo esc_attr( $header_text_color ); ?>;
		}
		</style>
	<?php
		endif;
	} else {
		?>
		<style type="text/css" id="nexus-header-css">
		.site-branding {
			margin: 0 auto 0 0;
		}

		.site-identity {
			clip: rect(1px, 1px, 1px, 1px);
			position: absolute;
		}
		</style>
	<?php
	}

}
endif; // nexus_header_style
