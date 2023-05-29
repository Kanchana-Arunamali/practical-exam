<?php
/**
 * Header Media Options
 */

function nexus_header_media_options( $wp_customize ) {

	nexus_register_option( $wp_customize, array(
			'name'              => 'nexus_header_media_option',
			'default'           => 'homepage',
			'sanitize_callback' => 'nexus_sanitize_select',
			'choices'           => array(
				'homepage'               => esc_html__( 'Homepage / Frontpage', 'nexus' ),
				'entire-site'            => esc_html__( 'Entire Site', 'nexus' ),
				'entire-site-page-post'  => esc_html__( 'Entire Site, Page/Post Featured Image', 'nexus' ),
				'disable'                => esc_html__( 'Disabled', 'nexus' ),
			),
			'label'             => esc_html__( 'Enable on ', 'nexus' ),
			'section'           => 'header_image',
			'type'              => 'select',
			'priority'          => 1,
		)
	);

	nexus_register_option( $wp_customize, array(
			'name'              => 'nexus_header_media_title',
			'default'           => esc_html__( 'Welcome to Nexus Events', 'nexus' ),
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Header Media Title', 'nexus' ),
			'section'           => 'header_image',
			'type'              => 'text',
		)
	);

    nexus_register_option( $wp_customize, array(
			'name'              => 'nexus_header_media_text',
			'default'           => esc_html__( 'We make your dream event a reality.', 'nexus' ),
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Header Media Text', 'nexus' ),
			'section'           => 'header_image',
			'type'              => 'textarea',
		)
	);

	nexus_register_option( $wp_customize, array(
			'name'              => 'nexus_header_media_url',
			'default'           => '#',
			'sanitize_callback' => 'esc_url_raw',
			'label'             => esc_html__( 'Header Media Url', 'nexus' ),
			'section'           => 'header_image',
		)
	);

	nexus_register_option( $wp_customize, array(
			'name'              => 'nexus_header_media_url_text',
			'default'           => esc_html__( 'Continue Reading', 'nexus' ),
			'sanitize_callback' => 'sanitize_text_field',
			'label'             => esc_html__( 'Header Media Url Text', 'nexus' ),
			'section'           => 'header_image',
		)
	);

	nexus_register_option( $wp_customize, array(
			'name'              => 'nexus_header_url_target',
			'sanitize_callback' => 'nexus_sanitize_checkbox',
			'label'             => esc_html__( 'Check to Open Link in New Window/Tab', 'nexus' ),
			'section'           => 'header_image',
			'type'              => 'checkbox',
		)
	);
}
add_action( 'customize_register', 'nexus_header_media_options' );

