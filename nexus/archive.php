<?php
/**
 * The template for displaying archive pages
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<div class="section-content-wrapper">
				<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/content/content', get_post_format() );

				// End the loop.
				endwhile;

				nexus_content_nav();?>
			</div><!-- .section-content-wrap -->

		<?php
		else :
			get_template_part( 'template-parts/content/content', 'none' );

		endif;?>


		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
