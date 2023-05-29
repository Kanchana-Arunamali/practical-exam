<?php
/**
 * Template Name: Events
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
            <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                <!-- Loop for upcoming events -->
                <h2>Upcoming Events</h2>
                <?php
                $today = date('Y-m-d',strtotime("today"));
                $upcoming_args = array(
                    'post_type'      => 'event',
                    'posts_per_page' => -1,
                    'orderby'        => 'meta_value',
                    'order'          => 'ASC',
                    'meta_key'       => 'event_start_date',
                    'meta_query'     => array(
                        array(
                            'key'     => 'event_start_date',
                            'value'   => $today,
                            'compare' => '>=',
                            'type'    => 'DATE',
                        ),
                    ),
                );
                $upcoming_query = new WP_Query($upcoming_args);
                if ($upcoming_query->have_posts()) : ?>
                <div class="event-wrapper">
                <?php
                    while ($upcoming_query->have_posts()) :
                        $upcoming_query->the_post();
                        ?>
                        <div id="post-<?php the_ID(); ?>" <?php post_class('event-item'); ?>>
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="event-thumbnail">
                                    <a href="<?php echo esc_url(get_permalink()); ?>">
                                        <?php the_post_thumbnail('thumbnail'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <div class="event-content">
                                <h3><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></h3>
                                <div class="event-description">
                                    <?php the_excerpt(); ?>
                                    <?php nexus_excerpt_more(esc_url(get_permalink()), "Read More"); ?>
                                </div>
                                <div class="event-meta">
                                    <span class="event-start"><?php echo nexus_get_svg( array( 'icon' => 'calendar' )) .  date( 'Y-m-d',strtotime(get_post_meta(get_the_ID(), 'event_start_date', true))) ?></span>
                                    <span class="event-location"><?php echo nexus_get_svg( array( 'icon' => 'tag' )) . get_post_meta(get_the_ID(), 'event_location', true); ?></span>
                                </div>
                            </div>
                        </div><!-- .event block -->
                    <?php
                    endwhile;
                    wp_reset_postdata();
                    ?>
                  </div><!-- .event wrapper -->
                  <?php
                else :
                    echo 'No upcoming events.';
                endif;
                ?>

                <!-- Loop for past events -->
                <h2>Past Events</h2>
                <?php
                $past_args = array(
                    'post_type'      => 'event',
                    'posts_per_page' => -1,
                    'orderby'        => 'meta_value',
                    'order'          => 'ASC',
                    'meta_key'       => 'event_start_date',
                    'meta_query'     => array(
                        array(
                            'key'     => 'event_start_date',
                            'value'   => $today,
                            'compare' => '<',
                            'type'    => 'DATE',
                        ),
                    ),
                );
                $past_query = new WP_Query($past_args);
                if ($past_query->have_posts()) : ?>
                 <div class="event-wrapper">
                    <?php
                    while ($past_query->have_posts()) :
                        $past_query->the_post();
                        ?>
                        <div id="post-<?php the_ID(); ?>" <?php post_class('event-item'); ?>>
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="event-thumbnail">
                                    <a href="<?php echo esc_url(get_permalink()); ?>">
                                        <?php the_post_thumbnail('thumbnail'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <div class="event-content">
                                <h3><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></h3>
                                <div class="event-description">
                                    <?php the_excerpt(); ?>
                                    <?php nexus_excerpt_more(esc_url(get_permalink()), "Read More"); ?>
                                </div>
                                <div class="event-meta">
                                    <span class="event-start"><?php echo nexus_get_svg( array( 'icon' => 'calendar' )) .  date( 'Y-m-d',strtotime(get_post_meta(get_the_ID(), 'event_start_date', true))) ?></span>
                                    <span class="event-location"><?php echo nexus_get_svg( array( 'icon' => 'tag' )) . get_post_meta(get_the_ID(), 'event_location', true); ?></span>
                                </div>
                            </div>
                        </div><!-- .event block -->
                    <?php
                    endwhile;
                    wp_reset_postdata(); ?>
                     </div><!-- .event wrapper -->
                <?php
                else :
                    echo 'No past events.';
                endif;
                ?>
        </div><!-- .singular-content-wrap -->
    </main><!-- .site-main -->
</div><!-- .content-area -->
<?php if ( $show_sidebar ) :
    get_sidebar();
endif; ?>
<?php get_footer(); ?>
