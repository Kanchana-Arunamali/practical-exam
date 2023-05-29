<?php
/**
 * Nexus Theme Options
 */

/**
 * Add theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function nexus_theme_options( $wp_customize ) {
	$wp_customize->add_panel( 'nexus_theme_options', array(
		'title'    => esc_html__( 'Nexus Options', 'nexus' ),
		'priority' => 130,
	) );

	// Breadcrumb Option.
	$wp_customize->add_section( 'nexus_breadcrumb_options', array(
		'description'   => esc_html__( 'Breadcrumbs are a great way of letting your visitors find out where they are on your site with just a glance.', 'nexus' ),
		'panel'         => 'nexus_theme_options',
		'title'         => esc_html__( 'Breadcrumb', 'nexus' ),
	) );

	nexus_register_option( $wp_customize, array(
			'name'              => 'nexus_breadcrumb_option',
			'default'           => 1,
			'sanitize_callback' => 'nexus_sanitize_checkbox',
			'label'             => esc_html__( 'Check to enable Breadcrumb', 'nexus' ),
			'section'           => 'nexus_breadcrumb_options',
			'type'              => 'checkbox',
		)
	);

	nexus_register_option( $wp_customize, array(
			'name'              => 'nexus_latest_posts_title',
			'default'           => esc_html__( 'News', 'nexus' ),
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Latest Posts Title', 'nexus' ),
			'section'           => 'nexus_theme_options',
		)
	);

	// Layout Options
	$wp_customize->add_section( 'nexus_layout_options', array(
		'title' => esc_html__( 'Layout Options', 'nexus' ),
		'panel' => 'nexus_theme_options',
		)
	);

	/* Default Layout */
	nexus_register_option( $wp_customize, array(
			'name'              => 'nexus_default_layout',
			'default'           => 'right-sidebar',
			'sanitize_callback' => 'nexus_sanitize_select',
			'label'             => esc_html__( 'Default Layout', 'nexus' ),
			'section'           => 'nexus_layout_options',
			'type'              => 'radio',
			'choices'           => array(
				'right-sidebar'         => esc_html__( 'Right Sidebar ( Content, Primary Sidebar )', 'nexus' ),
				'no-sidebar'            => esc_html__( 'No Sidebar', 'nexus' ),
			),
		)
	);

	/* Homepage/Archive Layout */
	nexus_register_option( $wp_customize, array(
			'name'              => 'nexus_homepage_archive_layout',
			'default'           => 'right-sidebar',
			'sanitize_callback' => 'nexus_sanitize_select',
			'label'             => esc_html__( 'Homepage/Archive Layout', 'nexus' ),
			'section'           => 'nexus_layout_options',
			'type'              => 'radio',
			'choices'           => array(
				'right-sidebar'         => esc_html__( 'Right Sidebar ( Content, Primary Sidebar )', 'nexus' ),
				'no-sidebar'            => esc_html__( 'No Sidebar', 'nexus' ),
			),
		)
	);

	// Excerpt Options.
	$wp_customize->add_section( 'nexus_excerpt_options', array(
		'panel'     => 'nexus_theme_options',
		'title'     => esc_html__( 'Excerpt Options', 'nexus' ),
	) );

	nexus_register_option( $wp_customize, array(
			'name'              => 'nexus_excerpt_length',
			'default'           => '20',
			'sanitize_callback' => 'absint',
			'description' => esc_html__( 'Excerpt length. Default is 20 words', 'nexus' ),
			'input_attrs' => array(
				'min'   => 10,
				'max'   => 200,
				'step'  => 5,
				'style' => 'width: 60px;',
			),
			'label'    => esc_html__( 'Excerpt Length (words)', 'nexus' ),
			'section'  => 'nexus_excerpt_options',
			'type'     => 'number',
		)
	);

	nexus_register_option( $wp_customize, array(
			'name'              => 'nexus_excerpt_more_text',
			'default'           => esc_html__( 'Continue reading', 'nexus' ),
			'sanitize_callback' => 'sanitize_text_field',
			'label'             => esc_html__( 'Read More Text', 'nexus' ),
			'section'           => 'nexus_excerpt_options',
			'type'              => 'text',
		)
	);

	// Homepage / Frontpage Options.
	$wp_customize->add_section( 'nexus_homepage_options', array(
		'description' => esc_html__( 'Only posts that belong to the categories selected here will be displayed on the front page', 'nexus' ),
		'panel'       => 'nexus_theme_options',
		'title'       => esc_html__( 'Homepage / Frontpage Options', 'nexus' ),
	) );

	nexus_register_option( $wp_customize, array(
			'name'              => 'nexus_front_page_category',
			'sanitize_callback' => 'nexus_sanitize_category_list',
			'custom_control'    => 'Nexus_Multi_Categories_Control',
			'label'             => esc_html__( 'Categories', 'nexus' ),
			'section'           => 'nexus_homepage_options',
			'type'              => 'dropdown-categories',
		)
	);

    // Font Settings

    $font_choices = array(
        'Kaushan Script:' => 'Kaushan Script',
        'Emilys Candy:' => 'Emilys Candy',
        'Poppins:0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900' => 'Poppins',
        'Source Sans Pro:400,700,400italic,700italic' => 'Source Sans Pro',
        'Open Sans:400italic,700italic,400,700' => 'Open Sans',
        'Oswald:400,700' => 'Oswald',
        'Playfair Display:400,700,400italic' => 'Playfair Display',
        'Montserrat:400,700' => 'Montserrat',
        'Raleway:400,700' => 'Raleway',
        'Droid Sans:400,700' => 'Droid Sans',
        'Lato:400,700,400italic,700italic' => 'Lato',
        'Arvo:400,700,400italic,700italic' => 'Arvo',
        'Lora:400,700,400italic,700italic' => 'Lora',
        'Merriweather:400,300italic,300,400italic,700,700italic' => 'Merriweather',
        'Oxygen:400,300,700' => 'Oxygen',
        'PT Serif:400,700' => 'PT Serif',
        'PT Sans:400,700,400italic,700italic' => 'PT Sans',
        'PT Sans Narrow:400,700' => 'PT Sans Narrow',
        'Cabin:400,700,400italic' => 'Cabin',
        'Fjalla One:400' => 'Fjalla One',
        'Francois One:400' => 'Francois One',
        'Josefin Sans:400,300,600,700' => 'Josefin Sans',
        'Libre Baskerville:400,400italic,700' => 'Libre Baskerville',
        'Arimo:400,700,400italic,700italic' => 'Arimo',
        'Ubuntu:400,700,400italic,700italic' => 'Ubuntu',
        'Bitter:400,700,400italic' => 'Bitter',
        'Droid Serif:400,700,400italic,700italic' => 'Droid Serif',
        'Roboto:400,400italic,700,700italic' => 'Roboto',
        'Open Sans Condensed:700,300italic,300' => 'Open Sans Condensed',
        'Roboto Condensed:400italic,700italic,400,700' => 'Roboto Condensed',
        'Roboto Slab:400,700' => 'Roboto Slab',
        'Yanone Kaffeesatz:400,700' => 'Yanone Kaffeesatz',
        'Rokkitt:400' => 'Rokkitt',
    );

    $wp_customize->add_section( 'nexus_font_options', array(
        'description' => esc_html__( 'You can select the fonts for headings and body here.', 'nexus' ),
        'panel'       => 'nexus_theme_options',
        'title'       => esc_html__( 'Font Settings', 'nexus' ),
    ) );

    nexus_register_option( $wp_customize, array(
            'name'              => 'nexus_headings_fonts',
            'sanitize_callback' => 'nexus_sanitize_fonts',
            'label'             => esc_html__( 'Heading Font', 'nexus' ),
            'section'           => 'nexus_font_options',
            'type' => 'select',
            'choices' => $font_choices
        )
    );

    nexus_register_option( $wp_customize, array(
            'name'              => 'nexus_body_fonts',
            'sanitize_callback' => 'nexus_sanitize_fonts',
            'label'             => esc_html__( 'Body Font', 'nexus' ),
            'section'           => 'nexus_font_options',
            'type' => 'select',
            'choices' => $font_choices
        )
    );

    function nexus_customize_font_styles($custom) {
        //Fonts
        $headings_font = esc_html(get_theme_mod('nexus_headings_fonts'));
        $body_font = esc_html(get_theme_mod('nexus_body_fonts'));

        if ( $headings_font ) {
            $font_pieces = explode(":", $headings_font);
            $custom .= "h1, h2, h3, h4, h5, h6 { font-family: {$font_pieces[0]}; }"."\n";
        }

        if ( $body_font ) {
            $font_pieces = explode(":", $body_font);
            $custom .= "body, button, input, select, textarea { font-family: {$font_pieces[0]}; }"."\n";
        }

        //Output all the styles
        wp_add_inline_style( 'nexus-font-style', $custom );
    }

    add_action( 'wp_enqueue_scripts', 'nexus_customize_font_styles' );


    // Footer Text


    $wp_customize->add_section( 'nexus_footer_text', array(
        'description' => esc_html__( 'You can update the footer bottom text here.', 'nexus' ),
        'panel'       => 'nexus_theme_options',
        'title'       => esc_html__( 'Footer Text', 'nexus' ),
    ) );

    nexus_register_option( $wp_customize, array(
            'name'              => 'nexus_footer_content_left',
            'sanitize_callback' => 'sanitize_text_field',
            'label'             => esc_html__( 'Footer Left Content', 'nexus' ),
            'section'           => 'nexus_footer_text',
            'type'              => 'text',
        )
    );

    nexus_register_option( $wp_customize, array(
            'name'              => 'nexus_footer_content_right',
            'sanitize_callback' => 'sanitize_text_field',
            'label'             => esc_html__( 'Footer Right Content', 'nexus' ),
            'section'           => 'nexus_footer_text',
            'type'              => 'text',
        )
    );

	// Pagination Options.
	$pagination_type = get_theme_mod( 'nexus_pagination_type', 'default' );

	$wp_customize->add_section( 'nexus_pagination_options', array(
		'description' => 'You can control pagination options here',
		'panel'       => 'nexus_theme_options',
		'title'       => esc_html__( 'Pagination Options', 'nexus' ),
	) );

	nexus_register_option( $wp_customize, array(
			'name'              => 'nexus_pagination_type',
			'default'           => 'default',
			'sanitize_callback' => 'nexus_sanitize_select',
			'choices'           => nexus_get_pagination_types(),
			'label'             => esc_html__( 'Pagination type', 'nexus' ),
			'section'           => 'nexus_pagination_options',
			'type'              => 'select',
		)
	);

	/* Scrollup Options */
	$wp_customize->add_section( 'nexus_scrollup', array(
		'panel'    => 'nexus_theme_options',
		'title'    => esc_html__( 'Scrollup Options', 'nexus' ),
	) );

    nexus_register_option( $wp_customize, array(
			'name'              => 'nexus_disable_scrollup',
			'sanitize_callback' => 'nexus_sanitize_checkbox',
			'label'             => esc_html__( 'Disable Scroll Up', 'nexus' ),
			'section'           => 'nexus_scrollup',
			'type'              => 'checkbox',
		)
	);
}
add_action( 'customize_register', 'nexus_theme_options' );
