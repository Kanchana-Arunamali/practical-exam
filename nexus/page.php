<?php
/**
 * The template for displaying pages
 */

get_header();
    $show_sidebar = true;
    if ( get_post_meta( $post->ID, 'nexus-page-layout', true ) == 'no-sidebar') {
        $show_sidebar = false;
    }
    ?>
        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">
                <div class="singular-content-wrap">
                    <?php
                    // Start the loop.
                    while ( have_posts() ) : the_post();

                        // Include the page content template.
                        get_template_part( 'template-parts/content/content', 'page' );

                        // Comments Templates
                        get_template_part( 'template-parts/content/content', 'comment' );

                        // End of the loop.
                    endwhile;
                    ?>
                </div><!-- .singular-content-wrap -->
            </main><!-- .site-main -->
        </div><!-- .content-area -->
    <?php if ( $show_sidebar ) :
         get_sidebar();
     endif; ?>
<?php get_footer(); ?>
