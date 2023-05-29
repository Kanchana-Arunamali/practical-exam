<?php
/**
 * Displays Header Right Navigation
 */
?>

<?php if ( has_nav_menu( 'social-header-right' ) ) : ?>
	<button id="menu-toggle-secondary" class="menu-secondary-toggle menu-toggle" aria-controls="secondary-menu" aria-expanded="false">
		<?php
		echo nexus_get_svg( array( 'icon' => 'bars' ) );
		echo nexus_get_svg( array( 'icon' => 'close' ) );
		echo '<span class="menu-label-prefix">'. esc_attr__( 'Secondary ', 'nexus' ) . '</span><span class="menu-label">'. esc_attr__( 'Menu', 'nexus' ) . '</span>';
		?>
	</button>

	<div id="site-header-right-menu" class="site-secondary-menu">
		<nav id="social-secondary-navigation-top" class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Header Right Social Links Menu', 'nexus' ); ?>">
			<?php
				wp_nav_menu( array(
					'theme_location' => 'social-header-right',
					'menu_class'     => 'social-links-menu',
					'depth'          => 1,
					'link_before'    => '<span class="screen-reader-text">',
					'link_after'     => '</span>' . nexus_get_svg( array( 'icon' => 'chain' ) ),
				) );
			?>
		</nav><!-- #social-secondary-navigation -->
	</div><!-- #site-header-right-menu -->

<?php endif;
