<?php
/**
 * Nexus Custom template tags
 */

if ( ! function_exists( 'nexus_entry_meta' ) ) :
/**
 * Prints HTML with meta information for the categories, tags.
 */
function nexus_entry_meta() {
	if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
		nexus_entry_date();
	}

	$format = get_post_format();
	if ( current_theme_supports( 'post-formats', $format ) ) {
		printf( '<span class="entry-format">%1$s<a href="%2$s">%3$s</a></span>',
			sprintf( '<span class="screen-reader-text">%s </span>', _x( 'Format', 'Used before post format.', 'nexus' ) ),
			esc_url( get_post_format_link( $format ) ),
			get_post_format_string( $format )
		);
	}

	if ( 'post' === get_post_type() ) {
		nexus_entry_taxonomies();
	}

	if ( ! is_singular() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">'  . nexus_get_svg( array( 'icon' => 'comment' ) );
		comments_popup_link( sprintf( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'nexus' ), get_the_title() ) );
		echo '</span>';
	}
}
endif;

if ( ! function_exists( 'nexus_entry_date' ) ) :
/**
 * Prints HTML with date information for current post.
 */
function nexus_entry_date() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		get_the_date(),
		esc_attr( get_the_modified_date( 'c' ) ),
		get_the_modified_date()
	);

	printf( '<span class="posted-on">' . nexus_get_svg( array( 'icon' => 'calendar' ) ) . '<span class="date-label screen-reader-text">%1$s</span><a href="%2$s" rel="bookmark">%3$s</a></span>',
		_x( 'Posted on', 'Used before publish date.', 'nexus' ),
		esc_url( get_permalink() ),
		$time_string
	);
}
endif;

if ( ! function_exists( 'nexus_entry_taxonomies' ) ) :
/**
 * Prints HTML with category and tags for current post.
 */
function nexus_entry_taxonomies() {
	$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'nexus' ) );
	if ( $categories_list && nexus_categorized_blog() ) {
		printf( '<span class="cat-links">' . nexus_get_svg( array( 'icon' => 'folder' ) ) . '<span class="cat-label screen-reader-text">%1$s</span>%2$s</span>',
			_x( 'Categories', 'Used before category names.', 'nexus' ),
			$categories_list
		);
	}

	$tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'nexus' ) );
	if ( $tags_list ) {
		printf( '<span class="tags-links">' . nexus_get_svg( array( 'icon' => 'tag' ) ) . '<span class="tag-label screen-reader-text">%1$s</span>%2$s</span>',
			_x( 'Tags', 'Used before tag names.', 'nexus' ),
			$tags_list
		);
	}
}
endif;


if ( ! function_exists( 'nexus_entry_category_date' ) ) :
/**
 * Prints HTML with category and tags for current post.
 */
function nexus_entry_category_date() {
	$meta = '<div class="entry-meta">';

	$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'nexus' ) );
	if ( $categories_list && nexus_categorized_blog( ) ) {
		$meta .= sprintf( '<span class="cat-links">' . nexus_get_svg( array( 'icon' => 'folder' ) ) . '<span class="cat-label screen-reader-text">%1$s</span>%2$s</span>',
			sprintf( _x( 'Categories', 'Used before category names.', 'nexus' ) ),
			$categories_list
		);
	}

	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$meta .= sprintf( '<span class="posted-on">' . nexus_get_svg( array( 'icon' => 'calendar' ) ) . '<span class="date-label screen-reader-text">%1$s</span><a href="%2$s" rel="bookmark">%3$s</a></span>',
		_x( 'Posted on', 'Used before publish date.', 'nexus' ),
		esc_url( get_permalink() ),
		$time_string
	);

	$meta .= '</div><!-- .entry-meta -->';

	return $meta;

}
endif;


if ( ! function_exists( 'nexus_entry_header' ) ) :
/**
 * Prints HTML with meta information for the date and author
 */
function nexus_entry_header() {
	// Get the author name; wrap it in a link.
	$byline = sprintf(
		/* translators: %s: post author */
		__( '<span class="author-label screen-reader-text">By </span>%s', 'nexus' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_the_author() . '</a></span>'
	);
	echo '<div class="entry-meta">';

		nexus_entry_date();

		echo '<span class="byline"> ' .  nexus_get_svg( array( 'icon' => 'user' )) . $byline . '</span>';

		if ( ! is_singular() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">' . nexus_get_svg( array( 'icon' => 'comment' ) );
			comments_popup_link( sprintf( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'nexus' ), get_the_title() ) );
			echo '</span>';
		}

	echo '</div><!-- .entry-meta -->';
}
endif;



if ( ! function_exists( 'nexus_entry_category' ) ) :
/**
 * Prints HTML with category for current post.
 */
function nexus_entry_category() {
	$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'nexus' ) );
	if ( $categories_list && nexus_categorized_blog() ) {
		echo '<span class="cat-links">' . nexus_get_svg( array( 'icon' => 'folder' ) ) . '<span class="cat-label screen-reader-text">' . __( 'Categories', 'nexus' ) . '</span>' . $categories_list . '</span>';
	}
}
endif;


if ( ! function_exists( 'nexus_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function nexus_entry_footer() {
	// Get Categories for posts.
	$categories_list = get_the_category_list( ' ' );

	// Get Tags for posts.
	$tags_list = get_the_tag_list( '' );

	// Do not output .entry-footer if is empty
	if ( ( ( nexus_categorized_blog() && $categories_list ) || $tags_list ) || get_edit_post_link() ) {

		echo '<footer class="entry-footer">';

			echo '<div class="entry-meta">';
				if ( 'post' === get_post_type() ) {
					if ( ( $categories_list && nexus_categorized_blog() ) || $tags_list ) {

						// Make sure there's more than one category before displaying.
						if ( $categories_list && nexus_categorized_blog() ) {
							echo '<span class="cat-links">' . '<span class="cat-label">' . esc_html__( 'Categories', 'nexus' ) . '</span>' . $categories_list . '</span>';
						}

						if ( $tags_list ) {
							echo '<span class="tags-links">' . '<span class="tag-label">' . esc_html__( 'Tags', 'nexus' ) . '</span>' . $tags_list . '</span>';
						}
					}
				}

				nexus_edit_link();
			echo '</div><!-- .entry-meta -->';

			if ( '' !== get_the_author_meta( 'description' ) ) {
				get_template_part( 'template-parts/biography' );
			}

		echo '</footer> <!-- .entry-footer -->';
	}
}
endif;


if ( ! function_exists( 'nexus_edit_link' ) ) :
/**
 * Returns an accessibility-friendly link to edit a post or page.
 */
function nexus_edit_link() {
	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'nexus' ),
			get_the_title()
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;


if ( ! function_exists( 'nexus_post_thumbnail' ) ) :
/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 */
function nexus_post_thumbnail( $size = 'post-thumbnail' ) {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}
	if ( is_singular() ) :
	?>

	<div class="post-thumbnail">
		<?php the_post_thumbnail( $size ); ?>
	</div><!-- .post-thumbnail -->

	<?php else : ?>

	<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
		<?php the_post_thumbnail( $size, array( 'alt' => the_title_attribute( 'echo=0' ) ) ); ?>
	</a>

	<?php endif; // End is_singular()
}
endif;

if ( ! function_exists( 'nexus_excerpt' ) ) :
	/**
	 * Displays the optional excerpt.
	 *
	 * Wraps the excerpt in a div element.
	 *
	 * @param string $class Optional. Class string of the div element. Defaults to 'entry-summary'.
	 */
	function nexus_excerpt( $class = 'entry-summary' ) {
		$class = esc_attr( $class );

		if ( has_excerpt() || is_search() ) : ?>
			<div class="<?php echo $class; ?>">
				<?php the_excerpt(); ?>
			</div><!-- .<?php echo $class; ?> -->
		<?php endif;
	}
endif;

if ( ! function_exists( 'nexus_excerpt_length' ) ) :
	/**
	 * Sets the post excerpt length to n words.
	 *
	 * function tied to the excerpt_length filter hook.
	 * @uses filter excerpt_length
	 *
	 */
	function nexus_excerpt_length( $length ) {
		if ( is_admin() ) {
			return $length;
		}

		// Getting data from Customizer Options.
		$length	= get_theme_mod( 'nexus_excerpt_length', 20 );

		return absint( $length );
	}
endif; //nexus_excerpt_length
add_filter( 'excerpt_length', 'nexus_excerpt_length' );

if ( ! function_exists( 'nexus_excerpt_more' ) ) :
	/**
	 * Replaces "[...]" (appended to automatically generated excerpts) with ... and a option from customizer.
	 * @return string option from customizer prepended with an ellipsis.
	 */
	function nexus_excerpt_more( $more ) {
		if ( is_admin() ) {
			return $more;
		}

		$more_tag_text = get_theme_mod( 'nexus_excerpt_more_text',  esc_html__( 'Read More', 'nexus' ) );

		$link = sprintf( '<a href="%1$s" class="more-link"><span class="more-button">%2$s</span></a>',
			esc_url( get_permalink( get_the_ID() ) ),
			/* translators: %s: Name of current post */
			wp_kses_data( $more_tag_text ) . '<span class="screen-reader-text">' . get_the_title( get_the_ID() ) . '</span>'
		);

		return ' &hellip; ' . $link;
	}
endif;
add_filter( 'excerpt_more', 'nexus_excerpt_more' );

if ( ! function_exists( 'nexus_custom_excerpt' ) ) :
	/**
	 * Adds Read More link to more tag excerpts.
	 *
	 * function tied to the get_the_excerpt filter hook.
	 */
	function nexus_custom_excerpt( $output ) {

		if ( has_excerpt() && ! is_attachment() ) {
			$more_tag_text = get_theme_mod( 'nexus_excerpt_more_text', esc_html__( 'Read More &gt;', 'nexus' ) );

			$link = sprintf( '<a href="%1$s" class="more-link"><span class="more-button">%2$s</span></a>',
				esc_url( get_permalink( get_the_ID() ) ),
				/* translators: %s: Name of current post */
				wp_kses_data( $more_tag_text ) . '<span class="screen-reader-text">' . get_the_title( get_the_ID() ) . '</span>'
			);

			$output .= ' &hellip; ' . $link;
		}

		return $output;
	}
endif; // nexus_custom_excerpt.
add_filter( 'get_the_excerpt', 'nexus_custom_excerpt' );

if ( ! function_exists( 'nexus_more_link' ) ) :
	/**
	 * Replacing Read More link to the_content more.
	 *
	 * function tied to the the_content_more_link filter hook.
	 */
	function nexus_more_link( $more_link, $more_link_text ) {
		$more_tag_text = get_theme_mod( 'nexus_excerpt_more_text', esc_html__( 'Read More &gt;', 'nexus' ) );

		return str_replace( $more_link_text, wp_kses_post( $more_tag_text ), $more_link );
	}
endif; // nexus_more_link.
add_filter( 'the_content_more_link', 'nexus_more_link', 10, 2 );

if ( ! function_exists( 'nexus_categorized_blog' ) ) :
/**
 * Determines whether blog/site has more than one category.
 *
 * @return bool True if there is more than one category, false otherwise.
 */
function nexus_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'nexus_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'nexus_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so nexus_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so nexus_categorized_blog should return false.
		return false;
	}
}
endif;

/**
 * Flushes out the transients used in nexus_categorized_blog().
 */
function nexus_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'nexus_categories' );
}
add_action( 'edit_category', 'nexus_category_transient_flusher' );
add_action( 'save_post',     'nexus_category_transient_flusher' );

if ( ! function_exists( 'nexus_the_custom_logo' ) ) :
/**
 * Displays the optional custom logo.
 *
 * Does nothing if the custom logo is not available.
 */
function nexus_the_custom_logo() {
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}
endif;

/**
 * Footer Text
 *
 * @get footer text from theme options and display them accordingly
 * @display footer_text
 * @action nexus_credits
 */
function nexus_footer_content() {
	$theme_data = wp_get_theme();

	$search  = array( '[the-year]', '[site-link]', '[privacy-policy-link]' );
	$replace = array( esc_attr( date_i18n( __( 'Y', 'nexus' ) ) ), '<a href="'. esc_url( home_url( '/' ) ) .'">'. esc_attr( get_bloginfo( 'name', 'display' ) ) . '</a>', get_the_privacy_policy_link() );

	$footer_left_content = str_replace( $search, $replace, get_theme_mod( 'nexus_footer_content_left', sprintf( _x( 'Copyright &copy; %1$s %2$s. All Rights Reserved. %3$s', '1: Year, 2: Site Title with home URL, 3: Privacy Policy Link', 'nexus' ), '[the-year]', '[site-link]', '[privacy-policy-link]' ) ) );

	$footer_right_content = str_replace( $search, $replace, get_theme_mod( 'nexus_footer_content_right', $theme_data->get( 'Name' ) . '&nbsp;' . esc_html__( 'by', 'nexus' ) . '&nbsp;<a target="_blank" href="' . esc_url( $theme_data->get( 'AuthorURI' ) ) . '">' . esc_html( $theme_data->get( 'Author' ) ) . '</a>' ) );

	$class = ' one';

	if ( '' === $footer_left_content && '' === $footer_right_content ) {
		return false;
	} elseif ( '' !== $footer_left_content && '' !== $footer_right_content ){
		$class = ' two';
	}

	$footer_content =  '
	<div class="site-info'. $class . '">
		<div class="wrapper">';

	if ( '' !== $footer_left_content ) {
		$footer_content .= '<div id="footer-left-content" class="copyright">' . $footer_left_content . '</div>';
	}

	if ( '' !== $footer_right_content ) {
		$footer_content .= '<div id="footer-right-content" class="powered">' . $footer_right_content . '</div>';
	}

	$footer_content .=  '
		</div><!-- .wrapper -->
	</div><!-- .site-info -->';

	echo $footer_content;
}
add_action( 'nexus_credits', 'nexus_footer_content', 10 );

if ( ! function_exists( 'nexus_comment' ) ) :
	/**
	 * Template for comments and pingbacks.
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 */
	function nexus_comment( $comment, $args, $depth ) {
		if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

		<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
			<div class="comment-body">
				<?php esc_html_e( 'Pingback:', 'nexus' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( 'Edit', 'nexus' ), '<span class="edit-link">', '</span>' ); ?>
			</div>

		<?php else : ?>

		<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
			<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">

				<div class="comment-author vcard">
					<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
				</div><!-- .comment-author -->

				<div class="comment-container">
					<header class="comment-meta">
						<?php printf( __( '%s <span class="says screen-reader-text">says:</span>', 'nexus' ), sprintf( '<cite class="fn author-name">%s</cite>', get_comment_author_link() ) ); ?>
					</header><!-- .comment-meta -->

					<div class="comment-metadata">
						<a class="comment-permalink" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
							<time datetime="<?php comment_time( 'c' ); ?>"><?php printf( esc_html__( '%s ago', 'nexus' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) ); ?></time></a>
						<?php edit_comment_link( esc_html__( 'Edit', 'nexus' ), '<span class="edit-link">', '</span>' ); ?>

						<?php if ( '0' == $comment->comment_approved ) : ?>
							<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'nexus' ); ?></p>
						<?php endif; ?>
					</div><!-- .comment-metadata -->

					<div class="comment-content">
						<?php comment_text(); ?>

						<?php
							comment_reply_link( array_merge( $args, array(
								'add_below' => 'div-comment',
								'depth'     => $depth,
								'max_depth' => $args['max_depth'],
								'before'    => '<span class="reply">',
								'after'     => '</span>',
							) ) );
						?>
					</div><!-- .comment-content -->
				</div><!-- .comment-content -->

			</article><!-- .comment-body -->
		<?php /* No closing </li> is needed. */ ?>

		<?php
		endif;
	}
endif; // ends check for nexus_comment()
