<?php
/**
 * The template for displaying all single posts and attachments
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

                        // Include the single post content template.
                        get_template_part( 'template-parts/content/content', 'single' );

                        // Comments Templates
                        get_template_part( 'template-parts/content/content', 'comment' );

                        if ( is_singular( 'attachment' ) ) {
                            // Parent post navigation.
                            the_post_navigation( array(
                                'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'nexus' ),
                            ) );
                        } elseif ( is_singular( 'post' ) ) {
                            // Previous/next post navigation.
                            the_post_navigation( array(
                                'prev_text' => '<span class="screen-reader-text">' . __( 'Previous Post', 'nexus' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Previous', 'nexus' ) . '</span> <span class="nav-title"><span class="nav-title-icon-wrapper">' . nexus_get_svg( array( 'icon' => 'arrow-left' ) ) . '</span>%title</span>',
                                'next_text' => '<span class="screen-reader-text">' . __( 'Next Post', 'nexus' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Next', 'nexus' ) . '</span> <span class="nav-title">%title<span class="nav-title-icon-wrapper">' . nexus_get_svg( array( 'icon' => 'arrow-right' ) ) . '</span></span>',
                            ) );
                        }

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
