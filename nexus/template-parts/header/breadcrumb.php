<?php
/**
 * Display Breadcrumb
 */

$enable_breadcrumb = get_theme_mod( 'nexus_breadcrumb_option', 1 );

if ( $enable_breadcrumb ) :
        nexus_breadcrumb();
endif;
