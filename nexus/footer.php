<?php
/**
 * The template for displaying the footer
 * Contains the closing of the #content div and all content after
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

?>
		</div><!-- .wrapper -->
	</div><!-- .site-content -->
	
	<footer id="colophon" class="site-footer" role="contentinfo">

		<?php get_template_part( 'template-parts/footer/footer', 'widgets' ); ?>

		<div id="site-generator">
			<?php get_template_part( 'template-parts/navigation/navigation', 'footer' ); ?>

			<?php get_template_part( 'template-parts/footer/site', 'info' ); ?>
		</div><!-- #site-generator -->

	</footer><!-- .site-footer -->
</div><!-- .site -->

<?php wp_footer(); ?>
</body>
</html>
