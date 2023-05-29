<?php
/**
 * The template for the sidebar containing the main widget area
 */
?>

<?php
$nexus_layout = nexus_get_theme_layout();

// Bail early if no sidebar layout is selected.
if ( 'no-sidebar' === $nexus_layout ) {
	return;
}

$sidebar = nexus_get_sidebar_id();

if ( '' === $sidebar ) {
    return;
}
?>

<aside id="secondary" class="sidebar widget-area" role="complementary">
	<?php dynamic_sidebar( $sidebar ); ?>
</aside><!-- .sidebar .widget-area -->
