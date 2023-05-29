<?php

// Event Meta Box
function event_manager_add_meta_box() {
    add_meta_box(
        'event_details',
        'Event Details',
        'event_manager_render_meta_box',
        'event',
        'normal',
        'default'
    );
}
add_action( 'add_meta_boxes', 'event_manager_add_meta_box' );

// Render Event Meta Box
function event_manager_render_meta_box( $post ) {
    $start_date = get_post_meta( $post->ID, 'event_start_date', true );
    $end_date = get_post_meta( $post->ID, 'event_end_date', true );
    $location = get_post_meta( $post->ID, 'event_location', true );

    // Convert Unix timestamps to date strings
    $start_date = $start_date ? date( 'Y-m-d', strtotime($start_date )) : '';
    $end_date = $end_date ? date( 'Y-m-d', strtotime($end_date) ) : '';

    wp_nonce_field( 'event_manager_save_meta_box_data', 'event_manager_meta_box_nonce' );

    echo '<div class="event-meta-box">';
    echo '<label for="event_start_date">Start Date:</label>';
    echo '<input type="text" id="event_start_date" name="event_start_date" class="datepicker" value="' . esc_attr( $start_date ) . '"><br>';

    echo '<label for="event_end_date">End Date:</label>';
    echo '<input type="text" id="event_end_date" name="event_end_date" class="datepicker" value="' . esc_attr( $end_date ) . '"><br>';

    echo '<label for="event_location">Location:</label>';
    echo '<input type="text" id="event_location" name="event_location" value="' . esc_attr( $location ) . '">';
    echo '</div>';
}

// Save Event Meta Box Data
function event_manager_save_meta_box_data( $post_id ) {
    if ( ! isset( $_POST['event_manager_meta_box_nonce'] ) ) {
        return;
    }

    if ( ! wp_verify_nonce( $_POST['event_manager_meta_box_nonce'], 'event_manager_save_meta_box_data' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $start_date = sanitize_text_field( $_POST['event_start_date'] );
    $end_date = sanitize_text_field( $_POST['event_end_date'] );
    $location = sanitize_text_field( $_POST['event_location'] );

    update_post_meta( $post_id, 'event_start_date', date('Y-m-d', strtotime($start_date)) );
    update_post_meta( $post_id, 'event_end_date', date('Y-m-d', strtotime($end_date)) );
    update_post_meta( $post_id, 'event_location', $location );
}
add_action( 'save_post', 'event_manager_save_meta_box_data' );


// JavaScript for Datepicker
function event_manager_datepicker_script() {
    ?>
    <script type="text/javascript">
        jQuery(function($) {
            $( ".datepicker" ).datepicker({
                dateFormat: "yy-mm-dd"
            });
        });
    </script>
    <?php
}
add_action( 'admin_footer', 'event_manager_datepicker_script' );

