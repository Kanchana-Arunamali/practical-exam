<?php
/**
 * The main template file
 */

get_header(); ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<?php
        $title     = 'Nexus Events'; ?>
		<div class="section-heading-wrapper">
				<div class="section-title-wrapper">
					<h2 class="section-title"><?php echo esc_html( $title ); ?></h2>
				</div><!-- .section-title-wrapper -->
		</div><!-- .section-heading-wrapper -->

		<div class="section-content-wrapper">
			<?php if ( have_posts() ) : ?>

			<?php if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
			<?php endif; ?>

			<?php
			// Start the loop.
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content/content', get_post_format() );

			// End the loop.
			endwhile;

			nexus_content_nav();
			?>
		</div><!-- .section-content-wrapper -->

		<?php
		else :
			get_template_part( 'template-parts/content/content', 'none' );

		endif;
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
