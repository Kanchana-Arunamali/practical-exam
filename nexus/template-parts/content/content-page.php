<?php
/**
 * The template used for displaying page content
 */
$show_featured_image = true;
    if ( get_post_meta( $post->ID, 'nexus-header-image', true ) == 'disable') {
        $show_featured_image = false;
    }
    ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="entry-header">
            <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
        </header><!-- .entry-header -->

        <div class="entry-content">
            <?php if ($show_featured_image && has_post_thumbnail() ){ ?>
            <div class="post-thumb">
                <?php the_post_thumbnail(); ?>
            </div>
            <?php }
            the_content();

            wp_link_pages( array(
                'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'nexus' ) . '</span>',
                'after'       => '</div>',
                'link_before' => '<span>',
                'link_after'  => '</span>',
                'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'nexus' ) . ' </span>%',
                'separator'   => '<span class="screen-reader-text">, </span>',
            ) );
            ?>
        </div><!-- .entry-content -->

        <?php
            edit_post_link(
                sprintf(
                    /* translators: %s: Name of current post */
                    __( 'Edit<span class="screen-reader-text"> "%s"</span>', 'nexus' ),
                    get_the_title()
                ),
                '<footer class="entry-footer"><span class="edit-link">',
                '</span></footer><!-- .entry-footer -->'
            );
        ?>

    </article><!-- #post-## -->
