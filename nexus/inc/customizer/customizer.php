<?php
/**
 * Theme Customizer
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function nexus_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector' => '.site-title a',
			'container_inclusive' => false,
			'render_callback' => 'nexus_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector' => '.site-description',
			'container_inclusive' => false,
			'render_callback' => 'nexus_customize_partial_blogdescription',
		) );
	}

	// Reset all settings to default.
	$wp_customize->add_section( 'nexus_reset_all', array(
		'description'   => esc_html__( 'Caution: Reset all settings to default. Refresh the page after save to view full effects.', 'nexus' ),
		'title'         => esc_html__( 'Reset all settings', 'nexus' ),
		'priority'      => 998,
	) );

	nexus_register_option( $wp_customize, array(
			'name'              => 'nexus_reset_all_settings',
			'sanitize_callback' => 'nexus_sanitize_checkbox',
			'label'             => esc_html__( 'Check to reset all settings to default', 'nexus' ),
			'section'           => 'nexus_reset_all',
			'transport'         => 'postMessage',
			'type'              => 'checkbox',
		)
	);
	// Reset all settings to default end.
}

add_action( 'customize_register', 'nexus_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function nexus_customize_preview_js() {
	wp_enqueue_script( 'nexus-customize-preview', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/js/customize-preview.min.js', array( 'customize-preview' ), '20170816', true );
}
add_action( 'customize_preview_init', 'nexus_customize_preview_js' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @see nexus_customize_register()
 *
 * @return void
 */
function nexus_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @see nexus_customize_register()
 *
 * @return void
 */
function nexus_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 ** Allow users to change theme colors through the WordPress Customizer
 */

function nexus_customize_colors( $wp_customize ) {
    $wp_customize->get_section( 'colors' )->description = esc_html__( 'Customize the colors of various elements throughout the website.', 'nexus' );

    // Primary menu background color
    $wp_customize->add_setting(
        'header_background_color',
        array(
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'header_background_color',
            array(
                'label'   => esc_html__( 'Header Background Color', 'nexus' ),
                'section' => 'colors',
            )
        )
    );

    // Links Text color
    $wp_customize->add_setting(
        'link_textcolor',
        array(
            'default'           => '#039be5',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'link_textcolor',
            array(
                'label'   => esc_html__( 'Links Color', 'nexus' ),
                'section' => 'colors',
            )
        )
    );

    // Headings color
    $wp_customize->add_setting(
        'headings_textcolor',
        array(
            'default'           => '#000000',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'headings_textcolor',
            array(
                'label'   => esc_html__( 'Headings Text Color', 'nexus' ),
                'section' => 'colors',
            )
        )
    );

    // Buttons
    $wp_customize->add_setting(
        'button_color',
        array(
            'default'           => '#000000',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'button_color',
            array(
                'label'   => esc_html__( 'Buttons Background Color', 'nexus' ),
                'section' => 'colors',
            )
        )
    );

    // Navigation Links
    $wp_customize->add_setting(
        'menu_color',
        array(
            'default'           => '#000000',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'menu_color',
            array(
                'label'   => esc_html__( 'Navigation Links Color', 'nexus' ),
                'section' => 'colors',
            )
        )
    );
}
add_action( 'customize_register', 'nexus_customize_colors' );

function nexus_customize_colors_css() {
    $header_text_color = get_theme_mod( 'header_textcolor' ); ?>

    <style type="text/css">
        body h1,
        body h2,
        body h3,
        body h4,
        body h5,
        body h6{
            color: <?php echo esc_attr( get_theme_mod( 'headings_textcolor', '#000000' ) ); ?>;
        }
        body a {
            color: <?php echo esc_attr( get_theme_mod( 'link_textcolor', '#039be5' ) ); ?>;
        }
        #header-content .wrapper {
            background-color: <?php echo esc_attr( get_theme_mod( 'header_background_color', '#ffffff' ) ); ?>;
        }
        <?php if ( $header_text_color ) : ?>
        .hero-text .site-title a,
        header .site-description {
            color: #<?php echo esc_attr( get_theme_mod( 'header_textcolor', 'fff' ) ); ?>;
        }

        <?php endif; ?>
        button,
        a.button,
        a.button:visited,
        input[type="button"],
        input[type="reset"],
        input[type="submit"] {
            background-color: <?php echo esc_attr( get_theme_mod( 'button_color' ) ); ?> !important;
        }

        .site-navigation ul li a{
            color: <?php echo esc_attr( get_theme_mod( 'menu_color' ) ); ?>
        }
    </style>

    <?php
}
add_action( 'wp_head', 'nexus_customize_colors_css' );

/**
 * Include Custom Controls
 */
require get_parent_theme_file_path( 'inc/customizer/custom-controls.php' );

/**
 * Include Header Media Options
 */
require get_parent_theme_file_path( 'inc/customizer/header-media.php' );

/**
 * Include Theme Options
 */
require get_parent_theme_file_path( 'inc/customizer/theme-options.php' );

/**
 * Include Customizer Helper Functions
 */
require get_parent_theme_file_path( 'inc/customizer/helpers.php' );

/**
 * Include Sanitization functions
 */
require get_parent_theme_file_path( 'inc/customizer/sanitize-functions.php' );


