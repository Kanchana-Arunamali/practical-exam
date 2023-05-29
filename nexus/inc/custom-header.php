<?php
/**
 *  Header Image Implementation
 */

if ( ! function_exists( 'nexus_featured_image' ) ) :
	/**
	 * Template for Featured Header Image from theme options
	 */
	function nexus_featured_image() {
		$header_media_title = get_theme_mod( 'nexus_header_media_title', esc_html__( 'Welcome To Nexus Events', 'nexus' ) );
		$header_media_text = get_theme_mod( 'nexus_header_media_text', esc_html__( 'Manage all your events easily.', 'nexus' ) );
		if ( has_custom_header() || '' !== $header_media_title || '' !== $header_media_text ) : ?>
			<div class="header-media">
				<div class="wrapper">
					<div class="custom-header-media">
						<?php the_custom_header_markup(); ?>
					</div>

					<?php get_template_part( 'template-parts/header/header-media', 'text' ); ?>
				</div><!-- .wrapper -->
			</div><!-- .header-media -->
		<?php
		endif;

	} // nexus_featured_image
endif;

if ( ! function_exists( 'nexus_featured_page_post_image' ) ) :
	/**
	 * Template for Featured Header Image from Post and Page
	 */
	function nexus_featured_page_post_image() {
		if ( ! has_post_thumbnail() ) {
			nexus_featured_image();
			return;
		}
		?>
		<div class="header-media">
			<div class="wrapper">
				<div class="post-thumbnail singular-header-image">
					<?php if ( is_home() && $blog_id = get_option( 'page_for_posts' ) ) {
					    echo get_the_post_thumbnail( $blog_id, 'nexus-slider' );
					} else
					the_post_thumbnail( 'nexus-slider' ); ?>

				</div><!-- .post-thumbnail -->
			</div><!-- .wrapper -->
		</div><!-- .header-media -->
		<?php
	} // nexus_featured_page_post_image
endif;


if ( ! function_exists( 'nexus_featured_overall_image' ) ) :
	/**
	 * Template for Featured Header Image from theme options
	 */
	function nexus_featured_overall_image() {
		global $post, $wp_query;
		$enable = get_theme_mod( 'nexus_header_media_option', 'homepage' );

		// Get Page ID outside Loop
		$page_id = absint( $wp_query->get_queried_object_id() );

		$page_for_posts = absint( get_option( 'page_for_posts' ) );

		// Check Enable/Disable header image in Page/Post Meta box
		if ( is_page() || is_single() ) {
			//Individual Page/Post Image Setting
			$individual_featured_image = get_post_meta( $post->ID, 'nexus-header-image', true );

			if ( 'disable' === $individual_featured_image || ( 'default' === $individual_featured_image && 'disable' === $enable ) ) {
				echo '<!-- Page/Post Disable Header Image -->';
				return;
			}
			elseif ( 'enable' == $individual_featured_image && 'disable' === $enable ) {
				nexus_featured_page_post_image();
			}
		}

		// Check Homepage
		if ( 'homepage' === $enable ) {
			if ( is_front_page() || ( is_home() && intval( $page_for_posts ) !== intval( $page_id ) ) ) {
				nexus_featured_image();
			}
		} if ( 'entire-site' === $enable ) {
			nexus_featured_image();
		}
		// Check Entire Site (Post/Page)
		elseif ( 'entire-site-page-post' === $enable ) {
			if ( is_page() || is_single() || ( is_home() && $page_for_posts === $page_id ) ) {
				nexus_featured_page_post_image();
			}
			else {
				nexus_featured_image();
			}
		}
	} // nexus_featured_overall_image
endif;
