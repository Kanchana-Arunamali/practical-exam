<?php
/**
 * Nexus functions and definitions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! function_exists( 'nexus_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function nexus_setup() {

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Allow WordPress to manage the document title.
	 */
	add_theme_support( 'title-tag' );

	/**
	 * Enable support for custom logo.
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 100,
		'width'       => 100,
		'flex-height' => true,
		'flex-width' => true,
	) );

	// Add support for Block Styles.
	add_theme_support( 'wp-block-styles' );

	// Add support for editor styles.
	add_theme_support( 'editor-styles' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add support for responsive embeds.
	add_theme_support( 'responsive-embeds' );

	// Add custom editor font sizes.
	add_theme_support(
		'editor-font-sizes',
		array(
			array(
				'name'      => __( 'Small', 'nexus' ),
				'shortName' => __( 'S', 'nexus' ),
				'size'      => 14,
				'slug'      => 'small',
			),
			array(
				'name'      => __( 'Normal', 'nexus' ),
				'shortName' => __( 'M', 'nexus' ),
				'size'      => 18,
				'slug'      => 'normal',
			),
			array(
				'name'      => __( 'Large', 'nexus' ),
				'shortName' => __( 'L', 'nexus' ),
				'size'      => 36,
				'slug'      => 'large',
			),
			array(
				'name'      => __( 'Huge', 'nexus' ),
				'shortName' => __( 'XL', 'nexus' ),
				'size'      => 48,
				'slug'      => 'huge',
			),
		)
	);

	// Add support for custom color scheme.
	add_theme_support( 'editor-color-palette', array(
		array(
			'name'  => __( 'White', 'nexus' ),
			'slug'  => 'white',
			'color' => '#ffffff',
		),
		array(
			'name'  => __( 'Black', 'nexus' ),
			'slug'  => 'black',
			'color' => '#000000',
		),
		array(
			'name'  => __( 'Medium Black', 'nexus' ),
			'slug'  => 'medium-black',
			'color' => '#222222',
		),
		array(
			'name'  => __( 'Gray', 'nexus' ),
			'slug'  => 'gray',
			'color' => '#f6f6f6',
		),
		array(
			'name'  => __( 'Blue', 'nexus' ),
			'slug'  => 'blue',
			'color' => '#039be5',
		),
	) );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );

	// Used in excerpt image Top 16:9 Ratio
	set_post_thumbnail_size( 1040, 585, true );

	// Used in Archive image left/right, 1:1 ratio
	add_image_size( 'nexus-square', 480, 480, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'menu-1'                => esc_html__( 'Primary Menu', 'nexus' ),
		'social-header-right'   => esc_html__( 'Social Header Right Menu', 'nexus' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'status',
		'audio',
		'chat',
	) );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'assets/css/editor-style.css' ) );

	// Indicate widget sidebars can use selective refresh in the Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );

}
endif; // nexus_setup
add_action( 'after_setup_theme', 'nexus_setup' );

/**
 * Sets the content width in pixels, based on the design and stylesheet of the theme.
 *
 * @global int $content_width
 */
function nexus_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'nexus_content_width', 990 );
}
add_action( 'after_setup_theme', 'nexus_content_width', 0 );

/**
 * Registers a widget area.
 */
function nexus_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'nexus' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'nexus' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 1', 'nexus' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'nexus' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 2', 'nexus' ),
		'id'            => 'sidebar-3',
		'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'nexus' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 3', 'nexus' ),
		'id'            => 'sidebar-4',
		'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'nexus' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

}
add_action( 'widgets_init', 'nexus_widgets_init' );

/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 */
function nexus_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-2' ) ) {
		$count++;
	}

	if ( is_active_sidebar( 'sidebar-3' ) ) {
		$count++;
	}

	if ( is_active_sidebar( 'sidebar-4' ) ) {
		$count++;
	}

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'one';
			break;
		case '2':
			$class = 'two';
			break;
		case '3':
			$class = 'three';
			break;
	}

	if ( $class )
		echo 'class="widget-area footer-widget-area ' . $class . '"';
}
/**
 * Enqueues scripts and styles.
 */
function nexus_scripts() {
	// Theme stylesheet.
	wp_enqueue_style( 'nexus-style', get_stylesheet_uri(), null, date( 'Ymd-Gis', filemtime( get_template_directory() . '/style.css' ) ) );

	// Theme block stylesheet.
	wp_enqueue_style( 'nexus-block-style', get_theme_file_uri( '/assets/css/blocks.css' ), array( 'nexus-style' ), '1.0' );

    //Font styles
    $headings_font = esc_html(get_theme_mod('nexus_headings_fonts'));
    $body_font = esc_html(get_theme_mod('nexus_body_fonts'));

    if( $headings_font ) {
        wp_enqueue_style( 'nexus-headings-fonts', '//fonts.googleapis.com/css?family='. $headings_font );
    }

    if( $body_font ) {
        wp_enqueue_style( 'nexus-body-fonts', '//fonts.googleapis.com/css?family='. $body_font );
    }

    // Load the html5 shiv.
	wp_enqueue_script( 'nexus-html5', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/js/html5.min.js', array(), '3.7.3' );
	wp_script_add_data( 'nexus-html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'nexus-skip-link-focus-fix', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/js/skip-link-focus-fix.min.js', array(), '20160816', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

 	wp_register_script( 'jquery-match-height', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/js/jquery.matchHeight.min.js', array( 'jquery' ), '20151215', true );

	wp_enqueue_script( 'nexus-script', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/js/functions.min.js', array( 'jquery', 'jquery-match-height' ), '20160816', true );

	wp_localize_script( 'nexus-script', 'screenReaderText', array(
		'expand'   => __( 'expand child menu', 'nexus' ),
		'collapse' => __( 'collapse child menu', 'nexus' ),
		'icon'     => nexus_get_svg( array(
			'icon'     => 'angle-down',
			'fallback' => true,
		) ),
	) );

}

add_action( 'wp_enqueue_scripts', 'nexus_scripts' );


/**
 * Enqueue editor styles for Gutenberg
 */
function nexus_block_editor_styles() {
	// Block styles.
	wp_enqueue_style( 'nexus-block-editor-style', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/css/editor-blocks.css' );
}
add_action( 'enqueue_block_editor_assets', 'nexus_block_editor_styles' );

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path( 'inc/template-tags.php' );

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * Include Header Background Color Options
 */
require get_parent_theme_file_path( 'inc/header-background-color.php' );

/**
 * SVG icons functions and filters.
 */
require get_parent_theme_file_path( 'inc/icon-functions.php' );

/**
 * Custom functions that act independently of the theme templates.
 */
require get_parent_theme_file_path( 'inc/extras.php' );

/**
 * Add functions for header media.
 */
require get_parent_theme_file_path( 'inc/custom-header.php' );

/**
 * Include Breadcrumb
 */
require get_parent_theme_file_path( '/inc/breadcrumb.php' );

/**
 * Add Metaboxes
 */
require get_parent_theme_file_path( 'inc/metabox/metabox.php' );

/**
 * Modifies tag cloud widget arguments to have all tags in the widget same font size.
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array A new modified arguments.
 */
function nexus_widget_tag_cloud_args( $args ) {
	$args['largest'] = 1;
	$args['smallest'] = 1;
	$args['unit'] = 'em';
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'nexus_widget_tag_cloud_args' );


