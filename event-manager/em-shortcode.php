<?php
// Event Shortcode

// Add Plugin Settings Page
function shortcode_generator() {
    add_submenu_page( 'edit.php?post_type=event', 'Shortcode Generator', 'Shortcode Generator', 'manage_options', 'shortcode-generator', 'render_shortcode_generator' );
}
add_action( 'admin_menu', 'shortcode_generator' );

// Render Shortcode generator interface
function render_shortcode_generator() {

    $html = '';
    $html .= '<div class="dash-area">';
    $html .= '<div class="settings">';
    $html .= '<h1>Create Shortcode with just few clicks: </h1><br/>';
    $html .= '<span class="metainfo">*Choose the below settings and your shortcode would be ready.</span>';
    $html .= '<h3>Layout: <span class="metainfo">Please select the layout for displaying events on frontend.</span></h3>';
    $html .= '<select id="layout_selector">';
    $html .= '<option value="" selected>Default</option>';
    $html .= '<option value="em-column-grid">Grid Layout</option>';
    $html .= '<option value="em-grid-full-width">Full Width Layout</option>';
    $html .= '<option value="em-grid-full-width-img-left">Boxed Layout (Image Left - Content Right)</option>';
    $html .= '<option value="em-grid-full-width-img-right">Boxed Layout (Content Left - Image Right)</option>';
    $html .= '<option value="em-grid-overlay">Content Overlay Layout</option>';
    $html .='</select><br/>';

    $html .= '<h3>Grid Columns <span class="optional">(required)</span>: <span class="metainfo">Only applicable for Grid Layout & Content Overlay Layout; Default: 1</span></h3>';
    $html .= '<select id="cols_selector">';
    $html .= '<option value="1" selected>1</option>';
    for($i=2; $i<=12; $i++){
        $html .= '<option value="'.$i.'">'.$i.'</option>';
    }
    $html .='</select><br/>';

    $html .= '<h3>Show Events <span class="optional">(optional)</span>: <span class="metainfo">Please add event IDs (comma seperated).<br/> *In order to show only specific events</span></h3>';
    $html .= '<input type="text" name="includeevents" id="includeevents" placeholder="Event IDs (comma seperated)" /><br/>';
    $html .= '<h3>Exclude Events <span class="optional">(optional)</span>: <span class="metainfo">Please add event ID (comma seperated).<br/>*In order to exclude specific events from display</span></h3>';
    $html .= '<input type="text" name="excludeevents" id="excludeevents" placeholder="Event IDs (comma seperated)" /><br/>';
    $html .= '<h3>Event Limit Per Page <span class="optional">(optional)</span>: <span class="metainfo">Please add -1 for showing all events</span></h3>';
    $html .= '<input type="number" name="numberevents" id="numberevents" placeholder="Number of events to be shown on per page" min="-1" /><br/>';
    $html .= '<h3>Event Order <span class="optional">(optional)</span>:</h3>';
    $html .= '<select id="order_selector">';
    $html .= '<option value="" selected disabled>Select an option</option>';
    $html .= '<option value="ASC">Ascending</option>';
    $html .= '<option value="DESC">Descending</option>';
    $html .='</select><br/>';
    $html .= '<h3>Event Orderby <span class="optional">(optional)</span>:</h3>';
    $html .= '<select id="orderby_selector">';
    $html .= '<option value="" selected disabled>Select an option</option>';
    $html .= '<option value="author">Author</option>';
    $html .= '<option value="comment_count">Comment count</option>';
    $html .= '<option value="date">Date</option>';
    $html .= '<option value="modified">Modified Date</option>';
    $html .= '<option value="none">None</option>';
    $html .= '<option value="rand">Random</option>';
    $html .= '<option value="title">Title</option>';
    $html .='</select><br/>';
    $html .= '<h3>Meta Info <span class="optional">(optional)</span>: <span class="metainfo">Please check the below checkboxes in order to enable them</span></h3>';
    $html .= '<div class="em_metadata">';
    $html .= '<input type="checkbox" id="em_author" name="em_author" value="yes"> <label for="em_author">Author</label>';
    $html .= '<input type="checkbox" id="em_comments" name="em_comments" value="yes"> <label for="em_comments">Comments</label>';
    $html .= '<input type="checkbox" id="em_date" name="em_date" value="yes"><label for="em_date">Date</label>';
    $html .= '</div>';
    $html .= '<h3>Event Title <span class="optional">(optional)</span>: <span class="metainfo">Default H3</span></h3>';
    $html .= '<select id="heading_selector">';
    $html .= '<option value="" selected disabled>Choose an option</option>';
    for($i=1; $i<=6; $i++){
        $html .= '<option value="h'.$i.'">H'.$i.'</option>';
    }
    $html .= '</select></br/>';
    $html .= '<h3>Event Content Length <span class="optional">(optional)</span>: <span class="metainfo">Default 120 words</span></h3>';
    $html .= '<input type="number" name="contentlength" id="contentlength" placeholder="Please add numbers only. e.g. 150" min="0" /><br/>';
    $html .= '</div>';
    $html .= '<div class="shortcode">';
    $html .= '<div class="shortcode-wrapper">';
    $html .= '<div class="create_shortcode"><a id="build_shortcode" class="fancy-button">Generate Shortcode</a></div>';
    $html .= '<h3><span class="metainfo"><strong>Note:</strong> Shortcode would get updated by clicking the above button<br/> based on settings given from left panel.</span></h3>';
    $html .= '<div class="em_shortcodeblock"><input type="text" name="name" id="showoption" placeholder="Shortcode will display here..." readonly="readonly" /><span class="dashicons dashicons-clipboard" onclick="copy_clipboard();"></span></div>';
    $html .= '<span id="shortalert" class="metainfo">*Please copy above shortcode and paste it on any page.</span>';
    $html .= '<div class="reset"><a id="reset_settings" class="fancy-button danger">RESET ALL</a></div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    echo $html;
}


/**
 * Function for the Shortcode in order to display Events
 */

function em_shortcode( $atts ) {

    // Attributes
    extract( shortcode_atts(
            array(
                'number' => '-1',
                'layout' => '',
                'columns' => '',
                'orderby' => '',
                'order' => '',
                'include' => '',
                'exclude' => '',
                'is_author' => '',
                'is_comments' => '',
                'is_date' => '',
                'title' => '',
                'length' => '',
                'paged' => '',
            ), $atts )
    );

    global $post;

    $html = "";

    // In case if no specific events are provided, 'post__in' must have empty array
    if($include == '' && $include == null){
        $include = array();
    }else{
        $include = explode(',',$include);
    }

    $my_query = new WP_Query(
        array(
            'post_type' => 'event',
            'posts_per_page' => $number,
            'orderby' => $orderby,
            'order' => $order,
            'post__in' => $include,
            'post__not_in' => explode(',',$exclude),
            'paged' => $paged
        ));

    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    if($layout == 'em-column-grid' || $layout == 'em-grid-overlay'){
        $em_custom_style = "style='grid-template-columns: repeat(".$columns.", 1fr);'";
    }

    if($layout !== '' && $layout !== NULL){
        $em_custom_style = "style='grid-template-columns: repeat(".$columns.", 1fr);'";
        $html .= "<div class='em-container em-grid ". $layout."' $em_custom_style>";
    }

    if($title == '' || $title == NULL){
        $title = 'h3';
    }

    if( $my_query->have_posts() ) : while( $my_query->have_posts() ) : $my_query->the_post();

        if($length !== '' && $length !== NULL){
            $em_content = get_the_content($post->ID);
            $em_strip_content = substr($em_content, 0, $length) . '<span class="dots">...</span>';
        }else{
            $em_content = get_the_content($post->ID);
            $em_strip_content = substr($em_content, 0, 120) . '<span class="dots">...</span>';
        }

        if($layout !== '' && $layout !== NULL){
            $html .= "<div class='em-post'>";
            $html .= "<div class='em-post-wrapper'>";
            $html .= "<div class='em-post-thumb'>";
            $html .= "<a href=". esc_url( get_permalink() ) . ">" . get_the_post_thumbnail() . "</a>";
            $html .= "</div>";
            $html .= "<div class='em-post-content'>";
            $html .= "<div class='em-post-title'><".$title."><a href=". esc_url( get_permalink() ) . ">" . get_the_title() . "</a></".$title."></div>";
            $html .= "<div class='em-post-desc'><p>". $em_strip_content ."</p></div>";
            $html .= "<div class='em-read-more'><a href=". esc_url( get_permalink() ) . " class='read-more button'>Read More</a></div>";

            if( $is_author || $is_comments || $is_date ){
                $html .= "<div class='em-post-meta'>";

                if($is_author){
                    $html .= "<span class='em-post-author'><span>Author:</span> ". get_the_author_link() ."</span>";
                }

                if($is_comments){
                    $html .= "<span class='em-comment-count'><span>Comments:</span> ". get_comments_number() ."</span>";
                }

                if($is_date){
                    $html .= "<span class='em-post-date'><span>Posted on:</span> ". get_the_date() ."</span>";
                }

                $html .= "</div>";
            }

            $html .= "</div>";
            $html .= "</div>";
            $html .= "</div>";

        }else{
            $html .= "<div class='event-block'><div class='innerwrapper'>";
            $html .= "<div class='event-thumb'>" . "<a href=". esc_url( get_permalink() ) . ">" . get_the_post_thumbnail() . "</a>" . "</div>";
            $html .= "<h2><a href=". esc_url( get_permalink() ) . ">" . get_the_title() . "</a>";
            $html .= "</h2>";
            $html .= "<div class='event-content'>";
            $html .= "<p>" . get_the_excerpt() . "</p><a href=". esc_url( get_permalink() ) . " class='read-more button'>Read More</a>";
            $html .= "</div></div></div>";
        }


    endwhile; endif;

    if($layout !== '' && $layout !== NULL){
        $html .= "</div>";
    }

    $big = 9999999999;
    $html .="<div class='event-nav-links'>" . paginate_links(
            array(
                'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format' => '?paged=%#%',
                'current' => max( 1, get_query_var('paged') ),
                'total' => $my_query->max_num_pages
            ) ) . "</div>";
    return $html;
}
add_shortcode( 'em_show', 'em_shortcode' );
